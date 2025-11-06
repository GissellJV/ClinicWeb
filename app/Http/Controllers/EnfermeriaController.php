<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnfermeriaController extends Controller
{
    //ESTA FUNCION ES SOLO PARA VISUALIZAR EL ACCESO COMO ENFERMERO (NO TIENE CONTENIDO)
    public function principal()
    {
        return view('enfermeria.principal');

    }
}
