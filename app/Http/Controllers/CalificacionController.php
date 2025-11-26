<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalificacionController extends Controller
{
    private function obtenerPacienteId()
    {
        return session('paciente_id');

    }

    public function store(Request $request)
    {
        if (!session('paciente_id')) {
        return redirect()->route('inicioSesion')
            ->with('error', 'Debes iniciar sesión para agendar una cita');
    }

        // VERIFICAR SESIÓN
        $pacienteId = session('paciente_id');
        if (!$pacienteId) {
            return back()->with('error', 'No se pudo identificar al paciente.');
        }

        // VALIDAR
        $validated = $request->validate([
            'doctor_id' => 'required|exists:empleados,id',
            'estrellas' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:500'
        ]);

        // EVITAR DUPLICADO
        if (Calificacion::yaCalificado($validated['doctor_id'], $pacienteId)) {
            return back()->with('info', 'Ya has calificado a este doctor.');
        }

        // GUARDAR
        Calificacion::create([
            'doctor_id' => $validated['doctor_id'],
            'paciente_id' => $pacienteId,
            'estrellas' => $validated['estrellas'],
            'comentario' => $validated['comentario']
        ]);

        return back()->with('success', '¡Gracias por tu calificación!');

    }

    public function verCalificaciones($doctorId)
    {
        $doctor = Empleado::with('calificaciones.paciente')->findOrFail($doctorId);

        return view('calificaciones.ver', compact('doctor'));
    }

    public function update(Request $request, $id)
    {
        $calificacion = Calificacion::findOrFail($id);
        $pacienteId = $this->obtenerPacienteId();

        if ($calificacion->paciente_id != $pacienteId) {
            return redirect()->back()->with('error', 'No tienes permiso para editar esta calificación.');
        }

        $validated = $request->validate([
            'estrellas' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:500'
        ]);

        $calificacion->update($validated);

        return redirect()->back()->with('success', 'Calificación actualizada correctamente.');
    }

    public function destroy($id)
    {
        $calificacion = Calificacion::findOrFail($id);
        $pacienteId = $this->obtenerPacienteId();

        if ($calificacion->paciente_id != $pacienteId) {
            return redirect()->back()->with('error', 'No tienes permiso para eliminar esta calificación.');
        }

        $calificacion->delete();

        return redirect()->back()->with('success', 'Calificación eliminada correctamente.');
    }
}
