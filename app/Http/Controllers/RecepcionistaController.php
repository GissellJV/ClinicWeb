<?php

namespace App\Http\Controllers;

use App\Models\Expediente;
use App\Models\Paciente;
use Illuminate\Http\Request;

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

}
