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
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('empleados.loginempleado')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }
        $query = RolTurnoDoctor::with(['empleado', 'cita']);

        if ($request->filled('empleado')) {
            $query->whereHas('empleado', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->doctor . '%');
            });
        }

        if ($request->filled('cargo')) {
            $query->whereHas('empleado.cargo', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->especialidad . '%');
            });
        }

        if ($request->filled('fecha')) {
            $query->where('fecha', $request->fecha);
        }

        $turnos = $query->paginate(10);
        $doctores = Empleado::where('cargo', 'Doctor')->get();
        $citas = Cita::with('paciente')->get();

        return view('recepcionista.turnos', compact('turnos', 'doctores', 'citas'));
    }

    public function store(Request $request)
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('empleados.loginempleado')
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

        return redirect()->route('rol-turnos.index')->with('success', 'Turno creado correctamente.');
    }

    public function show($id)
    {

        $turno = RolTurnoDoctor::with(['empleado', 'cita'])->findOrFail($id);
        return response()->json($turno);
    }

    public function verMas($id)
    {
        $turno = RolTurnoDoctor::with(['empleado', 'departamento'])->findOrFail($id);

        return view('recepcionista.vermas', compact('turno'));
    }
}
