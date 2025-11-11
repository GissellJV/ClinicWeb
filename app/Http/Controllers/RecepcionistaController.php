<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Expediente;
use App\Models\Paciente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecepcionistaController extends Controller
{
    public function buscarExpediente(Request $request)
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('empleados.loginempleado')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        $expedientes = null;

        if ($request->busqueda) {
            $busqueda = $request->input('busqueda');
            $filtro = $request->input('filtro', 'todos');

            $query = Paciente::query();

            if ($filtro == 'nombre') {
                $query->where('nombres', 'LIKE', "%{$busqueda}%");

            } elseif ($filtro == 'apellido') {
                $query->where('apellidos', 'LIKE', "%{$busqueda}%");

            } elseif ($filtro == 'numero_expediente') {
                $query->whereHas('expediente', function($q) use ($busqueda) {
                    $q->where('numero_expediente', 'LIKE', "%{$busqueda}%");
                });

            } else {

                $query->where(function ($q) use ($busqueda) {
                    $q->where('nombres', 'LIKE', "%{$busqueda}%")
                        ->orWhere('apellidos', 'LIKE', "%{$busqueda}%")
                        ->orWhereHas('expediente', function($subQuery) use ($busqueda) {
                            $subQuery->where('numero_expediente', 'LIKE', "%{$busqueda}%");
                        });
                });
            }


            $query->with('expediente')
                ->orderBy('apellidos', 'asc')
                ->orderBy('nombres', 'asc');

            $expedientes = $query->paginate(10)->withQueryString();

        }
        return view('recepcionista.busquedaexpediente', compact('expedientes'));
    }

    public function registroPaciente(Request $request)
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('empleados.loginempleado')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }
        $ninos = Paciente::whereRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) BETWEEN 0 AND 12')->get();
        $adolescentes = Paciente::whereRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) BETWEEN 13 AND 17')->get();
        $adultos = Paciente::whereRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) BETWEEN 18 AND 59')->get();
        $terceraEdad = Paciente::whereRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) >= 60')->get();

        $visitasPorDia = Paciente::select(
            DB::raw("DAYNAME(created_at) as dia"),
            DB::raw("COUNT(*) as total")
        )
            ->groupBy('dia')
            ->orderByRaw("FIELD(dia, 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')")
            ->get();

        $labelsVisitas = $visitasPorDia->pluck('dia');
        $dataVisitas = $visitasPorDia->pluck('total');

        $filtro = $request->get('filtro', 'recientes');

        $query = Paciente::orderBy('created_at', 'desc');

        if ($filtro == 'hoy') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($filtro == 'semana') {
            $query->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ]);
        } elseif ($filtro == 'mes') {
            $query->whereMonth('created_at', Carbon::now()->month);
        } elseif ($filtro == 'anio') {
            $query->whereYear('created_at', Carbon::now()->year);
        }

        if ($request->has('buscar')) {
            $query->where(function ($q) use ($request) {
                $q->where('nombres', 'LIKE', '%' . $request->buscar . '%')
                    ->orWhere('apellidos', 'LIKE', '%' . $request->buscar . '%');
            });
        }


        $pacientes = $query->paginate(10);

        $citas = Cita::with('paciente')->get();

        foreach ($citas as $cita) {
            $cita->paciente->edad = \Carbon\Carbon::parse($cita->paciente->fecha_nacimiento)->age;
        }

        return view('recepcionista.Registro_Asistencia', compact(
            'ninos',
            'adolescentes',
            'adultos',
            'terceraEdad',
            'labelsVisitas',
            'dataVisitas',
            'pacientes',
            'filtro',
            'citas'
        ));
    }

}
