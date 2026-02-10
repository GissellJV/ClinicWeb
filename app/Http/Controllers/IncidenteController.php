<?php

namespace App\Http\Controllers;

use App\Models\Incidente;
use App\Models\Paciente;
use Illuminate\Http\Request;

class IncidenteController extends Controller
{
    // Listar todos los incidentes
    public function index()
    {
        if (!session('cargo') || session('cargo') != 'Enfermero') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Enfermero');
        }

        $incidentes = Incidente::with('paciente')
            ->orderBy('fecha_hora_incidente', 'desc')
            ->paginate(10);

        return view('enfermeria.incidentes.index', compact('incidentes'));
    }

    // Mostrar formulario para crear incidente
    public function crear()
    {
        if (!session('cargo') || session('cargo') != 'Enfermero') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Enfermero');
        }

        $pacientes = Paciente::orderBy('nombres')->get();

        return view('enfermeria.incidentes.crear', compact('pacientes'));
    }

    // Guardar nuevo incidente
    public function guardar(Request $request)
    {
        if (!session('cargo') || session('cargo') != 'Enfermero') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Enfermero');
        }

        $request->validate([
            'descripcion' => 'required|string|max:1000',
            'fecha_hora_incidente' => 'required|date',
            'paciente_id' => 'required|exists:pacientes,id',
            'tipo_incidente' => 'required|in:Caída,Medicación,Alergia,Equipo Médico,Otro',
            'gravedad' => 'required|in:Leve,Moderado,Grave,Crítico',
            'acciones_tomadas' => 'nullable|string|max:500',
            'estado' => 'required|in:Pendiente,En Revisión,Resuelto',
        ]);

        // Crear incidente
        Incidente::create([
            'descripcion' => $request->descripcion,
            'fecha_hora_incidente' => $request->fecha_hora_incidente,
            'paciente_id' => $request->paciente_id,
            'empleado_id' => session('empleado_id'),
            'empleado_nombre' => session('empleado_nombre'),
            'tipo_incidente' => $request->tipo_incidente,
            'gravedad' => $request->gravedad,
            'acciones_tomadas' => $request->acciones_tomadas,
            'estado' => $request->estado,
        ]);

        return redirect()->route('incidentes.index')
            ->with('success', 'Incidente registrado exitosamente.');
    }

    // Ver detalle de incidente
    public function show($id)
    {
        if (!session('cargo') || session('cargo') != 'Enfermero') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Enfermero');
        }

        $incidente = Incidente::with('paciente')->findOrFail($id);

        return view('enfermeria.incidentes.show', compact('incidente'));
    }

    // Actualizar estado de incidente
    public function actualizarEstado(Request $request, $id)
    {
        if (!session('cargo') || session('cargo') != 'Enfermero') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Enfermero');
        }

        $request->validate([
            'estado' => 'required|in:Pendiente,En Revisión,Resuelto',
        ]);

        $incidente = Incidente::findOrFail($id);
        $incidente->estado = $request->estado;
        $incidente->save();

        return back()->with('success', 'Estado actualizado exitosamente.');
    }
}




