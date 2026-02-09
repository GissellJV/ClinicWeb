<?php

namespace App\Http\Controllers;

use App\Models\Incidente;
use App\Models\Paciente;
use Illuminate\Http\Request;

class IncidenteController extends Controller
{
    // Mostrar formulario para crear incidente
    public function crear()
    {
        if (!session('cargo') || session('cargo') != 'Enfermero') {
            return redirect()->route('empleados.loginempleado')
                ->with('error', 'Debes iniciar sesión como Enfermero');
        }

        $pacientes = Paciente::all();
        return view('enfermeria.incidentes.crear', compact('pacientes'));
    }

    // Guardar incidente
    public function guardar(Request $request)
    {
        if (!session('cargo') || session('cargo') != 'Enfermero') {
            return redirect()->route('empleados.loginempleado')
                ->with('error', 'Debes iniciar sesión como Enfermero');
        }

        $request->validate([
            'descripcion' => 'required|string|max:1000',
            'fecha_hora_incidente' => 'required|date',
            'paciente_id' => 'required|exists:pacientes,id',
            'tipo_incidente' => 'required|in:Caída,Medicación,Alergia,Equipo Médico,Otro',
            'gravedad' => 'required|in:Leve,Moderado,Grave,Crítico',
            'acciones_tomadas' => 'nullable|string|max:1000',
            'estado' => 'required|in:Pendiente,En Revisión,Resuelto'
        ]);

        Incidente::create([
            'descripcion' => $request->descripcion,
            'fecha_hora_incidente' => $request->fecha_hora_incidente,
            'paciente_id' => $request->paciente_id,
            'empleado_id' => session('empleado_id'),
            'empleado_nombre' => session('empleado_nombre'),
            'tipo_incidente' => $request->tipo_incidente,
            'gravedad' => $request->gravedad,
            'acciones_tomadas' => $request->acciones_tomadas,
            'estado' => $request->estado
        ]);

        return redirect()->route('incidentes.index')
            ->with('success', '¡Incidente registrado exitosamente!');
    }

    // Listar todos los incidentes
    public function index()
    {
        if (!session('cargo') || session('cargo') != 'Enfermero') {
            return redirect()->route('empleados.loginempleado')
                ->with('error', 'Debes iniciar sesión como Enfermero');
        }

        $incidentes = Incidente::with('paciente')
            ->orderBy('fecha_hora_incidente', 'desc')
            ->paginate(10);

        return view('enfermeria.incidentes.index', compact('incidentes'));
    }

    // Ver detalle de un incidente
    public function show($id)
    {
        if (!session('cargo') || session('cargo') != 'Enfermero') {
            return redirect()->route('empleados.loginempleado')
                ->with('error', 'Debes iniciar sesión como Enfermero');
        }

        $incidente = Incidente::with('paciente')->findOrFail($id);
        return view('enfermeria.incidentes.show', compact('incidente'));
    }

    // Actualizar estado del incidente
    public function actualizarEstado(Request $request, $id)
    {
        if (!session('cargo') || session('cargo') != 'Enfermero') {
            return redirect()->route('empleados.loginempleado')
                ->with('error', 'Debes iniciar sesión como Enfermero');
        }

        $incidente = Incidente::findOrFail($id);

        $request->validate([
            'estado' => 'required|in:Pendiente,En Revisión,Resuelto'
        ]);

        $incidente->update([
            'estado' => $request->estado
        ]);

        return redirect()->back()->with('success', 'Estado actualizado correctamente');
    }
}
