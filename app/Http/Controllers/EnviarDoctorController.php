<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnviarDoctorController extends Controller
{
    public function enviarExpedienteDoctor(Request $request, $expedienteId)
    {

        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
        ]);

        EnviarDoctor::create([
            'expediente_id' => $expedienteId,
            'doctor_id' => $request->empleado_id,
            'estado' => 'pendiente'
        ]);

        return redirect()->back()->with('success', 'El expediente fue enviado al doctor correctamente.');
    }

    public function expedientesAsignados()
    {
        $doctorId = auth()->id();

        $expedientes = EnviarDoctor::with('expediente.paciente')
            ->where('doctor_id', $doctorId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('doctor.expedientes', compact('expedientes'));
    }
    public function ver($id)
    {
        $asignacion = EnviarDoctor::where('doctor_id', auth()->id())
            ->where('expediente_id', $id)
            ->first();

        if ($asignacion && $asignacion->estado == 'pendiente') {
            $asignacion->update(['estado' => 'completado']);
        }

        $expediente = Expediente::findOrFail($id);

        return view('expedientes.ver', compact('expediente'));
    }
    public function agendar()
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        $pacientes = Paciente::all();
        $doctores = Empleado::where('cargo', 'Doctor')->get();
        $especialidades = Empleado::where('cargo', 'Doctor')
            ->select('departamento')
            ->distinct()
            ->pluck('departamento');

        return view('recepcionista.agendar-cita', compact('pacientes', 'doctores', 'especialidades'));
    }
    public function getDoctoresPorEspecialidad($departamento)
    {
        $doctores = Empleado::where('cargo', 'Doctor')
            ->where('departamento', $departamento)
            ->get(['id', 'nombre', 'departamento']);

        return response()->json($doctores);
    }
}
