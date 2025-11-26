<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enfermería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding-top: 60px;
            background-color: #f5f7fa;
        }

        /* NAVBAR MODERNO */
        .navbar-modern {
            background: linear-gradient(90deg, #00bfa6, #009e8e);
            padding: 0.75rem 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            overflow: visible !important;
        }
        .nav-link-glow {
            color: #e7fffc !important;
            font-weight: 500;
            transition: 0.25s ease;
        }
        .nav-link-modern {
            color: #e7fffc !important;
            font-weight: 500;
            transition: 0.25s ease;
        }
        .nav-link-glow:hover, .nav-link-glow.active {
            color: #ffffff !important;
            text-shadow: 0 0 10px #00ffe0, 0 0 20px #00d3b8;
        }

        /* Dropdown moderno */
        .dropdown-menu-modern {
            background-color: #00bfa6;
            border: none;
            min-width: 220px;
        }
        .dropdown-item-modern {
            color: #e7fffc;
            transition: all 0.3s ease;
        }
        .dropdown-item-modern:hover {
            color: #ffffff;
            text-shadow: 0 0 8px #00ffe0;
            background-color: rgba(0,0,0,0.1);
        }

        /* Perfil badge */
        .profile-badge {
            display: flex;
            align-items: center;
        }

        /* Botón cerrar sesión */
        .btn-logout {
            padding: 6px 12px !important;
            font-size: 14px !important;
            border-radius: 6px !important;
            background: #dc3545;
            color: white !important;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .btn-logout:hover {
            background-color: #e04344;
            box-shadow: 0 0 9px #ff6b6b;
        }

        /* Logo SVG */
        .navbar-brand svg {
            height: 48px;
            width: 48px;
        }

        /* Offcanvas */
        .offcanvas-modern {
            background: linear-gradient(180deg, #00bfa6, #009e8e);
            color: #e7fffc;
        }
        .offcanvas-modern .nav-link {
            color: #e7fffc;
            transition: 0.3s;
        }
        .offcanvas-modern .nav-link:hover {
            color: #fff;
            text-shadow: 0 0 10px #00ffe0;
        }

        main.contenido {
            flex: 1;
            margin-top: 80px;
            padding: 1rem;
        }


        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
        }
        .nav-link-modern {
            color: #e7fffc !important;
            font-weight: 500;
            transition: 0.3s;
        }
        .nav-link-modern:hover {
            color: #ffffff !important;
            text-shadow: 0 0 4px rgba(255,255,255,0.7);
        }

        /* BOTÓN HAMBURGUESA MODERNO */
        .navbar-toggler {
            background: white;
            border: 2px solid #4ecdc4;
            border-radius: 10px;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        .navbar-toggler::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(78, 205, 196, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.4s ease, height 0.4s ease;
        }
        .navbar-toggler:hover::before {
            width: 200px;
            height: 200px;
        }
        .navbar-toggler:hover {
            background: #4ecdc4;
            box-shadow: 0 0 20px rgba(78, 205, 196, 0.6),
            0 0 40px rgba(78, 205, 196, 0.4),
            0 4px 8px rgba(0, 0, 0, 0.2);
            transform: translateY(-2px);
        }
        .navbar-toggler-icon-modern {
            background-image: url("data:image/svg+xml;charset=UTF8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='%2334b5ad' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
            width: 24px;
            height: 24px;
            transition: transform 0.3s ease;
        }

        .navbar-toggler:hover .navbar-toggler-icon-modern {
            background-image: url("data:image/svg+xml;charset=UTF8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='%23ffffff' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
            transform: rotate(90deg);
        }
        .navbar-toggler.collapsed .bar:nth-child(2) {
            opacity: 1;
        }
        .navbar-toggler.collapsed .bar:nth-child(1) {
            transform: rotate(0) translate(0,0);
        }
        .navbar-toggler.collapsed .bar:nth-child(3) {
            transform: rotate(0) translate(0,0);
        }
        .navbar-toggler:not(.collapsed) .bar:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }
        .navbar-toggler:not(.collapsed) .bar:nth-child(2) {
            opacity: 0;
        }
        .navbar-toggler:not(.collapsed) .bar:nth-child(3) {
            transform: rotate(-45deg) translate(5px, -5px);
        }

        /* OFFCANVAS ESTILIZADO */
        .offcanvas-end {
            width: 280px;
            background: linear-gradient(180deg, #009e8e, #00bfa6);
            color: white;
            padding: 1rem;
        }
        .offcanvas-end .nav-link {
            color: white;
            padding: 0.6rem 0.8rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .offcanvas-end .nav-link:hover {
            background: rgba(255,255,255,0.2);
            color: #ffffff;
        }
        .offcanvas-header .btn-close {
            filter: invert(1); /* botón blanco */
        }

        /* FOOTER MODERNO */
        .footer-modern {
            background: linear-gradient(180deg, #009e8e, #00bfa6);
            color: white;
            padding: 2rem 1rem;
        }
        .footer-title { font-weight: 700; margin-bottom: 0.8rem; }
        .footer-text { color: #eafffa; font-size: 0.95rem; margin-bottom: 0.4rem; }
        .footer-divider { border-color: rgba(255,255,255,0.25); }
        .social.modern {
            width: 42px; height: 42px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: white;
            transition: 0.3s ease;
        }
        .social.modern:hover { background: white; color: #009e8e; }
    </style>
</head>

<body>
<nav class="navbar navbar-modern navbar-expand-lg fixed-top">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center fw-bold text-white" href="{{ route('/') }}">
            ClinicWeb
        </a>

        <!-- Botón móvil -->
        <button class="navbar-toggler collapsed" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarClinic"
                aria-controls="navbarClinic" aria-expanded="false">
            <span class="navbar-toggler-icon-modern"></span>
        </button>

        <!-- Menú -->
        <div class="collapse navbar-collapse" id="navbarClinic">

            <ul class="navbar-nav ms-auto gap-2">

                <!-- Inicio -->
                <li class="nav-item">
                    <a class="nav-link nav-link-glow active" href="{{ route('/') }}">
                        <i class="bi bi-house-door-fill me-1"></i> Inicio
                    </a>
                </li>

                <!-- Enfermería -->
                <li class="nav-item dropdown">
                    <a class="nav-link nav-link-glow dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-heart-pulse-fill me-1"></i> Enfermería
                    </a>
                    <ul class="dropdown-menu dropdown-menu-modern">
                        <li>
                            <a class="dropdown-item dropdown-item-modern"
                               href="{{route('inventario.principal')}}">
                                <i class="bi bi-capsule"></i> Administrar Medicamentos
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item dropdown-item-modern"
                               href="{{route('enfermeria.historial')}}">
                                <i class="bi bi-clipboard2-pulse"></i> Historial Medicamentos
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Perfil -->
                <li class="nav-item dropdown">
                    <a class="nav-link nav-link-glow dropdown-toggle profile-badge" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> {{ session('empleado_nombre') }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-modern dropdown-menu-end">
                        <li>
                            <form action="{{ route('empleados.logout') }}" method="POST" class="px-3 py-1">
                                @csrf
                                <button type="submit" class="btn btn-logout w-100">
                                    Cerrar Sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <!-- Enlaces principales -->

    </div>
</nav>

<div class="container-fluid p-0 mt-0 pt-0">
    @yield('contenido')
</div>

<footer class="footer-modern mt-5">
    <div class="container py-5">
        <div class="row gy-4">

            <!-- Columna 1 -->
            <div class="col-md-4">
                <h4 class="fw-bold text-white mb-3">ClinicWeb</h4>
                <p class="footer-text">
                    Gestión moderna de citas médicas con atención profesional y tecnología avanzada.
                </p>
            </div>

            <!-- Columna 2 -->
            <div class="col-md-4">
                <h5 class="footer-title">Contacto</h5>
                <p class="footer-text"><i class="bi bi-geo-alt-fill me-2"></i> Danlí, El Paraíso, Honduras</p>
                <p class="footer-text"><i class="bi bi-telephone-fill me-2"></i> +504 2234-5678</p>
                <p class="footer-text"><i class="bi bi-envelope-fill me-2"></i> contacto@clinicweb.hn</p>
            </div>

            <!-- Columna 3 -->
            <div class="col-md-4">
                <h5 class="footer-title">Síguenos</h5>
                <div class="d-flex gap-3">
                    <a class="social modern" href="#"><i class="bi bi-facebook"></i></a>
                    <a class="social modern" href="#"><i class="bi bi-instagram"></i></a>
                    <a class="social modern" href="#"><i class="bi bi-twitter-x"></i></a>
                    <a class="social modern" href="#"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>
        </div>

        <hr class="footer-divider">

        <div class="text-center text-white-50 small mt-3">
            © {{ date('Y') }} ClinicWeb. Todos los derechos reservados.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>

