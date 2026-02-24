<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Cirugia;
use App\Models\Empleado;
use App\Models\EvaluacionPrequirurgica;
use App\Models\Paciente;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CirugiaController extends Controller
{
    /**
     * Mostrar formulario de evaluación prequirúrgica (desde la cita programada).
     */
    public function crearEvaluacion($cita_id)
    {
        if (!session('cargo') || session('cargo') != 'Doctor') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Doctor.');
        }

        $cita = Cita::with('paciente')->findOrFail($cita_id);

        // Verificar que la cita pertenece a este doctor
        if ($cita->empleado_id != session('empleado_id')) {
            return redirect()->route('doctor.citas')
                ->with('error', 'No tienes acceso a esta cita.');
        }

        // Si ya existe una evaluación para esta cita, mostrarla
        $evaluacionExistente = EvaluacionPrequirurgica::where('cita_id', $cita_id)->first();

        return view('doctor.evaluacion_prequirurgica', compact('cita', 'evaluacionExistente'));
    }

    /**
     * Guardar la evaluación prequirúrgica.
     */
    public function guardarEvaluacion(Request $request)
    {
        if (!session('cargo') || session('cargo') != 'Doctor') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Doctor.');
        }

        $request->validate(EvaluacionPrequirurgica::rules());

        // Evitar duplicados
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
            ->with('success', '¡Evaluación prequirúrgica guardada! Ahora puedes agendar la cirugía.');
    }

    /**
     * Ver evaluación guardada con botón "Agendar Cirugía".
     */
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
    //  H74 – RECEPCIONISTA: Programar cirugía en quirófano
    // ─────────────────────────────────────────────

    /**
     * Formulario para programar cirugía (recepcionista).
     * Abre desde el botón "Agendar Cirugía" con datos precargados.
     */
    public function programarCirugia($evaluacion_id)
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista.');
        }

        $evaluacion = EvaluacionPrequirurgica::with(['paciente', 'doctor', 'cita'])->findOrFail($evaluacion_id);

        // Si ya fue programada, redirigir
        if ($evaluacion->cirugia) {
            return redirect()->route('recepcionista.cirugia.ver', $evaluacion->cirugia->id)
                ->with('info', 'Esta cirugía ya fue programada.');
        }

        $quirofanos = ['Quirófano 1', 'Quirófano 2', 'Quirófano 3', 'Quirófano 4'];

        return view('recepcionista.programar_cirugia', compact('evaluacion', 'quirofanos'));
    }

    /**
     * Guardar la cirugía programada en BD.
     */
    public function guardarCirugia(Request $request)
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista.');
        }

        $request->validate(Cirugia::rules());

        // Verificar que el quirófano esté disponible en esa fecha y hora
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
            'evaluacion_id'          => $request->evaluacion_id,
            'paciente_id'            => $evaluacion->paciente_id,
            'empleado_id'            => $evaluacion->empleado_id,
            'tipo_cirugia'           => $evaluacion->tipo_cirugia,
            'quirofano'              => $request->quirofano,
            'fecha_cirugia'          => $request->fecha_cirugia,
            'hora_inicio'            => $request->hora_inicio,
            'hora_fin'               => $request->hora_fin,
            'duracion_estimada_min'  => $request->duracion_estimada_min,
            'anestesiologo'          => $request->anestesiologo,
            'instrumentos_requeridos'=> $request->instrumentos_requeridos,
            'notas_adicionales'      => $request->notas_adicionales,
            'estado'                 => 'programada',
        ]);

        return redirect()->route('recepcionista.cirugia.ver', $cirugia->id)
            ->with('success', '¡Cirugía programada exitosamente en ' . $request->quirofano . '!');
    }

    /**
     * Ver detalle de cirugía programada (recepcionista).
     */
    public function verCirugia($id)
    {
        if (!session('cargo') || !in_array(session('cargo'), ['Recepcionista', 'Doctor'])) {
            return redirect()->route('inicioSesion')
                ->with('error', 'Acceso no autorizado.');
        }

        $cirugia = Cirugia::with(['evaluacion', 'paciente', 'doctor'])->findOrFail($id);

        return view('recepcionista.ver_cirugia', compact('cirugia'));
    }

    /**
     * Panel "Mis Cirugías Quirúrgicas" del doctor.
     */
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

    /**
     * Verificar disponibilidad de quirófano (AJAX).
     */
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
    public function indexRecepcionista()
    {
        // Evaluaciones aprobadas por el doctor SIN cirugía programada aún
        $evaluaciones = \App\Models\EvaluacionPrequirurgica::whereDoesntHave('cirugia')
            ->with(['paciente', 'doctor'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Todas las cirugías ya programadas
        $cirugias = \App\Models\Cirugia::with(['paciente', 'doctor'])
            ->orderBy('fecha_cirugia', 'asc')
            ->get();

        // Contadores para las stats
        $evaluacionesPendientes = $evaluaciones->count();
        $cirugiasProgramadas = $cirugias->where('estado', 'programada')->count();
        $cirugiasCompletadas = $cirugias->where('estado', 'completada')->count();
        $cirugiasCanceladas = $cirugias->where('estado', 'cancelada')->count();

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











