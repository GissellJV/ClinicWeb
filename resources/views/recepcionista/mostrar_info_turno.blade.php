<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalles del Turno</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f7fdfc;
            font-family: 'Segoe UI', sans-serif;
        }

        .header-title {
            color: #00bfa6;
            font-weight: 800;
            border-left: 6px solid #00bfa6;
            padding-left: 12px;
        }

        .card-custom {
            background: white;
            border-radius: 18px;
            padding: 2rem;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
            border: none;
        }

        .detail-label {
            color: #009e8e;
            font-weight: 600;
        }

        .detail-value {
            color: #004b46;
            font-size: 1.05rem;
        }

        .btn-mint {
            background-color: #00bfa6 !important;
            border-color: #00bfa6 !important;
            color: white !important;
            padding: 0.55rem 1.3rem;
            border-radius: 10px;
            font-weight: 600;
        }

        .btn-mint:hover {
            background-color: #009e8e !important;
            border-color: #009e8e !important;
            color: #fff !important;
        }

    </style>
</head>
<body>

<div class="container mt-5">

    <!-- Título -->
    <h2 class="header-title mb-4">
        <i class="bi bi-calendar-week"></i> Detalles completos del turno #{{ $turno->id }}
    </h2>

    <!-- Tarjeta principal -->
    <div class="card-custom">

        <div class="row mb-3">
            <div class="col-md-6">
                <span class="detail-label">Empleado:</span>
                <p class="detail-value">
                    {{ $turno->empleado->nombre }} {{ $turno->empleado->apellido }}
                </p>
            </div>

            <div class="col-md-6">
                <span class="detail-label">Departamento:</span>
                <p class="detail-value">
                    {{ $turno->departamento->nombre }}
                </p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <span class="detail-label">Fecha:</span>
                <p class="detail-value">
                    {{ \Carbon\Carbon::parse($turno->fecha)->format('d/m/Y') }}
                </p>
            </div>

            <div class="col-md-4">
                <span class="detail-label">Hora:</span>
                <p class="detail-value">{{ $turno->hora_turno }}</p>
            </div>

            <div class="col-md-4">
                <span class="detail-label">Estado:</span>
                <p class="detail-value">{{ $turno->estado }}</p>
            </div>
        </div>

        <!-- Botón regresar -->
        <a href="{{ route('recepcionista.index') }}" class="btn btn-mint mt-3">
            <i class="bi bi-arrow-left"></i> Volver
        </a>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>

