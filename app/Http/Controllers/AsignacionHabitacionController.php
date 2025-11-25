<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Models\Paciente;
use App\Models\AsignacionHabitacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsignacionHabitacionController extends Controller
{
    // Mostrar lista de habitaciones (H28)
    public function index()
    {
        $habitaciones = Habitacion::with('asignacionActiva.paciente')->get();
        return view('enfermeria.habitaciones.index', compact('habitaciones'));
    }

    // Formulario de asignación
    public function create()
    {
        $habitacionesDisponibles = Habitacion::where('estado', 'disponible')
            ->whereDoesntHave('asignaciones', function($query) {
                $query->where('estado', 'activo');
            })->get();

        $pacientes = Paciente::whereHas('expediente')
            ->whereHas('citas', function($query){
                $query->where('fecha', '>=', now());
            })
            ->get();


        return view('enfermeria.habitaciones.asignar', compact('habitacionesDisponibles', 'pacientes'));
    }

    // Guardar asignación
    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'habitacion_id' => 'required|exists:habitaciones,id',
            'observaciones' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();
        try {
            // Verificar que la habitación esté disponible
            $habitacion = Habitacion::findOrFail($request->habitacion_id);

            if ($habitacion->estado !== 'disponible') {
                return back()->with('error', 'La habitación no está disponible');
            }

            // Verificar que el paciente no tenga otra habitación activa
            $asignacionActiva = AsignacionHabitacion::where('paciente_id', $request->paciente_id)
                ->where('estado', 'activo')
                ->first();

            if ($asignacionActiva) {
                return back()->with('error', 'El paciente ya tiene una habitación asignada');
            }

            // Crear asignación
            AsignacionHabitacion::create([
                'paciente_id' => $request->paciente_id,
                'habitacion_id' => $request->habitacion_id,
                'fecha_asignacion' => now(),
                'estado' => 'activo',
                'observaciones' => $request->observaciones
            ]);

            // Actualizar estado de habitación
            $habitacion->update(['estado' => 'ocupada']);

            DB::commit();
            return redirect()->route('enfermeria.habitaciones.index')
                ->with('success', 'Habitación asignada correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al asignar habitación: ' . $e->getMessage());
        }
    }

    // Liberar habitación
    public function liberar($id)
    {
        DB::beginTransaction();
        try {
            $asignacion = AsignacionHabitacion::findOrFail($id);

            $asignacion->update([
                'fecha_salida' => now(),
                'estado' => 'finalizado'
            ]);

            $asignacion->habitacion->update(['estado' => 'disponible']);

            DB::commit();
            return redirect()->route('enfermeria.habitaciones.index')
                ->with('success', 'Habitación liberada correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al liberar habitación');
        }
    }
    public function createRecepcionista()
    {
        $habitacionesDisponibles = Habitacion::where('estado', 'disponible')
            ->whereDoesntHave('asignaciones', function($query) {
                $query->where('estado', 'activo');
            })->get();

        $pacientes = Paciente::all();

        return view('recepcionista.habitaciones.asignar', compact('habitacionesDisponibles', 'pacientes'));
    }
    public function storeRecepcionista(Request $request)
    {
        return $this->store($request);
    }
}
