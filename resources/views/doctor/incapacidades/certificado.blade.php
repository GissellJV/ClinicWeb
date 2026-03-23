<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Certificado de Incapacidad</title>
    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #2c3e50;
            background: #fff;
            padding: 16px 24px;
        }


        .header-top {
            color: #2c3e50;
        }
        .header-sub {
            padding: 1px 2px 1px 2px;
            font-size: 9px;
            color: #f9f9f9;
            margin-bottom: 8px;
        }
        .header-title-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .header-title {
            font-family: Georgia, serif;
            font-size: 17px;
            text-align: center;
            margin-top: 30px;
            font-weight: bold;

        }
        .logo img {
            width: 120px;
            height: auto;
        }
        .logo {
            text-align: right;
        }

        .header-gold {
            height: 3px;
            background: linear-gradient(90deg, #b8860b, #f5e9c8, #b8860b);
        }

        .header-banner {
            padding: 8px 12px;
            display: flex;

            justify-content: space-between;
        }

        .banner-dias {
            font-size: 22px;
            font-weight: bold;
            line-height: 1;
            color: #2c3e50;
        }

        .banner-dias-lbl {
            font-size: 8px;
            color: #7f8c8d;
            text-transform: uppercase;
        }

        .banner-emitido {
            text-align: right;
            font-size: 9px;
            color: #7f8c8d;
        }
        .banner-emitido-val{
            font-size: 11px;
            font-weight: bold;
            color: #2c3e50;;
        }


        .sec-title {
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #17a589;
            border-bottom: 1.5px solid #dee2e6;
            padding-bottom: 4px;
            margin-bottom: 10px;
            margin-top: 14px;
        }
        .sec-title:first-child {
            margin-top: 0;
        }

        .grid {
            width: 100%;
            border-collapse: collapse;
        }
        .grid td {
            padding: 3px 0 6px 0;
            vertical-align: top;
        }

        .grid td:first-child {
            width: 54%;
            padding-right: 6px;
        }

        .grid td:last-child  {
            width: 46%;
        }

        .field-lbl {
            font-size: 7.5px;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #7f8c8d;
            margin-bottom: 2px;
        }
        .field-val { font-size: 10.5px; font-weight: bold; }

        /* PERIODO */
        .periodo-box {
            background: #e8f8f5;
            border-radius: 4px;
            padding: 8px;
            text-align: center;
            width: 45.6%;
            display: inline-block;
        }
        .periodo-lbl {
            font-size: 7.5px;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #17a589;
            margin-bottom: 3px;
        }
        .periodo-val {
            font-family: Georgia, serif;
            font-size: 12px;
            font-weight: bold;
            color: #17a589;
        }

        .periodo-dia {
            font-size: 8px;
            color: #7f8c8d;
            text-transform: capitalize;
        }

        .periodo-arrow {
            display: inline-block;
            padding: 0 8px;
            font-size: 14px;
            color: #1abc9c;
            vertical-align: middle;
        }

        .motivo-box {
            background: #f9f9f9;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 8px 10px;
            font-style: italic;
            font-size: 10px;
            line-height: 1.65;
            margin-bottom: 6px;
        }

        .footer {
            background: #fafbfc;
            border-top: 1px solid #dee2e6;
            padding: 28px 24px;
            display: flex;

            align-items: center;
            text-align: center;
            margin-top: 40px;
        }

        .firma-line {
            border-top: 1.5px solid #2c3e50;
            width: 160px;
            margin: 0 auto 5px;

        }

        .firma-nombre {
            font-family: Georgia, serif;
            font-size: 10px;
            font-weight: bold;
        }

        .firma-cargo  {
            font-size: 8px;
            color: #7f8c8d;
        }

        .legal {
            text-align: center;
            font-size: 7.5px;
            color: #95a5a6;
            padding: 8px 24px 12px;
            line-height: 1.6;
        }
        /*Líneas decorativas dobles*/
        .line-top  { width: 100%;
            border: none;
            border-top: 3px solid #4ecdc4;
            margin-bottom: 2px;
        }
        .line-top2 {
            width: 100%;
            border: none;
            border-top: 1.5px solid #44a08d;
            margin-bottom: 24px;
        }

    </style>
</head>
<body>

<div class="header-top">
    <div class="header-sub">

    </div>
    <div class="header-title-row">
        <div class="logo">
            <img src="{{ public_path('imagenes/login-icon.png') }}" alt="Logo ClinicWeb">
        </div>
        <div class="header-title text-info-emphasis"> Certificado de Incapacidad Médica</div>
        <br>
        {{-- Líneas decorativas--}}
        <hr class="line-top">
        <hr class="line-top2">
    </div>
</div>



<div class="header-gold"></div>
<div class="header-banner">
    <div>
        <div class="banner-dias">{{ $inc->cantidad_dias }}</div>
        <div class="banner-dias-lbl">dias de reposo</div>
    </div>
    <div class="banner-emitido">
        <div>Emitido el</div>
        <div class="banner-emitido-val">
             {{ $inc->created_at->isoFormat('D MMM YYYY') }}
        </div>
    </div>
</div>

<div class="body">

    <div class="sec-title">Datos del Paciente</div>
    <table class="grid">
        <tr>
            <td>
                <div class="field-lbl">Nombre completo</div>
                <div class="field-val">{{ $inc->paciente->nombres }} {{ $inc->paciente->apellidos }}</div>
            </td>
            <td>
                <div class="field-lbl">Numero de identidad</div>
                <div class="field-val">{{ $inc->paciente->numero_identidad ?? 'N/A' }}</div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="field-lbl">Fecha de nacimiento</div>
                <div class="field-val">
                    {{ $inc->paciente->fecha_nacimiento
                        ? \Carbon\Carbon::parse($inc->paciente->fecha_nacimiento)->isoFormat('D MMM YYYY')
                        : 'N/A' }}
                </div>
            </td>
            <td>
                <div class="field-lbl">Genero</div>
                <div class="field-val">{{ $inc->paciente->genero ?? 'N/A' }}</div>
            </td>
        </tr>
    </table>

    <div class="sec-title">Periodo de Incapacidad</div>
    <div style="margin-bottom:10px; margin-top: 20px">
        <div class="periodo-box">
            <div class="periodo-lbl">Fecha de Inicio</div>
            <div class="periodo-val">{{ $inc->fecha_inicio->isoFormat('D MMM YYYY') }}</div>
            <div class="periodo-dia">{{ $inc->fecha_inicio->locale('es')->isoFormat('dddd') }}</div>
        </div>
        <span class="periodo-arrow">&#8594;</span>
        <div class="periodo-box">
            <div class="periodo-lbl">Fecha de Fin</div>
            <div class="periodo-val">{{ $inc->fecha_fin->isoFormat('D MMM YYYY') }}</div>
            <div class="periodo-dia">{{ $inc->fecha_fin->locale('es')->isoFormat('dddd') }}</div>
        </div>
    </div>

    <div class="sec-title">Motivo de la Incapacidad</div>
    <div class="motivo-box">{{ $inc->motivo }}</div>

    <div class="sec-title">Medico Tratante</div>
    <table class="grid">
        <tr>
            <td>
                <div class="field-lbl">Doctor</div>
                <div class="field-val">
                    {{ $inc->empleado->genero === 'F' ? 'Dra.' : 'Dr.' }}
                    {{ $inc->empleado->nombre }} {{ $inc->empleado->apellido }}
                </div>
            </td>
            <td>
                <div class="field-lbl">Especialidad</div>
                <div class="field-val">{{ $inc->empleado->departamento}}</div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="field-lbl">Departamento</div>
                <div class="field-val">{{ $inc->empleado->departamento }}</div>
            </td>
            <td>
                <div class="field-lbl">Teléfono</div>
                <div class="field-val">{{  $inc->empleado->loginEmpleado->telefono?? 'N/A' }}</div>
            </td>
        </tr>
    </table>

</div>

<div class="footer">
    <br>
    <div class="firma-line"></div>
    <div class="firma-nombre">
        {{ $inc->empleado->genero === 'F' ? 'Dra.' : 'Dr.' }}
        {{ $inc->empleado->nombre }} {{ $inc->empleado->apellido }}
    </div>
    <div class="firma-cargo">{{ $inc->empleado->departamento }}</div>
</div>

<div class="legal">
    Documento oficial emitido por ClinicWeb.<br>
    Su falsificación o alteración constituye un delito.<br>
    <br>
</div>

</body>
</html>
