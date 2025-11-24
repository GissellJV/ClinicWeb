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
                            <a class="nav-link  fw-semibold text-custom" href="{{ route('inicioSesion') }}" id="loginDropdown"
                               role="button" >
                                <i class="bi bi-box-arrow-in-right me-1"></i> Acceder
                            </a>
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
            height: 3rem;
            width: auto;
        }
        .navbar-brand {
            margin-left: -96px;
            padding-left: 0;
        }

        /* ========== MODALES PERSONALIZADOS ========== */
        /* Modal de Confirmación Personalizado */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 9999;
            animation: fadeIn 0.3s ease;
            backdrop-filter: blur(3px);
        }

        .modal-overlay.active {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .modal-container {
            background: white;
            border-radius: 20px;
            padding: 40px 35px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            animation: modalSlideUp 0.4s ease;
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .modal-title {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
            text-align: center;
            margin-bottom: 15px;
            line-height: 1.3;
        }

        .modal-message {
            font-size: 17px;
            color: #5a6c7d;
            text-align: center;
            line-height: 1.6;
            margin-bottom: 35px;
            padding: 0 10px;
        }

        .modal-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-modal {
            padding: 14px 32px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 140px;
            flex: 1;
            max-width: 180px;
        }

        .btn-modal-cancel {
            background: #6c757d;
            color: white;
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
        }

        .btn-modal-cancel:hover {
            background: #5a6268;
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(108, 117, 125, 0.4);
        }

        .btn-modal-confirm {
            background: #95180b;
            color: white;
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
        }

        .btn-modal-confirm:hover {
            background: #000000;
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(231, 76, 60, 0.4);
        }

        /* Modal de Reprogramación Personalizado */
        .modal-reprogramar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 9998;
            animation: fadeIn 0.3s ease;
            backdrop-filter: blur(3px);
        }

        .modal-reprogramar-overlay.active {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .modal-reprogramar-container {
            background: white;
            border-radius: 20px;
            padding: 40px 35px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            animation: modalSlideUp 0.4s ease;
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .modal-reprogramar-title {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
            text-align: center;
            margin-bottom: 15px;
            line-height: 1.3;
        }

        .modal-reprogramar-content {
            margin-bottom: 30px;
        }

        .modal-reprogramar-form-group {
            margin-bottom: 20px;
        }

        .modal-reprogramar-label {
            font-weight: 600;
            color: #5a6c7d;
            margin-bottom: 8px;
            display: block;
        }

        .modal-reprogramar-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0e6ed;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .modal-reprogramar-input:focus {
            outline: none;
            border-color: #4ecdc4;
            box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.1);
            background: white;
        }

        .modal-reprogramar-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 25px;
        }

        .btn-modal-reprogramar {
            padding: 14px 32px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 140px;
            flex: 1;
            max-width: 180px;
        }

        .btn-modal-reprogramar-cancel {
            background: #6c757d;
            color: white;
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
        }

        .btn-modal-reprogramar-cancel:hover {
            background: #5a6268;
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(108, 117, 125, 0.4);
        }

        .btn-modal-reprogramar-confirm {
            background: #4ecdc4;
            color: white;
            box-shadow: 0 4px 12px rgba(78, 205, 196, 0.3);
        }

        .btn-modal-reprogramar-confirm:hover {
            background: #3bb4ac;
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(78, 205, 196, 0.4);
        }

        /* Animaciones */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes modalSlideUp {
            from {
                transform: translateY(60px) scale(0.95);
                opacity: 0;
            }
            to {
                transform: translateY(0) scale(1);
                opacity: 1;
            }
        }

        /* Responsive */
        @media (max-width: 576px) {
            .modal-container,
            .modal-reprogramar-container {
                padding: 30px 25px;
                margin: 20px;
            }

            .modal-buttons,
            .modal-reprogramar-buttons {
                flex-direction: column;
            }

            .btn-modal,
            .btn-modal-reprogramar {
                max-width: 100%;
            }
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

<!-- ========== MODALES PERSONALIZADOS ========== -->

<!-- Modal de Confirmación (Cancelar) -->
<div class="modal-overlay" id="confirmModalOverlay" onclick="closeModalOnBackdrop(event)">
    <div class="modal-container">
        <div class="modal-icon">
        </div>
        <h2 class="modal-title" id="confirmModalTitle">¿Estás seguro?</h2>
        <p class="modal-message" id="confirmModalMessage">
            ¿Estás seguro de que deseas realizar esta acción?
        </p>
        <div class="modal-buttons">
            <button class="btn-modal btn-modal-cancel" onclick="closeConfirmModal()">
                Cancelar
            </button>
            <button class="btn-modal btn-modal-confirm" id="confirmModalButton">
                Confirmar
            </button>
        </div>
    </div>
</div>

<!-- Modal de Reprogramación -->
<div class="modal-reprogramar-overlay" id="reprogramarModalOverlay" onclick="closeReprogramarModalOnBackdrop(event)">
    <div class="modal-reprogramar-container">
        <div class="modal-reprogramar-icon">
        </div>
        <h2 class="modal-reprogramar-title" id="reprogramarModalTitle">Reprogramar Cita</h2>

        <div class="modal-reprogramar-content" id="reprogramarModalContent">
            <!-- El contenido del formulario se insertará aquí dinámicamente -->
        </div>

        <div class="modal-reprogramar-buttons">
            <button class="btn-modal-reprogramar btn-modal-reprogramar-cancel" onclick="closeReprogramarModal()">
                Cerrar
            </button>
            <button class="btn-modal-reprogramar btn-modal-reprogramar-confirm" id="reprogramarModalButton">
                Reprogramar
            </button>
        </div>
    </div>
</div>

<!-- JavaScript de los Modales -->
<script>
    // ========== MODAL DE CONFIRMACIÓN (CANCELAR) ==========
    let confirmCallback = null;
    let confirmAutoCloseTimer = null;

    function showConfirmModal(title, message, confirmText, callback) {
        if (confirmAutoCloseTimer) {
            clearTimeout(confirmAutoCloseTimer);
            confirmAutoCloseTimer = null;
        }

        document.getElementById('confirmModalTitle').textContent = title;
        document.getElementById('confirmModalMessage').textContent = message;
        document.getElementById('confirmModalButton').textContent = confirmText;

        confirmCallback = callback;
        document.getElementById('confirmModalOverlay').classList.add('active');

        document.querySelector('.btn-modal-cancel').focus();

        confirmAutoCloseTimer = setTimeout(() => {
            closeConfirmModal();
        }, 10000);
    }

    function closeConfirmModal() {
        document.getElementById('confirmModalOverlay').classList.remove('active');
        confirmCallback = null;

        if (confirmAutoCloseTimer) {
            clearTimeout(confirmAutoCloseTimer);
            confirmAutoCloseTimer = null;
        }
    }

    function closeModalOnBackdrop(event) {
        if (event.target === event.currentTarget) {
            closeConfirmModal();
        }
    }

    document.getElementById('confirmModalButton').addEventListener('click', function() {
        if (confirmCallback) {
            confirmCallback();
        }
        closeConfirmModal();
    });

    // ========== MODAL DE REPROGRAMACIÓN ==========
    let reprogramarCallback = null;
    let reprogramarAutoCloseTimer = null;

    function showReprogramarModal(title, formHTML, callback) {
        if (reprogramarAutoCloseTimer) {
            clearTimeout(reprogramarAutoCloseTimer);
            reprogramarAutoCloseTimer = null;
        }

        document.getElementById('reprogramarModalTitle').textContent = title;
        document.getElementById('reprogramarModalContent').innerHTML = formHTML;

        reprogramarCallback = callback;
        document.getElementById('reprogramarModalOverlay').classList.add('active');

        const firstInput = document.querySelector('.modal-reprogramar-input');
        if (firstInput) {
            firstInput.focus();
        }

        reprogramarAutoCloseTimer = setTimeout(() => {
            closeReprogramarModal();
        }, 10000);
    }

    function closeReprogramarModal() {
        document.getElementById('reprogramarModalOverlay').classList.remove('active');
        reprogramarCallback = null;

        if (reprogramarAutoCloseTimer) {
            clearTimeout(reprogramarAutoCloseTimer);
            reprogramarAutoCloseTimer = null;
        }
    }

    function closeReprogramarModalOnBackdrop(event) {
        if (event.target === event.currentTarget) {
            closeReprogramarModal();
        }
    }

    document.getElementById('reprogramarModalButton').addEventListener('click', function() {
        if (reprogramarCallback) {
            reprogramarCallback();
        }
    });

    // ========== FUNCIONES GLOBALES ==========
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            if (document.getElementById('confirmModalOverlay').classList.contains('active')) {
                closeConfirmModal();
            }
            if (document.getElementById('reprogramarModalOverlay').classList.contains('active')) {
                closeReprogramarModal();
            }
        }
    });

    // Auto-ocultar alertas después de 10 segundos
    document.addEventListener('DOMContentLoaded', function() {
        const autoHideAlerts = document.querySelectorAll('.alert-auto-hide[data-auto-hide="true"]');
        autoHideAlerts.forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s ease';
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 500);
            }, 10000);
        });
    });
</script>

</body>
</html>

