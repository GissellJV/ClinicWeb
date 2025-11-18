<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\AsignacionHabitacion;
use Illuminate\Http\Request;

class VisualizacionHabitacionController extends Controller
{
    // Mostrar vista de búsqueda (H30)
    public function index()
    {
        return view('recepcionista.habitaciones.buscarhabitacion');
    }

    // Buscar paciente y su habitación
    public function buscar(Request $request)
    {
        $request->validate([
            'busqueda' => 'required|string|min:3'
        ]);

        $busqueda = $request->busqueda;

        $pacientes = Paciente::with(['asignacionesHabitacion' => function($query) {
            $query->where('estado', 'activo')->with('habitacion');
        }])
            ->where(function($query) use ($busqueda) {
                $query->where('nombre', 'LIKE', "%{$busqueda}%")
                    ->orWhere('apellido', 'LIKE', "%{$busqueda}%")
                    ->orWhere('numero_expediente', 'LIKE', "%{$busqueda}%");
            })
            ->get();

        return view('recepcionista.habitaciones.resultados', compact('pacientes', 'busqueda'));
    }

    // Ver todas las habitaciones ocupadas
    public function listarOcupadas()
    {
        $asignaciones = AsignacionHabitacion::with(['paciente', 'habitacion'])
            ->where('estado', 'activo')
            ->orderBy('habitacion_id')
            ->get();

        return view('recepcionista.habitaciones.ocupadas', compact('asignaciones'));
    }
}
