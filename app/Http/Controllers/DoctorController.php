<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use App\Models\EnviarDoctor;
use App\Models\Paciente;
use App\Models\Expediente;
use App\Models\Cita;


class DoctorController extends Controller
{
    /**
     * Ver expediente desde cualquier lugar (citas o expedientes recibidos)
     */
    public function verExpediente($pacienteId)
    {
        if (!session('cargo') || session('cargo') != 'Doctor') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Doctor');
        }

        $doctorId = session('empleado_id');

        try {
            // Verificar acceso: puede ser por enviardoctores O por cita activa
            $tieneAcceso = false;

            // Verificar en enviardoctores
            $asignacion = EnviarDoctor::where('empleado_id', $doctorId)
                ->where('paciente_id', $pacienteId)
                ->first();

            if ($asignacion) {
                $tieneAcceso = true;
                // Marcar como completado
                $asignacion->update(['estado' => 'completado']);
            }

            // Verificar en citas activas
            $citaActiva = Cita::where('empleado_id', $doctorId)
                ->where('paciente_id', $pacienteId)
                ->whereIn('estado', ['programada', 'pendiente', 'confirmada'])
                ->first();

            if ($citaActiva) {
                $tieneAcceso = true;
            }

            // Si no tiene acceso por ninguna vía
            if (!$tieneAcceso) {
                return redirect()->route('doctor.citas')
                    ->with('error', 'No tienes acceso al expediente de este paciente');
            }

            // Buscar el paciente
            $paciente = Paciente::find($pacienteId);
            if (!$paciente) {
                return redirect()->route('doctor.citas')
                    ->with('error', 'Paciente no encontrado');
            }

            // Buscar o crear el expediente
            $expediente = Expediente::with('paciente')->where('paciente_id', $pacienteId)->first();

            // Si no existe expediente, lo creamos automáticamente
            if (!$expediente) {
                $expediente = Expediente::create([
                    'paciente_id' => $pacienteId,
                    'numero_expediente' => Expediente::generarNumeroExpediente(),
                    'peso' => null,
                    'altura' => null,
                    'temperatura' => null,
                    'presion_arterial' => null,
                    'frecuencia_cardiaca' => null,
                    'sintomas_actuales' => 'Pendiente de registrar',
                    'diagnostico' => 'Pendiente de registrar',
                    'tratamiento' => 'Pendiente de registrar',
                    'alergias' => 'No registradas',
                    'medicamentos_actuales' => 'No registrados',
                    'antecedentes_familiares' => 'No registrados',
                    'antecedentes_personales' => 'No registrados',
                    'observaciones' => '',
                    'estado' => 'activo'
                ]);

                $expediente = Expediente::with('paciente')->find($expediente->id);
            }

            return view('expedientes.verexpediente', compact('expediente'));

        } catch (\Exception $e) {
            return redirect()->route('doctor.citas')
                ->with('error', 'Error al ver el expediente: ' . $e->getMessage());
        }
    }

    public function expedientesRecibidos()
    {
        if (!session('cargo') || session('cargo') != 'Doctor') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Doctor');
        }

        $doctorId = session('empleado_id');

        if (!$doctorId) {
            abort(404, 'ID del doctor no encontrado en sesión');
        }

        $expedientes = EnviarDoctor::with('paciente')
            ->where('empleado_id', $doctorId)
            ->orderBy('created_at', 'DESC')
            ->paginate(6);

        return view('doctor.expedientes_recibidos', compact('expedientes'));
    }

    public function getDoctoresPorEspecialidad($departamento)
    {
        $doctores = Empleado::where('cargo', 'Doctor')
            ->where('departamento', $departamento)
            ->get(['id', 'nombre', 'apellido', 'foto', 'genero']);
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
