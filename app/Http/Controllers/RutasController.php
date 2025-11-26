<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Comentario;
use App\Models\Empleado;
use App\Models\Paciente;
use App\Models\Calificacion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RutasController extends Controller
{
    /**
     * Mostrar la página principal con estadísticas y doctores
     */
    public function index()
    {
        // Obtener estadísticas generales
        $empleados = Empleado::all();
        $pacientes = Paciente::all();
        $citas = Cita::all();

        // Obtener solo los doctores con sus calificaciones
        $doctores = Empleado::where('cargo', 'Doctor')
            ->with(['calificaciones' => function($query) {
                $query->select('doctor_id', 'paciente_id', 'estrellas', 'comentario', 'created_at')
                    ->orderBy('created_at', 'desc');
            }])
            ->get();

        // Si el usuario es paciente, verificar qué doctores ya calificó
        $pacienteId = session('paciente_id');
        $esPaciente = session('tipo_usuario') === 'paciente';

        if ($esPaciente && $pacienteId) {
            // Obtener IDs de doctores que ya calificó
            $doctoresCalificados = Calificacion::where('paciente_id', $pacienteId)
                ->pluck('doctor_id')
                ->toArray();

            // Agregar información al objeto de doctores
            $doctores->each(function($doctor) use ($doctoresCalificados) {
                $doctor->yacalifico = in_array($doctor->id, $doctoresCalificados);
            });
        } else {
            // Si no es paciente, marcar todos como no calificados
            $doctores->each(function($doctor) {
                $doctor->yacalifico = false;
            });
        }

        // Calcular promedios y estadísticas por doctor
        $doctores->each(function($doctor) {
            $totalCalificaciones = $doctor->calificaciones->count();
            $doctor->promedio_calificacion = $totalCalificaciones > 0
                ? round($doctor->calificaciones->avg('estrellas'), 1)
                : 0;
            $doctor->total_calificaciones = $totalCalificaciones;
        });

        // Ordenar doctores por mejor calificación
        $doctores = $doctores->sortByDesc('promedio_calificacion');

        return view('index', compact('empleados', 'pacientes', 'citas', 'doctores'));
    }

    /**
     * Obtener información de un doctor específico (AJAX)
     */
    public function getDoctorInfo($id)
    {
        try {
            $doctor = Empleado::where('id', $id)
                ->where('cargo', 'Doctor')
                ->with(['calificaciones' => function($query) {
                    $query->orderBy('created_at', 'desc')
                        ->limit(10); // Últimas 10 calificaciones
                }])
                ->firstOrFail();

            $totalCalificaciones = $doctor->calificaciones->count();
            $promedio = $totalCalificaciones > 0
                ? round($doctor->calificaciones->avg('estrellas'), 1)
                : 0;

            // Distribución de estrellas
            $distribucion = [
                5 => $doctor->calificaciones->where('estrellas', 5)->count(),
                4 => $doctor->calificaciones->where('estrellas', 4)->count(),
                3 => $doctor->calificaciones->where('estrellas', 3)->count(),
                2 => $doctor->calificaciones->where('estrellas', 2)->count(),
                1 => $doctor->calificaciones->where('estrellas', 1)->count(),
            ];

            return response()->json([
                'success' => true,
                'doctor' => [
                    'id' => $doctor->id,
                    'nombre' => $doctor->nombre . ' ' . $doctor->apellido,
                    'departamento' => $doctor->departamento,
                    'total_calificaciones' => $totalCalificaciones,
                    'promedio' => $promedio,
                    'distribucion' => $distribucion,
                    'calificaciones_recientes' => $doctor->calificaciones->take(5)
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Doctor no encontrado'
            ], 404);
        }
    }

    /**
     * Obtener doctores por especialidad (AJAX)
     */
    public function getDoctoresPorEspecialidad($especialidad)
    {
        try {
            $doctores = Empleado::where('cargo', 'Doctor')
                ->where('departamento', $especialidad)
                ->with('calificaciones')
                ->get();

            $doctores->each(function($doctor) {
                $totalCalificaciones = $doctor->calificaciones->count();
                $doctor->promedio_calificacion = $totalCalificaciones > 0
                    ? round($doctor->calificaciones->avg('estrellas'), 1)
                    : 0;
                $doctor->total_calificaciones = $totalCalificaciones;
            });

            return response()->json([
                'success' => true,
                'doctores' => $doctores
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener doctores'
            ], 500);
        }
    }

    /**
     * Obtener estadísticas generales del sistema (AJAX)
     */
    public function getEstadisticas()
    {
        try {
            $stats = [
                'total_doctores' => Empleado::where('cargo', 'Doctor')->count(),
                'total_pacientes' => Paciente::count(),
                'total_citas' => Cita::count(),
                'citas_hoy' => Cita::whereDate('fecha', today())->count(),
                'calificacion_promedio' => round(Calificacion::avg('estrellas'), 1) ?? 0,
                'total_calificaciones' => Calificacion::count(),
            ];

            return response()->json([
                'success' => true,
                'estadisticas' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas'
            ], 500);
        }
    }

    /**
     * Verificar si un paciente puede calificar a un doctor (AJAX)
     */
    public function verificarPuedeCalificar(Request $request)
    {
        $doctorId = $request->input('doctor_id');
        $pacienteId = session('paciente_id');
        $esPaciente = session('tipo_usuario') === 'paciente';

        if (!$esPaciente || !$pacienteId) {
            return response()->json([
                'puede_calificar' => false,
                'mensaje' => 'Debes iniciar sesión como paciente'
            ]);
        }

        $yaCalificado = Calificacion::where('doctor_id', $doctorId)
            ->where('paciente_id', $pacienteId)
            ->exists();

        return response()->json([
            'puede_calificar' => !$yaCalificado,
            'mensaje' => $yaCalificado ? 'Ya has calificado a este doctor' : 'Puedes calificar',
            'yacalifico' => $yaCalificado
        ]);
        $comentarios = Comentario::latest()->get();

        Carbon::setLocale('es');
        // Generar iniciales (nombre + apellido) en el controller
        foreach ($comentarios as $c) {
            $partes = explode(' ', trim($c->usuario));
            $nombre = $partes[0] ?? '';
            $apellido = $partes[1] ?? '';

            $c->iniciales = strtoupper(substr($nombre, 0, 1)) . strtoupper(substr($apellido, 0, 1));
            $c->tiempo = $c->created_at->diffForHumans();
        }

        return view('index', compact('promociones', 'doctores', 'empleados', 'pacientes', 'citas', 'comentarios'));
    }
}
