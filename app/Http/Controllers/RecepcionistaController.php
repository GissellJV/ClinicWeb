<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\HistorialDiario;
use App\Models\Receta;
use App\Models\Empleado;
use App\Models\Expediente;
use App\Models\Paciente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\EnviarDoctor;

class RecepcionistaController extends Controller
{
    public function enviarDoctor(Request $request)
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        // VALIDAR datos de envío
        $request->validate([
            'paciente_id'   => 'required|exists:pacientes,id',
            'empleado_id'   => 'required|exists:empleados,id',
            'especialidad'  => 'required|string'
        ]);

        // IMPLEMENTAR creación del envío
        EnviarDoctor::create([
            'paciente_id'  => $request->paciente_id,
            'empleado_id'  => $request->empleado_id,
            'especialidad' => $request->especialidad,
            'estado'       => 'pendiente'
        ]);

        return redirect()->route('recepcionista.busquedaexpediente')
            ->with('success', 'Expediente enviado correctamente al doctor.');
    }

    public function vistaEnviarDoctor($id)
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        $expediente = Expediente::findOrFail($id);

        $especialidades = Empleado::where('cargo', 'Doctor')
            ->select('departamento')
            ->distinct()
            ->get();

        return view('recepcionista.enviar_doctor', compact('expediente', 'especialidades'));
    }

    public function buscarExpediente(Request $request)
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }
        $expedientes = Paciente::with('expediente')
            ->orderBy('apellidos')
            ->orderBy('nombres')
            ->get();
        return view('recepcionista.busquedaexpediente', compact('expedientes'));
    }

    public function registroPaciente(Request $request)
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        $ninos = Paciente::whereRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) BETWEEN 0 AND 12')->get();
        $adolescentes = Paciente::whereRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) BETWEEN 13 AND 17')->get();
        $adultos = Paciente::whereRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) BETWEEN 18 AND 59')->get();
        $terceraEdad = Paciente::whereRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) >= 60')->get();

        $visitasPorDia = Paciente::select(
            DB::raw("DAYNAME(created_at) as dia"),
            DB::raw("COUNT(*) as total")
        )
            ->groupBy('dia')
            ->orderByRaw("FIELD(dia, 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')")
            ->get();

        $labelsVisitas = $visitasPorDia->pluck('dia');
        $dataVisitas = $visitasPorDia->pluck('total');

        $filtro = $request->get('filtro', 'recientes');
        $query = Paciente::orderBy('created_at', 'desc');

        if ($filtro == 'hoy') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($filtro == 'semana') {
            $query->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ]);
        } elseif ($filtro == 'mes') {
            $query->whereMonth('created_at', Carbon::now()->month);
        } elseif ($filtro == 'anio') {
            $query->whereYear('created_at', Carbon::now()->year);
        }

        if ($request->has('buscar')) {
            $query->where(function ($q) use ($request) {
                $q->where('nombres', 'LIKE', '%' . $request->buscar . '%')
                    ->orWhere('apellidos', 'LIKE', '%' . $request->buscar . '%');
            });
        }

        $pacientes = $query->paginate(10);
        $citas = Cita::with('paciente')->get();

        foreach ($citas as $cita) {
            $cita->paciente->edad = \Carbon\Carbon::parse($cita->paciente->fecha_nacimiento)->age;
        }

        return view('recepcionista.Registro_Asistencia', compact(
            'ninos', 'adolescentes', 'adultos', 'terceraEdad',
            'labelsVisitas', 'dataVisitas', 'pacientes', 'filtro', 'citas'
        ));
    }

    public function historialDiario()
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }
        $historial = HistorialDiario::whereDate('fecha', now())->get();
        return view('recepcionista.historial', compact('historial'));
    }

    public function listaDoctores()
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }
        $doctores = Empleado::where('cargo', 'Doctor')->paginate(6);
        return view('recepcionista.lista_doctores', compact('doctores'));
    }

    // --- MÉTODOS PARA  REGISTRO DE VISITANTES ---

    /**
     * Mostrar el formulario de registro de visitantes.
     * Acción: Validar sesión y Cargar pacientes.
     */
    public function indexVisitantes()
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        // Obtener pacientes para el select del formulario
        $pacientes = Paciente::orderBy('nombres')->get();

        return view('recepcionista.registro_visitantes', compact('pacientes'));
    }

    /**
     * Guardar el registro del visitante.
     * Acción: Validar datos, Validar habitación e Implementar guardado.
     */
    public function storeVisitante(Request $request)
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion');
        }

        // 1. VALIDAR datos técnicos (nombres de inputs en el formulario)
        $request->validate([
            'nombre_visitante' => 'required|string|max:255',
            'dni_visitante'    => 'required|string|max:20',
            'paciente_id'      => 'required|exists:pacientes,id',
        ]);

        // 2. VALIDAR Criterio de Aceptación: El paciente debe estar hospitalizado
        $tieneHabitacion = \App\Models\AsignacionHabitacion::where('paciente_id', $request->paciente_id)
            ->exists();

        if (!$tieneHabitacion) {
            return back()->with('error', 'Validación fallida: El paciente seleccionado no tiene una habitación asignada actualmente.');
        }

        // 3. IMPLEMENTAR guardado en la tabla 'visitantes'
        // NOTA: Se usa la columna 'dni' para coincidir con tu base de datos MySQL
        try {
            DB::table('visitantes')->insert([
                'nombre_visitante' => $request->nombre_visitante,
                'dni'              => $request->dni_visitante,
                'paciente_id'      => $request->paciente_id,
                'fecha_ingreso'    => now(),
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);

            return back()->with('success', 'Registro completado: Ingreso de visitante validado e implementado correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error técnico al registrar: ' . $e->getMessage());
        }
    }
}
