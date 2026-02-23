<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            background: #ffffff;
            color: #1e2832;
            font-size: 12px;
            padding: 30px 40px;
        }

        /*ENCABEZADO con logo  */
        .header-top table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-top td {
            vertical-align: middle;
        }

        .clinic-info {
            font-size: 9.5px;
            color: #555;
            line-height: 1.7;
        }

        .clinic-info strong {
            font-size: 12px;
            color: #1e2832;
        }

        .logo {
            text-align: right;
        }

        .logo img {
            width: 120px;
            height: auto;
        }

        /* Título  */
        .doc-title {
            text-align: center;
            font-size: 17px;
            font-weight: 700;
            color: #1e2832;
            margin: 16px 0 14px 0;
            letter-spacing: 0.3px;
        }

        /*Líneas decorativas dobles*/
        .line-top  { width: 100%; border: none; border-top: 3px solid #4ecdc4; margin-bottom: 2px; }
        .line-top2 { width: 100%; border: none; border-top: 1.5px solid #44a08d; margin-bottom: 24px; }


        /* Badge estado */
        .estado-wrap { margin-bottom: 18px; }

        .estado-badge {
            display: inline-block;
            padding: 3px 14px;
            border-radius: 20px;
            font-size: 8.5px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .estado-programada   { background: #d4edda; color: #155724; }
        .estado-reprogramada { background: #fff3cd; color: #856404; }


        .section-title {
            font-size: 12.5px;
            font-weight: 700;
            color: #1e2832;
            margin-bottom: 10px;
        }


        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }

        .data-table tr td {
            padding: 5px 0;
            vertical-align: top;
        }

        .data-table .label {
            font-weight: 700;
            color: #1e2832;
            width: 130px;
            font-size: 11.5px;
        }

        .data-table .value {
            color: #2c3e50;
            font-size: 11.5px;
        }

        /*Separador entre secciones  */
        .section-divider {
            border: none;
            border-top: 1.5px solid #b2ddd9;
            margin: 18px 0;
        }

        /* Pie de página  */
        .footer-line  { border: none; border-top: 3px solid #4ecdc4; margin-top: 36px; margin-bottom: 2px; }
        .footer-line2 { border: none; border-top: 1.5px solid #44a08d; margin-bottom: 10px; }

        .footer-text {
            text-align: center;
            font-size: 8px;
            color: #7a9a96;
            line-height: 1.7;
        }
    </style>

</head>
<body>


<div class="header-top">
    <table>
        <tr>
        <tr>
            <td class="clinic-info" >
                Danlí, El Paraíso, Honduras<br>
                contacto@clinicweb.com <br>
            </td>

            <td class="logo" >
                <img src="{{ public_path('imagenes/login-icon.png') }}" alt="Logo ClinicWeb">
            </td>

        </tr>
    </table>
</div>


<div class="doc-title">Comprobante de Cita Médica</div>

{{-- Líneas decorativas--}}
<hr class="line-top">
<hr class="line-top2">

{{-- Estado--}}
<div class="estado-wrap">
    <span class="estado-badge estado-{{ strtolower($estado) }}">{{ $estado }}</span>
</div>

{{--Información del Paciente--}}
<div class="section-title">Información del Paciente</div>
<table class="data-table">
    <tr>
        <td class="label">Nombre:</td>
        <td class="value">{{ $paciente }}</td>
    </tr>
</table>

<hr class="section-divider">

{{--Información de la Cita--}}
<div class="section-title">Información de la Cita</div>
<table class="data-table">
    <tr>
        <td class="label">Médico:</td>
        <td class="value">{{ $doctor }}</td>
    </tr>
    <tr>
        <td class="label">Especialidad:</td>
        <td class="value">{{ $especialidad }}</td>
    </tr>
    <tr>
        <td class="label">Fecha:</td>
        <td class="value">{{ $fecha }}</td>
    </tr>
    <tr>
        <td class="label">Hora:</td>
        <td class="value">{{ $hora }}</td>
    </tr>
</table>

<hr class="section-divider">

{{--Indicaciones--}}
<div class="section-title">Indicaciones</div>
<table class="data-table">
    <tr>
        <td style="width:14px; vertical-align:top; padding-top:5px;">•</td>
        <td class="value">Presentarse 15 minutos antes de la cita.</td>
    </tr>
    <tr>
        <td style="width:14px; vertical-align:top; padding-top:5px;">•</td>
        <td class="value">Para cancelaciones o cambios, comunicarse con anticipación.</td>
    </tr>
</table>

{{-- Pie --}}
<hr class="footer-line">
<hr class="footer-line2">
<div class="footer-text">
    Este comprobante es válido como respaldo de su reserva médica en ClinicWeb.<br>
    Generado el {{ $fecha_gen }} a las {{ $hora_gen }}<br>
     +504 2234-5678
</div>

</body>
</html>
