<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Empleado;
use App\Models\RolTurnoDoctor;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    public function index(Request $request)
    {
        // Verificación de sesión
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        // Construcción del query
        $query = Cita::with(['doctor', 'paciente']);

        // Filtrar por doctor
        if ($request->filled('doctor')) {
            $query->where('doctor_nombre', 'like', '%' . $request->doctor . '%');
        }

        // Filtrar por especialidad
        if ($request->filled('especialidad')) {
            $query->where('especialidad', 'like', '%' . $request->especialidad . '%');
        }

        // Filtrar por fecha exacta
        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }

        // Paginación
        $citas = $query->paginate(10);

        // Datos extra para la vista
        $doctores = Empleado::where('cargo', 'Doctor')->get();
        $especialidads = Cita::select('especialidad')
            ->whereNotNull('especialidad')
            ->distinct()
            ->pluck('especialidad');

        return view('recepcionista.turnos', compact( 'doctores', 'citas', 'especialidads'));
    }


    public function store(Request $request)
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'cita_id'     => 'required|exists:citas,id',
            'fecha'       => 'required|date',
            'hora_turno'  => 'required'
        ]);

        RolTurnoDoctor::create([
            'empleado_id' => $request->empleado_id,
            'cita_id'     => $request->cita_id,
            'fecha'       => $request->fecha,
            'hora_turno'  => $request->hora_turno
        ]);

        return redirect()->route('recepcionista.index')->with('success', 'Turno creado correctamente.');
    }

    public function show($id)
    {

        $turno = RolTurnoDoctor::with(['empleado', 'cita'])->findOrFail($id);
        return response()->json($turno);
    }
}
