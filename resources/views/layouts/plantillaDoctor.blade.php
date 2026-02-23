<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding-top: 60px;
            background-color: #f5f7fa;
        }
        .formulario small.text-danger {
            font-size: 0.875rem;
            display: block;
            margin-top: 0.5rem;
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
        /* ALINEACIÓN HORIZONTAL DEL NAVBAR */
        .navbar-nav {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 1rem;
        }

        .navbar-nav .nav-item {
            display: flex;
            align-items: center;
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

        .edit-icon-overlay {
            position: absolute;
            bottom: -2px;
            right: -2px;
            background: #00bfa6;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid white;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        .edit-icon-overlay i {
            font-size: 10px;
            color: white;
        }

        .edit-icon-overlay:hover {
            background: #009e8e;
            transform: scale(1.15);
            box-shadow: 0 0 12px rgba(0, 217, 192, 0.8);
        }

        .profile-badge img {
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 217, 192, 0.3);
        }

        .profile-badge:hover img {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 217, 192,0.5);
        }

        .edit-icon-overlay {
            position: absolute;
            bottom: -2px;
            right: -2px;
            background: #00bfa6;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid white;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        .edit-icon-overlay i {
            font-size: 10px;
            color: white;
        }

        .edit-icon-overlay:hover {
            background: #009e8e;
            transform: scale(1.15);
            box-shadow: 0 0 12px rgba(0, 217, 192, 0.8);
        }

        .profile-badge img {
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 217, 192, 0.3);
        }

        .profile-badge:hover img {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 217, 192,0.5);
        }

        /* BOTONES */
        .btn-register {
            padding: 0.875rem 2rem;
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.3);
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        }

        .btn-cancel {
            padding: 0.875rem 2rem;
            background: white;
            border: 2px solid #dc3545;
            border-radius: 8px;
            color: #dc3545;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }
        .foto-preview-container {
            width: 200px;
            height: 200px;
            margin: 0 auto;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid #e0e0e0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .foto-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .foto-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 6rem;
            color: rgba(255, 255, 255, 0.4);
        }

        .form-group-custom {
            margin-bottom: 1.5rem;
        }

        .form-group-custom label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
            color: #333;
        }

        .form-group-custom .form-control {
            border-radius: 8px;
            padding: 10px;
            border: 2px solid #e0e0e0;
            transition: all 0.3s;
        }

        .form-group-custom .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(0, 217, 192, 0.25);
        }

        #nuevaFotoPreview .foto-preview {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary);
        }

    </style>
</head>
<body>

<nav class="navbar navbar-modern navbar-expand-lg fixed-top shadow-sm">
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





        <!-- Desktop menu -->

        <ul class="navbar-nav flex-row ms-auto me-3 gap-2 d-none d-lg-flex">
            <!-- Inicio -->
            <li class="nav-item">
                <a class="nav-link nav-link-glow {{ request()->routeIs('/') ? 'active' : '' }}" href="{{ route('/') }}">
                    <i class="bi bi-house-door-fill me-1"></i> Inicio
                </a>
            </li>

            <!-- Acciones -->
            <li class="nav-item dropdown">
                <a class="nav-link nav-link-glow dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-lightning-fill me-1"></i> Acciones
                </a>
                <ul class="dropdown-menu dropdown-menu-modern">
                    <li>
                        <a class="dropdown-item dropdown-item-modern" href="{{ route('doctor.citas') }}">
                            <i class="bi bi-calendar-check me-1"></i> Citas Programadas
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item dropdown-item-modern" href="{{ route('recetamedica') }}">
                            <i class="bi bi-prescription2 me-1"></i> Generar Receta
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item dropdown-item-modern" href="{{ route('doctor.habitaciones.mis-pacientes') }}">
                            <i class="bi bi-hospital me-1"></i> Pacientes Hospitalizados
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item dropdown-item-modern" href="{{ route('doctor.expedientesRecibidos') }}">
                            <i class="bi bi-folder2-open me-1"></i> Expedientes Recibidos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item dropdown-item-modern" href="{{ route('doctor.alta_pacientes') }}">
                            <i class="bi bi-clipboard-check-fill"></i>  Historial de Altas
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item dropdown-item-modern" href="{{ route('doctor.cirugias') }}">
                            <i class="bi bi-scissors me-1"></i> Mis Citas Quirúrgicas
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Perfil -->
            <li class="nav-item dropdown">

                <a class="nav-link nav-link-glow dropdown-toggle profile-badge" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @php
                        $empleadoId = session('empleado_id');
                        $empleado = \App\Models\Empleado::find($empleadoId);
                    @endphp

                    <div style="position: relative; display: inline-block; margin-right: 8px;">
                        @if($empleado && $empleado->foto)
                            <img src="data:image/jpeg;base64,{{ base64_encode($empleado->foto) }}"
                                 alt="Foto"
                                 style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid #00ffe0;">
                        @else
                            <i class="bi bi-person-circle" style="font-size: 35px; color: #e7fffc;"></i>
                        @endif


                        <span class="edit-icon-overlay" data-bs-toggle="modal" data-bs-target="#modalFotoDoctor" onclick="event.stopPropagation();">
            <i class="bi bi-camera-fill"></i>
        </span>
                    </div>

                    {{ session('empleado_nombre') ?? 'Empleado' }}
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
</nav>

<main class="container-fluid p-0 mt-0 pt-0">
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
                <p class="footer-text"><i class="bi bi-envelope-fill me-2"></i> <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="f3909c9d879290879cb3909f9a9d9a90849691dd9b9d">[email&#160;protected]</a></p>
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

<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>


<div class="modal fade" id="modalFotoDoctor" tabindex="-1" aria-labelledby="modalFotoDoctorLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFotoDoctorLabel">
                    <i class="bi bi-camera-fill me-2"></i>Actualizar Foto de Perfil
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('doctor.subirFoto') }}" method="POST" enctype="multipart/form-data" id="formFotoDoctor">
                @csrf
                <div class="modal-body">

                    <!-- Vista previa de la foto actual -->
                    <div class="text-center mb-4">
                        <div class="foto-preview-container">
                            @php
                                $empleadoId = session('empleado_id');
                                $empleado = \App\Models\Empleado::find($empleadoId);
                            @endphp

                            @if($empleado && $empleado->foto)
                                <img src="data:image/jpeg;base64,{{ base64_encode($empleado->foto) }}"
                                     alt="Foto actual"
                                     class="foto-preview"
                                     id="fotoActual">
                            @else
                                <div class="foto-placeholder" id="fotoPlaceholder">
                                    <i class="bi bi-person-circle"></i>
                                </div>
                            @endif
                        </div>
                        <small class="text-muted">Foto actual</small>
                    </div>

                    <!-- Input para nueva foto -->
                    <div class="form-group-custom mb-3">
                        <label for="foto" class="form-label">Seleccionar nueva foto *</label>
                        <input type="file"
                               class="form-control @error('foto') is-invalid @enderror"
                               id="foto"
                               name="foto"
                               accept="image/jpeg,image/jpg,image/png"
                               onchange="previewImage(event)"
                        >

                        @error('foto')
                        <div class="invalid-feedback d-block">
                            <i></i>{{ $message }}
                        </div>
                        @enderror

                        <div class="invalid-feedback" id="errorFoto">
                            <i></i>Por favor selecciona una imagen válida
                        </div>

                    </div>

                    <!-- Vista previa de la nueva foto -->
                    <div class="text-center mt-3" id="nuevaFotoPreview" style="display: none;">
                        <p class="mb-2"><strong>Nueva foto:</strong></p>
                        <img src="" alt="Vista previa" class="foto-preview" id="imagenPreview">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">
                        <i class=""></i>Cancelar
                    </button>
                    <button type="submit" class="btn-register" id="btnSubirFoto">
                        <i class="bi bi-upload me-1"></i>Subir Foto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('nuevaFotoPreview');
        const img = document.getElementById('imagenPreview');
        const fotoInput = document.getElementById('foto');

        // Limpiar clases de error previas
        fotoInput.classList.remove('is-invalid');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            const fileSize = file.size / 1024 / 1024; // MB
            const fileType = file.type;
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

            // Validar tipo de archivo
            if (!allowedTypes.includes(fileType)) {
                fotoInput.classList.add('is-invalid');
                document.getElementById('errorFoto').textContent = 'Solo se permiten archivos JPG, JPEG o PNG';
                input.value = '';
                preview.style.display = 'none';
                return;
            }

            // Validar tamaño (máximo 2MB)
            if (fileSize > 2) {
                fotoInput.classList.add('is-invalid');
                document.getElementById('errorFoto').textContent = 'La imagen no debe superar los 2MB';
                input.value = '';
                preview.style.display = 'none';
                return;
            }

            // Si pasa las validaciones, mostrar preview
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    }

    // Validar antes de enviar el formulario
    document.getElementById('formFotoDoctor').addEventListener('submit', function(e) {
        const fotoInput = document.getElementById('foto');
        const btnSubmit = document.getElementById('btnSubirFoto');

        // Validar si hay archivo seleccionado
        if (!fotoInput.files || fotoInput.files.length === 0) {
            e.preventDefault();
            fotoInput.classList.add('is-invalid');
            document.getElementById('errorFoto').textContent = 'Debes seleccionar una foto';
            fotoInput.focus();
            return false;
        }

        const file = fotoInput.files[0];
        const fileSize = file.size / 1024 / 1024; // MB
        const fileType = file.type;
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

        // Validar tipo
        if (!allowedTypes.includes(fileType)) {
            e.preventDefault();
            fotoInput.classList.add('is-invalid');
            document.getElementById('errorFoto').textContent = 'Solo se permiten archivos JPG, JPEG o PNG';
            fotoInput.focus();
            return false;
        }

        // Validar tamaño
        if (fileSize > 2) {
            e.preventDefault();
            fotoInput.classList.add('is-invalid');
            document.getElementById('errorFoto').textContent = 'La imagen no debe superar los 2MB';
            fotoInput.focus();
            return false;
        }

        // Si pasa todas las validaciones, deshabilitar botón y mostrar loading
        fotoInput.classList.remove('is-invalid');
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Subiendo...';

        return true;
    });

    // Limpiar validación al cambiar archivo
    document.getElementById('foto').addEventListener('change', function() {
        if (this.files.length > 0) {
            this.classList.remove('is-invalid');
        }
    });

    // Mantener modal abierto si hay errores de validación del servidor
    document.addEvent
