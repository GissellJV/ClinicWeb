<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Empleado;
use App\Models\RolTurnoDoctor;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TurnoController extends Controller
{
    public function index(Request $request)
    {

        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        $query = Cita::with(['doctor', 'paciente']);
        $mes  = (int)($request->get('mes', now()->month));
        $anio = (int)($request->get('anio', now()->year));

        // Filtrar por doctor
        if ($request->filled('doctor')) {
            $query->where('doctor_nombre', 'like', '%' . $request->doctor . '%');
        }
        $inicioMes = Carbon::create($anio, $mes, 1)->startOfMonth();
        $finMes    = (clone $inicioMes)->endOfMonth();
        $diasEnMes = $inicioMes->daysInMonth;

        // === DOCTORES DESDE BD ===
        $doctoresQuery = Empleado::query()
            ->where('cargo', 'Doctor');

        // Filtrar por especialidad
        if ($request->filled('especialidad')) {
            $query->where('especialidad', 'like', '%' . $request->especialidad . '%');
            // filtro por nombre (nombre o apellido)
            if ($request->filled('nombre')) {
                $nombre = $request->nombre;
                $doctoresQuery->where(function ($q) use ($nombre) {
                    $q->where('nombre', 'like', "%$nombre%")
                        ->orWhere('apellido', 'like', "%$nombre%");
                });
            }
        }

                // filtro por especialidad (ajusta el campo real en tu BD)
                if ($request->filled('departamento')) {
                    $doctoresQuery->where('departamento', $request->departamento);
                }

                // paginación: 10 doctores
                $doctores = $doctoresQuery
                    ->orderBy('apellido')
                    ->orderBy('nombre')
                    ->paginate(10)
                    ->withQueryString();

        // lista de especialidades para el select
        $departamentos = Empleado::where('cargo','Doctor')
            ->whereNotNull('departamento')
            ->distinct()
            ->orderBy('departamento')
                    ->pluck('departamento');

        // días del mes (para el header)
        $dias = [];
        for ($d=1; $d <= $diasEnMes; $d++) {
            $fecha = Carbon::create($anio, $mes, $d);
            $dias[] = [
                'dia' => $d,
                'fecha' => $fecha->format('Y-m-d'),
                'diaSemana' => mb_strtoupper($fecha->locale('es')->isoFormat('dd'), 'UTF-8'), // LU, MA...
                'esFinDeSemana' => $fecha->isWeekend(),
            ];
        }

        // === TURNOS DEL MES
        $turnosMes = RolTurnoDoctor::whereBetween('fecha', [$inicioMes->toDateString(), $finMes->toDateString()])
            ->get()
            ->groupBy(fn($t) => $t->empleado_id); // por doctor

        // grid: [doctorId][dia] => turno
        $grid = [];
        foreach ($doctores as $doc) {
            for ($d=1; $d <= $diasEnMes; $d++) $grid[$doc->id][$d] = null;

            foreach (($turnosMes[$doc->id] ?? collect()) as $t) {
                $diaNum = Carbon::parse($t->fecha)->day;
                $grid[$doc->id][$diaNum] = $t;
            }
        }

        // navegación mes
        $prev = (clone $inicioMes)->subMonth();
        $next = (clone $inicioMes)->addMonth();
        $prevMes = $prev->month; $prevAnio = $prev->year;
        $nextMes = $next->month; $nextAnio = $next->year;

        $nombreMes = strtoupper($inicioMes->locale('es')->monthName);

        // códigos
        $turnosCodigos = [
            'A' => ['nombre'=>'Turno A','inicio'=>'7:00 AM','fin'=>'1:00 PM','color'=>'#2ecc71'],
            'B' => ['nombre'=>'Turno B','inicio'=>'1:00 PM','fin'=>'7:00 PM','color'=>'#3498db'],
            'C' => ['nombre'=>'Turno C','inicio'=>'7:00 PM','fin'=>'7:00 AM','color'=>'#9b59b6'],
            'BC' => ['nombre'=>'BC','inicio'=>null,'fin'=>null,'color'=>'#1abc9c'],
            'ABC' => ['nombre'=>'ABC','inicio'=>null,'fin'=>null,'color'=>'#e67e22'],
            'L' => ['nombre'=>'Libre','inicio'=>null,'fin'=>null,'color'=>'#95a5a6'],
            'LLAMADO' => ['nombre'=>'Al llamado','inicio'=>null,'fin'=>null,'color'=>'#e74c3c'],
        ];

        return view('recepcionista.turnos', compact(
            'mes','anio','nombreMes',
            'prevMes','prevAnio','nextMes','nextAnio',
            'diasEnMes','dias',
            'doctores','departamentos',
            'grid','turnosCodigos'
        ));
    }


    public function store(Request $request)
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }
        $data = $request->validate([
            'empleado_id'  => ['required','integer'],
            'fecha'        => ['required','date'],
            'codigo_turno' => ['required','in:A,B,C,BC,ABC,L,LLAMADO'],
            'nota'        => ['nullable','string','max:255'],
        ]);

        RolTurnoDoctor::updateOrCreate(
            [
                'empleado_id' => $data['empleado_id'],
                'fecha'       => Carbon::parse($data['fecha'])->format('Y-m-d'),
            ],
            [
                'codigo_turno' => $data['codigo_turno'],
                'nota'        => $data['nota'] ?? null,
            ]
        );

        return back()->with('ok', 'Turno guardado correctamente.');
    }

    public function destroy(RolTurnoDoctor $turno)
    {
        $turno->delete();
        return back()->with('ok', 'Turno eliminado.');
    }

    public function show($id)
    {
        $turno = RolTurnoDoctor::with(['empleado'])->findOrFail($id);
        return response()->json($turno);
    }
}
