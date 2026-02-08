<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    @stack('styles')
    <style>
        /* === Estilos GLOBALMENTE aplicados === */

        body {
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        /* Ajuste del contenido para no quedar debajo del navbar */
        main.contenido {
            flex: 1;
            margin-top: 80px; /* altura del navbar */
        }

        /* Cuando estemos en el hero, que sea full screen */
        .hero-full {
            width: 100%;
            margin: 0;
            padding: 0;
        }


        .text-custom {
            color: #4ecdc4 !important;
            transition: color 0.3s ease;
        }

        .text-custom:hover {
            color: #34b5ad !important;
            text-decoration: underline;
        }

        .btn-custom {
            background-color: #4ecdc4;
            color: #fff;
            border: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #34b5ad;
        }

        .dropdown-menu {
            border-radius: 0.75rem;
            border: none;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        .dropdown-item i {
            color: #4ecdc4;
            margin-right: 6px;
        }

        .card.card-hover {
            transition: all 0.35s ease;
            border: 1px solid rgba(78, 205, 196, 0.2);
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .card.card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(78, 205, 196, 0.35);
            border-color: #4ecdc4;
        }

        .navbar-brand img {
            height: 3rem;
        }

        .navbar-brand {
            margin-left: 10px;
        }

        /* NAV MODERNO */
        .nav-modern {
            background: linear-gradient(90deg, #00bfa6, #009e8e);
            padding: 0.65rem 0;
        }

        .nav-modern .navbar-brand {
            font-size: 1.4rem;
            letter-spacing: 0.5px;
        }

        .nav-link-modern {
            color: #e7fffc !important;
            font-weight: 500;
            transition: 0.25s ease;
        }

        .nav-link-modern:hover {
            color: #ffffff !important;
            text-shadow: 0 0 4px rgba(255,255,255,0.7);
        }

        .nav-modern .nav-link-modern.dropdown-toggle {
            font-weight: 600;
        }


        /* Botón Registrarse */
        .btn-register {
            background: #ffffff;
            color: #009e8e;
            padding: 0.45rem 1rem;
            border-radius: 10px;
            transition: all .3s ease;
            font-weight: 600;
        }

        .btn-register:hover {
            background: #dafcf8;
            color: #00786f;
        }
        /* FOOTER MODERNO */
        .footer-modern {
            background: linear-gradient(180deg, #009e8e, #00bfa6);
            color: white;
        }

        .footer-title {
            font-weight: 700;
            margin-bottom: 0.8rem;
        }

        .footer-text {
            color: #eafffa;
            font-size: 0.95rem;
            margin-bottom: 0.4rem;
        }

        .footer-divider {
            border-color: rgba(255,255,255,0.25);
        }

        /* Íconos sociales */
        .social.modern {
            width: 42px;
            height: 42px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: white;
            transition: 0.3s ease;
        }

        .social.modern:hover {
            background: white;
            color: #009e8e;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #4ecdc4;
            margin-right: 8px;
        }

        .user-initials {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
            border: 2px solid #4ecdc4;
            margin-right: 8px;
        }

        .nav-link-modern {
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg fixed-top shadow-sm nav-modern">
        <div class="container-fluid px-4">

            <!-- LOGO -->
            <a class="navbar-brand d-flex align-items-center fw-bold text-white" href="{{ route('/') }}">
                ClinicWeb
            </a>

            <!-- Botón móvil -->
            <button class="navbar-toggler text-white border-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarClinic">
                <i class="bi bi-list" style="font-size: 1.8rem;"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarClinic">
                <ul class="navbar-nav ms-auto align-items-center gap-2">

                    <li class="nav-item">
                        <a class="nav-link nav-link-modern" href="{{ request()->routeIs('/') ? '#hero' : url('/#hero') }}">Inicio</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-link-modern" href="{{ request()->routeIs('/') ? '#servicios' : url('/#servicios') }}">Información</a>
                    </li>

                    <!-- Doctores -->
                    <li class="nav-item">
                        <a class="nav-link nav-link-modern" href="{{ request()->routeIs('/') ? '#doctors' : url('/#doctors') }}">Doctores</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-link-modern" href="{{ request()->routeIs('/') ? '#comentarios' : url('/#comentarios') }}">Comentarios</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-link-modern" href="{{ route('preguntas.publico') }}"> Preguntas Frecuentes</a>
                    </li>

                    @if(!session('paciente_id'))
                        <li class="nav-item">
                            <a class="nav-link nav-link-modern" href="{{ route('inicioSesion') }}">Acceder</a>
                        </li>

                        <li class="nav-item">
                            <a class="btn btn-register" href="{{ route('pacientes.registrarpaciente') }}">
                                <i class="bi bi-pencil-square me-1"></i> Registrarse
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-link-modern dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                               role="button" data-bs-toggle="dropdown" aria-expanded="false">

                                @php
                                    $pacienteId = session('paciente_id');
                                    $paciente = \App\Models\Paciente::find($pacienteId);
                                @endphp

                                @if($paciente && $paciente->foto)
                                    <img src="{{ asset('storage/' . $paciente->foto) }}"
                                         alt="Foto de perfil"
                                         class="user-avatar">
                                @else
                                    <div class="user-initials">
                                        @if($paciente)
                                            {{ strtoupper(substr($paciente->nombres, 0, 1) . substr($paciente->apellidos, 0, 1)) }}
                                        @else
                                            <i class="bi bi-person-circle"></i>
                                        @endif
                                    </div>
                                @endif

                                {{ session('paciente_nombre') }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('agendarcitas') }}"><i class="bi bi-calendar-plus"></i> Agendar cita</a></li>
                                <li><a class="dropdown-item" href="{{ route('citas.mis-citas') }}"><i class="bi bi-calendar-check"></i> Mis citas</a></li>
                                <li><a class="dropdown-item" href="{{ route('perfil') }}"><i class="bi bi-person-fill"></i> Mi Perfil</a></li>

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
</header>


<main class="contenido">
        @yield('contenido')
</main>

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
