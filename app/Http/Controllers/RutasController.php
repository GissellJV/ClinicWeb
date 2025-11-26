<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Comentario;
use App\Models\Empleado;
use App\Models\Paciente;
use Carbon\Carbon;
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
