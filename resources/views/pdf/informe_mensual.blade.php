<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe Mensual</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .paciente {
            border: 1px solid #ddd;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 8px;
        }

        .titulo {
            font-weight: bold;
            color: #00bfa6;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .seccion {
            margin-top: 8px;
        }

        .label {
            font-weight: bold;
        }

        .ok {
            color: #27ae60;
        }

        .danger {
            color: #e74c3c;
        }

        hr {
            border: none;
            border-top: 1px solid #eee;
            margin: 10px 0;
        }
    </style>
</head>

<body>

<h2>Informe Mensual de Enfermería</h2>

<p><b>Mes:</b> {{ $mes }} | <b>Año:</b> {{ $anio }}</p>
<p><b>Total medicamentos aplicados:</b> {{ $totalMedicamentos }}</p>
<p><b>Total registros:</b> {{ $totalRegistros }}</p>

<hr>

@foreach($pacientes as $pacienteId => $items)

    @php
        $paciente = $items->first();
    @endphp

    <div class="paciente">

        <div class="titulo">
            {{ $paciente->nombres }} {{ $paciente->apellidos }}
        </div>

        {{-- HABITACIÓN --}}
        <div class="seccion">
            <span class="label">Habitación:</span>
            {{ $paciente->habitacion ?? 'Sin habitación asignada' }}
        </div>

        {{-- MEDICAMENTOS --}}
        <div class="seccion">
            <span class="label">Medicamentos aplicados:</span><br>

            @php
                $meds = $items->whereNotNull('medicamento');
            @endphp

            @if($meds->count() > 0)
                @foreach($meds as $m)
                    - {{ $m->medicamento }} ({{ $m->cantidad }}) <br>
                    <small>{{ $m->fecha_aplicacion }}</small><br>
                @endforeach
            @else
                <span class="ok">No hay medicamentos aplicados</span>
            @endif
        </div>

        {{-- INCIDENTES --}}
        <div class="seccion">
            <span class="label">Incidentes:</span><br>

            @php
                $incs = $incidentes[$pacienteId] ?? collect();
            @endphp

            @if($incs->count() > 0)
                @foreach($incs as $i)
                    - {{ $i->tipo_incidente }} ({{ $i->gravedad }}) <br>
                    {{ $i->descripcion }} <br><br>
                @endforeach
            @else
                No hay incidentes
            @endif
        </div>

    </div>

@endforeach

</body>
</html>
