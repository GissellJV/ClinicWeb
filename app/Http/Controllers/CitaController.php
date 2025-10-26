<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitaController extends Controller
{
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
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->get();

        return view('citas.mis-citas', compact('citas'));
    }

    public function cancelarCita($id)
    {
        $cita = Cita::findOrFail($id);

        // Verificar que la cita pertenezca al paciente
        $paciente_id = session('paciente_id');
        $paciente = Paciente::find($paciente_id);

        if ($cita->paciente_id !== $paciente->id) {
            return redirect()->back()->with('error', 'No tienes permiso para cancelar esta cita');
        }

        $cita->update(['estado' => 'cancelada']);

        return redirect()->back()->with('success', 'Cita cancelada exitosamente');
    }

    public function reprogramarCita(Request $request, $id)
    {
        $request->validate([
            'nueva_fecha' => 'required|date|after:today',
            'nueva_hora' => 'required'
        ]);

        $cita = Cita::findOrFail($id);

        // Verificar permisos
        $paciente_id = session('paciente_id');
        $paciente = Paciente::find($paciente_id);

        if ($cita->paciente_id !== $paciente->id) {
            return redirect()->back()->with('error', 'No tienes permiso para reprogramar esta cita');
        }

        $cita->update([
            'fecha_cita' => $request->fecha,
            'estado' => 'reprogramada'
        ]);

        return redirect()->back()->with('success', 'Cita reprogramada exitosamente');
    }
}
