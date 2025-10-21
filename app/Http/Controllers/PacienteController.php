<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

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
            'numero_identidad' => 'required|string|size:13|regex:/^\d{4}\d{4}\d{5}$/',
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

    public function recuperar_contra()
    {
        return view('pacientes.recuperar_contraseña');
    }

    public function agendar_Citasonline(){
        return view('pacientes.agendar_Citasonline');
    }

}
