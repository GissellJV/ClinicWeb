@extends('layouts.plantillaRecepcion')
        @section('contenido')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Asistencia | ClinicWeb</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:whitesmoke;
            display: flex;

        }

        .stat-card {
            border: none;
            border-radius: 15px;
            color: white;
            padding: 1.2rem;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .mint { background-color: #00bfa6; }
        .aqua { background-color: #4cd7c6; }
        .turq { background-color: #82e9de; }
        .soft { background-color: #b2f5ea; color: #004b46; }

        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .filter-tabs .nav-link {
            color: #009e8e;
            border: none;
            border-bottom: 3px solid transparent;
        }

        .filter-tabs .nav-link.active {
            border-bottom: 3px solid #00bfa6;
            font-weight: 600;
        }

        .right-menu {
            position: fixed;
            right: 1.5rem;
            top: 6rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .right-menu button {
            background: white;
            border: none;
            border-radius: 50%;
            width: 48px;
            height: 48px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            color: #009e8e;
        }

        .right-menu button:hover {
            background: #00bfa6;
            color: white;
        }

        .table thead th {
            background: #4ecdc4 ;
        }

        .table.table-hover tbody tr:hover,
        .table.table-hover tbody tr:hover td {
            background: rgb(222, 251, 249);
            color: rgba(28, 27, 27, 0.95);
        }
    </style>
</head>
<body>

<br>
<br>
<br>

<div class="container my-4">

    <!-- Estadísticas -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card mint">
                <i class="bi bi-emoji-smile fs-1"></i>
                <h5>Niños</h5>
                <h3>{{$ninos->count()}}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card aqua">
                <i class="bi bi-person-hearts fs-1"></i>
                <h5>Adolescentes</h5>
                <h3>{{$adolescentes->count()}}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card turq">
                <i class="bi bi-person-badge fs-1"></i>
                <h5>Adultos</h5>
                <h3>{{$adultos->count()}}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card soft">
                <i class="bi bi-person-wheelchair fs-1"></i>
                <h5>Tercera edad</h5>
                <h3>{{$terceraEdad->count()}}</h3>
            </div>
        </div>
    </div>

    <!-- Gráficas -->
    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="chart-container">
                <h5 class="mb-3">Visitas por Semana</h5>
                <canvas id="visitasChart"></canvas>
            </div>
        </div>
        <div class="col-md-4">
            <div class="chart-container">
                <h5 class="mb-3">Distribución por Edad</h5>
                <canvas id="edadChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Registro y filtros -->
     <div class="chart-container">
         <!--<form method="GET">
            <div class="input-group mb-3">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                <input type="text" name="buscar" class="form-control border-start-0" placeholder="Buscar paciente..." value="{{ request('buscar') }}">
            </div>
        </form>-->
         <div class="chart-container">
             <h5 class="mb-3">Registro de visitas</h5>
         </div>

        <ul class="nav nav-tabs filter-tabs mb-3">
            <li class="nav-item"><a class="nav-link {{ $filtro == 'recientes' ? 'active' : '' }}" href="?filtro=recientes">Recientes</a></li>
            <li class="nav-item"><a class="nav-link {{ $filtro == 'hoy' ? 'active' : '' }}" href="?filtro=hoy">Hoy</a></li>
            <li class="nav-item"><a class="nav-link {{ $filtro == 'semana' ? 'active' : '' }}" href="?filtro=semana">Semana</a></li>
            <li class="nav-item"><a class="nav-link {{ $filtro == 'mes' ? 'active' : '' }}" href="?filtro=mes">Mes</a></li>
            <li class="nav-item"><a class="nav-link {{ $filtro == 'anio' ? 'active' : '' }}" href="?filtro=anio">Año</a></li>
        </ul>


        <table class="table table-hover align-middle">
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Edad</th>
                <th>Doctor/Especialista</th>
                <th>Especialidad</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Estado</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($citas as $cita)
                <tr>
                    <td>{{ $cita->paciente_nombre }}</td>
                    <td>{{ $cita->paciente->edad }} años</td>
                    <td>{{ $cita->doctor_nombre }}</td>
                    <td>{{ $cita->especialidad }}</td>
                    <td>{{ $cita->fecha }}</td>
                    <td>{{ $cita->hora }}</td>
                    <td>{{ ucfirst($cita->estado) }}</td>
                </tr>
            @endforeach
            </tbody>
            {{ $pacientes->links() }}
        </table>
    </div>
</div>

<!-- Menú lateral derecho
<div class="right-menu">
    <button><i class="bi bi-bell"></i></button>
    <button><i class="bi bi-gear"></i></button>
    <button><i class="bi bi-person-circle"></i></button>
</div>-->

<script>
    // Gráfico de barras
    const ctx1 = document.getElementById('visitasChart');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: @json($labelsVisitas),
            datasets: [{
                label: 'Visitas',
                data: @json($dataVisitas),
                backgroundColor: '#00bfa6'
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });

    // Gráfico circular
    const ctx2 = document.getElementById('edadChart');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Niños', 'Adolescentes', 'Adultos', 'Tercera Edad'],
            datasets: [{
                data: [{{$ninos->count()}}, {{$adolescentes->count()}}, {{$adultos->count()}}, {{$terceraEdad->count()}}],
                backgroundColor: ['#00bfa6', '#4cd7c6', '#82e9de', '#b2f5ea']
            }]
        },
        options: { responsive: true, cutout: '70%' }
    });
</script>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection
