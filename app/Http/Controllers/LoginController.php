<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\LoginEmpleado;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function loginempleado()
    {

        return view('login');
    }

        public function login(Request $request)
        {

            $request->validate([
                'telefono' => 'required|string',
                'password' => 'required|string',
            ], [
                'telefono.required' => 'Ingresa el número de teléfono',
                'password.required' => 'Ingresa la contraseña'
            ]);

            $telefono = $request->input('telefono');
            $password = $request->password;


            // Capturar el parámetro de redirección
            $redirectTo = $request->input('redirect_to');

            // Primero intentar login como empleado
            $loginEmpleado = LoginEmpleado::where('telefono', $telefono)->first();

            if ($loginEmpleado && Hash::check($password, $loginEmpleado->password)) {

                $empleado = Empleado::find($loginEmpleado->empleado_id);

                session([
                    'empleado_id' => $empleado->id,
                    'empleado_nombre' => $empleado->nombre . ' ' . $empleado->apellido,
                    'cargo' => $empleado->cargo,
                    'tipo_usuario' => 'empleado' // Identificador del tipo de usuario
                ]);

                $mensaje = '¡Bienvenido ' . $empleado->nombre . ' ' . $empleado->apellido . '!';
                $cargo = strtolower($empleado->cargo);

                if ($cargo == 'doctor') {
                    return redirect()->route('doctor.receta')->with('mensaje', $mensaje);
                } elseif ($cargo == 'recepcionista') {
                    return redirect()->route('recepcionista.busquedaexpediente')->with('mensaje', $mensaje);
                } elseif ($cargo == 'enfermero') {
                    return redirect()->route('inventario.principal')->with('mensaje', $mensaje);
                } else {
                    return redirect()->route('empleado.dashboard')->with('mensaje', $mensaje);
                }
            }


            $paciente = Paciente::where('telefono', $telefono)->first();

            if ($paciente && Hash::check($password, $paciente->password)) {

                session([
                    'paciente_id' => $paciente->id,
                    'paciente_nombre' => $paciente->nombres . ' ' . $paciente->apellidos,
                    'tipo_usuario' => 'paciente'
                ]);

                $mensaje = '¡Bienvenido ' . $paciente->nombres . '!';

                // Si viene desde el botón de calificar, redirigir a la sección de doctores
                if ($redirectTo === 'doctors') {
                    return redirect('/')->with('mensaje', $mensaje)->with('scroll_to', 'doctors');
                }

                return redirect()->route('agendarcitas')->with('mensaje', $mensaje);

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
