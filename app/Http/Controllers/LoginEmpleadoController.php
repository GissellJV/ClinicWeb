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
        return view('empleados.InicioEmpleado');
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

            $mensaje = '¡Bienvenido ' . $empleado->nombre . ' ' . $empleado->apellido . '!';
            $cargo = strtolower($empleado->cargo);

            if ($cargo == 'doctor') {
                return redirect()->route('doctor.receta')->with('mensaje', $mensaje);
            }
            elseif ($cargo == 'recepcionista') {
                return redirect()->route('recepcionista.busquedaexpediente')->with('mensaje', $mensaje);
            }
            elseif ($cargo == 'enfermero') {
                return redirect()->route('enfermeria.principal')->with('mensaje', $mensaje);
            }
            else {
                return redirect()->route('empleado.dashboard')->with('mensaje', $mensaje);
            }

        }

        return back()
            ->with('error', 'El número de teléfono o la contraseña son incorrectos.')
            ->withInput($request->only('telefono'));

    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        $nombreEmpleado = session('empleado_nombre');
        $request->session()->forget(['empleado_id', 'empleado_nombre', 'cargo']);
        $request->session()->regenerate();

        return redirect()->route('/')
            ->with('mensaje', 'Has cerrado sesión correctamente.');
    }
    public function enviar_codigo_recuperacion()
    {
        return view('pacientes.enviar_codigo_recuperacion');
    }

}
