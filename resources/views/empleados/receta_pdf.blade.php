<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receta Médica</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 40px;
            background-color: #fff;
            color: #333;
        }
        .receta-container {
            border: 2px solid #44a08d;
            border-radius: 10px;
            padding: 30px 40px;
            background-color: #fff;
            max-width: 650px;
            margin: 0 auto;
        }
        h2 {
            text-align: center;
            color: #000;
            font-size: 24px;
            margin-bottom: 25px;
            border-bottom: 1px solid #44a08d;
            padding-bottom: 10px;
        }
        .campo {
            margin-bottom: 12px;
            font-size: 15px;
            line-height: 1.5;
        }
        .label {
            font-weight: bold;
            color: #000;
            display: inline-block;
            width: 180px;
        }
        .firma {
            margin-top: 60px;
            text-align: center;
        }
        .firma p {
            margin: 3px;
            font-size: 14px;
        }
        .linea-firma {
            border-top: 1px solid #000;
            width: 60%;
            margin: 0 auto 5px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #000;
            margin-top: 40px;
        }
    </style>
</head>
<body>

<div class="receta-container">
    <h1 class="text-center text-info-emphasis">Receta Médica</h1>

    <div class="campo"><span class="label">Paciente:</span> {{ $nombre_paciente }}</div>
    <div class="campo"><span class="label">Medicamento:</span> {{ $medicamento }}</div>
    <div class="campo"><span class="label">Dosis:</span> {{ $dosis }}</div>
    <div class="campo"><span class="label">Duración del tratamiento:</span> {{ $duracion }}</div>

    @if($observaciones)
        <div class="campo"><span class="label">Observaciones:</span> {{ $observaciones }}</div>
    @endif

    <br> <br>

    <div class="firma">
        <div class="linea-firma"></div>
        @if(session('cargo') && session('cargo') == 'Doctor')
            <div class="alert alert-info mb-3">
                {{session('empleado_nombre')}}
            </div>
        @endif
        <p>Médico responsable</p>
    </div>

    <div class="footer">
        <p><em>ClínicWeb • Tel. 504 2234-5678 • contacto@clinicweb.hn</em></p>
    </div>
</div>

</body>
</html>
