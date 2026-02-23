<?php

namespace App\Http\Controllers;

use App\Models\Traslado;
use App\Models\Paciente;
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
}
