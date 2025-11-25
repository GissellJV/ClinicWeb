<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Illuminate\Support\Facades\Http;
use App\Models\Inventario;

class PacienteController extends Controller
{
    public function asignarMedicamento(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'inventario_id' => 'required|exists:inventario_medicamentos,id',
            'habitacion_id' => 'required|exists:habitaciones,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $paciente = Paciente::findOrFail($request->paciente_id);
        $medicamento = Inventario::findOrFail($request->inventario_id);
        $cantidadAsignar = $request->cantidad;

        // Verificar que hay suficiente medicamento en inventario
        if ($cantidadAsignar > $medicamento->cantidad) {
            return back()->with('error', "No hay suficiente $medicamento->nombre en inventario.");
        }

        // Asignar medicamento al paciente
        $medExistente = $paciente->medicamentos()->where('inventario_id', $medicamento->id)->first();

        if ($medExistente) {
            $paciente->medicamentos()->updateExistingPivot($medicamento->id, [
                'cantidad' => $medExistente->pivot->cantidad + $cantidadAsignar,
                'habitacion_id' => $request->habitacion_id,
                'fecha_aplicacion' => now()
            ]);
        } else {
            $paciente->medicamentos()->attach($medicamento->id, [
                'cantidad' => $cantidadAsignar,
                'habitacion_id' => $request->habitacion_id,
                'fecha_aplicacion' => now()
            ]);
        }

        // ⚡ Restar la cantidad del inventario directamente
        $medicamento->decrement('cantidad', $cantidadAsignar);

        return back()->with('success', "$medicamento->nombre asignado correctamente. Inventario actualizado.");
    }



    public function historialPacientes()
    {
        $pacientes = Paciente::with([
            'medicamentos',
            'asignacionesHabitacion.habitacion'
        ])->get();

        $inventarios = Inventario::all();

        return view('enfermeria.historial', compact('pacientes', 'inventarios'));
    }

    public function medicamentosPorPaciente()
    {
        $pacientes = Paciente::with([
            'medicamentos',
            'asignacionesHabitacion' => function($query) {
                $query->where('estado', 'activo')->with('habitacion');
            }
        ])->get();

        $inventarios = Inventario::all(); // Traemos todos los medicamentos disponibles

        return view('enfermeria.historial', compact('pacientes', 'inventarios'));


    }

    public function registrarpaciente(){

        return view('pacientes.registrarpaciente');
    }

    public function store(Request $request)
    {
        // Validar datos
        $request->validate([
            'nombres' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/'
            ],
            'apellidos' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/'
            ],
            'fecha_nacimiento' => [
                'required',
                'date',
                'before:today',
                function ($attribute, $value, $fail) {
                    $edad = Carbon::parse($value)->age;
                    if ($edad > 120) {
                        $fail('La edad no puede ser mayor a 120 años.');
                    }
                }
            ],
            'numero_identidad' => 'required|string|size:13|regex:/^\d{4}\d{4}\d{5}$/|unique:pacientes',
            'genero' => 'required|in:Femenino,Masculino',
            'telefono' => 'required|string|size:8|regex:/^[389]\d{7}$/',
            'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]/|confirmed',
        ],
            [

            'nombres.required' => 'Nombres obligatorios',
            'nombres.regex' => 'Ingrese nombres válidos (solo letras y espacios)',
            'nombres.max' => 'Los nombres no pueden tener más de 50 caracteres',
            'apellidos.required' => 'Apellidos obligatorios',
            'apellidos.regex' => 'Ingrese apellidos válidos (solo letras y espacios)',
            'apellidos.max' => 'Los apellidos no pueden tener más de 50 caracteres',
            'fecha_nacimiento.required' => 'Fecha de nacimiento obligatoria',
            'fecha_nacimiento.before' => 'Ingresa una fecha válida',
            'genero.required' => 'Selecciona un género',
            'numero_identidad.required' => 'El número de identidad es obligatorio',
            'numero_identidad.regex' => 'El formato del número de identidad no es válido',
            'numero_identidad.size' => 'El número de identidad debe tener 13 dígitos',
            'numero_identidad.unique' => 'El número de identidad ya ha sido registrado',
            'telefono.required' => 'El número de teléfono es obligatorio',
            'telefono.regex' => 'El número de teléfono no es válido',
            'telefono.size' => 'El número de teléfono debe tener 8 dígitos',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener mínimo 8 caracteres',
            'password.regex' => 'Mínimo 8 caracteres, incluye mayúsculas, minúsculas y números',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ]);


        $nuevoPaciente = new Paciente();
        $nuevoPaciente->nombres = $request->input('nombres');
        $nuevoPaciente->apellidos = $request->input('apellidos');
        $nuevoPaciente->fecha_nacimiento = $request->input('fecha_nacimiento');
        $nuevoPaciente->genero = $request->input('genero');
        $nuevoPaciente->numero_identidad = $request->input('numero_identidad');
        $nuevoPaciente->telefono = $request->input('telefono');
        $nuevoPaciente->password = bcrypt($request->input('password'));
        $nuevoPaciente->save();


        return redirect()->route('inicioSesion')->with('mensaje', 'Registro exitoso, Inicia sesión');
    }


    public function listado_citaspro(Request $request){

        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        $pacientes = null;

        if ($request->busqueda) {
            $busqueda = $request->input('busqueda');
            $filtro = $request->input('filtro');

            $query = Paciente::query();

            if ($filtro == 'nombre') {
                $query->where('nombres', 'LIKE', "%{$busqueda}%");
            } else {
                $query->where(function ($q) use ($busqueda) {
                    $q->where('nombres', 'LIKE', "%{$busqueda}%");
                });
            }

            $query->orderBy('nombres', 'asc');
            $pacientes = $query->paginate(10)->withQueryString();
        }

        return view('pacientes.listado_citaspro', compact('pacientes'));
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('/');
    }

    public function enviar_codigo_recuperacion()
    {
        return view('pacientes.enviar_codigo_recuperacion');
    }

    public function agendar_Citasonline()
    {
        if (!session('paciente_id')) {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión para agendar una cita');
        }

        $paciente = Paciente::find(session('paciente_id'));
        $doctores = Empleado::where('cargo', 'Doctor')->get();
        $especialidades = Empleado::where('cargo', 'Doctor')
            ->select('departamento')
            ->distinct()
            ->pluck('departamento');

        return view('pacientes.agendar_Citasonline', compact('paciente', 'especialidades', 'doctores'));
    }

    public function enviarCodigoRecuperacion(Request $request)
    {
        $request->validate([
            'telefono' => 'required|string|size:8|regex:/^[2389]\d{7}$/'
        ],[
            'telefono.required' => 'El número de teléfono es obligatorio',
            'telefono.regex' => 'El número de teléfono no es válido',
            'telefono.size' => 'El número de teléfono debe tener 8 dígitos',
        ]);

        $pacientes = DB::table('pacientes')->where('telefono', $request->input('telefono'))->first();
        if (!$pacientes) {
            return back()->withErrors(['telefono' => 'Este número no está registrado.']);
        }

        $token = Str::random(60);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['telefono' => $request->telefono],
            [
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        $enlace = url('/restablecer/' . $token);

        $basic = new Basic("2301b790", "ZJZ2LcWTIIQaUbAL");
        $client = new Client($basic);

        $mensaje = "Hola {$pacientes->nombres}, para restablecer tu contraseña entra a este enlace: $enlace";

        $response = Http::withBasicAuth('2301b790', 'ZJZ2LcWTIIQaUbAL')
            ->post('https://messages-sandbox.nexmo.com/v1/messages', [
                'from' => '14157386102',
                'to' => '504' . $request->telefono,
                'message_type' => 'text',
                'text' => $mensaje,
                'channel' => 'whatsapp',
            ]);

        if ($response->failed()) {
            return redirect('/recuperar')->with('error', 'Error al enviar el mensaje. Por favor, intenta nuevamente.');
        }

        return redirect('/recuperar')->with('status', 'Se ha enviado el enlace de recuperación por WhatsApp.');
    }

    public function cambio_contra($token)
    {
        $tokenData = DB::table('password_reset_tokens')->where('token', $token)->first();
        if (!$tokenData) {
            return redirect('/recuperar')->with(['error' => 'El enlace no es válido o ha expirado.']);
        }
        return view('pacientes.cambio_contra', ['token' => $token]);
    }

    public function actualizarContra(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]/|confirmed',
        ],[
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener mínimo 8 caracteres',
            'password.regex' => 'Mínimo 8 caracteres, incluye mayúsculas, minúsculas y números',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ]);

        $tokenData = DB::table('password_reset_tokens')->where('token', $request->token)->first();
        if (!$tokenData) {
            return redirect('/recuperar')->withErrors(['token' => 'El enlace de recuperación no es válido o ha expirado.']);
        }

        $usuario = DB::table('pacientes')->where('telefono', $tokenData->telefono)->first();
        if (!$usuario) {
            return redirect('/recuperar')->withErrors(['telefono' => 'No se encontró un usuario para este enlace.']);
        }

        DB::table('pacientes')->where('telefono', $tokenData->telefono)->update([
            'password' => Hash::make($request->password),
        ]);

        DB::table('password_reset_tokens')->where('token', $request->token)->delete();
        return redirect('/login')->with('status', 'Tu contraseña se ha cambiado exitosamente.');
    }

    public function informacion()
    {
        return view('pacientes.informacion_clinica');
    }
}
