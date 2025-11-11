<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f7fdfc;
            font-family: 'Segoe UI', sans-serif;
        }

        .stat-card {
            border: none;
            border-radius: 15px;
            color: white;
            padding: 1.2rem;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .mint { background-color: #00bfa6 !important; }
        .aqua { background-color: #4cd7c6 !important; }
        .turq { background-color: #82e9de !important; color: #004b46 !important; }
        .soft { background-color: #b2f5ea !important; color: #004b46 !important; }

        .card-custom {
            border-radius: 18px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.1);
            border: none;
        }

        .btn-primary {
            background-color: #00bfa6 !important;
            border-color: #00bfa6 !important;
        }

        .btn-primary:hover {
            background-color: #009e8e !important;
            border-color: #009e8e !important;
        }

        .btn-outline-primary {
            color: #00bfa6 !important;
            border-color: #00bfa6 !important;
        }

        .btn-outline-primary:hover {
            background-color: #00bfa6 !important;
            color: white !important;
        }

        .btn-outline-info {
            color: #4cd7c6 !important;
            border-color: #4cd7c6 !important;
        }

        .btn-outline-info:hover {
            background-color: #4cd7c6 !important;
            color: white !important;
        }

        .btn-outline-danger {
            color: #e74c3c !important;
            border-color: #e74c3c !important;
        }

        .btn-outline-danger:hover {
            background-color: #e74c3c !important;
            color: white !important;
        }

        table thead {
            background: #b2f5ea !important;
            color: #004b46 !important;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2>Detalles completos del turno #{{ $turno->id }}</h2>

        <div class="card mt-3 p-4">
            <p><strong>Empleado:</strong> {{ $turno->empleado->nombre }} {{ $turno->empleado->apellido }}</p>
            <p><strong>Departamento:</strong> {{ $turno->departamento->nombre }}</p>
            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($turno->fecha)->format('d/m/Y') }}</p>
            <p><strong>Hora:</strong> {{ $turno->hora_turno }}</p>
            <p><strong>Estado:</strong> {{ $turno->estado }}</p>

            <a href="{{ route('recepcionista.index') }}" class="btn btn-secondary mt-3">Volver</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
