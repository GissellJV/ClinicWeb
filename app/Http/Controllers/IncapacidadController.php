<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\IncapacidadMedica;
use App\Models\Paciente;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IncapacidadController extends Controller
{
    // EMITIR INCAPACIDADES
    public function emitirIncapacidad(){

        if (!session('cargo') || session('cargo') != 'Doctor') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Doctor');
        }

        $pacientes = Paciente::orderBy('nombres')->get();
        $empleado  = Empleado::find(session('empleado_id'));

        return view('doctor.incapacidades.incapacidad', compact('empleado', 'pacientes'));
    }
    public function guardarIncapacidad(Request $request){
        if (!session('cargo') || session('cargo') != 'Doctor') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesion como Doctor');
        }

        $validated = $request->validate([
            'paciente_id'  => 'required|exists:pacientes,id',
            'fecha_inicio' => 'required|date|after_or_equal:today|before_or_equal:fecha_fin',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
            'motivo'       => 'required|string',
        ], [
            'paciente_id.required'     => 'Debe seleccionar un paciente',
            'paciente_id.exists'       => 'El paciente seleccionado no existe en el sistema',
            'fecha_inicio.required'    => 'La fecha de inicio es obligatoria',
            'fecha_inicio.date'        => 'La fecha de inicio debe ser una fecha valida',
            'fecha_inicio.after_or_equal' => 'La fecha de inicio debe ser posterior o igual a la fecha actual',
            'fecha_inicio.before_or_equal' => 'La fecha de inicio debe ser anterior o igual a la fecha de fin',
            'fecha_fin.required'       => 'La fecha de fin es obligatoria',
            'fecha_fin.date'           => 'La fecha de fin debe ser una fecha valida',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser posterior o igual a la fecha de inicio',
            'motivo.required'          => 'El motivo de la incapacidad es obligatorio',
        ]);

      // Validar que no exista ya una incapacidad para ese paciente en esa misma fecha
        $existe = IncapacidadMedica::where('paciente_id', $validated['paciente_id'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('fecha_inicio', [$validated['fecha_inicio'], $validated['fecha_fin']])
                    ->orWhereBetween('fecha_fin',  [$validated['fecha_inicio'], $validated['fecha_fin']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('fecha_inicio', '<=', $validated['fecha_inicio'])
                            ->where('fecha_fin',    '>=', $validated['fecha_fin']);
                    });
            })->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->withErrors([
                    'paciente_id' => 'Este paciente ya tiene una incapacidad registrada en esta fecha',
                ]);
        }
        // Calcular cantidad de días entre fecha inicio y fin
        $fechaInicio    = Carbon::parse($validated['fecha_inicio']);
        $fechaFin       = Carbon::parse($validated['fecha_fin']);
        $cantidadDias   = $fechaInicio->diffInDays($fechaFin) + 1;

        // Crear el registro
        IncapacidadMedica::create([
            'paciente_id'  => $validated['paciente_id'],
            'empleado_id'  => session('empleado_id'),
            'fecha_inicio' => $validated['fecha_inicio'],
            'fecha_fin'    => $validated['fecha_fin'],
            'cantidad_dias'=> $cantidadDias,
            'motivo'       => $validated['motivo'],
        ]);

        return redirect()->route('doctor.guardar-incapacidad')
            ->with('success', 'Se emitió la incapacidad correctamente');
    }
    //Listado de Incapacidades
    public function listaIncapacidades()
    {
        if (!session('cargo') || session('cargo') != 'Doctor') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Doctor');
        }

        $id = session('empleado_id');

        $incapacidades = IncapacidadMedica::where('empleado_id', $id)
            ->with('paciente')
            ->latest()
            ->get();

        $stats = [
            'total'    => $incapacidades->count(),
            'vigentes' => $incapacidades->filter(fn($i) => $i->estado_calculado === 'Vigente')->count(),
            'vencidas' => $incapacidades->filter(fn($i) => $i->estado_calculado === 'Vencida')->count(),
        ];

        $empleado = Empleado::find($id);

        return view('doctor.incapacidades.listado_incapacidades',
            compact('incapacidades', 'stats', 'empleado'));
    }

    public function descargarCertificado(int $id)
    {
        if (!session('cargo') || session('cargo') != 'Doctor') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesi´pn como Doctor');
        }

        $inc = IncapacidadMedica::where('empleado_id', session('empleado_id'))
            ->with('paciente', 'empleado', 'empleado.loginEmpleado')
            ->findOrFail($id);

        $pdf = Pdf::loadView('doctor.incapacidades.certificado', compact('inc'))
            ->setPaper('carta');
        $name=  $inc->paciente->nombres . ' ' . $inc->paciente->apellidos;

        return $pdf->download("Incapacidad-$name.pdf");
    }


}
