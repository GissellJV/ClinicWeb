<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RutasController extends Controller
{
    public function index(Request $request)
    {
        // Simulación de promociones
        $promociones = collect([
            ['titulo' => 'Descuento de Tercera Edad', 'descripcion' => '30% en consultas, exámenes y rayos X.', 'mes' => 'todas'],
            ['titulo' => 'Descuento de Cuarta Edad', 'descripcion' => '40% en consultas, exámenes y medicamentos.', 'mes' => 'todas'],
            ['titulo' => 'Control Total', 'descripcion' => 'Promoción de octubre: precio 1,000 L.', 'mes' => 'octubre'],
            ['titulo' => 'Control Estándar', 'descripcion' => 'Promoción hasta noviembre: precio 850 L.', 'mes' => 'todas'],
        ]);

        // Filtro por mes
        if ($request->has('mes')) {
            $promociones = $promociones->where('mes', $request->mes);
        }

        // Ordenar alfabéticamente
        $promociones = $promociones->sortBy('titulo');

        return view('index', compact('promociones'));
    }
}
