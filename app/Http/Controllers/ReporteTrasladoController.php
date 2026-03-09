<?php

namespace App\Http\Controllers;

use App\Models\CalificacionTraslado;
use App\Models\Traslado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteTrasladoController extends Controller
{
    public function index(Request $request)
    {
        // 1. Obtener indicadores rápidos (KPIs)
        $promedioGeneral = CalificacionTraslado::avg('puntuacion') ?? 0;
        $totalCalificaciones = CalificacionTraslado::count();
        $mejorAmbulancia = Traslado::join('calificaciones_traslados', 'traslados.id', '=', 'calificaciones_traslados.traslado_id')
            ->select('unidad_asignada', DB::raw('avg(puntuacion) as promedio'))
            ->groupBy('unidad_asignada')
            ->orderByDesc('promedio')
            ->first();

        // 2. Preparar datos para la gráfica de barras
        $datosGrafica = Traslado::join('calificaciones_traslados', 'traslados.id', '=', 'calificaciones_traslados.traslado_id')
            ->select('unidad_asignada', DB::raw('avg(puntuacion) as promedio'))
            ->groupBy('unidad_asignada')
            ->get();

        // 3. Obtener listado para la tabla con filtros aplicados
        $query = CalificacionTraslado::with('traslado.paciente');

        if ($request->fecha) {
            $query->whereDate('created_at', $request->fecha);
        }

        if ($request->unidad) {
            $query->whereHas('traslado', function($q) use ($request) {
                $q->where('unidad_asignada', 'like', '%' . $request->unidad . '%');
            });
        }

        $calificaciones = $query->latest()->get();

        return view('recepcionista.dashboard_calificaciones', compact(
            'promedioGeneral',
            'totalCalificaciones',
            'mejorAmbulancia',
            'datosGrafica',
            'calificaciones'
        ));
    }
}
