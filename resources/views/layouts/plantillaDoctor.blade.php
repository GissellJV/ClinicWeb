<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .navbar-toggler {
            background-color: white;
            border: 2px solid #4ecdc4;
            border-radius: 8px;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
            margin-right: 20px;
        }
        .navbar-toggler:hover {
            background-color: #34b5ad;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            transform: translateY(-2px);
        }
        .navbar-brand img {
            height: 3rem;
            width: auto;
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml;charset=UTF8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='%2334b5ad' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
        }
        .navbar-toggler:hover .navbar-toggler-icon {
            background-image: url("data:image/svg+xml;charset=UTF8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='%23000000' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
        }
        .nav-link {
            color: #4ecdc4 !important;
            transition: color 0.3s ease;
        }
        .nav-link:hover, .nav-link.active {
            color: #34b5ad !important;
            text-decoration: underline;
            font-weight: 600;
        }

    </style>
</head>
<body>
<nav class="navbar  fixed-top shadow-sm bg-white">
    <div class="container-fluid d-flex align-items-center">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('/') }}" style="color: #4ecdc4;">
            <img src="/imagenes/login-icon.png" alt="login-icono">
        </a>

        <!-- Enlaces principales alineados a la derecha -->
        <ul class="navbar-nav flex-row ms-auto me-3 gap-3">
            <li class="nav-item">
                <a class="nav-link fw-semibold text-custom {{ request()->routeIs('/') ? 'active' : '' }}" href="{{ route('/') }}">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-semibold text-custom {{ request()->routeIs('pacientes.informacion_Clinica') ? 'active' : '' }}"
                   href="{{ route('pacientes.informacion_Clinica') }}">Información sobre la clínica</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link  fw-semibold text-custom d-flex align-items-center" href="#" id="userDropdown"
                   role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle me-1"></i> {{ session('empleado_nombre') ?? 'Empleado' }}
                </a>

            </li>
        </ul>


        <!-- Botón del menú lateral -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
             aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">

                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>


            </div>
            @if(session('cargo') && session('cargo') == 'Doctor')
                <div class="alert alert-info mb-3">
                    <strong>Bienvenido Dr: </strong> {{session('empleado_nombre')}}
                </div>
            @endif
            <div class="offcanvas-body">
                <ul class="navbar-nav flex-grow-1 pe-3">
                            <!--LA CONDICION DE DOCTOR-->
                            <li><a class="nav-link {{ request()->routeIs('doctor.citas') ? 'active' : '' }}" href="{{route('doctor.citas')}}">Citas programadas</a></li>
                            <li><a class="nav-link {{ request()->routeIs('recetamedica') ? 'active' : '' }}" href="{{route('recetamedica')}}">Generar Receta</a></li>
                            <li><a class="nav-link {{ request()->routeIs('doctor.habitaciones.index') ? 'active' : '' }}" href="{{ route('doctor.habitaciones.index') }}">Buscar Habitación</a></li>
                            <li><a class="nav-link {{ request()->routeIs('doctor.habitaciones.mis-pacientes') ? 'active' : '' }}" href="{{ route('doctor.habitaciones.mis-pacientes') }}">Pacientes Hospitalizados</a></li>
                            <li><a class="nav-link {{ request()->routeIs('doctor.expedientesRecibidos') ? 'active' : '' }}" href="{{ route('doctor.expedientesRecibidos') }}">Expedientes Recibidos</a></li>

                        </ul>


                @if(session('empleado_id'))
                    <form action="{{route('empleados.logout')}}" method="POST" class="mt-3">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100">
                            Cerrar
                        </button>
                    </form>
                @endif

                <form class="d-flex mt-3" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-10 pt-10">
    <div class="row justify-content-center">

    @yield('contenido')

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

