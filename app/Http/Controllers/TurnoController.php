<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Empleado;
use App\Models\RolTurnoDoctor;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class TurnoController extends Controller
{
    public function verTurnos(Request $request)
    {
        if (!session('cargo') || session('cargo') != 'Doctor') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Doctor');
        }

        $mes = $request->mes ?? now()->month;
        $anio = $request->anio ?? now()->year;

        $fecha = Carbon::create($anio, $mes, 1);

        $prevMes = $fecha->copy()->subMonth()->month;
        $prevAnio = $fecha->copy()->subMonth()->year;

        $nextMes = $fecha->copy()->addMonth()->month;
        $nextAnio = $fecha->copy()->addMonth()->year;

        $nombreMes = $fecha->translatedFormat('F');
        $diasEnMes = $fecha->daysInMonth;

        // DOCTORES
        $doctores = Empleado::where('cargo', 'doctor')->paginate(10);

        // TURNOS
        $turnos = RolTurnoDoctor::whereMonth('fecha', $mes)
            ->whereYear('fecha', $anio)
            ->get();

        // GRID
        $grid = [];
        foreach ($turnos as $turno) {
            $dia = Carbon::parse($turno->fecha)->day;
            $grid[$turno->empleado_id][$dia] = $turno;
        }

        // DEPARTAMENTOS
        $departamentos = Empleado::select('departamento')
            ->distinct()
            ->pluck('departamento');

        // GENERAR DIAS DEL MES
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
        return view('doctor.Turnos_Mensuales', compact(
            'mes',
            'anio',
            'prevMes',
            'prevAnio',
            'nextMes',
            'nextAnio',
            'nombreMes',
            'diasEnMes',
            'doctores',
            'grid',
            'departamentos',
            'dias',
            'turnosCodigos'
        ));
    }

    public function index(Request $request)
    {

        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        $query = Cita::with(['doctor', 'paciente']);
        $mes = (int)($request->get('mes', now()->month));
        $anio = (int)($request->get('anio', now()->year));

        // Filtrar por doctor
        if ($request->filled('doctor')) {
            $query->where('doctor_nombre', 'like', '%' . $request->doctor . '%');
        }
        $inicioMes = Carbon::create($anio, $mes, 1)->startOfMonth();
        $finMes = (clone $inicioMes)->endOfMonth();
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
        $departamentos = Empleado::where('cargo', 'Doctor')
            ->whereNotNull('departamento')
            ->distinct()
            ->orderBy('departamento')
            ->pluck('departamento');

        // días del mes (para el header)
        $dias = [];
        for ($d = 1; $d <= $diasEnMes; $d++) {
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
            for ($d = 1; $d <= $diasEnMes; $d++) $grid[$doc->id][$d] = null;

            foreach (($turnosMes[$doc->id] ?? collect()) as $t) {
                $diaNum = Carbon::parse($t->fecha)->day;
                $grid[$doc->id][$diaNum] = $t;
            }
        }

        // navegación mes
        $prev = (clone $inicioMes)->subMonth();
        $next = (clone $inicioMes)->addMonth();
        $prevMes = $prev->month;
        $prevAnio = $prev->year;
        $nextMes = $next->month;
        $nextAnio = $next->year;

        $nombreMes = strtoupper($inicioMes->locale('es')->monthName);

        // códigos
        $turnosCodigos = [
            'A' => ['nombre' => 'Turno A', 'inicio' => '7:00 AM', 'fin' => '1:00 PM', 'color' => '#2ecc71'],
            'B' => ['nombre' => 'Turno B', 'inicio' => '1:00 PM', 'fin' => '7:00 PM', 'color' => '#3498db'],
            'C' => ['nombre' => 'Turno C', 'inicio' => '7:00 PM', 'fin' => '7:00 AM', 'color' => '#9b59b6'],
            'BC' => ['nombre' => 'BC', 'inicio' => null, 'fin' => null, 'color' => '#1abc9c'],
            'ABC' => ['nombre' => 'ABC', 'inicio' => null, 'fin' => null, 'color' => '#e67e22'],
            'L' => ['nombre' => 'Libre', 'inicio' => null, 'fin' => null, 'color' => '#95a5a6'],
            'LLAMADO' => ['nombre' => 'Al llamado', 'inicio' => null, 'fin' => null, 'color' => '#e74c3c'],
        ];

        return view('recepcionista.turnos', compact(
            'mes', 'anio', 'nombreMes',
            'prevMes', 'prevAnio', 'nextMes', 'nextAnio',
            'diasEnMes', 'dias',
            'doctores', 'departamentos',
            'grid', 'turnosCodigos'
        ));
    }


    public function store(Request $request)
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }
        $data = $request->validate([
            'empleado_id' => ['required', 'integer'],
            'fecha' => ['required', 'date'],
            'codigo_turno' => ['required', 'in:A,B,C,BC,ABC,L,LLAMADO'],
            'nota' => ['nullable', 'string', 'max:255'],
        ]);

        RolTurnoDoctor::updateOrCreate(
            [
                'empleado_id' => $data['empleado_id'],
                'fecha' => Carbon::parse($data['fecha'])->format('Y-m-d'),
            ],
            [
                'codigo_turno' => $data['codigo_turno'],
                'nota' => $data['nota'] ?? null,
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

    public function exportPdf(Request $request)
    {
        // Permitir Recepcionista y Doctor
        if (!session('cargo') || !in_array(session('cargo'), ['Recepcionista', 'Doctor'])) {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista o Doctor');
        }

        $mes = (int)($request->get('mes', now()->month));
        $anio = (int)($request->get('anio', now()->year));

        $inicioMes = Carbon::create($anio, $mes, 1)->startOfMonth();
        $finMes = (clone $inicioMes)->endOfMonth();
        $diasEnMes = $inicioMes->daysInMonth;

        // Query de doctores
        $doctoresQuery = Empleado::query()->where('cargo', 'Doctor');

        // Si es Doctor, solo traer su propio registro
        if (session('cargo') == 'Doctor') {
            $doctoresQuery->where('id', session('empleado_id'));
        } else {
            // Filtrar por nombre si es Recepcionista
            if ($request->filled('nombre')) {
                $nombre = $request->nombre;
                $doctoresQuery->where(function ($q) use ($nombre) {
                    $q->where('nombre', 'like', "%$nombre%")
                        ->orWhere('apellido', 'like', "%$nombre%");
                });
            }

            // Filtrar por departamento si es Recepcionista
            if ($request->filled('departamento')) {
                $doctoresQuery->where('departamento', $request->departamento);
            }
        }

        $doctores = $doctoresQuery->orderBy('apellido')->orderBy('nombre')->get();

        // Generar los días del mes
        $dias = [];
        for ($d = 1; $d <= $diasEnMes; $d++) {
            $fecha = Carbon::create($anio, $mes, $d);
            $dias[] = [
                'dia' => $d,
                'fecha' => $fecha->format('Y-m-d'),
                'diaSemana' => mb_strtoupper($fecha->locale('es')->isoFormat('dd'), 'UTF-8'),
                'esFinDeSemana' => $fecha->isWeekend(),
            ];
        }

        // Turnos del mes agrupados por doctor
        $turnosMes = RolTurnoDoctor::whereBetween('fecha', [$inicioMes->toDateString(), $finMes->toDateString()])
            ->get()
            ->groupBy(fn($t) => $t->empleado_id);

        // Grid
        $grid = [];
        foreach ($doctores as $doc) {
            for ($d = 1; $d <= $diasEnMes; $d++) $grid[$doc->id][$d] = null;

            foreach (($turnosMes[$doc->id] ?? collect()) as $t) {
                $diaNum = Carbon::parse($t->fecha)->day;
                $grid[$doc->id][$diaNum] = $t;
            }
        }

        // Validar que haya al menos un turno
        if ($turnosMes->isEmpty()) {
            return back()->with('error', 'No hay turnos registrados para el mes seleccionado.');
        }

        $nombreMes = strtoupper($inicioMes->locale('es')->monthName);

        $turnosCodigos = [
            'A' => ['nombre' => 'Turno A', 'inicio' => '7:00 AM', 'fin' => '1:00 PM'],
            'B' => ['nombre' => 'Turno B', 'inicio' => '1:00 PM', 'fin' => '7:00 PM'],
            'C' => ['nombre' => 'Turno C', 'inicio' => '7:00 PM', 'fin' => '7:00 AM'],
            'BC' => ['nombre' => 'BC'],
            'ABC' => ['nombre' => 'ABC'],
            'L' => ['nombre' => 'Libre'],
            'LLAMADO' => ['nombre' => 'Al llamado'],
        ];

        $pdf = Pdf::loadView('pdf.turnos-mensual', compact(
            'mes', 'anio', 'nombreMes', 'diasEnMes', 'dias', 'doctores', 'grid', 'turnosCodigos'
        ))->setPaper('a4', 'landscape');

        $filename = "rol-turnos-doctores-{$anio}-" . str_pad((string)$mes, 2, '0', STR_PAD_LEFT) . ".pdf";
        return $pdf->download($filename);

    }
    //Funcion para descargar el archivo y abrirlo desde el calendario para que se guarde
    public function exportarMesCalendario(Request $request)
    {
        // Validar que sea Doctor
        if (!session('cargo') || session('cargo') != 'Doctor') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Doctor');
        }

        $mes = $request->get('mes', now()->month);
        $anio = $request->get('anio', now()->year);

        // Traer solo los turnos del doctor logueado
        $turnos = RolTurnoDoctor::with('empleado')
            ->where('empleado_id', session('empleado_id'))
            ->whereMonth('fecha', $mes)
            ->whereYear('fecha', $anio)
            ->get();

        if ($turnos->isEmpty()) {
            return back()->with('error', 'No hay turnos registrados para este mes.');
        }

        $ics = "BEGIN:VCALENDAR\r\n";
        $ics .= "VERSION:2.0\r\n";
        $ics .= "PRODID:-//MiApp//Turnos Doctor//ES\r\n";
        $ics .= "CALSCALE:GREGORIAN\r\n";
        $ics .= "METHOD:PUBLISH\r\n";

        foreach ($turnos as $turno) {
            $empleado = $turno->empleado->nombre . ' ' . $turno->empleado->apellido;
            $codigo = $turno->codigo_turno;

            // Definir horarios según código
            switch ($codigo) {
                case 'A': $start='07:00'; $end='14:00'; break;
                case 'B': $start='14:00'; $end='21:00'; break;
                case 'C': $start='21:00'; $end='07:00'; break;
                default: $start='07:00'; $end='14:00'; break;
            }

            $startDT = Carbon::parse($turno->fecha . ' ' . $start);
            $endDT   = Carbon::parse($turno->fecha . ' ' . $end);
            if ($codigo == 'C') $endDT->addDay(); // turno nocturno

            $ics .= "BEGIN:VEVENT\r\n";
            $ics .= "UID:" . uniqid() . "@miapp.com\r\n";
            $ics .= "DTSTAMP:" . now()->format('Ymd\THis\Z') . "\r\n";
            $ics .= "DTSTART:" . $startDT->format('Ymd\THis') . "\r\n";
            $ics .= "DTEND:" . $endDT->format('Ymd\THis') . "\r\n";
            $ics .= "SUMMARY:Turno {$codigo} - {$empleado}\r\n";
            $ics .= "DESCRIPTION:Turno asignado ({$codigo})\r\n";
            $ics .= "END:VEVENT\r\n";
        }

        $ics .= "END:VCALENDAR\r\n";

        $filename = "turnos-{$anio}-" . str_pad($mes, 2, '0', STR_PAD_LEFT) . ".ics";

        return response($ics)
            ->header('Content-Type', 'text/calendar; charset=utf-8')
            ->header('Content-Disposition', "attachment; filename={$filename}");
    }
}
