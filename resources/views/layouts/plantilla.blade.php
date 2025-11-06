<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg fixed-top shadow-sm" style="background-color: #4ecdc4;">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand fw-bold text-white d-flex align-items-center" href="{{ route('/') }}">
            <i class="bi bi-hospital me-2"></i> ClinicWeb
        </a>

        <!-- Botón para dispositivos móviles -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarClinic"
                aria-controls="navbarClinic" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Opciones de navegación -->
        <div class="collapse navbar-collapse" id="navbarClinic">
            <ul class="navbar-nav ms-auto align-items-center">

                <li class="nav-item">
                    <a class="nav-link text-white fw-semibold" href="{{ route('/') }}">Inicio</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white fw-semibold" href="{{ route('pacientes.informacion_Clinica') }}">Información</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white fw-semibold" href="{{ route('comentarios.index') }}">Comentarios</a>
                </li>

                @if(!session('paciente_id'))
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="{{ route('pacientes.visualizacion_Doctores') }}">Doctores</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" id="loginDropdown"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Acceder
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('pacientes.loginp') }}"><i class="bi bi-person"></i> Paciente</a></li>
                            <li><a class="dropdown-item" href="{{ route('empleados.loginempleado') }}"><i class="bi bi-person-badge"></i> Empleado</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="btn btn-light ms-2 fw-semibold" href="{{ route('pacientes.registrarpaciente') }}">
                            <i class="bi bi-pencil-square me-1"></i> Registrarse
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-semibold text-white d-flex align-items-center" href="#" id="userDropdown"
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


<div class="container">
    @yield('contenido')
    <style>

        body {
            padding-top: 70px;
        }

        /* Hover de enlaces */
        .navbar-nav .nav-link:hover {
            color: #f1f1f1 !important;
            text-decoration: underline;
        }

        /* Botón de registro */
        .btn-light {
            color: #4ecdc4;
            background-color: #fff;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-light:hover {
            background-color: #3cb7ad;
            color: #fff;
        }

        /* Dropdown menú*/
        .dropdown-menu {
            border-radius: 0.75rem;
            border: none;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        /* Íconos dentro del menú */
        .dropdown-item i {
            color: #4ecdc4;
            margin-right: 6px;
        }


    </style>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
