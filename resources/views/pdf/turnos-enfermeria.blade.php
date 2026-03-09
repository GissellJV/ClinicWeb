<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Rol mensual — Enfermería</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 9px; }

        h2 { margin: 0; }

        .muted { color: #666; }
        .code { font-weight: bold; }
        .nota { font-size: 8px; color: #444; display: block; margin-top: 1px; }

        /* ===== TABLA GRANDE ===== */

        table.calendar{
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        table.calendar th, table.calendar td{
            border: 1px solid #333;
            padding: 3px;
            text-align: center;
            vertical-align: middle;
        }

        /* Color principal verde menta */

        table.calendar thead th{
            background: #2ec4b6 !important;
            color: #fff !important;
            font-weight: bold;
        }

        table.calendar thead th.doc-head{
            background: #2ec4b6 !important;
            color: #fff !important;
            text-align: left !important;
        }

        /* días entre semana */

        table.calendar thead th.weekday-head{
            background: #e9f8f6 !important;
            color: #000 !important;
        }

        /* fines de semana */

        table.calendar thead th.weekend-head{
            background: #c7efea !important;
            color: #000 !important;
        }

        table.calendar td.doc-cell{
            text-align: left !important;
            width: 180px;
        }

        table.calendar td.weekend-cell{
            background: #c7efea !important;
        }

        /* ===== CUADROS INFERIORES ===== */

        .bottom-wrap{
            margin-top: 14px;
            width: 100%;
            position: relative;
            page-break-inside: avoid;
        }

        .box{
            width: 260px;
            margin-top: 10px;
        }

        .box-title{
            background: #2ec4b6;
            color: #fff;
            font-weight: bold;
            padding: 6px 8px;
            font-size: 11px;
        }

        table.mini{
            width: 100%;
            border-collapse: collapse;
        }

        table.mini td{
            border: 1px solid #333;
            padding: 7px 10px;
            font-size: 10px;
            text-align: left;
            line-height: 1.3;
        }

        .mini-subtitle{
            background: #2ec4b6;
            color: #fff;
            font-weight: bold;
            text-align: center !important;
            padding: 8px 10px;
        }

    </style>
</head>
<body>
<h2 style="margin:0;">Clínic Web — Rol de turnos Enfermería ({{ $nombreMes }} {{ $anio }})</h2>
<div style="color:#666; font-size: 8px;">Generado: {{ now()->format('Y-m-d H:i') }}</div>

<table class="calendar">
    <thead>
    <tr>
        <th class="doc-head">Enfermero/a</th>

        @foreach($dias as $dia)
            <th class="{{ $dia['esFinDeSemana'] ? 'weekend-head' : 'weekday-head' }}">
                {{ $dia['diaSemana'] }}<br>{{ $dia['dia'] }}
            </th>
        @endforeach
    </tr>
    </thead>

    <tbody>
    @foreach($enfermeros as $enf)
        <tr>

            <td class="doc-cell">
                {{ $enf->genero === 'Femenino' ? 'Licda.' : 'Lic.' }} {{ $enf->nombre }} {{ $enf->apellido }}
                <br>
                <span class="muted">{{ $enf->departamento ?? 'General' }}</span>
            </td>

            @foreach($dias as $dia)
                @php
                    $t = $grid[$enf->id][$dia['dia']] ?? null;
                @endphp

                <td class="{{ $dia['esFinDeSemana'] ? 'weekend-cell' : '' }}">
                    @if($t)
                        <span class="code">{{ $t->codigo_turno }}</span>
                        @if(!empty($t->nota))
                            <span class="nota">{{ $t->nota }}</span>
                        @endif
                    @else
                        —
                    @endif
                </td>
            @endforeach

        </tr>
    @endforeach
    </tbody>
</table>

<!-- Cuadros inferiores -->
<div class="bottom-wrap">
    <!-- Cuadro 1: Horario de los turnos -->
    <div class="box">
        <div class="box-title">Horario de los turnos</div>
        <table class="mini">
            <tr>
                <td><strong>A</strong> = 7 am - 1 pm</td>
            </tr>
            <tr>
                <td><strong>B</strong> = 1 pm - 7 pm</td>
            </tr>
            <tr>
                <td><strong>C</strong> = 7 pm - 7 am <span class="muted">(al llamado)</span></td>
            </tr>
        </table>
    </div>

    <!-- Cuadro 2: Horario fines de semana -->
    <div class="box">
        <div class="box-title">Horario fines de semana</div>
        <table class="mini">
            <tr>
                <td><strong>Sa</strong> = 7 am - 2 pm</td>
            </tr>
            <br>
            <tr>
                <td class="mini-subtitle">Al llamado</td>
            </tr>
            <tr>
                <td><strong>Sa</strong> = 2 pm - 7 am</td>
            </tr>
            <tr>
                <td><strong>Do</strong> = 24 hrs</td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
