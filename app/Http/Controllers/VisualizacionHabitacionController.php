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
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        return view('recepcionista.habitaciones.buscarhabitacion');
    }

    // Buscar paciente y su habitación
    public function buscar(Request $request)
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        $request->validate([
            'busqueda' => 'required|string|min:3'
        ]);

        $busqueda = $request->busqueda;

        $pacientes = Paciente::with(['asignacionesHabitacion' => function($query) {
            $query->where('estado', 'activo')->with('habitacion');
        }])
            ->where(function($query) use ($busqueda) {
                $query->where('nombres', 'LIKE', "%{$busqueda}%")
                    ->orWhere('apellidos', 'LIKE', "%{$busqueda}%")
                    ->orWhere('numero_identidad', 'LIKE', "%{$busqueda}%");
            })
            ->get();

        return view('recepcionista.habitaciones.resultados', compact('pacientes', 'busqueda'));
    }

    // Ver todas las habitaciones ocupadas
    public function listarOcupadas()
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        $asignaciones = AsignacionHabitacion::with(['paciente', 'habitacion'])
            ->where('estado', 'activo')
            ->orderBy('habitacion_id')
            ->get();

        return view('recepcionista.habitaciones.ocupadas', compact('asignaciones'));
    }
}
