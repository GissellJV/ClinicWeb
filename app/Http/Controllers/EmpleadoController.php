<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\LoginEmpleado;

class EmpleadoController extends Controller
{
    public function crear()
    {
        $cargos = ['Recepcionista', 'Doctor', 'Enfermero', 'Gerente', 'Administrativo'];
        $departamentos = ['Recepción', 'Medicina General', 'Pediatría', 'Cirugía', 'Administración'];

        return view('empleados.crear', compact('cargos', 'departamentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'numero_identidad' => 'required|string|unique:empleados,numero_identidad',
            'cargo' => 'required|string',
            'departamento' => 'required|string',
            'fecha_ingreso' => 'required|date',
            'telefono' => 'required|string|min:8|max:15',
            'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]/'
        ]);

        $empleado = Empleado::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'numero_identidad' => $request->numero_identidad,
            'cargo' => $request->cargo,
            'departamento' => $request->departamento,
            'fecha_ingreso' => $request->fecha_ingreso,
        ]);

        // Crear el login asociado
        $empleado->loginEmpleado()->create([
            'empleado_nombre' => $request->nombre,
            'empleado_apellido' => $request->apellido,
            'telefono' => $request->telefono,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('empleados.lista')->with('success', 'Empleado registrado exitosamente.');
    }

    public function lista()
    {
        $empleados = Empleado::orderBy('created_at', 'desc')->get();
        return view('empleados.lista', compact('empleados'));
    }
}
