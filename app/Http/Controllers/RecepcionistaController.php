<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class RecepcionistaController extends Controller
{
    public function buscarExpediente(Request $request)
    {
        $pacientes = null;

        if ($request->busqueda) {
            $busqueda = $request->input('busqueda');
            $filtro = $request->input('filtro', 'todos');


            $query = Paciente::query();


            if ($filtro == 'nombre') {
                $query->where('nombres', 'LIKE', "%{$busqueda}%");

            } elseif ($filtro == 'apellido') {
                $query->where('apellidos', 'LIKE', "%{$busqueda}%");

            } elseif ($filtro == 'identidad') {
                $query->where('numero_identidad', 'LIKE', "%{$busqueda}%");

            } else {

                $query->where(function ($q) use ($busqueda) {
                    $q->where('nombres', 'LIKE', "%{$busqueda}%")
                        ->orWhere('apellidos', 'LIKE', "%{$busqueda}%")
                        ->orWhere('numero_identidad', 'LIKE', "%{$busqueda}%");
                });
            }


            $query->orderBy('apellidos', 'asc')->orderBy('nombres', 'asc');


            $pacientes = $query->paginate(10)->withQueryString();

        }
        return view('recepcionista.busquedaexpediente', compact('pacientes'));
    }

}
