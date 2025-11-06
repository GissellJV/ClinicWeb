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
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top shadow-sm bg-white">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('/') }}" style="color: #4ecdc4;">
            <i class="bi bi-hospital me-2"></i> ClinicWeb
        </a>

        <!-- Botón para móviles -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarClinic"
                aria-controls="navbarClinic" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Opciones -->
        <div class="collapse navbar-collapse" id="navbarClinic">
            <ul class="navbar-nav ms-auto align-items-center">

                <li class="nav-item">
                    <a class="nav-link fw-semibold text-custom" href="{{ route('/') }}">Inicio</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link fw-semibold text-custom" href="{{ route('pacientes.informacion_Clinica') }}">Información</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link fw-semibold text-custom" href="{{ route('comentarios.index') }}">Comentarios</a>
                </li>

                @if(!session('paciente_id'))
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-custom" href="{{ route('pacientes.visualizacion_Doctores') }}">Doctores</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-semibold text-custom" href="#" id="loginDropdown"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Acceder
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('pacientes.loginp') }}"><i class="bi bi-person"></i> Paciente</a></li>
                            <li><a class="dropdown-item" href="{{ route('empleados.loginempleado') }}"><i class="bi bi-person-badge"></i> Empleado</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="btn btn-custom ms-2 fw-semibold" href="{{ route('pacientes.registrarpaciente') }}">
                            <i class="bi bi-pencil-square me-1"></i> Registrarse
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-semibold text-custom d-flex align-items-center" href="#" id="userDropdown"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i> {{ session('paciente_nombre') }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('agendarcitas') }}"><i class="bi bi-calendar-plus"></i> Agendar cita</a></li>
                            <li><a class="dropdown-item" href="{{ route('citas.mis-citas') }}"><i class="bi bi-calendar-check"></i> Mis citas</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('pacientes.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger fw-semibold">
                                        <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

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
                <h3>58</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card aqua">
                <i class="bi bi-person-hearts fs-1"></i>
                <h5>Adolescentes</h5>
                <h3>74</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card turq">
                <i class="bi bi-person-badge fs-1"></i>
                <h5>Adultos</h5>
                <h3>120</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card soft">
                <i class="bi bi-person-wheelchair fs-1"></i>
                <h5>Tercera edad</h5>
                <h3>32</h3>
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
        <div class="input-group mb-3">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
            <input type="text" class="form-control border-start-0" placeholder="Buscar paciente...">
        </div>

        <ul class="nav nav-tabs filter-tabs mb-3">
            <li class="nav-item"><a class="nav-link active" href="#">Recientes</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Hoy</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Semana</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Mes</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Año</a></li>
        </ul>

        <table class="table table-hover align-middle">
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Edad</th>
                <th>Motivo</th>
                <th>Hora</th>
            </tr>
            </thead>
            <tbody>
            <tr><td>Juan Pérez</td><td>10</td><td>Consulta general</td><td>08:45</td></tr>
            <tr><td>María López</td><td>28</td><td>Chequeo anual</td><td>09:20</td></tr>
            <tr><td>José Martínez</td><td>65</td><td>Control de presión</td><td>10:05</td></tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Menú lateral derecho -->
<div class="right-menu">
    <button><i class="bi bi-bell"></i></button>
    <button><i class="bi bi-gear"></i></button>
    <button><i class="bi bi-person-circle"></i></button>
</div>

<script>
    // Gráfico de barras
    const ctx1 = document.getElementById('visitasChart');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
            datasets: [{
                label: 'Visitas',
                data: [45, 60, 50, 80, 75, 30, 20],
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
                data: [58, 74, 120, 32],
                backgroundColor: ['#00bfa6', '#4cd7c6', '#82e9de', '#b2f5ea']
            }]
        },
        options: { responsive: true, cutout: '70%' }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
