<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\AsignacionHabitacion;
use Illuminate\Http\Request;

class DoctorHabitacionController extends Controller
{
    // Vista principal de búsqueda (H29)
    public function index()
    {
        return view('doctor.habitaciones.buscar');
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
                    ->orWhere('numero_expediente', 'LIKE', "%{$busqueda}%")
                    ->orWhere('numero_identidad', 'LIKE', "%{$busqueda}%");
            })
            ->get();

        return view('doctor.habitaciones.resultados', compact('pacientes', 'busqueda'));
    }

    // Ver habitaciones de mis pacientes (opcional)
    public function misPacientes()
    {
        // Aquí puedes filtrar por las citas del doctor autenticado
        // Por ahora mostramos todos los pacientes con habitación
        $asignaciones = AsignacionHabitacion::with(['paciente', 'habitacion'])
            ->where('estado', 'activo')
            ->orderBy('habitacion_id')
            ->get();

        return view('doctor.habitaciones.mis-pacientes', compact('asignaciones'));
    }
}
