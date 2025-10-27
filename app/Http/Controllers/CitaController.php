<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    //Vista del recepcionista
    public function index()
    {
        $citas = Cita::with(['doctor', 'paciente'])

            ->get();

        return view('pacientes.listado_citaspro', compact('citas'));
    }

    //Vista del paciente
    public function misCitas()
    {
        $paciente_id = session('paciente_id');

        if (!$paciente_id) {
            return redirect()->route('pacientes.loginp')->with('error', 'Debes iniciar sesión para ver tus citas');
        }

        $paciente = Paciente::find($paciente_id);

        if (!$paciente) {
            return redirect()->back()->with('error', 'No se encontró información del paciente');
        }

        $citas = Cita::with('doctor')
            ->where('paciente_id', $paciente->id)
            ->get();

        return view('citas.mis-citas', compact('citas'));
    }

    //  Cancelar cita
    public function cancelarCita($id)
    {
        $cita = Cita::findOrFail($id);
        $paciente_id = session('paciente_id');
        $paciente = Paciente::find($paciente_id);

        if ($cita->paciente_id !== $paciente->id) {
            return redirect()->back()->with('error', 'No tienes permiso para cancelar esta cita');
        }

        // Aquí se limpia el mensaje además de cambiar el estado
        $cita->update([
            'estado' => 'cancelada',
            'mensaje' => null
        ]);

        return redirect()->back()->with('success', 'Cita cancelada exitosamente');
    }


    //  Reprogramar cita
    public function reprogramarCita(Request $request, $id)
    {
        $request->validate([
            'nueva_fecha' => 'required|date|after:today',
            'nueva_hora' => 'required'
        ]);

        $cita = Cita::findOrFail($id);
        $paciente_id = session('paciente_id');
        $paciente = Paciente::find($paciente_id);

        if ($cita->paciente_id !== $paciente->id) {
            return redirect()->back()->with('error', 'No tienes permiso para reprogramar esta cita');
        }

        $cita->update([
            'fecha' => $request->nueva_fecha,
            'hora' => $request->nueva_hora,
            'estado' => 'reprogramada',
            'mensaje' => null
        ]);

        return redirect()->back()->with('success', 'Cita reprogramada exitosamente');
    }

    //Confirmar cita (recepcionista)
    public function confirmarCita($id)
    {
        // Buscar la cita
        $cita = Cita::findOrFail($id);

        // Verificar que la cita esté pendiente
        if ($cita->estado !== 'pendiente') {
            return redirect()->back()->with('error', 'La cita no se puede confirmar porque no está pendiente.');
        }

        // Obtener nombre del doctor seguro
        $doctorNombre = $cita->doctor ? $cita->doctor->nombre : ($cita->doctor_nombre ?? 'Doctor no asignado');

        // Actualizar estado y guardar mensaje
        $cita->estado = 'programada';
        $cita->mensaje = "Tu cita con el {$doctorNombre} ha sido confirmada para las {$cita->hora}.";
        $cita->save();

        return redirect()->back()->with('success', 'Cita confirmada correctamente.');
    }

    public function guardarDesdeCalendario(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora' => 'required|string',
            'doctor' => 'required|string',
            'especialidad' => 'required|string',
        ]);

        $paciente_id = session('paciente_id');
        $paciente_nombre = session('paciente_nombre');

        if (!$paciente_id || !$paciente_nombre) {
            return response()->json(['success' => false, 'message' => 'Debe iniciar sesión']);
        }

        try {
            $cita = Cita::create([
                'paciente_id' => $paciente_id,
                'paciente_nombre' => $paciente_nombre, //
                'doctor_nombre' => $request->doctor,
                'especialidad' => $request->especialidad,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'estado' => 'pendiente',
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }



}
