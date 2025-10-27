<?php

namespace App\Http\Controllers;

use App\Models\LoginEmpleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginempleadoController extends Controller
{
    public function loginempleado(Request $request)
    {
        return view('empleados.busquedaexpedientes');
    }
    public function login(Request $request){

        $request->validate([
            'telefono' => 'required|string',
            'password' => 'required|string',
        ],[
            'telefono.required'=>'Ingresa el número de teléfono',
            'password.required'=>'Ingresa la contraseña'
        ]);

        $empleado= LoginEmpleado::where('telefono',$request->input('telefono'))->first();

        if($empleado && Hash::check($request->password, $empleado->password)){

            session([
                'empleado_id' => $empleado->id,
                'empleado_nombre' => $empleado->empleado_nombre . ' ' . $empleado->empleado_apellido,
            ]);

            return redirect()->route('recepcionistas.busquedaexpediente')
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
        return redirect()->route('empleados.inicioEmpleado')
            ->with('mensaje', 'Sesión cerrada con exito');
    }
    public function enviar_codigo_recuperacion()
    {
        return view('pacientes.enviar_codigo_recuperacion');
    }

}
