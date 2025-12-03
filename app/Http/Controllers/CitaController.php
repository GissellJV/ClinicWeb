<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CitaController extends Controller
{
    // AGENDAR CITAS RECEPCIONISTA
    public function agendar()
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        $pacientes = Paciente::all();
        $doctores = Empleado::where('cargo', 'Doctor')->get();
        $especialidades = Empleado::where('cargo', 'Doctor')
            ->select('departamento')
            ->distinct()
            ->pluck('departamento');

        return view('recepcionista.agendar-cita', compact('pacientes', 'doctores', 'especialidades'));
    }

    //Vista del recepcionista
    public function index()
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        // Cargar las citas con las relaciones
        $citas = Cita::with(['doctor', 'paciente'])
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->paginate(10);

        return view('pacientes.listado_citaspro', compact('citas'));
    }

    //Vista del paciente
    public function misCitas()
    {
        if (!session('paciente_id')) {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión para visualizar tus citas');
        }

        $paciente_id = session('paciente_id');

        if (!$paciente_id) {
            return redirect()->route('pacientes.loginp')->with('error', 'Debes iniciar sesión para ver tus citas');
        }

        $paciente = Paciente::find($paciente_id);

        if (!$paciente) {
            return redirect()->back()->with('error', 'No se encontró información del paciente');
        }

        $citas = Cita::with('doctor')
            ->where('paciente_id', $paciente->id)
            ->Paginate(9);

        return view('citas.mis-citas', compact('citas'));
    }

    //  Cancelar cita
    public function cancelarCita($id)
    {
        if (!session('paciente_id')) {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión primero');
        }

        $cita = Cita::findOrFail($id);
        $paciente_id = session('paciente_id');
        $paciente = Paciente::find($paciente_id);

        if ($cita->paciente_id !== $paciente->id) {
            return redirect()->back()->with('error', 'No tienes permiso para cancelar esta cita');
        }

        $cita->update([
            'estado' => 'cancelada',
            'mensaje' => null
        ]);

        return redirect()->back()->with('success', 'Cita cancelada exitosamente');
    }

    //  Reprogramar cita
    public function reprogramarCita(Request $request, $id)
    {

        if (!session('paciente_id')) {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión primero');
        }

        $request->validate([
            'nueva_fecha' => 'required|date|after:today',
            'nueva_hora' => 'required'
        ]);

        $cita = Cita::findOrFail($id);
        $paciente_id = session('paciente_id');
        $paciente = Paciente::find($paciente_id);

        if ($cita->paciente_id !== $paciente->id) {
            return redirect()->back()->with('error', 'No tienes permiso para reprogramar esta cita');
        }

        $cita->update([
            'fecha' => $request->nueva_fecha,
            'hora' => $request->nueva_hora,
            'estado' => 'reprogramada',
            'mensaje' => null
        ]);

        return redirect()->back()->with('success', 'Cita reprogramada exitosamente');
    }

    //Confirmar cita (recepcionista)
    public function confirmarCita($id)
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        $cita = Cita::findOrFail($id);

        if ($cita->estado !== 'pendiente') {
            return redirect()->back()->with('error', 'La cita no se puede confirmar porque no está pendiente.');
        }

        // Construir el nombre completo del doctor con el título según el género
        if ($cita->doctor) {
            $titulo = $cita->doctor->genero === 'Femenino' ? 'Dra.' : 'Dr.';
            $doctorNombre = "{$titulo} {$cita->doctor->nombre} {$cita->doctor->apellido}";
        } else {
            $doctorNombre = $cita->doctor_nombre ?? 'Doctor no asignado';
        }

        $cita->estado = 'programada';
        $cita->mensaje = "Tu cita con  {$doctorNombre} ha sido confirmada para las {$cita->hora}.";
        $cita->save();

        return redirect()->back()->with('success', 'Cita confirmada correctamente.');
    }

    public function guardarDesdeCalendario(Request $request)
    {
        $request->validate([
            'fecha' => [
                'required',
                'date',
                'after_or_equal:today'
            ],
            'hora' => 'required|string',
            'doctor_id' => 'required|exists:empleados,id',
            'especialidad' => 'required|string',
        ]);

        $paciente_id = session('paciente_id');
        $paciente_nombre = session('paciente_nombre');

        if (!$paciente_id || !$paciente_nombre) {
            return response()->json([
                'success' => false,
                'message' => 'Debe iniciar sesión como paciente'
            ], 401);
        }

        try {

            $fechaSeleccionada = Carbon::parse($request->fecha);
            $hoy = Carbon::today();

            if ($fechaSeleccionada->lt($hoy)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se pueden agendar citas en fechas pasadas.'
                ]);
            }

            // NUEVA VALIDACIÓN: Verificar si el PACIENTE ya tiene una cita en esa fecha y hora
            $pacienteTieneCita = Cita::where('paciente_id', $paciente_id)
                ->where('fecha', $request->fecha)
                ->where('hora', $request->hora)
                ->whereIn('estado', ['pendiente', 'programada'])
                ->exists();

            if ($pacienteTieneCita) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya tienes una cita agendada para esta fecha y hora. No puedes agendar otra cita al mismo tiempo.'
                ]);
            }

            // Obtener información del doctor
            $doctor = Empleado::findOrFail($request->doctor_id);

            // Verificar disponibilidad del DOCTOR
            $citaExistente = Cita::where('empleado_id', $request->doctor_id)
                ->where('fecha', $request->fecha)
                ->where('hora', $request->hora)
                ->whereIn('estado', ['pendiente', 'programada'])
                ->exists();

            if ($citaExistente) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este horario ya está ocupado con el doctor seleccionado. Por favor seleccione otro horario.'
                ]);
            }

            // Crear la cita
            $cita = Cita::create([
                'paciente_id' => $paciente_id,
                'paciente_nombre' => $paciente_nombre,
                'empleado_id' => $request->doctor_id,
                'doctor_nombre' => 'Dr. ' . $doctor->nombre . ' ' . ($doctor->apellido ?? ''),
                'especialidad' => $request->especialidad,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'estado' => 'pendiente',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Cita agendada exitosamente',
                'cita_id' => $cita->id
            ]);

        } catch (\Exception $e) {
            \Log::error('Error al guardar cita: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la solicitud: ' . $e->getMessage()
            ], 500);
        }
    }

    public function obtenerHorarios($doctorId, $fecha)
    {
        $paciente_id = session('paciente_id');

        // Horarios base del consultorio
        $horariosBase = [
            '08:00 AM', '09:00 AM', '10:00 AM', '11:00 AM',
            '01:00 PM', '02:00 PM', '03:00 PM', '04:00 PM', '05:00 PM'
        ];

        // Obtener citas ya agendadas para ese doctor en esa fecha
        $citasOcupadasDoctor = Cita::where('empleado_id', $doctorId)
            ->where('fecha', $fecha)
            ->whereIn('estado', ['pendiente', 'programada'])
            ->pluck('hora')
            ->toArray();


        $citasPaciente = [];
        if ($paciente_id) {
            $citasPaciente = Cita::where('paciente_id', $paciente_id)
                ->where('fecha', $fecha)
                ->whereIn('estado', ['pendiente', 'programada'])
                ->pluck('hora')
                ->toArray();
        }

        // Crear array de horarios con disponibilidad
        $horarios = [];
        foreach ($horariosBase as $hora) {
            $ocupadoDoctor = in_array($hora, $citasOcupadasDoctor);
            $ocupadoPaciente = in_array($hora, $citasPaciente);

            $horarios[] = [
                'hora' => $hora,
                'disponible' => !$ocupadoDoctor && !$ocupadoPaciente,
                'motivo' => $ocupadoPaciente ? 'paciente' : ($ocupadoDoctor ? 'doctor' : null)
            ];
        }

        return response()->json($horarios);
    }

    // GUARDAR CITA RECEPCIONISTA
    public function guardarCitaRecepcionista(Request $request)
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        // Validación más robusta
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'especialidad' => 'required|string|max:255',
            'empleado_id' => 'required|exists:empleados,id',
            'fecha' => [
                'required',
                'date',
                'after_or_equal:today',
                function ($attribute, $value, $fail) {
                    $fechaSeleccionada = \Carbon\Carbon::parse($value);
                    $hoy = \Carbon\Carbon::today();

                    if ($fechaSeleccionada->lt($hoy)) {
                        $fail('La fecha de la cita no puede ser anterior a hoy.');
                    }
                }
            ],
            'hora' => 'required',
            'motivo' => 'required|string|max:500'
        ]);

        // Verificar disponibilidad (ya lo tienes)
        $citaExistente = Cita::where('empleado_id', $request->empleado_id)
            ->where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->whereIn('estado', ['pendiente', 'programada'])
            ->first();

        if ($citaExistente) {
            return back()->with('error', 'El horario seleccionado ya está ocupado. Por favor, elija otro.')
                ->withInput();
        }

        // Obtener datos del paciente y doctor
        $paciente = Paciente::findOrFail($request->paciente_id);
        $doctor = Empleado::findOrFail($request->empleado_id);

        // Crear la cita
        Cita::create([
            'paciente_id' => $request->paciente_id,
            'paciente_nombre' => $paciente->nombres . ' ' . $paciente->apellidos,
            'empleado_id' => $request->empleado_id,
            'doctor_nombre' => 'Dr. ' . $doctor->nombre,
            'especialidad' => $request->especialidad,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'motivo' => $request->motivo,
            'estado' => 'programada'
        ]);

        return redirect()->route('listadocitas')
            ->with('success', '¡Cita agendada exitosamente!');
    }

    public function getDoctoresPorEspecialidad($departamento)
    {
        $doctores = Empleado::where('cargo', 'Doctor')
            ->where('departamento', $departamento)
            ->get(['id', 'nombre', 'departamento']);

        return response()->json($doctores);
    }

    public function verificarDisponibilidad(Request $request)
    {
        $citaExistente = Cita::where('empleado_id', $request->empleado_id)
            ->where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->whereIn('estado', ['pendiente', 'programada'])
            ->exists();

        return response()->json(['disponible' => !$citaExistente]);
    }

    // VER CITAS DEL DOCTOR

    public function misCitasDoctor(Request $request)
    {
        if (!session('cargo') || session('cargo') != 'Doctor') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Doctor');
        }

        $empleado_id = session('empleado_id');

        // Query base
        $query = Cita::with(['paciente'])
            ->where('empleado_id', $empleado_id);

        // Aplicar filtros
        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Ordenamiento
        if ($request->filled('orden')) {
            if ($request->orden == 'fecha_asc') {
                $query->orderBy('fecha', 'asc')->orderBy('hora', 'asc');
            } else {
                $query->orderBy('fecha', 'desc')->orderBy('hora', 'desc');
            }
        } else {
            $query->orderBy('fecha', 'asc')->orderBy('hora', 'asc');
        }

        $citas = $query->paginate(10);

        // Contar citas de hoy
        $citasHoy = Cita::where('empleado_id', $empleado_id)
            ->whereDate('fecha', Carbon::today())
            ->whereIn('estado', ['programada', 'pendiente'])
            ->count();

        return view('doctor.mis-citas', compact('citas', 'citasHoy'));
    }

    public function completarCita($id)
    {
        if (!session('cargo') || session('cargo') != 'Doctor') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Doctor');
        }

        $cita = Cita::where('id', $id)
            ->where('empleado_id', session('empleado_id'))
            ->firstOrFail();

        $cita->update([
            'estado' => 'completada'
        ]);

        return redirect()->back()->with('success', 'Cita marcada como completada');
    }
}
