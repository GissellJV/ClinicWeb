<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    @stack('styles')
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg fixed-top shadow-sm bg-white">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('/') }}" style="color: #4ecdc4;">
                <img src="/imagenes/login-icon.png" alt="login-icono">
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
</header>


<main class="contenido">

    <div class="container">
        @yield('contenido')
    </div>
        <style>

            body {
                display: flex;
                flex-direction: column;
                min-height: 100vh;
                margin: 0;
            }
            .contenido {
                flex: 1;
                padding-top: 100px;
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

            /* Botón personalizado */
            .btn-custom {
                background-color: #4ecdc4;
                color: #fff;
                border: none;
                transition: all 0.3s ease;
                border-radius: 8px;
            }

            .btn-custom:hover {
                background-color: #34b5ad;
                color: #fff;
            }

            /* Dropdown moderno */
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

            .card.card-hover {
                transition: all 0.35s ease;
                border: 1px solid rgba(78, 205, 196, 0.2);
                border-radius: 12px;
                box-shadow: 0 4px 10px rgba(0,0,0,0.05);
                overflow: hidden;
            }

            .card.card-hover:hover {
                transform: translateY(-8px);
                box-shadow: 0 12px 25px rgba(78, 205, 196, 0.35);
                border-color: #4ecdc4;
                cursor: pointer;
            }

            /* Para título y botón dentro de la card */
            .card.card-hover .card-title {
                color: #333;
                transition: color 0.3s ease;
            }

            .card.card-hover:hover .card-title {
                color: #4ecdc4;
            }

            .card.card-hover .btn {
                background-color: #4ecdc4;
                border: none;
                color: #fff;
                border-radius: 8px;
                transition: all 0.3s ease;
            }

            .card.card-hover .btn:hover {
                background-color: #34b5ad;
            }

            html, body {
                height: 100%;
                margin: 0;
            }
            .footer {
                width: 100%;
                background-color: #ffffff;
                color: #333;
                border-top: 3px solid #4ecdc4;
                box-shadow: 0 -4px 15px rgba(0,0,0,0.05);
                padding: 1rem 0;
            }


            .footer h5, .footer h4 {
                margin-bottom: 1rem;
            }

            .footer .social-link {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 38px;
                height: 38px;
                border-radius: 50%;
                background-color: #4ecdc4;
                color: white;
                font-size: 1.2rem;
                transition: all 0.3s ease;
            }

            .footer .social-link:hover {
                background-color: #34b5ad;
                transform: translateY(-3px);
            }
            .navbar-brand img {
                height: 3rem; /* ajusta según necesites */
                width: auto;  /* mantiene proporción */
            }

        </style>

</main>
<footer class="footer mt-5">

        <div class="row text-center text-md-start mx-0">
            <!-- Logo y descripción -->
            <div class="col-md-4 mb-4">
                <h4 class="fw-bold text-uppercase" style="color:#4ecdc4;">ClinicWeb</h4>
                <p class="text-muted">
                    Brindamos atención médica profesional con tecnología moderna y un equipo humano comprometido con tu salud.
                </p>
            </div>

            <!-- Información de contacto -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-semibold" style="color:#4ecdc4;">Contáctanos</h5>
                <ul class="list-unstyled text-muted">
                    <li><i class="bi bi-geo-alt-fill" style="color:#4ecdc4;"></i> Barrio centro, Danlí, El Paraíso, Honduras</li>
                    <li><i class="bi bi-telephone-fill" style="color:#4ecdc4;"></i> +504 2234-5678</li>
                    <li><i class="bi bi-envelope-fill" style="color:#4ecdc4;"></i> contacto@clinicweb.hn</li>
                </ul>
            </div>

            <!-- Redes sociales -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-semibold" style="color:#4ecdc4;">Síguenos</h5>
                <div class="d-flex justify-content-center justify-content-md-start gap-3">
                    <a href="#" class="social-link"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-link"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="social-link"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="social-link"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>
        </div>

        <hr class="my-0" style="border-color: rgba(78, 205, 196, 0.3);">

        <div class="text-center text-muted small">
            © {{ date('Y') }} ClinicWeb. Todos los derechos reservados.
        </div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
