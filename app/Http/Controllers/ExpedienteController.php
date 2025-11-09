<?php

namespace App\Http\Controllers;

use App\Models\Expediente;
use App\Models\Paciente;
use Illuminate\Http\Request;

class ExpedienteController extends Controller
{
    public function crearExpediente($paciente_id = null)
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('empleados.loginempleado')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        $pacientes = Paciente::all();
        $numero_expediente = Expediente::generarNumeroExpediente();

        $pacienteSeleccionado = null;
        if (!$paciente_id) {
            $paciente_id = request('paciente_id');
        }

        if ($paciente_id) {
            $pacienteSeleccionado = Paciente::find($paciente_id);
        }
        return view('expedientes.crear', compact('pacientes', 'numero_expediente', 'paciente_id', 'pacienteSeleccionado'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'peso' => 'nullable|numeric|min:0',
            'altura' => 'nullable|numeric|min:0',
            'temperatura' => 'nullable|string|max:10',
            'presion_arterial' => 'nullable|string|max:20',
            'frecuencia_cardiaca' => 'nullable|string|max:10',
        ]);

        // Verificar si ya existe expediente para este paciente
        $existeExpediente = Expediente::where('paciente_id', $request->paciente_id)->exists();

        if ($existeExpediente) {
            return redirect()->back()->with('error', 'Este paciente ya tiene un expediente registrado.');
        }

        Expediente::create([
            'paciente_id' => $request->paciente_id,
            'numero_expediente' => Expediente::generarNumeroExpediente(),
            'peso' => $request->peso,
            'altura' => $request->altura,
            'temperatura' => $request->temperatura,
            'presion_arterial' => $request->presion_arterial,
            'frecuencia_cardiaca' => $request->frecuencia_cardiaca,
            'tiene_fiebre' => $request->has('tiene_fiebre'),
            'sintomas_actuales' => $request->sintomas_actuales,
            'diagnostico' => $request->diagnostico,
            'tratamiento' => $request->tratamiento,
            'alergias' => $request->alergias,
            'medicamentos_actuales' => $request->medicamentos_actuales,
            'antecedentes_familiares' => $request->antecedentes_familiares,
            'antecedentes_personales' => $request->antecedentes_personales,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()->route('recepcionista.busquedaexpediente');
    }

    public function verExpediente($id)
    {

        if (!session('empleado_id')) {
            return redirect()->route('empleados.loginempleado')->with('error', 'Debes iniciar sesion como Recepcionista');
        }

        $expediente = Expediente::with('paciente')->findOrFail($id);

        $cargo = session('cargo');


        if ($cargo === 'Recepcionista') {
            return view('recepcionista.visualizarexpediente', compact('expediente'));
        } elseif ($cargo === 'Doctor') {
            return view('doctor.visualizarexpediente', compact('expediente'));
        }
    }
    public function actualizarSignos(Request $request, $id)
    {
        $request->validate([
            'peso' => 'required|numeric',
            'altura' => 'required|numeric',
            'temperatura' => 'required|numeric',
            'presion_arterial' => 'required',
            'frecuencia_cardiaca' => 'required',
        ]);

        $expediente = Expediente::findOrFail($id);
        $expediente->peso = $request->peso;
        $expediente->altura = $request->altura;
        $expediente->temperatura = $request->temperatura;
        $expediente->presion_arterial = $request->presion_arterial;
        $expediente->frecuencia_cardiaca = $request->frecuencia_cardiaca;
        $expediente->save();

        return redirect()->back()->with('success_signos', 'Signos vitales actualizados correctamente.');
    }

    public function actualizarConsulta(Request $request, $id)
    {
        $expediente = Expediente::findOrFail($id);
        $expediente->sintomas_actuales = $request->sintomas_actuales;
        $expediente->diagnostico = $request->diagnostico;
        $expediente->tratamiento = $request->tratamiento;
        $expediente->save();

        return redirect()->back()->with('success_consulta', 'Registro médico actualizado correctamente.');
    }



}
