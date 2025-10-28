<?php

namespace App\Http\Controllers;

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


class PacienteController extends Controller
{
    public function registrarpaciente(){
        return view('pacientes.registrarpaciente');
    }
    public function store(Request $request)
    {
        // Validar datos
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date|before:today',
            'numero_identidad' => 'required|string|size:13|regex:/^\d{4}\d{4}\d{5}$/|unique:pacientes',
            'genero' => 'required|in:Femenino,Masculino',
            'telefono' => 'required|string|min:8|max:15',
            'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]/|confirmed',

        ], [

            'nombres.required' => 'Nombres obligatorios',
            'apellidos.required' => 'Apellidos obligatorios ',
            'fecha_nacimiento.required' => 'Fecha de nacimiento obligatoria',
            'fecha_nacimiento.before' => 'Ingresa una fecha valida',
            'genero.required' => 'Selecciona un genero',
            'numero_identidad.required' => 'El número de identidad es obligatorio',
            'numero_identidad.regex' => 'El formato del número de identidad no es valido',
            'numero_identidad.size' => 'El número de identidad debe tener 13 dígitos',
            'numero_identidad.unique' => 'El número de identidad ya ha sido registrado',
            'telefono.required' => 'Teléfono  obligatorio',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener mínimo 8 caracteres',
            'password.regex' => 'La contraseña debe contener al menos:
             - 8 caracteres
             - Una letra mayúscula
             - Una letra minúscula
             - Un número',
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


       //dirigirse a iniciar sesion // if($nuevoPaciente->save()){

      return redirect()->route('pacientes.loginp')->with('mensaje', 'Registro exitoso, Inicia sesión');
    }

    public function listado_citaspro(Request $request){

        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('empleados.loginempleado')
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

    public function loginp()
    {
        return view('pacientes.iniciodesesion');
    }
    public function login(Request $request){

        $request->validate([
            'telefono' => 'required|string',
            'password' => 'required|string',
        ],[
            'telefono.required'=>'Ingresa el número de teléfono',
            'password.required'=>'Ingresa la contraseña'
        ]);

        $paciente= Paciente::where('telefono',$request->input('telefono'))->first();

        if($paciente && Hash::check($request->password, $paciente->password)){

            session([
                'paciente_id' => $paciente->id,
                'paciente_nombre' => $paciente->nombres . ' ' . $paciente->apellidos,
            ]);

            return redirect()->route('agendarcitas')
                ->with('mensaje', '¡Bienvenido ' . $paciente->nombres . '!');
        }

        return back()
            ->with('error', 'El número de teléfono o la contraseña son incorrectos.')
            ->withInput($request->only('telefono'));

    }

    // Cerrar sesión
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
                    return redirect()->route('pacientes.loginp')
              ->with('error', 'Debes iniciar sesión primero');
      }

        $paciente = Paciente::find(session('paciente_id'));

        return view('pacientes.agendar_Citasonline', compact('paciente'));
    }

    public function enviarCodigoRecuperacion(Request $request)

    {
        $request->validate([
            'telefono' => 'required|digits_between:7,8'
        ]);

        $pacientes = DB::table('pacientes')->where('telefono', $request->input('telefono'))->first();
        if (!$pacientes) {
            return
                back()->withErrors(['telefono' => 'Este numero no está registrado.']);
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
            return back()->withErrors(['whatsapp' => 'Error al enviar el mensaje: ' . $response->body()]);
        }

        return redirect('/recuperar')->with('status', 'Se ha enviado el enlace de recuperación por WhatsApp.');
    }

    public function cambio_contra($token)
    {
        $tokenData = DB::table('password_reset_tokens')->where('token', $token)->first();
        if (!$tokenData) {
            return redirect('/recuperar')->withErrors(['token' => 'El enlace no es válido o ha expirado.']);
        }
        return view('pacientes.cambio_contra', ['token' => $token]);
    }

    public function actualizarContra(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
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
        return redirect('/loginpaciente')->with('status', 'Tu contraseña se ha cambiado exitosamente.');
    }



    public function informacion()
    {
        return view('pacientes.informacion_clinica');
    }



}
