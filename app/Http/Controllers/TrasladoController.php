<?php

namespace App\Http\Controllers;

use App\Models\Traslado;
use App\Models\Paciente;
use App\Models\CalificacionTraslado;
use Illuminate\Http\Request;

class TrasladoController extends Controller
{
    public function create()
    {
        if (!session('paciente_id')) {
            return redirect()->route('inicioSesion')->with('error', 'Inicia sesión.');
        }

        $paciente = Paciente::with(['asignacionesHabitacion' => function ($query) {
            $query->where('estado', 'activo');
        }])->find(session('paciente_id'));

        if ($paciente->asignacionesHabitacion->isNotEmpty()) {
            return redirect()->route('perfil')->with('error', 'No puede solicitar traslado: Aún se encuentra internado.');
        }

        return view('pacientes.traslado', compact('paciente'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'direccion_destino' => 'required|string|max:255',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required',
            'unidad_id' => 'required',
            'costo_estimado' => 'required|numeric|min:1'
        ]);

        $traslado = new Traslado();
        $traslado->paciente_id = session('paciente_id');
        $traslado->direccion_destino = $request->direccion_destino;
        $traslado->fecha_traslado = $request->fecha . ' ' . $request->hora;
        $traslado->unidad_asignada = "Ambulancia #" . $request->unidad_id;
        $traslado->costo_estimado = $request->costo_estimado;
        $traslado->estado = 'Pendiente';
        $traslado->save();

        return redirect()->route('ambulancia.create')->with('success', 'El traslado ha sido registrado correctamente.');
    }

    /**
     * Validar acceso y mostrar vista (H83)
     */
    public function calificar($id)
    {
        if (!session('paciente_id')) {
            return redirect()->route('inicioSesion')->with('error', 'Inicia sesión.');
        }

        $traslado = Traslado::where('id', $id)
            ->where('paciente_id', session('paciente_id'))
            ->first();

        if (!$traslado) {
            return redirect()->route('perfil')->with('error', 'Acceso denegado o el registro no existe.');
        }

        return view('pacientes.calificar_traslado', compact('traslado'));
    }

    /**
     * Implementar el guardado y retornar a la misma ventana (H83)
     */
    public function guardarCalificacion(Request $request)
    {
        $request->validate([
            'traslado_id' => 'required|exists:traslados,id',
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:255'
        ]);

        CalificacionTraslado::create([
            'traslado_id' => $request->traslado_id,
            'puntuacion' => $request->puntuacion,
            'comentario' => $request->comentario
        ]);

        return back()->with('success', 'El traslado ha sido calificado correctamente.');
    }

    /**
     * Historial de traslados para recepcionista (H104)
     */
    public function historial(Request $request)
    {
        if (!session('empleado_id')) {
            return redirect()->route('inicioSesion')->with('error', 'Debes iniciar sesión.');
        }

        $query = Traslado::with('paciente')->orderBy('fecha_traslado', 'desc');

        // Filtro por nombre de paciente
        if ($request->filled('busqueda')) {
            $busqueda = $request->busqueda;
            $query->whereHas('paciente', function ($q) use ($busqueda) {
                $q->where('nombres', 'like', "%{$busqueda}%")
                    ->orWhere('apellidos', 'like', "%{$busqueda}%");
            });
        }

        // Filtro por fecha
        if ($request->filled('fecha')) {
            $query->whereDate('fecha_traslado', $request->fecha);
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $traslados  = $query->paginate(10)->withQueryString();
        $total      = Traslado::count();
        $pendientes = Traslado::where('estado', 'Pendiente')->count();
        $completados = Traslado::where('estado', 'Completado')->count();
        $cancelados  = Traslado::where('estado', 'Cancelado')->count();

        return view('recepcionista.historial_traslados', compact(
            'traslados', 'total', 'pendientes', 'completados', 'cancelados'
        ));
    }
}
