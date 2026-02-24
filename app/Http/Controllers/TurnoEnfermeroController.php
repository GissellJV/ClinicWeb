<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\RolTurnoEnfermero;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TurnoEnfermeroController extends Controller
{
    public function indexEnfermero(Request $request)
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        $mes  = (int)($request->get('mes', now()->month));
        $anio = (int)($request->get('anio', now()->year));

        $inicioMes = Carbon::create($anio, $mes, 1)->startOfMonth();
        $finMes    = (clone $inicioMes)->endOfMonth();
        $diasEnMes = $inicioMes->daysInMonth;

        // === ENFERMEROS DESDE BD ===
        $enfermerosQuery = Empleado::query()
            ->where('cargo', 'Enfermero');

        if ($request->filled('nombre')) {
            $nombre = $request->nombre;
            $enfermerosQuery->where(function($q) use ($nombre) {
                $q->where('nombre', 'like', "%$nombre%")
                    ->orWhere('apellido', 'like', "%$nombre%");
            });
        }

        if ($request->filled('departamento')) {
            $enfermerosQuery->where('departamento', $request->departamento);
        }

        $enfermeros = $enfermerosQuery
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();

        $departamentos = Empleado::where('cargo','Enfermeria') // ✅ CAMBIO
        ->whereNotNull('departamento')
            ->distinct()
            ->orderBy('departamento')
            ->pluck('departamento');

        $dias = [];
        for ($d=1; $d <= $diasEnMes; $d++) {
            $fecha = Carbon::create($anio, $mes, $d);
            $dias[] = [
                'dia' => $d,
                'fecha' => $fecha->format('Y-m-d'),
                'diaSemana' => mb_strtoupper($fecha->locale('es')->isoFormat('dd'), 'UTF-8'),
                'esFinDeSemana' => $fecha->isWeekend(),
            ];
        }

        // === TURNOS DEL MES ===
        $turnosMes = RolTurnoEnfermero::whereBetween('fecha', [$inicioMes->toDateString(), $finMes->toDateString()])
            ->get()
            ->groupBy(fn($t) => $t->empleado_id);

        $grid = [];
        foreach ($enfermeros as $enf) {
            for ($d=1; $d <= $diasEnMes; $d++) $grid[$enf->id][$d] = null;

            foreach (($turnosMes[$enf->id] ?? collect()) as $t) {
                $diaNum = Carbon::parse($t->fecha)->day;
                $grid[$enf->id][$diaNum] = $t;
            }
        }

        $prev = (clone $inicioMes)->subMonth();
        $next = (clone $inicioMes)->addMonth();
        $prevMes = $prev->month; $prevAnio = $prev->year;
        $nextMes = $next->month; $nextAnio = $next->year;

        $nombreMes = strtoupper($inicioMes->locale('es')->monthName);

        $turnosCodigos = [
            'A' => ['nombre'=>'Turno A','inicio'=>'7:00 AM','fin'=>'1:00 PM','color'=>'#2ecc71'],
            'B' => ['nombre'=>'Turno B','inicio'=>'1:00 PM','fin'=>'7:00 PM','color'=>'#3498db'],
            'C' => ['nombre'=>'Turno C','inicio'=>'7:00 PM','fin'=>'7:00 AM','color'=>'#9b59b6'],
            'BC' => ['nombre'=>'BC','inicio'=>null,'fin'=>null,'color'=>'#1abc9c'],
            'ABC' => ['nombre'=>'ABC','inicio'=>null,'fin'=>null,'color'=>'#e67e22'],
            'L' => ['nombre'=>'Libre','inicio'=>null,'fin'=>null,'color'=>'#95a5a6'],
            'LLAMADO' => ['nombre'=>'Al llamado','inicio'=>null,'fin'=>null,'color'=>'#e74c3c'],
        ];

        return view('recepcionista.turnoEnfermeros', compact(
            'mes','anio','nombreMes',
            'prevMes','prevAnio','nextMes','nextAnio',
            'diasEnMes','dias',
            'enfermeros','departamentos',
            'grid','turnosCodigos'
        ));
    }

    public function storeEnfermero(Request $request)
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        $data = $request->validate([
            'empleado_id'  => ['required','integer'],
            'fecha'        => ['required','date'],
            'codigo_turno' => ['required','in:A,B,C,BC,ABC,L,LLAMADO'],
            'nota'         => ['nullable','string','max:255'],
        ]);

        RolTurnoEnfermero::updateOrCreate(
            [
                'empleado_id' => $data['empleado_id'],
                'fecha'       => Carbon::parse($data['fecha'])->format('Y-m-d'),
            ],
            [
                'codigo_turno' => $data['codigo_turno'],
                'nota'         => $data['nota'] ?? null,
            ]
        );

        return back()->with('ok', 'Turno guardado correctamente.');
    }

    public function destroyEnfermero(RolTurnoEnfermero $turno)
    {
        $turno->delete();
        return back()->with('ok', 'Turno eliminado.');
    }

    public function showEnfermero($id)
    {
        $turno = RolTurnoEnfermero::with(['empleado'])->findOrFail($id);
        return response()->json($turno);
    }
}
