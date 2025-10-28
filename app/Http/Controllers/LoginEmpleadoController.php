<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\LoginEmpleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginEmpleadoController extends Controller
{
    public function loginempleado()
    {
<<<<<<< HEAD:app/Http/Controllers/LoginempleadoController.php
        return view('empleados.loginempleado');
=======
        return view('empleados.InicioEmpleado');
>>>>>>> origin/main:app/Http/Controllers/LoginEmpleadoController.php
    }
    public function login(Request $request){

        $request->validate([
            'telefono' => 'required|string',
            'password' => 'required|string',
        ],[
            'telefono.required'=>'Ingresa el número de teléfono',
            'password.required'=>'Ingresa la contraseña'
        ]);

        $loginEmpleado = LoginEmpleado::where('telefono',$request->input('telefono'))->first();

        if($loginEmpleado && Hash::check($request->password, $loginEmpleado->password)){

            $empleado = Empleado::find($loginEmpleado->empleado_id);

            session([
                'empleado_id' => $empleado->id,
                'empleado_nombre' => $empleado->nombre . ' ' . $empleado->apellido,
                'cargo' => $empleado->cargo
            ]);

            return redirect()->route('recepcionista.busquedaexpediente')
                ->with('mensaje', '¡Bienvenido ' . $empleado->empleado_nombre . ' ' . $empleado->empleado_apellido . '!');
        }

        return back()
            ->with('error', 'El número de teléfono o la contraseña son incorrectos.')
            ->withInput($request->only('telefono'));

    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('/')
            ->with('mensaje', 'Sesión cerrada con exito');
    }
    public function enviar_codigo_recuperacion()
    {
        return view('pacientes.enviar_codigo_recuperacion');
    }

}
