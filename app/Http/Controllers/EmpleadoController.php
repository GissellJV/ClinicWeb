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
        if (!session('cargo') || strtolower(session('cargo')) != 'recepcionista') {
            return redirect()->route('empleados.loginempleado')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        $cargos = ['Recepcionista', 'Doctor', 'Enfermero', 'Gerente', 'Administrativo'];
        $departamentos = ['Recepción', 'Medicina General', 'Pediatría', 'Cirugía', 'Administración'];

        return view('empleados.crear', compact('cargos', 'departamentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'numero_identidad' => 'required|string|size:13|regex:/^\d{4}\d{4}\d{5}$/|unique:empleados,numero_identidad',
            'cargo' => 'required|string',
            'departamento' => 'required|string',
            'fecha_ingreso' => 'required|date',
            'telefono' => 'required|string|size:8|regex:/^[2389]\d{7}$/',
            'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]/'
        ],[

            'nombre.required' => 'El nombre es obligatorio',
            'apellido.required' => 'El apellido es obligatorio',
            'cargo.required' => 'El cargo es obligatorio',
            'departamento.required' => 'El departamento es obligatorio',
            'fecha_ingreso.required' => 'La fecha de ingreso es obligatoria',
            'fecha_ingreso.date' => 'La fecha de ingreso debe ser una fecha válida',
            'numero_identidad.required' => 'El número de identidad es obligatorio',
            'numero_identidad.regex' => 'El formato del número de identidad no es válido',
            'numero_identidad.size' => 'El número de identidad debe tener 13 dígitos',
            'telefono.required' => 'El número de teléfono  obligatorio',
            'telefono.regex' => 'El número de telefono no es valido',
            'telefono.size' => 'El número de telefono debe tener 8 dígitos',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener mínimo 8 caracteres',
            'password.regex' => 'La contraseña debe incluir mayúsculas, minúsculas y números',
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
            'telefono' =>$request->telefono,
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
