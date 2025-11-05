<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;

class RecetaController extends Controller
{
    public function recetamedica()
    {
        return view('empleados.recetamedica');
    }

}
