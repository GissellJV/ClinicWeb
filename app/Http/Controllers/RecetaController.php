<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;

class RecetaController extends Controller
{
    public function recetamedica()
    {
        if (!session('cargo') || session('cargo') != 'Doctor') {
            return redirect()->route('empleados.loginempleado')
                ->with('error', 'Debes iniciar sesión como Doctor');
        }
        return view('empleados.recetamedica');
    }

}
