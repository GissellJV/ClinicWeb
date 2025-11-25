<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Empleado;
use App\Models\Paciente;
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

        $doctores = Empleado::where('cargo', 'Doctor')->get();
        $empleados = Empleado::orderBy('created_at', 'desc')->get();
        $pacientes = Paciente::orderBy('created_at', 'desc')->get();
        $citas = Cita::orderBy('created_at', 'desc')->get();

        return view('index', compact('promociones', 'doctores', 'empleados', 'pacientes', 'citas'));
    }
}
