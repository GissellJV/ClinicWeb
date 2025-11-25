<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use App\Models\EnviarDoctor;
use App\Models\Paciente;
use App\Models\Expediente;


class DoctorController extends Controller
{
    public function verExpediente($pacienteId)
    {
        if (!session('cargo') || session('cargo') != 'Doctor') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Doctor');
        }

        $doctorId = session('empleado_id');

        // Verifica que el doctor tenga asignado este paciente
        $asignacion = EnviarDoctor::where('empleado_id', $doctorId)
            ->where('paciente_id', $pacienteId)
            ->firstOrFail();

        // Marcar como completado
        $asignacion->update(['estado' => 'completado']);

        // Cargar el expediente real del paciente
        $expediente = Expediente::with('paciente')->where('paciente_id', $pacienteId)->firstOrFail();

        return view('expedientes.verexpediente', compact('expediente'));
    }

    public function expedientesRecibidos()
    {
        if (!session('cargo') || session('cargo') != 'Doctor') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Doctor');
        }

        $doctorId = session('empleado_id'); // obtiene el ID de la sesión

        if (!$doctorId) {
            abort(404, 'ID del doctor no encontrado en sesión');
        }

        $expedientes = EnviarDoctor::with('paciente')
            ->where('empleado_id', $doctorId)
            ->orderBy('created_at', 'DESC')
            ->paginate(6);;

        return view('doctor.expedientes_recibidos', compact('expedientes'));
    }


    public function getDoctoresPorEspecialidad($departamento)
    {
        $doctores = Empleado::where('cargo', 'Doctor')
            ->where('departamento', $departamento)
            ->get(['id', 'nombre', 'apellido']);
        return response()->json($doctores);
    }



    public function visualizacion_Doctores()
    {


        $doctores = Empleado::where('cargo', 'Doctor')->get();

        return view('index', compact('doctores'));
    }

    public function receta()
    {
        if (!session('cargo') || session('cargo') != 'Doctor') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Doctor');
        }
        return view('empleados.recetamedica');

    }

}
