<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\RolTurnoEnfermero;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;
Carbon::setLocale('es');


class TurnoEnfermeroController extends Controller
{
    public function verTurnosE(Request $request)
    {
        if (!session('cargo') || !in_array(session('cargo'), ['Recepcionista', 'Enfermero', 'Administrador'])) {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista o enfermero');
        }

        $mes = $request->mes ?? now()->month;
        $anio = $request->anio ?? now()->year;

        $fecha = Carbon::create($anio, $mes, 1);

        $prevMes = $fecha->copy()->subMonth()->month;
        $prevAnio = $fecha->copy()->subMonth()->year;

        $nextMes = $fecha->copy()->addMonth()->month;
        $nextAnio = $fecha->copy()->addMonth()->year;

        $nombreMes = ucfirst($fecha->translatedFormat('F'));
        $diasEnMes = $fecha->daysInMonth;

        // SOLO EL ENFERMERO LOGUEADO
        $enfermeros = Empleado::where('id', session('empleado_id'))->get();

        // TURNOS SOLO DE ESE ENFERMERO
        $turnos = RolTurnoEnfermero::where('empleado_id', session('empleado_id'))
            ->whereMonth('fecha', $mes)
            ->whereYear('fecha', $anio)
            ->get();

        $grid = [];

        foreach ($turnos as $turno) {
            $dia = Carbon::parse($turno->fecha)->day;
            $grid[$turno->empleado_id][$dia] = $turno;
        }
        $departamentos = Empleado::where('cargo','Enfermeria') // ✅ CAMBIO
        ->whereNotNull('departamento')
            ->distinct()
            ->orderBy('departamento')
            ->pluck('departamento');

        $dias = [];

        for ($d = 1; $d <= $diasEnMes; $d++) {

            $date = Carbon::create($anio, $mes, $d);

            $dias[] = [
                'dia' => $d,
                'fecha' => $date->format('Y-m-d'),
                'diaSemana' => strtoupper($date->translatedFormat('D')),
                'esFinDeSemana' => $date->isWeekend(),
            ];
        }

        $turnosCodigos = [
            'A' => [
                'nombre' => 'Turno A',
                'inicio' => '7:00 AM',
                'fin' => '2:00 PM',
                'color' => '#2ecc71'
            ],
            'B' => [
                'nombre' => 'Turno B',
                'inicio' => '2:00 PM',
                'fin' => '9:00 PM',
                'color' => '#4ecdc4'
            ],
            'C' => [
                'nombre' => 'Turno C',
                'inicio' => '9:00 PM',
                'fin' => '7:00 AM',
                'color' => '#9b59b6'
            ],
            'BC' => [
                'nombre' => 'Turno BC',
                'inicio' => '',
                'fin' => '',
                'color' => '#00ffe7'
            ],
            'ABC' => [
                'nombre' => 'Turno ABC',
                'inicio' => '',
                'fin' => '',
                'color' => '#f4a261'
            ],
            'L' => [
                'nombre' => 'Libre',
                'inicio' => '',
                'fin' => '',
                'color' => '#95a5a6'
            ],
            'LLAMADO' => [
                'nombre' => 'Al llamado',
                'inicio' => '',
                'fin' => '',
                'color' => '#ff4d6d'
            ],
        ];

        return view('enfermeria.Turnos-Mensuales', compact(
            'mes',
            'anio',
            'prevMes',
            'prevAnio',
            'nextMes',
            'nextAnio',
            'nombreMes',
            'diasEnMes',
            'enfermeros',
            'grid',
            'dias',
            'turnosCodigos',
            'departamentos'
        ));
    }
    public function exportPdf(Request $request)
    {

        if (!session('cargo') || !in_array(session('cargo'), ['Recepcionista', 'Enfermero', 'Administrador'])) {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista o enfermero');
        }

        $mes = (int)($request->get('mes', now()->month));
        $anio = (int)($request->get('anio', now()->year));

        $inicioMes = Carbon::create($anio, $mes, 1)->startOfMonth();
        $finMes = (clone $inicioMes)->endOfMonth();
        $diasEnMes = $inicioMes->daysInMonth;

        // SOLO EL ENFERMERO LOGUEADO
        $enfermeros = Empleado::where('id', session('empleado_id'))->paginate(10);

        // TURNOS DEL MES
        $turnosMes = RolTurnoEnfermero::where('empleado_id', session('empleado_id'))
            ->whereBetween('fecha', [$inicioMes->toDateString(), $finMes->toDateString()])
            ->get()
            ->groupBy(fn($t) => $t->empleado_id);

        if ($turnosMes->isEmpty()) {
            return back()->with('error', 'No hay turnos registrados para este mes.');
        }

        $grid = [];

        foreach ($enfermeros as $enf) {

            for ($d=1; $d <= $diasEnMes; $d++) {
                $grid[$enf->id][$d] = null;
            }

            foreach (($turnosMes[$enf->id] ?? collect()) as $t) {
                $diaNum = Carbon::parse($t->fecha)->day;
                $grid[$enf->id][$diaNum] = $t;
            }
        }

        $dias = [];

        for ($d=1; $d <= $diasEnMes; $d++) {

            $fecha = Carbon::create($anio, $mes, $d);

            $dias[] = [
                'dia'=>$d,
                'fecha'=>$fecha->format('Y-m-d'),
                'diaSemana'=>mb_strtoupper($fecha->locale('es')->isoFormat('dd'),'UTF-8'),
                'esFinDeSemana'=>$fecha->isWeekend(),
            ];
        }

        $nombreMes = strtoupper($inicioMes->locale('es')->monthName);

        $turnosCodigos = [
            'A' => ['nombre'=>'Turno A'],
            'B' => ['nombre'=>'Turno B'],
            'C' => ['nombre'=>'Turno C'],
            'BC' => ['nombre'=>'BC'],
            'ABC' => ['nombre'=>'ABC'],
            'L' => ['nombre'=>'Libre'],
            'LLAMADO' => ['nombre'=>'Al llamado'],
        ];

        $pdf = Pdf::loadView('pdf.turnos-enfermeria', compact(
            'mes','anio','nombreMes','diasEnMes',
            'dias','enfermeros','grid','turnosCodigos'
        ))->setPaper('a4','landscape');

        $filename = "rol-turnos-enfermeria-{$anio}-" . str_pad((string)$mes, 2, '0', STR_PAD_LEFT) . ".pdf";

        return $pdf->download($filename);
    }
    public function indexEnfermero(Request $request)
    {
        if (!session('cargo') || !in_array(session('cargo'), ['Recepcionista', 'Enfermero', 'Administrador'])) {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista o enfermero');
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
        if (!session('cargo') || !in_array(session('cargo'), ['Recepcionista', 'Enfermero', 'Administrador'])) {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista o enfermero');
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
    public function exportarMesCalendario(Request $request)
    {
        if (!session('cargo') || session('cargo') != 'Enfermero') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Enfermero');
        }

        $mes = $request->get('mes', now()->month);
        $anio = $request->get('anio', now()->year);

        // SOLO TURNOS DEL ENFERMERO LOGUEADO
        $turnos = RolTurnoEnfermero::with('empleado')
            ->where('empleado_id', session('empleado_id'))
            ->whereMonth('fecha', $mes)
            ->whereYear('fecha', $anio)
            ->get();

        if ($turnos->isEmpty()) {
            return back()->with('error', 'No hay turnos registrados para este mes.');
        }

        $ics = "BEGIN:VCALENDAR\r\n";
        $ics .= "VERSION:2.0\r\n";
        $ics .= "PRODID:-//MiApp//Turnos Enfermería//ES\r\n";
        $ics .= "CALSCALE:GREGORIAN\r\n";
        $ics .= "METHOD:PUBLISH\r\n";

        foreach ($turnos as $turno) {

            $empleado = $turno->empleado->nombre . ' ' . $turno->empleado->apellido;
            $codigo = $turno->codigo_turno;

            switch ($codigo) {
                case 'A': $start='07:00'; $end='14:00'; break;
                case 'B': $start='14:00'; $end='21:00'; break;
                case 'C': $start='21:00'; $end='07:00'; break;
                default: $start='07:00'; $end='14:00'; break;
            }

            $startDT = Carbon::parse($turno->fecha . ' ' . $start);
            $endDT   = Carbon::parse($turno->fecha . ' ' . $end);

            if ($codigo == 'C') {
                $endDT->addDay(); // turno nocturno
            }

            $ics .= "BEGIN:VEVENT\r\n";
            $ics .= "UID:" . uniqid() . "@miapp.com\r\n";
            $ics .= "DTSTAMP:" . now()->format('Ymd\THis\Z') . "\r\n";
            $ics .= "DTSTART:" . $startDT->format('Ymd\THis') . "\r\n";
            $ics .= "DTEND:" . $endDT->format('Ymd\THis') . "\r\n";
            $ics .= "SUMMARY:Turno {$codigo} - {$empleado}\r\n";
            $ics .= "DESCRIPTION:Turno de enfermería ({$codigo})\r\n";
            $ics .= "END:VEVENT\r\n";
        }

        $ics .= "END:VCALENDAR\r\n";

        $filename = "turnos-enfermeria-{$anio}-" . str_pad($mes, 2, '0', STR_PAD_LEFT) . ".ics";

        return response($ics)
            ->header('Content-Type', 'text/calendar; charset=utf-8')
            ->header('Content-Disposition', "attachment; filename={$filename}");
    }
}
