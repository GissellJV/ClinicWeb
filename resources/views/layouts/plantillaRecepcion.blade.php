<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Demo - Navbar Animado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        main.contenido {
            flex: 1;
            margin-top: 80px;
        }

        .navbar-modern {
            background: linear-gradient(90deg, #00bfa6, #009e8e);
            padding: 0.75rem 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .navbar-brand img {
            height: 3rem;
            width: auto;
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover img {
            transform: scale(1.05);
        }

        .nav-link-glow {
            color: #e7fffc !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .nav-link-glow::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.4s ease, height 0.4s ease;
        }

        .nav-link-glow:hover::before {
            width: 300px;
            height: 300px;
        }

        .nav-link-glow:hover {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.5),
            0 0 30px rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .nav-link-glow.active {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff !important;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.4);
        }

        .navbar-toggler-modern {
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

        .navbar-toggler-modern::before {
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

        .navbar-toggler-modern:hover::before {
            width: 200px;
            height: 200px;
        }

        .navbar-toggler-modern:hover {
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

        .navbar-toggler-modern:hover .navbar-toggler-icon-modern {
            background-image: url("data:image/svg+xml;charset=UTF8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='%23ffffff' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
            transform: rotate(90deg);
        }

        /* ANIMACIONES MEJORADAS */
        .offcanvas-modern {
            background: linear-gradient(180deg, #f8fffe, #e7fffc);
            width: 350px !important;
        }

        .offcanvas-header-modern {
            background: linear-gradient(90deg, #00bfa6, #009e8e);
            color: white;
            padding: 1.5rem;
        }

        .offcanvas-title-modern {
            font-weight: 700;
            font-size: 1.3rem;
        }

        .btn-close-modern {
            filter: brightness(0) invert(1);
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .offcanvas-nav-link {
            color: #009e8e !important;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin: 0.25rem 0;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            opacity: 0;
            animation: slideInRight 0.4s ease forwards;
        }

        .offcanvas-nav-link:nth-child(1) {
            animation-delay: 0.05s;
        }

        .offcanvas-nav-link:nth-child(2) {
            animation-delay: 0.1s;
        }

        .offcanvas-nav-link:nth-child(3) {
            animation-delay: 0.15s;
        }

        .offcanvas-nav-link:nth-child(4) {
            animation-delay: 0.2s;
        }

        .offcanvas-nav-link:nth-child(5) {
            animation-delay: 0.25s;
        }

        .offcanvas-nav-link:nth-child(6) {
            animation-delay: 0.3s;
        }

        .offcanvas-nav-link:nth-child(7) {
            animation-delay: 0.35s;
        }

        .offcanvas-nav-link:nth-child(8) {
            animation-delay: 0.4s;
        }

        .offcanvas-nav-link:nth-child(9) {
            animation-delay: 0.45s;
        }

        .offcanvas-nav-link:nth-child(10) {
            animation-delay: 0.5s;
        }

        .offcanvas-nav-link:nth-child(11) {
            animation-delay: 0.55s;
        }

        .offcanvas-nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 0;
            background: linear-gradient(90deg, #4ecdc4, #00bfa6);
            transition: width 0.3s ease;
            z-index: -1;
        }

        .offcanvas-nav-link:hover::before,
        .offcanvas-nav-link.active::before {
            width: 100%;
        }

        .offcanvas-nav-link:hover,
        .offcanvas-nav-link.active {
            color: white !important;
            transform: translateX(10px);
            box-shadow: 0 4px 12px rgba(78, 205, 196, 0.3);
        }

        .offcanvas-nav-link i {
            margin-right: 10px;
            transition: transform 0.3s ease;
            font-size: 1.1rem;
        }

        .offcanvas-nav-link:hover i {
            transform: scale(1.2) rotate(5deg);
        }

        .alert-welcome {
            background: linear-gradient(135deg, #4ecdc4, #00bfa6);
            color: white;
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(78, 205, 196, 0.3);
        }

        .demo-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .demo-title {
            color: #009e8e;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        /* CORRIGE ALINEACIÓN EN ESCRITORIO Y EVITA QUE TODO SE DESBORDE */
        .navbar-modern .container-fluid {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* LOS MENÚS EN PC NO SE DEBEN ROMPER */
        .navbar-modern .navbar-nav {
            display: flex;
            align-items: center;
            flex-wrap: nowrap;
        }

        /* EL BOTÓN HAMBURGUESA SIEMPRE A LA DERECHA */
        .navbar-toggler-modern {
            margin-left: auto;
        }

        .offcanvas-body .navbar-nav {
            text-align: left;
            align-items: flex-start !important;
        }
        /* 1) PEGAR LOS LINKS DE PC AL BOTÓN HAMBURGUESA */
        .navbar-modern .navbar-nav.d-none.d-lg-flex {
            gap: 0.5rem !important;        /* antes estaba demasiado grande */
            margin-right: 0.5rem !important; /* reduce el espacio hacia la derecha */
        }

        /* Ajuste opcional: reducir aún más la separación */
        .navbar-modern .navbar-nav .nav-item .nav-link {
            padding-left: 0.55rem !important;
            padding-right: 0.55rem !important;
        }


        /* 2) ALINEAR A LA IZQUIERDA TODO EL MENÚ DEL OFFCANVAS */
        .offcanvas-body .navbar-nav {
            align-items: flex-start !important;
            text-align: left !important;
            width: 100%;
        }

        .offcanvas-nav-link {
            width: 100%;
        }


        .offcanvas-nav-link i {
            margin-right: 12px !important;
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
<nav class="navbar navbar-modern fixed-top">
    <div class="container-fluid d-flex align-items-center justify-content-between">

        <!-- LOGO -->
        <a class="navbar-brand d-flex align-items-center fw-bold text-white" href="{{ route('/') }}">
            ClinicWeb
        </a>

        <!-- LINKS VISIBLES SOLO EN PC -->
        <ul class="navbar-nav flex-row ms-auto me-1 gap-1 d-none d-lg-flex">
        <li class="nav-item">
                <a class="nav-link nav-link-glow active" href="#">
                    <i class="bi bi-house-door-fill me-1"></i> Inicio
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-link-glow" href="#">
                    <i class="bi bi-info-circle-fill me-1"></i> Información
                </a>
            </li>
        </ul>

        <!-- BOTÓN HAMBURGUESA -->
        <button class="navbar-toggler-modern" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar">
            <span class="navbar-toggler-icon-modern"></span>
        </button>

        <div class="offcanvas offcanvas-end offcanvas-modern" tabindex="-1" id="offcanvasNavbar">
            <div class="offcanvas-header offcanvas-header-modern">
                <h5 class="offcanvas-title offcanvas-title-modern">
                    <i class="bi bi-reception-4 me-2"></i> Menú administrativo
                </h5>
                <button type="button" class="btn-close btn-close-modern" data-bs-dismiss="offcanvas"></button>
            </div>

            <div class="offcanvas-body">

                @if(session('empleado_nombre'))
                    <div class="user-card p-3 mb-3 d-flex align-items-center rounded shadow-sm"
                         style="background: linear-gradient(135deg, #4ecdc4, #00bfa6); color: white;">

                        <div class="me-3 d-flex align-items-center justify-content-center"
                             style="width: 55px; height: 55px; background:white; border-radius:50%;">
                            <i class="bi bi-person-fill" style="font-size: 2rem; color:#00bfa6;"></i>
                        </div>

                        <div>
                            <div class="fw-bold" style="font-size: 1.1rem;">
                                {{ session('empleado_nombre') }}
                            </div>
                            <small>Recepcionista</small>
                        </div>
                    </div>
                @endif


                <!-- MENU -->
                <ul class="navbar-nav flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link offcanvas-nav-link" href="{{ route('recepcionista.busquedaexpediente') }}">
                            <i class="bi bi-search"></i> Búsqueda de Expediente
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link offcanvas-nav-link" href="{{ route('citas.agendar') }}">
                            <i class="bi bi-calendar-plus"></i> Agendar Cita
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link offcanvas-nav-link" href="{{ route('empleados.crear') }}">
                            <i class="bi bi-person-plus"></i> Registrar Empleado
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link offcanvas-nav-link" href="{{ route('listadocitas') }}">
                            <i class="bi bi-calendar-check"></i> Citas Programadas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link offcanvas-nav-link" href="{{ route('recepcionista.registroPaciente') }}">
                            <i class="bi bi-clipboard-check"></i> Asistencia de Pacientes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link offcanvas-nav-link" href="{{ route('recepcionista.index') }}">
                            <i class="bi bi-clock-history"></i> Turnos de Doctores
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link offcanvas-nav-link" href="{{ route('recepcionista.habitaciones.index') }}">
                            <i class="bi bi-door-open"></i> Buscar Habitación
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link offcanvas-nav-link" href="{{ route('recepcionista.habitaciones.ocupadas') }}">
                            <i class="bi bi-door-closed"></i> Habitaciones Ocupadas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link offcanvas-nav-link" href="{{ route('recepcionista.habitaciones.asignar') }}">
                            <i class="bi bi-house-add"></i> Asignar Habitación
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link offcanvas-nav-link" href="{{ route('lista.doctores') }}">
                            <i class="bi bi-people"></i> Doctores
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link offcanvas-nav-link" href="{{ route('historial.diario') }}">
                            <i class="bi bi-journal-text"></i> Historial Diario
                        </a>
                    </li>
                </ul>

                <!-- BOTÓN CERRAR SESIÓN -->
                @if(session('empleado_id'))
                    <form action="{{ route('empleados.logout') }}" method="POST" class="mt-4">
                        @csrf
                        <button class="btn w-100 d-flex align-items-center justify-content-center"
                                style="
                        background: linear-gradient(90deg, #ff5f6d, #ff3d54);
                        color: white;
                        border: none;
                        padding: 12px;
                        border-radius: 10px;
                        font-weight: 600;
                        transition: all 0.3s ease;
                    "
                                onmouseover="this.style.transform='scale(1.03)'"
                                onmouseout="this.style.transform='scale(1)'">
                            <i class="bi bi-box-arrow-right me-2"></i>
                            Cerrar Sesión
                        </button>
                    </form>
                @endif

            </div> <!-- FIN OFFCANVAS BODY -->

        </div>
        </div>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
