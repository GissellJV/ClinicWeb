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
        .alert {
            transition: all 0.5s ease;
        }

        main.contenido {
            flex: 1;
            padding: 1rem;
        }
        .navbar-modern .nav-link {
            display: flex;
            align-items: center;
            gap: 0.35rem; /* espacio entre icono y texto */
        }
        .navbar-modern {
            background: linear-gradient(90deg, #00bfa6, #009e8e);
            padding: 0.75rem 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            overflow: visible !important;
        }

        /* Contenedor navbar */
        .navbar-modern .container-fluid {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Navbar links */
        .navbar-modern .navbar-nav {
            display: flex;
            align-items: center;
            flex-wrap: nowrap;
        }

        .navbar-modern .navbar-nav.d-none.d-lg-flex {
            gap: 0rem !important;
            margin-right: 0rem !important;
        }

        .navbar-modern .navbar-nav.flex-row .nav-item {
            margin-right: 0 !important;
        }

        .navbar-modern .navbar-nav.flex-row .nav-link {
            padding-left: 0.25rem !important;
            padding-right: 0.25rem !important;
            margin-right: 0 !important;
        }

        .navbar-modern .navbar-nav .nav-item .nav-link {
            padding-left: 0.55rem !important;
            padding-right: 0.55rem !important;
        }

        /* ================== LOGO ================== */
        .navbar-brand img {
            height: 3rem;
            width: auto;
            transition: transform 0.3s ease;
        }
        .navbar-brand:hover img {
            transform: scale(1.05);
        }

        /* ================== NAV-LINK GLOW ================== */
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

        /* ================== DROPDOWN ================== */
        .navbar-modern .d-none.d-lg-flex .nav-item.dropdown .dropdown-menu {
            position: absolute !important;
            top: 100% !important;
            right: 0 !important;
            margin-top: 8px !important;
            transform: none !important;
            z-index: 99999 !important;
        }

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

        /* ================== BOTÓN HAMBURGUESA ================== */
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
            0 0 40px rgba(78, 205,196, 0.4),
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

        /* ================== OFFCANVAS ================== */
        .offcanvas-modern {
            background-color: #e7fffc;
            width: 350px !important;
            height: 100% !important;
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

        /* ================== OFFCANVAS LINKS ================== */
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .offcanvas-body .navbar-nav {
            align-items: flex-start !important;
            text-align: left !important;
            width: 100%;
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
            width: 100%;
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
            margin-right: 12px !important;
            transition: transform 0.3s ease;
            font-size: 1.1rem;
        }

        .offcanvas-nav-link:hover i {
            transform: scale(1.2) rotate(5deg);
        }

        /* ================== BOTÓN CERRAR SESIÓN ================== */
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

        /* ================== FOOTER ================== */
        .footer-modern {
            background: linear-gradient(180deg, #009e8e, #00bfa6);
            color: white;
            padding: 2rem 1rem;
        }
        .footer-title { font-weight: 700; margin-bottom: 0.8rem; }
        .footer-text { color: #eafffa; font-size: 0.95rem; margin-bottom: 0.4rem; }
        .footer-divider { border-color: rgba(255,255,255,0.25); }
        .social.modern {
            width: 42px;
            height: 42px;
            background: rgba(255, 255, 255, 0.2);
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
            box-shadow: 0 4px 12px rgba(0, 217, 192, 0.5);
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
            box-shadow: 0 4px 12px rgba(0, 217, 192, 0.5);
        }
        /* BOTONES */
        .btn-subir {
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

        .btn-subir:hover {
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
            flex: 0.6;
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

        /* ================= DARK MODE ================= */

        .dark-mode {
            background-color: #121212 !important;
            color: #e4e4e4 !important;
        }

        /* NAVBAR */
        .dark-mode .navbar-modern {
            background: linear-gradient(90deg, #0f2027, #203a43, #2c5364);
        }

        /* FOOTER */
        .dark-mode .footer-modern {
            background: linear-gradient(180deg, #0f2027, #203a43);
        }

        /* CARDS / CONTENEDORES */
        .dark-mode .card,
        .dark-mode .calendar-container,
        .dark-mode .filter-bar,
        .dark-mode .legend-container {
            background: #1e1e1e !important;
            color: #e4e4e4;
            border-color: #333;
        }

        /* INPUTS */
        .dark-mode input,
        .dark-mode select,
        .dark-mode textarea {
            background: #2a2a2a !important;
            color: #fff !important;
            border-color: #444 !important;
        }

        /* TABLAS */
        .dark-mode table {
            color: #e4e4e4;
        }

        .dark-mode td,
        .dark-mode th {
            border-color: #333 !important;
        }

        /* BOTONES */
        .dark-mode .btn {
            opacity: 0.9;
        }

        /* MODALES */
        .dark-mode .modal-content {
            background: #1e1e1e;
            color: #fff;
        }

        /* TEXTO */
        .dark-mode .text-muted {
            color: #aaa !important;
        }/* ===== DROPDOWN NAVBAR DARK ===== */

        .dark-mode .dropdown-menu-modern {
            background: linear-gradient(180deg, #203a43, #2c5364);
            border: 1px solid #333;
        }

        /* ITEMS */
        .dark-mode .dropdown-item-modern {
            color: #ddd;
        }

        /* HOVER */
        .dark-mode .dropdown-item-modern:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
            text-shadow: none;
        }
        /* ================= DARK MODE ================= */

        #modalFotoRecepcion .modal-content {
            border-radius: 18px;
            border: 3px solid #24f3e2;
            box-shadow: 0 0 20px rgba(36, 243, 226, 0.4);
            overflow: hidden;
            padding: 0;
        }

        #modalFotoRecepcion .modal-header {
            background: linear-gradient(90deg, #00e1ff, #00ffc8);
            color: white;
            border-radius: 20px 20px 0 0;
            border-bottom: none;
            padding: 20px 30px;
        }

        #modalFotoRecepcion .modal-title {
            font-weight: 700;
            font-size: 1.3rem;
        }

        #modalFotoRecepcion .modal-body {
            padding: 30px;
        }

        #modalFotoRecepcion .modal-footer {
            border-top: none;
            padding: 20px 30px;
            display: flex;
            justify-content: center;
            gap: 12px;
        }

        #modalFotoRecepcion .btn-close {
            filter: brightness(0) invert(1);
        }

        #modalFotoRecepcion .form-control {
            border: 2px solid #24f3e2;
            border-radius: 12px;
            background: #fff;
            padding: 10px 14px;
            font-size: 1rem;
            width: 100%;
            box-shadow: 0 0 12px rgba(36, 243, 226, 0.2);
            transition: 0.2s;
            outline: none;
        }

        #modalFotoRecepcion .form-control:focus {
            border-color: #00f3ff;
            box-shadow: 0 0 10px rgba(0, 243, 255, 0.42);
        }

        /* ════ ESTILOS GLOBALES ════ */

        /* #7 Selects — verde transparente con borde */
        select.form-control,
        select.form-select,
        select.form-select-custom {
            border: 2px solid #4ecdc4 !important;
            background-color: rgba(78, 205, 196, 0.05) !important;
            color: #2c3e50 !important;
            border-radius: 8px !important;
        }
        select.form-control:focus,
        select.form-select:focus,
        select.form-select-custom:focus {
            border-color: #44a08d !important;
            box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.15) !important;
            background-color: white !important;
        }

        /* #2 Orden botones: Registrar primero, Cancelar después */
        .btn-group-custom,
        .button-group,
        .btn-group-form {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
        }
        .btn-register { order: 1; }
        .btn-cancel   { order: 2; }
        /* ══════════════════════════ */
    </style>

</head>

<body>
@if(session('ok'))
    <div id="globalAlert" class="alert alert-success alert-dismissible fade show text-center mb-0" role="alert">
        {{ session('ok') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div id="globalAlert" class="alert alert-danger alert-dismissible fade show text-center mb-0" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<nav class="navbar navbar-modern fixed-top">
    <div class="container-fluid d-flex align-items-center justify-content-between">

        <!-- LOGO -->
        <a class="navbar-brand d-flex align-items-center fw-bold text-white" href="{{ route('/') }}">
            ClinicWeb
        </a>

        <!-- LINKS VISIBLES SOLO EN PC -->
        <ul class="navbar-nav flex-row ms-auto me-4 gap-3 d-none d-lg-flex nav-ul-tight">
            <li class="nav-item">
                <a class="nav-link nav-link-glow active" href="{{ request()->routeIs('/') ? '#hero' : url('/#hero') }}">
                    <i class="bi bi-house-door-fill me-1"></i> Inicio
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-link-glow" href="{{ request()->routeIs('/') ? '#servicios' : url('/#servicios') }}">
                    <i class="bi bi-info-circle-fill me-1"></i> Información
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-link-glow" href="{{ request()->routeIs('/') ? '#doctors' : url('/#doctors') }}">
                    <i class="bi bi-person-fill"></i> Doctores
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-link-glow" href="{{ route('preguntas.publico') }}">
                    <i class="bi bi-question-circle me-1"></i> Preguntas Frecuentes
                </a>
            </li>

            <!-- Perfil -->
            <li>


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


                    <span class="edit-icon-overlay" data-bs-toggle="modal" data-bs-target="#modalFotoRecepcion"
                          onclick="event.stopPropagation();">
            <i class="bi bi-camera-fill"></i>
        </span>
                </div>


            </li>
        </ul>
        <a class="nav-link nav-link-glow dropdown-toggle profile-badge" href="#" role="button"
           data-bs-toggle="dropdown" aria-expanded="false">
            {{ session('empleado_nombre') ?? 'Empleado' }}
        </a>
        <ul class="dropdown-menu dropdown-menu-modern dropdown-menu-end">
            <li class="nav-item dropdown">
                <form action="{{ route('empleados.logout') }}" method="POST" class="px-3 py-1">
                    @csrf
                    <button type="submit" class="btn btn-logout w-100">
                        Cerrar Sesión
                    </button>
                </form>
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
                                    <i class="bi bi-person-fill" style="font-size: 2rem; color:#00bfa6;"></i>
                                </div>
                            @endif
                        </div>

                        <div>
                            <div class="fw-bold" style="font-size: 1.1rem;">
                                {{ session('empleado_nombre') }}
                            </div>
                            <small>{{$empleado->departamento}}</small>
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
                        <a class="nav-link offcanvas-nav-link" href="{{ route('recepcionista.reporte.calidad') }}">
                            <i class="bi bi-patch-check-fill"></i> Calidad de Traslados
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link offcanvas-nav-link" href="{{ route('listadocitas') }}">
                            <i class="bi bi-calendar-check"></i> Citas Programadas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link offcanvas-nav-link" href="{{ route('recepcionista.registroPaciente')}}">
                            <i class="bi bi-clipboard-check"></i> Asistencia de Pacientes
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
                        <a class="nav-link offcanvas-nav-link" href="{{ route('historial.diario') }}">
                            <i class="bi bi-journal-text"></i> Historial Diario
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link offcanvas-nav-link" href="{{ route('preguntas.index') }}">
                            <i class="bi bi-question-circle"></i> Administración de Preguntas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link offcanvas-nav-link" href="{{ route('recepcionista.cirugias.index') }}">
                            <i class="bi bi-scissors"></i> Cirugías Programadas
                        </a>
                    </li>
                    <!-- H74: Cirugías Programadas -->
                    <li class="nav-item">
                        <a class="nav-link offcanvas-nav-link" href="{{ route('recepcionista.incidentes.index') }}">
                            <i class="bi bi-exclamation-triangle"></i> Reportes de Incidentes
                        </a>
                    </li>
                    <!-- Reportes de Incidentes -->
                    <li class="nav-item">
                        <a class="nav-link offcanvas-nav-link" href="{{ route('inventario.equipos.index') }}">
                            <i class="bi bi-box-seam"></i> Inventario de Equipos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link offcanvas-nav-link" href="{{ route('expedientes.archivados') }}">
                            <i class="bi bi-folder-plus"></i> Expedientes Archivados
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link offcanvas-nav-link" href="{{ route('recepcionista.traslados.historial') }}">
                            <i class="bi bi-truck"></i> Historial de Traslados
                        </a>
                    </li>
                    <!-- REGISTRO DE VISITANTES-->
                    <li class="nav-item">
                        <a class="nav-link offcanvas-nav-link" href="{{ route('visitantes.index') }}">
                            <i class="bi bi-person-check-fill"></i> Registro de Visitantes
                        </a>
                    </li>
                </ul>
                    <!-- INCIDENTE EN RUTA-->
                    <li class="nav-item">
                        <a class="nav-link offcanvas-nav-link" href="{{ route('incidentes_ruta.index') }}">
                            <i class="bi bi-exclamation-triangle-fill"></i> Incidentes en Ruta
                        </a>
                    </li>


                <li class="nav-item">
                    <div class="form-check form-switch text-white">
                        <input class="form-check-input" type="checkbox" id="darkModeToggle">
                    </div>
                </li>

                <!-- Perfil -->
                <li class="nav-item dropdown">

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
                </li>
            </div> <!-- FIN OFFCANVAS BODY -->

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
                <p class="footer-text"><i class="bi bi-envelope-fill me-2"></i> <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="46252928322725322906252a2f282f25312324682e28">[email&#160;protected]</a></p>
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

@stack('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alert = document.getElementById('globalAlert');
        if (alert) {
            setTimeout(function () {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 3000); // 3 segundos
        }
    });
</script>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>


<div class="modal fade" id="modalFotoRecepcion" tabindex="-1" aria-labelledby="modalFotoRecepcionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRecepcionDoctorLabel">
                    <i class="bi bi-camera-fill me-2"></i>Actualizar Foto de Perfil
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('doctor.subirFoto') }}" method="POST" enctype="multipart/form-data"
                  id="formFotoRecepcion">
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
                    <button type="submit" class="btn-subir" id="btnSubirFoto">
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
            reader.onload = function (e) {
                img.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    }

    // Validar antes de enviar el formulario
    document.getElementById('formFotoRecepcion').addEventListener('submit', function (e) {
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
    document.getElementById('foto').addEventListener('change', function () {
        if (this.files.length > 0) {
            this.classList.remove('is-invalid');
        }
    });

    // Mantener modal abierto si hay errores de validación del servidor
    document.addEvent
</script>


{{-- Modal de éxito para foto --}}
@if(session('foto_success'))
    <div class="modal fade" id="modalExito" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 380px;">
            <div class="modal-content" style="border-radius: 18px; border: 3px solid #24f3e2; box-shadow: 0 0 20px rgba(36, 243, 226, 0.4); overflow: hidden; padding: 0;">

                {{-- Header --}}
                <div class="modal-header" style="background: linear-gradient(90deg, #00e1ff, #00ffc8); color: white; border-radius: 16px 16px 0 0; border-bottom: none; padding: 20px 30px;">
                    <h5 class="modal-title fw-bold" style="font-size: 1.3rem;">

                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            style="filter: brightness(0) invert(1);" aria-label="Close"></button>
                </div>

                {{-- Body --}}
                <div class="modal-body text-center px-4 pt-4 pb-2" style="padding: 30px;">
                    <div style="width: 60px; height: 60px; background: #e6faf7;
                            border-radius: 50%; display: flex; align-items: center;
                            justify-content: center; margin: 0 auto 1rem;
                            border: 2px solid #00bfa6;">
                        <i class="bi bi-check-lg" style="font-size: 1.8rem; color: #00bfa6;"></i>
                    </div>
                    <h6 class="fw-bold mb-1" style="color: #222;">¡Listo!</h6>
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">
                        {{ session('foto_success') }}
                    </p>
                </div>

                {{-- Footer --}}
                <div class="modal-footer" style="border-top: none; padding: 20px 30px; display: flex; justify-content: center; gap: 12px;">
                    <button type="button"
                            data-bs-dismiss="modal"
                            style="background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%); color: white; border: none;
                               padding: 0.5rem 2.5rem; border-radius: 8px;
                               font-size: 0.95rem; font-weight: 500; cursor: pointer;
                               transition: background 0.2s;">
                        Aceptar
                    </button>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new bootstrap.Modal(document.getElementById('modalExito')).show();
        });
    </script>
@endif

{{-- Modal error --}}
@if(session('foto_error'))
    <div class="modal fade" id="modalError" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow" style="border-radius: 12px; overflow: hidden;">
                <div style="height: 6px; background: linear-gradient(90deg, #dc3545, #b02a37);"></div>
                <div class="modal-body text-center px-4 pt-4 pb-2">
                    <div style="width: 60px; height: 60px; background: #fdecea;
                            border-radius: 50%; display: flex; align-items: center;
                            justify-content: center; margin: 0 auto 1rem;
                            border: 2px solid #dc3545;">
                        <i class="bi bi-x-lg" style="font-size: 1.8rem; color: #dc3545;"></i>
                    </div>
                    <h6 class="fw-bold mb-1" style="color: #222;">¡Error!</h6>
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">
                        {{ session('foto_error') }}
                    </p>
                </div>
                <div class="modal-footer border-0 justify-content-center pt-2 pb-4">
                    <button type="button" data-bs-dismiss="modal"
                            style="background: #dc3545; color: white; border: none;
                               padding: 0.5rem 2.5rem; border-radius: 8px;
                               font-size: 0.95rem; font-weight: 500; cursor: pointer;">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new bootstrap.Modal(document.getElementById('modalError')).show();
        });
    </script>
@endif

<!-- #10 Temporizador alertas — desaparecen en 5 segundos -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const alertas = document.querySelectorAll(".alert");
        alertas.forEach(function (alerta) {
            setTimeout(function () {
                alerta.style.transition = "opacity 0.8s ease";
                alerta.style.opacity = "0";
                setTimeout(function () {
                    alerta.style.display = "none";
                }, 800);
            }, 5000);
        });
    });
</script>
</body>

<script>
    const toggle = document.getElementById('darkModeToggle');

    // Cargar preferencia
    if (localStorage.getItem('darkMode') === 'true') {
        document.body.classList.add('dark-mode');
        toggle.checked = true;
    }

    // Cambiar modo
    toggle.addEventListener('change', function () {
        if (this.checked) {
            document.body.classList.add('dark-mode');
            localStorage.setItem('darkMode', 'true');
        } else {
            document.body.classList.remove('dark-mode');
            localStorage.setItem('darkMode', 'false');
        }
    });
</script>


</html>
