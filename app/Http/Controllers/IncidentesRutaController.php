<?php

namespace App\Http\Controllers;

use App\Models\IncidenteRuta;
use App\Models\Traslado;
use Illuminate\Http\Request;
use Carbon\Carbon;

class IncidentesRutaController extends Controller {

    public function index() {
        // Auto-Resolución al cargar la página
        $activosParaVerificar = IncidenteRuta::where('estado_incidente', 'Activo')->get();
        foreach ($activosParaVerificar as $inc) {
            $tiempoLimite = $inc->created_at->addMinutes($inc->minutos_retraso);
            if (now()->greaterThan($tiempoLimite)) {
                $inc->update(['estado_incidente' => 'Resuelto']);
            }
        }

        // Estadísticas
        $total = IncidenteRuta::count();
        $pendientes = IncidenteRuta::where('estado_incidente', 'Activo')->count();
        $resueltos = IncidenteRuta::where('estado_incidente', 'Resuelto')->count();

        // Cargar incidentes y formatear la fecha para JS
        $incidentes = IncidenteRuta::with('traslado.paciente')->latest()->get();
        foreach ($incidentes as $inc) {
            // Esto asegura que JS reciba la hora exacta de expiración
            $inc->fecha_expiracion_js = $inc->created_at->addMinutes($inc->minutos_retraso)->toIso8601String();
        }

        $trasladosActivos = Traslado::where('estado', 'Pendiente')->get();

        return view('recepcionista.incidentes_ruta.index', compact(
            'incidentes', 'trasladosActivos', 'total', 'pendientes', 'resueltos'
        ));
    }

    public function store(Request $request) {
        $request->validate([
            'traslado_id' => 'required|exists:traslados,id',
            'tipo_incidente' => 'required',
            'minutos_retraso' => 'required|integer|min:1',
            'nota_descriptiva' => 'nullable|string'
        ]);

        IncidenteRuta::create([
            'traslado_id' => $request->traslado_id,
            'tipo_incidente' => $request->tipo_incidente,
            'minutos_retraso' => $request->minutos_retraso,
            'nota_descriptiva' => $request->nota_descriptiva,
            'estado_incidente' => 'Activo'
        ]);

        return back()->with('success', 'Incidente registrado correctamente.');
    }

    public function resolver($id) {
        IncidenteRuta::where('id', $id)->update(['estado_incidente' => 'Resuelto']);
        return back()->with('success', 'Incidente finalizado.');
    }
}
