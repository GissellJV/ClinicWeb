<?php

namespace App\Http\Controllers;

use App\Models\Expediente;
use App\Models\HistorialExpediente;
use App\Models\Paciente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpedienteController extends Controller
{
    public function actualizarUltimoHistorial(Request $request, $expediente)
    {
        $request->validate([
            'historial_id' => 'required|exists:historial_expedientes,id',
            'alergias' => 'nullable|string',
            'medicamentos_actuales' => 'nullable|string',
            'antecedentes_familiares' => 'nullable|string',
            'antecedentes_personales' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        $historial = HistorialExpediente::findOrFail($request->historial_id);

        $historial->update($request->only([
            'alergias',
            'medicamentos_actuales',
            'antecedentes_familiares',
            'antecedentes_personales',
            'observaciones'
        ]));

        return response()->json(['success' => true, 'message' => 'Historial clínico actualizado correctamente']);
    }
    public function actualizarHistorial(Request $request, $id)
    {
        $historial = HistorialExpediente::find($request->historial_id);

        if ($historial) {
            $historial->update($request->only([
                'alergias',
                'antecedentes_familiares',
                'antecedentes_personales',
                'medicamentos_actuales',
                'observaciones',
            ]));
        }

        return redirect()->back()->with('success', 'Historial actualizado');
    }
    public function verHistorial($id)
    {
        // Solo para doctores
        if (session('cargo') !== 'Doctor') {
            return redirect()->route('inicioSesion')->with('error', 'Acceso denegado.');
        }

        $expediente = Expediente::with('paciente')->findOrFail($id);

        // Traer el historial del expediente
        $historiales = DB::table('historial_expedientes')
            ->where('expediente_id', $id)
            ->orderBy('fecha', 'desc')
            ->get();

        return view('expedientes.historial', compact('expediente', 'historiales'));
    }

    public function historialExpediente($id)
    {
        $expediente = Expediente::with('paciente')->findOrFail($id);
        $historiales = DB::table('historial_expedientes')
            ->where('expediente_id', $id)
            ->orderBy('fecha', 'desc')
            ->get();

        return view('expedientes.historial', compact('expediente', 'historiales'));
    }

    public function actualizarHistorialExpediente(Request $request, $expediente_id)
    {
        // Validación de los campos
        $request->validate([
            'peso' => 'nullable|numeric',
            'altura' => 'nullable|numeric',
            'temperatura' => 'nullable|string',
            'presion_arterial' => 'nullable|string',
            'frecuencia_cardiaca' => 'nullable|string',
            'alergias' => 'nullable|string',
            'medicamentos_actuales' => 'nullable|string',
            'antecedentes_familiares' => 'nullable|string',
            'antecedentes_personales' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        // Insertar un nuevo registro en historial_expediente
        DB::table('historial_expedientes')->insert([
            'expediente_id' => $expediente_id,
            'fecha' => now()->toDateString(),
            'peso' => $request->peso,
            'altura' => $request->altura,
            'temperatura' => $request->temperatura,
            'presion_arterial' => $request->presion_arterial,
            'frecuencia_cardiaca' => $request->frecuencia_cardiaca,
            'alergias' => $request->alergias,
            'medicamentos_actuales' => $request->medicamentos_actuales,
            'antecedentes_familiares' => $request->antecedentes_familiares,
            'antecedentes_personales' => $request->antecedentes_personales,
            'observaciones' => $request->observaciones,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Registro agregado al historial correctamente.');
    }

    public function crearExpediente($paciente_id = null)
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
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
            return redirect()->route('inicioSesion')->with('error', 'Debes iniciar sesion como Recepcionista');
        }

        $expediente = Expediente::with('paciente')->findOrFail($id);

        $historial = \DB::table('historial_expedientes')
            ->where('expediente_id', $id)
            ->orderByDesc('fecha')
            ->get();

        $cargo = session('cargo');

        if ($cargo === 'Recepcionista') {
            return view('recepcionista.visualizarexpediente', compact('expediente', 'historial'));
        } elseif ($cargo === 'Doctor') {
            return view('doctor.visualizarexpediente', compact('expediente'));
        }
    }
    public function actualizarSignos(Request $request, $id)
    {
        $expediente = Expediente::findOrFail($id);

        $historial = $expediente->historiales()->create([
            'peso' => $request->peso,
            'altura' => $request->altura,
            'temperatura' => $request->temperatura,
            'presion_arterial' => $request->presion_arterial,
            'frecuencia_cardiaca' => $request->frecuencia_cardiaca,
            'fecha' => Carbon::today()->toDateString(), // formato Y-m-d
        ]);

        return redirect()->back()->with('success', 'Signos vitales agregados correctamente.');
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
