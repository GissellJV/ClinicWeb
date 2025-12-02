<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Cita;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalificacionController extends Controller
{
    // Mostrar el formulario de edición


    // Guardar los cambios

    public function editar(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|integer',
            'paciente_id' => 'required|integer',
            'estrellas' => 'required|integer|min:1|max:5',
        ]);

        $calificacion = Calificacion::where('doctor_id', $request->doctor_id)
            ->where('paciente_id', $request->paciente_id)
            ->first();

        if (!$calificacion) {
            $calificacion = new Calificacion();
            $calificacion->doctor_id = $request->doctor_id;
            $calificacion->paciente_id = $request->paciente_id;
        }

        $calificacion->estrellas = $request->estrellas;
        $calificacion->comentario = $request->comentario ?? '';
        $calificacion->save();

        // Redirigir a la sección #doctors
        return redirect(url('/#doctors'))->with('success', 'Calificación actualizada correctamente');
    }


    private function obtenerPacienteId()
    {
        return session('paciente_id');

    }

    public function store(Request $request)
    {
        if (!session('paciente_id')) {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión para calificar al doctor');
        }

        $pacienteId = session('paciente_id');

        // Validación
        $validated = $request->validate([
            'doctor_id' => 'required|exists:empleados,id',
            'estrellas' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:500'
        ]);

        //  1. VERIFICAR SI EL PACIENTE TUVO CITA CON ESTE DOCTOR
        $tuvoCita = Cita::where('paciente_id', $pacienteId)
            ->where('empleado_id', $validated['doctor_id'])
            ->where('estado', 'Completada')
            ->exists();


        if (!$tuvoCita) {
            // Mostrar modal o mensaje
            return redirect('/#doctors')->with('error', 'No puedes calificar: no has tenido una cita con este doctor.');
        }

        // 2. VERIFICAR SI YA HABÍA CALIFICADO
        $calificacionExistente = Calificacion::where('doctor_id', $validated['doctor_id'])
            ->where('paciente_id', $pacienteId)
            ->first();

        if ($calificacionExistente) {
            //3. SI YA CALIFICÓ → se actualiza
            $calificacionExistente->update([
                'estrellas' => $validated['estrellas'],
                'comentario' => $validated['comentario']
            ]);

            return redirect('/#doctors')->with('success', 'Calificación actualizada correctamente.');
        }

        // 4. SI NO EXISTE → se crea una nueva
        Calificacion::create([
            'doctor_id' => $validated['doctor_id'],
            'paciente_id' => $pacienteId,
            'estrellas' => $validated['estrellas'],
            'comentario' => $validated['comentario']
        ]);

        return redirect('/#doctors')->with('success', '¡Gracias por tu calificación!');
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
            return redirect('/#doctors')->with('error', 'No tienes permiso para editar esta calificación.');
        }

        $validated = $request->validate([
            'estrellas' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:500'
        ]);

        $calificacion->update($validated);

        return redirect('/#doctors')->with('success', 'Calificación actualizada correctamente.');
    }

    public function destroy($id)
    {
        $calificacion = Calificacion::findOrFail($id);
        $pacienteId = $this->obtenerPacienteId();

        if ($calificacion->paciente_id != $pacienteId) {
            return redirect('/#doctors')->with('error', 'No tienes permiso para eliminar esta calificación.');
        }

        $calificacion->delete();

        return redirect('/#doctors')->with('success', 'Calificación eliminada correctamente.');
    }
}
