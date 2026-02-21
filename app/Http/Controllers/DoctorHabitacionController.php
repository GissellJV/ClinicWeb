<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;
use App\Models\AsignacionHabitacion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DoctorHabitacionController extends Controller
{
    // Vista principal de búsqueda (H29)
    public function index()
    {
        if (!session('cargo') || session('cargo') != 'Doctor') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Doctor');
        }

        return view('doctor.habitaciones.buscar');
    }

    // Buscar paciente y su habitación
    public function buscar(Request $request)
    {
        if (!session('cargo') || session('cargo') != 'Doctor') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Doctor');
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

        return view('doctor.habitaciones.resultados', compact('pacientes', 'busqueda'));
    }

    // Ver habitaciones de mis pacientes (opcional)
    public function misPacientes()
    {
        if (!session('cargo') || session('cargo') != 'Doctor') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Doctor');
        }

        // Aquí puedes filtrar por las citas del doctor autenticado
        // Por ahora mostramos todos los pacientes con habitación
        $asignaciones = AsignacionHabitacion::with(['paciente', 'habitacion'])
            ->where('estado', 'activo')
            ->orderBy('habitacion_id')
            ->get();

        return view('doctor.habitaciones.pacientes-hospitalizados', compact('asignaciones'));
    }

    public function alta_pacientes(Request $request)
    {
       // Verificar sesión de doctor
        if (!session('cargo') || session('cargo') != 'Doctor') {
         return redirect()->route('inicioSesion')
              ->with('error', 'Debes iniciar sesión como Doctor');
       }

       $doctorId = session('empleado_id');

       $pacienteIds = Cita::where('empleado_id', $doctorId)
         ->pluck('paciente_id')
         ->unique();

       $query = AsignacionHabitacion::with(['paciente', 'habitacion'])
         ->where('estado', 'finalizado')
        ->whereNotNull('fecha_salida')
         ->whereIn('paciente_id', $pacienteIds);

        // Filtro por búsqueda de nombre
       if ($request->filled('buscar')) {
             $buscar = $request->buscar;
           $query->whereHas('paciente', function($q) use ($buscar) {
                      $q->where('nombres', 'like', '%' . $buscar . '%')
                 ->orWhere('apellidos', 'like', '%' . $buscar . '%')
                 ->orWhere('numero_identidad', 'like', '%' . $buscar . '%');
          });
       }

       if ($request->filled('fecha_inicio')) {
              $query->whereDate('fecha_salida', '>=', $request->fecha_inicio);
       }

       if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha_salida', '<=', $request->fecha_fin);
       }

      $pacientes = $query->orderBy('fecha_salida', 'desc')->get();

       // Estadísticas también filtradas por el doctor
       $totalAltas = AsignacionHabitacion::where('estado', 'finalizado')
          ->whereIn('paciente_id', $pacienteIds)
         ->count();

       $altasMes = AsignacionHabitacion::where('estado', 'finalizado')
           ->whereIn('paciente_id', $pacienteIds)
          ->whereMonth('fecha_salida', Carbon::now()->month)
         ->whereYear('fecha_salida', Carbon::now()->year)
        ->count();

       $altasSemana = AsignacionHabitacion::where('estado', 'finalizado')
         ->whereIn('paciente_id', $pacienteIds)
         ->whereBetween('fecha_salida', [
                  Carbon::now()->startOfWeek(),
              Carbon::now()->endOfWeek()
          ])->count();

       $promedioDias = AsignacionHabitacion::where('estado', 'finalizado')
        ->whereIn('paciente_id', $pacienteIds)
          ->whereNotNull('fecha_salida')
          ->whereNotNull('fecha_asignacion')
        ->get()
          ->avg(fn($a) => Carbon::parse($a->fecha_asignacion)
              ->diffInDays(Carbon::parse($a->fecha_salida)));

       $promedioDias= round($promedioDias ?? 0);

        return view('doctor.alta_pacientes', compact(
            'pacientes',
         'totalAltas',
         'altasMes',
       'altasSemana',
         'promedioDias'
       ));
    }

}
