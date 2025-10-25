<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<nav class="navbar bg-body-tertiary fixed-top" >
    <div class="container-fluid">
        <a class="navbar-brand" href="{{route('/')}}">ClinicWeb</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <a href="{{route('/')}}" class="text-decoration-none text-dark"><h5 class="offcanvas-title" id="offcanvasNavbarLabel" >ClinicWeb</h5></a>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            @if(session('paciente_id'))
                <div class="alert alert-info mb-3">
                    <strong>Bienvenido: </strong> {{session('paciente_nombre')}}
                </div>
            @endif
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{route('/')}}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('pacientes.informacion_Clinica')}}">Información sobre la clínica</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Paciente
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Pedir cita</a></li>
                            @if(!session('paciente_id'))
                            <li><a class="dropdown-item" href="{{route('pacientes.registrarpaciente')}}">Registrarse como paciente</a></li>
                            @endif
                            <li><a class="dropdown-item" href="{{ route('citasprogramadas') }}">Pacientes con citas programadas </a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Contactanos</a></li>
                        </ul>
                    </li>
                </ul>
                @if(session('paciente_id'))
                    <form action="{{route('pacientes.logout')}}" method="POST" class="mt-3">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100">
                            Cerrar Sesión
                        </button>
                    </form>
                @else
                    <a href="{{route('pacientes.loginp')}}" class="btn btn-primary w-100 mt-3">
                        Iniciar Sesión
                    </a>
                @endif
                <form class="d-flex mt-3" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<div class="container">
    @yield('contenido')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
