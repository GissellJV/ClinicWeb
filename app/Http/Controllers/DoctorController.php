<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Cirugia;
use App\Models\Empleado;
use App\Models\EnviarDoctor;
use App\Models\EvaluacionPrequirurgica;
use App\Models\Expediente;
use App\Models\IncapacidadMedica;
use App\Models\Paciente;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    // ─────────────────────────────────────────────
    //  EXPEDIENTES
    // ─────────────────────────────────────────────

    public function verExpediente($pacienteId)
    {
        if (!session('cargo') || session('cargo') != 'Doctor') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Doctor');
        }

        $doctorId = session('empleado_id');

        $asignacion = EnviarDoctor::where('empleado_id', $doctorId)
            ->where('paciente_id', $pacienteId)
            ->firstOrFail();

        $asignacion->update(['estado' => 'completado']);

        $expediente = Expediente::with('paciente')->where('paciente_id', $pacienteId)->firstOrFail();

        return view('expedientes.verexpediente', compact('expediente'));
    }

    public function expedientesRecibidos()
    {
        if (!session('cargo') || session('cargo') != 'Doctor') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Doctor');
        }

        $doctorId = session('empleado_id');

        if (!$doctorId) {
            abort(404, 'ID del doctor no encontrado en sesión');
        }

        $expedientes = EnviarDoctor::with('paciente')
            ->where('empleado_id', $doctorId)
            ->orderBy('created_at', 'DESC')
            ->paginate(6);

        return view('doctor.expedientes_recibidos', compact('expedientes'));
    }

    // ─────────────────────────────────────────────
    //  DOCTORES
    // ─────────────────────────────────────────────

    public function getDoctoresPorEspecialidad($departamento)
    {
        $doctores = Empleado::where('cargo', 'Doctor')
            ->where('departamento', $departamento)
            ->get(['id', 'nombre', 'apellido', 'foto', 'genero']);

        return response()->json($doctores);
    }

    public function visualizacion_Doctores()
    {
        $doctores = Empleado::where('cargo', 'Doctor')->get();

        return view('index', compact('doctores'));
    }

    // ─────────────────────────────────────────────
    //  RECETA
    // ─────────────────────────────────────────────

    public function receta()
    {
        if (!session('cargo') || session('cargo') != 'Doctor') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Doctor');
        }

        return view('empleados.recetamedica');
    }

    // ─────────────────────────────────────────────
    //  H71 – EVALUACIÓN PREQUIRÚRGICA
    // ─────────────────────────────────────────────

    public function crearEvaluacion($cita_id)
    {
        if (!session('cargo') || session('cargo') != 'Doctor') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Doctor.');
        }

        $cita = Cita::with('paciente')->findOrFail($cita_id);

        if ($cita->empleado_id != session('empleado_id')) {
            return redirect()->route('doctor.citas')
                ->with('error', 'No tienes acceso a esta cita.');
        }

        $evaluacionExistente = EvaluacionPrequirurgica::where('cita_id', $cita_id)->first();

        return view('doctor.evaluacion_prequirurgica', compact('cita', 'evaluacionExistente'));
    }

    public function guardarEvaluacion(Request $request)
    {
        if (!session('cargo') || session('cargo') != 'Doctor') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Doctor.');
        }

        $request->validate(EvaluacionPrequirurgica::rules());

        $yaExiste = EvaluacionPrequirurgica::where('cita_id', $request->cita_id)->exists();
        if ($yaExiste) {
            return redirect()->back()
                ->with('error', 'Ya existe una evaluación para esta cita.')
                ->withInput();
        }

        $evaluacion = EvaluacionPrequirurgica::create([
            'cita_id'                   => $request->cita_id,
            'paciente_id'               => $request->paciente_id,
            'empleado_id'               => session('empleado_id'),
            'tipo_cirugia'              => $request->tipo_cirugia,
            'diagnostico'               => $request->diagnostico,
            'descripcion_procedimiento' => $request->descripcion_procedimiento,
            'nivel_riesgo'              => $request->nivel_riesgo,
            'observaciones'             => $request->observaciones,
            'presion_arterial'          => $request->presion_arterial,
            'temperatura'               => $request->temperatura,
            'frecuencia_cardiaca'       => $request->frecuencia_cardiaca,
            'frecuencia_respiratoria'   => $request->frecuencia_respiratoria,
            'peso'                      => $request->peso,
            'talla'                     => $request->talla,
            'alergias'                  => $request->alergias,
            'medicamentos_actuales'     => $request->medicamentos_actuales,
            'antecedentes_quirurgicos'  => $request->antecedentes_quirurgicos,
            'estado'                    => 'aprobada',
        ]);

        return redirect()->route('doctor.evaluacion.ver', $evaluacion->id)
            ->with('success', '¡Evaluación prequirúrgica guardada! La recepcionista puede agendar la cirugía.');
    }

    public function verEvaluacion($id)
    {
        if (!session('cargo') || session('cargo') != 'Doctor') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Doctor.');
        }

        $evaluacion = EvaluacionPrequirurgica::with(['cita', 'paciente', 'doctor'])->findOrFail($id);

        return view('doctor.ver_evaluacion', compact('evaluacion'));
    }

    // ─────────────────────────────────────────────
    //  H71 – MIS CIRUGÍAS (panel del doctor)
    // ─────────────────────────────────────────────

    public function misCirugias(Request $request)
    {
        if (!session('cargo') || session('cargo') != 'Doctor') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Doctor.');
        }

        $empleado_id = session('empleado_id');

        $query = Cirugia::with(['paciente', 'evaluacion'])
            ->where('empleado_id', $empleado_id);

        if ($request->filled('fecha')) {
            $query->whereDate('fecha_cirugia', $request->fecha);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $query->orderBy('fecha_cirugia', 'asc')->orderBy('hora_inicio', 'asc');

        $cirugias = $query->paginate(10);

        $cirugiasProgramadas = Cirugia::where('empleado_id', $empleado_id)
            ->where('estado', 'programada')
            ->count();

        $cirugiaHoy = Cirugia::where('empleado_id', $empleado_id)
            ->whereDate('fecha_cirugia', Carbon::today())
            ->where('estado', '!=', 'cancelada')
            ->count();

        return view('doctor.mis_cirugias', compact('cirugias', 'cirugiasProgramadas', 'cirugiaHoy'));
    }

    // ─────────────────────────────────────────────
    //  H74 – RECEPCIONISTA: Programar cirugía
    // ─────────────────────────────────────────────

    public function programarCirugia($evaluacion_id)
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista.');
        }

        $evaluacion = EvaluacionPrequirurgica::with(['paciente', 'doctor', 'cita'])->findOrFail($evaluacion_id);

        if ($evaluacion->cirugia) {
            return redirect()->route('recepcionista.cirugia.ver', $evaluacion->cirugia->id)
                ->with('info', 'Esta cirugía ya fue programada.');
        }

        $quirofanos = ['Quirófano 1', 'Quirófano 2', 'Quirófano 3', 'Quirófano 4'];

        return view('recepcionista.programar_cirugia', compact('evaluacion', 'quirofanos'));
    }

    public function guardarCirugia(Request $request)
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista.');
        }

        $request->validate(Cirugia::rules());

        $conflicto = Cirugia::where('quirofano', $request->quirofano)
            ->where('fecha_cirugia', $request->fecha_cirugia)
            ->where('estado', '!=', 'cancelada')
            ->where(function ($q) use ($request) {
                $q->whereBetween('hora_inicio', [$request->hora_inicio, $request->hora_fin])
                    ->orWhereBetween('hora_fin', [$request->hora_inicio, $request->hora_fin]);
            })
            ->exists();

        if ($conflicto) {
            return redirect()->back()
                ->with('error', 'El quirófano ya está ocupado en ese horario. Por favor, elige otro.')
                ->withInput();
        }

        $evaluacion = EvaluacionPrequirurgica::findOrFail($request->evaluacion_id);

        $cirugia = Cirugia::create([
            'evaluacion_id'           => $request->evaluacion_id,
            'paciente_id'             => $evaluacion->paciente_id,
            'empleado_id'             => $evaluacion->empleado_id,
            'tipo_cirugia'            => $evaluacion->tipo_cirugia,
            'quirofano'               => $request->quirofano,
            'fecha_cirugia'           => $request->fecha_cirugia,
            'hora_inicio'             => $request->hora_inicio,
            'hora_fin'                => $request->hora_fin,
            'duracion_estimada_min'   => $request->duracion_estimada_min,
            'anestesiologo'           => $request->anestesiologo,
            'instrumentos_requeridos' => $request->instrumentos_requeridos,
            'notas_adicionales'       => $request->notas_adicionales,
            'estado'                  => 'programada',
        ]);

        return redirect()->route('recepcionista.cirugia.ver', $cirugia->id)
            ->with('success', '¡Cirugía programada exitosamente en ' . $request->quirofano . '!');
    }

    public function verCirugia($id)
    {
        if (!session('cargo') || !in_array(session('cargo'), ['Recepcionista', 'Doctor'])) {
            return redirect()->route('inicioSesion')
                ->with('error', 'Acceso no autorizado.');
        }

        $cirugia = Cirugia::with(['evaluacion', 'paciente', 'doctor'])->findOrFail($id);

        return view('recepcionista.ver_cirugia', compact('cirugia'));
    }

    public function verificarQuirofano(Request $request)
    {
        $ocupado = Cirugia::where('quirofano', $request->quirofano)
            ->where('fecha_cirugia', $request->fecha)
            ->where('estado', '!=', 'cancelada')
            ->where(function ($q) use ($request) {
                $q->whereBetween('hora_inicio', [$request->hora_inicio, $request->hora_fin])
                    ->orWhereBetween('hora_fin', [$request->hora_inicio, $request->hora_fin]);
            })
            ->exists();

        return response()->json(['disponible' => !$ocupado]);
    }

    // ─────────────────────────────────────────────
    //  H74 – RECEPCIONISTA: Index cirugías
    // ─────────────────────────────────────────────

    public function indexRecepcionista()
    {
        $evaluaciones = EvaluacionPrequirurgica::whereDoesntHave('cirugia')
            ->with(['paciente', 'doctor'])
            ->orderBy('created_at', 'desc')
            ->get();

        $cirugias = Cirugia::with(['paciente', 'doctor'])
            ->orderBy('fecha_cirugia', 'asc')
            ->get();

        $evaluacionesPendientes = $evaluaciones->count();
        $cirugiasProgramadas    = $cirugias->where('estado', 'programada')->count();
        $cirugiasCompletadas    = $cirugias->where('estado', 'completada')->count();
        $cirugiasCanceladas     = $cirugias->where('estado', 'cancelada')->count();

        return view('recepcionista.cirugias', compact(
            'evaluaciones',
            'cirugias',
            'evaluacionesPendientes',
            'cirugiasProgramadas',
            'cirugiasCompletadas',
            'cirugiasCanceladas'
        ));
    }




}
