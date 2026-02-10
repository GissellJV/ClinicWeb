<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\LoginEmpleado;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\ResetPasswordMail;


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
                    return redirect()->route('doctor.citas')->with('mensaje', $mensaje);
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

    public function enviarEnlace(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;

        // buscar en empleados
        $empleado = Empleado::where('email', $email)->first();

        // buscar en pacientes
        $paciente = Paciente::where('email', $email)->first();

        if (!$empleado && !$paciente) {
            return back()->with('error', 'Este correo no está registrado');
        }

        $tipo = $empleado ? 'empleado' : 'paciente';

        // generar token
        $token = Str::random(64);

        // guardar en tabla password_resets
        DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            [
                'token' => $token,
                'tipo_usuario' => $tipo,
                'created_at' => Carbon::now()
            ]
        );

        // crear link
        $link = url('/restablecer/'.$token.'?email='.$email);

        // enviar correo
        Mail::raw(
            "Hola,\n\nHaz clic en el siguiente enlace para restablecer tu contraseña:\n\n".$link,
            function ($message) use ($email) {
                $message->to($email)
                    ->subject('Restablecer contraseña');
            }
        );

        return back()->with('status', 'Se envió un enlace a tu correo');
    }

    public function mostrarFormularioReset($token, Request $request)
    {
        return view('pacientes.cambio_contra', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    public function actualizarPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        $registro = DB::table('password_resets')
            ->where('token', $request->token)
            ->first();

        if (!$registro) {
            return back()->with('error', 'Token inválido');
        }

        if ($registro->tipo_usuario == 'empleado') {

            $empleado = Empleado::where('email', $registro->email)->first();

            if ($empleado) {
                LoginEmpleado::where('empleado_id', $empleado->id)
                    ->update([
                        'password' => Hash::make($request->password)
                    ]);
            }

        } else {

            Paciente::where('email', $registro->email)
                ->update([
                    'password' => Hash::make($request->password)
                ]);
        }

        // eliminar token
        DB::table('password_resets')
            ->where('email', $registro->email)
            ->delete();

        return redirect()->route('inicioSesion')
            ->with('status', 'Contraseña actualizada correctamente');
    }

    public function enviarCodigoRecuperacion(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;
        $tipoUsuario = null;

        // buscar en pacientes
        if (Paciente::where('email', $email)->exists()) {
            $tipoUsuario = 'paciente';
        }

        // buscar en empleados
        if (!$tipoUsuario && Empleado::where('email', $email)->exists()) {
            $tipoUsuario = 'empleado';
        }

        if (!$tipoUsuario) {
            return back()->with('error', 'Este correo no está registrado');
        }

        $token = Str::random(60);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            [
                'token' => $token,
                'tipo_usuario' => $tipoUsuario,
                'created_at' => now()
            ]
        );

        Mail::to($email)->send(new ResetPasswordMail($token, $email));

        return back()->with('status', 'Se envió el enlace a tu correo');
    }

    public function actualizarContra(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6'
        ]);

        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return back()->with('error', 'Token inválido');
        }

        if ($reset->tipo_usuario == 'paciente') {

            Paciente::where('email', $request->email)
                ->update([
                    'password' => Hash::make($request->password)
                ]);
        }

        if ($reset->tipo_usuario == 'empleado') {

            $empleado = Empleado::where('email', $request->email)->first();

            LoginEmpleado::where('empleado_id', $empleado->id)
                ->update([
                    'password' => Hash::make($request->password)
                ]);
        }

        DB::table('password_resets')
            ->where('email', $request->email)
            ->delete();

        return redirect()->route('inicioSesion')
            ->with('status', 'Contraseña actualizada correctamente');
    }

}
