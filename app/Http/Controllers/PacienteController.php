<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class PacienteController extends Controller
{
    public function registrarpaciente(){
        return view('pacientes.registrarpaciente');
    }
    public function store(Request $request)
    {
        // Validar datos
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date|before:today',
            'numero_identidad' => 'required|string|size:13|regex:/^\d{4}\d{4}\d{5}$/|unique:pacientes',
            'genero' => 'required|in:Femenino,Masculino',
            'telefono' => 'required|string|min:8|max:15',
            'contraseña' => 'required|string|min:8|confirmed',

        ], [

            'nombres.required' => 'Nombres obligatorios',
            'apellidos.required' => 'Apellidos obligatorios ',
            'fecha_nacimiento.required' => 'Fecha de nacimiento obligatoria',
            'fecha_nacimiento.before' => 'Ingresa una fecha valida',
            'genero.required' => 'Selecciona un genero',
            'numero_identidad.required' => 'El número de identidad es obligatorio',
            'numero_identidad.regex' => 'El formato del número de identidad no es valido',
            'numero_identidad.size' => 'El número de identidad debe tener 13 dígitos',
            'numero_identidad.unique' => 'El número de identidad ya ha sido registrado',
            'telefono.required' => 'Teléfono  obligatorio',
            'contraseña.required' => 'La contraseña es obligatoria',
            'contraseña.min' => 'La contraseña debe tener mínimo 8 caracteres',
            'contraseña.confirmed' => 'Las contraseñas no coinciden',

        ]);


        $nuevoPaciente = new Paciente();
        $nuevoPaciente->nombres = $request->input('nombres');
        $nuevoPaciente->apellidos = $request->input('apellidos');
        $nuevoPaciente->fecha_nacimiento = $request->input('fecha_nacimiento');
        $nuevoPaciente->genero = $request->input('genero');
        $nuevoPaciente->numero_identidad = $request->input('numero_identidad');
        $nuevoPaciente->telefono = $request->input('telefono');
        $nuevoPaciente->contraseña = bcrypt($request->input('contraseña'));
         $nuevoPaciente->save();


       //dirigirse a iniciar sesion // if($nuevoPaciente->save()){

      return redirect()->route('pacientes.loginp')->with('mensaje', 'Registro exitoso, Inicia sesión');
//}
    }

    public function listado_citaspro(){
        return view('pacientes.listado_citaspro');
    }

    public function loginp()
    {
        return view('pacientes.iniciodesesion');
    }
    public function login(Request $request){

        $request->validate([
            'telefono' => 'required|string',
            'contraseña' => 'required|string',
        ],[
            'telefono.required'=>'Ingresa el número de teléfono',
            'contraseña.required'=>'Ingresa la contraseña'
        ]);

        $paciente= Paciente::where('telefono',$request->input('telefono'))->first();

        if($paciente && Hash::check($request->contraseña, $paciente->contraseña)){

            session([
                'paciente_id' => $paciente->id,
                'paciente_nombre' => $paciente->nombres . ' ' . $paciente->apellidos,
            ]);

            return redirect()->route('agendarcitas')
                ->with('mensaje', '¡Bienvenido ' . $paciente->nombres . '!');
        }

        return back()
            ->with('error', 'El número de teléfono o la contraseña son incorrectos.')
            ->withInput($request->only('telefono'));

    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('pacientes.loginp')
            ->with('mensaje', 'Sesión cerrada con exito');
    }
    public function enviar_codigo_recuperacion()
    {
        return view('pacientes.enviar_codigo_recuperacion');
    }

    public function agendar_Citasonline(){
        return view('pacientes.agendar_Citasonline');
    }

}
