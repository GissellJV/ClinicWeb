<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        .navbar-toggler {
            background-color: white;
            color: white;
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

        .btn-close-offcanvas i {
            font-size: 1.25rem;
            line-height: 1;
        }


        .nav-link {
            color: #4ecdc4 !important;
            transition: color 0.3s ease;
        }
        .nav-link:hover{
            color: #34b5ad !important;
            text-decoration: underline;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        /* Color principal */
        .text-custom {
            color: #4ecdc4 !important;
            transition: color 0.3s ease;
        }

        .text-custom:hover {
            color: #34b5ad !important;
            text-decoration: underline;
        }
        .dropdown-menu {
            border-radius: 0.75rem;
            border: none;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
<nav class="navbar bg-body-tertiary fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('/') }}" style="color: #4ecdc4;">
            <img src="/imagenes/login-icon.png" alt="login-icono">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <a href="{{route('/')}}" class="text-decoration-none text-dark"><h5 class="offcanvas-title" id="offcanvasNavbarLabel" >ClinicWeb</h5></a>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            @if(session('cargo') && session('cargo') == 'Enfermero')
                <div class="alert alert-info mb-3">
                    <strong>Bienvenido: </strong> {{session('empleado_nombre')}}
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
                            Enfermeria
                        </a>
                        <!--LA CONDICION DE ENFERMERIA-->
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"></a></li>
                            <li><a class="dropdown-item" href="#"></a></li>

                        </ul>
                    </li>
                </ul>

                @if(session('empleado_id'))
                    <form action="{{route('empleados.logout')}}" method="POST" class="mt-3">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100">
                            Cerrar Sesión
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

<div class="container">
    @yield('contenido')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>

