@extends('layouts.plantilla')

@section('titulo','Citas Archivadas')

@section('contenido')

    <style>

        body{
            font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;
            background:whitesmoke;
            min-height:100vh;
            padding:20px;
        }

        .citas-container{
            max-width:1450px;
            margin:40px auto;
        }

        .header{
            text-align:center;
            margin-bottom:40px;
        }

        .header h1{
            color:#0f766e;
            font-size:2.5rem;
            font-weight:700;
        }

        .alert-custom{
            padding:18px 25px;
            border-radius:12px;
            margin-bottom:25px;
            display:flex;
            align-items:center;
            gap:12px;
        }

        .alert-info-custom{
            background:#ffffff;
            text-align:center;
        }

        .alert-info-custom i{
            font-size:3rem;
            display:block;
            margin-bottom:15px;
        }

        /* GRID DE CITAS */

        .citas-grid{
            display:grid;
            grid-template-columns:repeat(auto-fill,minmax(400px,1fr));
            gap:25px;
        }

        .cita-card{
            background:white;
            border-radius:20px;
            overflow:hidden;
            box-shadow:0 4px 20px rgba(0,0,0,0.08);
            border-left:6px solid #4ECDC4;
            transition:all .3s ease;
        }

        .cita-card:hover{
            transform:translateY(-8px);
            box-shadow:0 8px 30px rgba(0,0,0,0.15);
        }

        .cita-header-card{
            background:linear-gradient(135deg,#4ECDC4 0%,#44A08D 100%);
            padding:25px;
            color:white;
        }

        .doctor-name{
            font-size:1.4rem;
            font-weight:700;
            display:flex;
            align-items:center;
            gap:10px;
        }

        .especialidad-badge{
            display:inline-block;
            background:rgba(255,255,255,0.3);
            padding:6px 14px;
            border-radius:20px;
            font-size:.85rem;
        }

        .cita-body{
            padding:25px;
        }

        .estado-badge{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:10px 18px;
            border-radius:25px;
            font-size:.9rem;
            font-weight:600;
            margin-bottom:15px;
            background:#d4edda;
            color:#155724;
        }

        .cita-info-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:15px;
        }

        .cita-info-item{
            display:flex;
            gap:12px;
        }

        .cita-info-item i{
            color:#4ECDC4;
        }

        .info-label{
            font-size:.75rem;
            color:#7f8c8d;
            text-transform:uppercase;
        }

        .info-value{
            font-size:1rem;
            color:#2c3e50;
            font-weight:600;
        }

        /* PAGINACION */

        .pagination{
            margin-top:10px;
        }

        /* RESPONSIVE */

        @media (max-width:768px){

            .citas-grid{
                grid-template-columns:1fr;
            }

            .cita-info-grid{
                grid-template-columns:1fr;
            }

        }
        /* Filtros */
        .filters-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .filters-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            align-items: end;
        }

        .filter-group label {
            display: block;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .filter-group select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e8f4f3;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #f8fffe;
        }

        .filter-group select:focus {
            outline: none;
            border-color: #4ECDC4;
            box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.1);
        }

        .filter-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e8f4f3;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #f8fffe;
        }

        .filter-group input:focus {
            outline: none;
            border-color: #4ECDC4;
            box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.1);
        }


        .filters-row {
            display: flex;
            align-items: flex-end;
            gap: 15px;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            flex: 1;
            min-width: 200px;
        }

        .filter-group:last-child {
            flex: 0;
            min-width:12%;
            margin-left: auto;
        }

        .filter-group label {
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .filter-group input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }

        .filter-group select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }

        .btn-filter {
            padding: 12px 30px;
            background: linear-gradient(135deg, #4ECDC4 0%, #44A08D 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 205, 196, 0.4);
        }

        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.4);
        }
        /* ================= DARK MODE - CITAS ARCHIVADAS ================= */

        .dark-mode body {
            background: #121212 !important;
            color: #e4e4e4 !important;
        }

        .dark-mode .citas-container {
            background: transparent;
        }

        /* HEADER */
        .dark-mode .header h1 {
            color: #4ecdc4 !important;
        }

        /* ALERTAS */
        .dark-mode .alert-success {
            background: #1e3a2f !important;
            color: #4ade80 !important;
            border-color: #2f5f4a !important;
        }

        .dark-mode .alert-danger {
            background: #3a1e1e !important;
            color: #ff6b6b !important;
            border-color: #5f2f2f !important;
        }

        .dark-mode .alert-info-custom {
            background: #1e1e1e !important;
            color: #d1d5db !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.45);
        }

        .dark-mode .alert-info-custom h5 {
            color: #e5e7eb !important;
        }

        .dark-mode .alert-info-custom i {
            color: #4ecdc4 !important;
        }

        /* FILTROS */
        .dark-mode .filters-card {
            background: #1e1e1e !important;
            color: #e4e4e4 !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.45);
        }

        .dark-mode .filter-group label {
            color: #ccc !important;
        }

        .dark-mode .filter-group select,
        .dark-mode .filter-group input,
        .dark-mode .form-control {
            background: #2a2a2a !important;
            color: #fff !important;
            border: 1px solid #444 !important;
        }

        .dark-mode .filter-group select:focus,
        .dark-mode .filter-group input:focus,
        .dark-mode .form-control:focus {
            border-color: #4ecdc4 !important;
            box-shadow: 0 0 0 3px rgba(78,205,196,0.2) !important;
        }

        .dark-mode .filter-group select option {
            background: #2a2a2a;
            color: #fff;
        }

        .dark-mode .btn-filter {
            background: linear-gradient(135deg, #2c5364, #203a43) !important;
            color: #e4e4e4 !important;
            border: none !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.5);
            transition: all 0.3s ease;
        }

        .dark-mode .btn-filter:hover {
            background: linear-gradient(135deg, #4ecdc4, #00ffe7) !important;
            color: #000 !important;
            box-shadow: 0 0 15px #00ffe7, 0 0 25px rgba(0,255,231,0.4);
            transform: translateY(-2px);
        }

        /* TARJETAS */
        .dark-mode .cita-card {
            background: #1e1e1e !important;
            color: #e4e4e4 !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.45);
            border-left-color: #4ecdc4 !important;
        }

        .dark-mode .cita-card:hover {
            box-shadow: 0 8px 30px rgba(0,0,0,0.6);
        }

        .dark-mode .cita-header-card {
            background: linear-gradient(135deg, #203a43 0%, #2c5364 100%) !important;
            color: #fff !important;
        }

        .dark-mode .doctor-name {
            color: #fff !important;
        }

        .dark-mode .especialidad-badge {
            background: rgba(255,255,255,0.15) !important;
            color: #fff !important;
        }

        .dark-mode .cita-body {
            background: #1e1e1e !important;
        }

        .dark-mode .estado-badge {
            background: #1e3140 !important;
            color: #4ecdc4 !important;
        }

        .dark-mode .cita-info-item i {
            color: #4ecdc4 !important;
        }

        .dark-mode .info-label {
            color: #9ca3af !important;
        }

        .dark-mode .info-value {
            color: #e5e7eb !important;
        }

        /* PAGINACIÓN */
        .dark-mode .page-link {
            background: #1f2937 !important;
            color: #d1d5db !important;
            border: 1px solid #374151 !important;
        }

        .dark-mode .page-link:hover {
            background: #374151 !important;
            color: #ffffff !important;
        }

        .dark-mode .page-item.active .page-link {
            background: #4ecdc4 !important;
            border-color: #4ecdc4 !important;
            color: #111827 !important;
        }

        .dark-mode .page-item.disabled .page-link {
            background: #111827 !important;
            color: #6b7280 !important;
            border-color: #374151 !important;
        }

        /* BOTÓN CERRAR ALERTA */
        .dark-mode .btn-close {
            filter: invert(1) grayscale(100%);
        }
    </style>

    <div class="citas-container">

        <div class="header">
            <h1>Mis Citas Archivadas</h1>
        </div>


        {{-- ALERTAS BOOTSTRAP --}}
        @if(session('success'))
            <div class="alert alert-dismissible fade show" role="alert" style="
        border-radius: 8px;
        border: none;
        border-left: 4px solid #17a2b8;
        background: #d1ecf1;
        color: #0c5460;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
    ">
                <div style="flex: 1;">
                    <p style="margin: 5px 0 0 0; font-size: 17px;">
                        {{ session('success') }}
                    </p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-dismissible fade show" role="alert" style="
        border-radius: 8px;
        border: none;
        border-left: 4px solid #dc3545;
        background: #f8d7da;
        color: #721c24;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
    ">
                <div style="flex: 1;">
                    <p style="margin: 5px 0 0 0; font-size: 17px;">
                        {{ session('error') }}
                    </p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Filtros -->
        <div class="filters-card">
            <form method="GET" action="{{ route('citas.citasArchivadas') }}">
                <div class="filters-row">

                    <div class="filter-group">
                        <label><i class="fas fa-filter"></i> Filtrar por Especialidad</label>
                        <select name="especialidad">
                            <option value="">Todas</option>
                            <option value="Pediatría" {{ request('especialidad') == 'Pediatría' ? 'selected' : '' }}>Pediatría</option>
                            <option value="Medicina General" {{ request('especialidad') == 'Medicina General' ? 'selected' : '' }}>Medicina General</option>
                            <option value="Dermatología" {{ request('especialidad') == 'Dermatología' ? 'selected' : '' }}>Dermatología</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label><i class="fas fa-calendar"></i> Filtrar por Fecha</label>
                        <input type="date"
                               name="fecha"
                               value="{{ request('fecha') }}">
                    </div>

                    <div class="filter-group">
                        <button type="submit" class="btn-filter">
                            <i class="fas fa-search"></i> Filtrar
                        </button>
                    </div>

                </div>
            </form>
        </div>



        @if($citas->count() > 0)

            <div class="citas-grid">

                @foreach($citas as $cita)

                    <div class="cita-card archivada">

                        <div class="cita-header-card">

                            <div class="doctor-name">

                                @if($cita->doctor && $cita->doctor->foto)

                                    <img src="data:image/jpeg;base64,{{ base64_encode($cita->doctor->foto) }}"
                                         style="width:45px;height:45px;border-radius:50%;object-fit:cover;">

                                @else
                                    <i class="fas fa-user-md"></i>
                                @endif

                                @if($cita->doctor)
                                    {{ $cita->doctor->genero == 'Femenino' ? 'Dra.' : 'Dr.' }}
                                    {{ $cita->doctor->nombre }}
                                    {{ $cita->doctor->apellido }}
                                @endif

                            </div>
                            <span class="especialidad-badge">
                                    {{ $cita->especialidad ?? 'No definida' }}
                                </span>
                        </div>


                        <div class="cita-body">

                            <div class="estado-badge estado-programada">
                                <i class="fas fa-box-archive"></i>
                                Archivada
                            </div>


                            <div class="cita-info-grid">

                                <div class="cita-info-item">
                                    <i class="fas fa-user"></i>

                                    <div class="info-content">
                                        <div class="info-label">Paciente</div>
                                        <div class="info-value">
                                            {{ session('paciente_nombre') }}
                                        </div>
                                    </div>
                                </div>



                                <div class="cita-info-item">
                                    <i class="fas fa-calendar"></i>

                                    <div class="info-content">
                                        <div class="info-label">Fecha</div>
                                        <div class="info-value">
                                            {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}
                                        </div>
                                    </div>
                                </div>



                                <div class="cita-info-item">
                                    <i class="fas fa-clock"></i>

                                    <div class="info-content">
                                        <div class="info-label">Hora</div>
                                        <div class="info-value">
                                            {{ $cita->hora }}
                                        </div>
                                    </div>
                                </div>



                                <div class="cita-info-item">
                                    <i class="fas fa-hospital"></i>

                                    <div class="info-content">
                                        <div class="info-label">Clínica</div>
                                        <div class="info-value">
                                            ClinicWeb
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>
            <div class="pagination d-flex justify-content-end mt-3">

                <nav>
                    <ul class="pagination">

                        {{-- Botón anterior --}}
                        <li class="page-item {{ $citas->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $citas->previousPageUrl() ?? '#' }}">
                               <
                            </a>
                        </li>

                        {{-- Página actual --}}
                        <li class="page-item active">
                <span class="page-link">
                    {{ $citas->currentPage() }}
                </span>
                        </li>

                        {{-- Botón siguiente --}}
                        <li class="page-item {{ !$citas->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $citas->nextPageUrl() ?? '#' }}">
                                >
                            </a>
                        </li>

                    </ul>
                </nav>

            </div>

        @else

            <div class="alert-custom alert-info-custom">
                <i class="fas fa-box-open"></i>
                <div>
                    <h5>No tienes citas archivadas</h5>
                </div>
            </div>

        @endif

    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

@endsection
