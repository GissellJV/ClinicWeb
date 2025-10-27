<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function visualizacion_Doctores()
    {
        $doctores = Empleado::where('cargo', 'Doctor')->get();

        return view('pacientes.visualizacion_Doctores', compact('doctores'));
    }

}
