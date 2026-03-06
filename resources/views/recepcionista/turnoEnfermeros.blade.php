@extends('layouts.plantillaRecepcion')
<style>
    /* Fondo general */
    .turnos-page {
        background: linear-gradient(135deg, #f8fffe 0%, #e6fffb 50%, #f0fffd 100%);
        min-height: 100vh;
        padding: 2rem 0 4rem;
    }

    /* Header Card */
    .turnos-header {
        background: linear-gradient(135deg, #009e8e, #4ecdc4, #00ffe7);
        border-radius: 20px;
        padding: 2rem 2.5rem;
        color: white;
        box-shadow: 0 10px 40px rgba(78, 205, 196, 0.35);
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .turnos-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.12) 0%, transparent 70%);
        border-radius: 50%;
    }

    .turnos-header h1 {
        font-weight: 800;
        font-size: 1.8rem;
        letter-spacing: 2px;
        margin: 0;
    }

    .turnos-header .subtitle {
        font-size: 1.2rem;
        font-weight: 300;
        opacity: 0.9;
        letter-spacing: 1px;
    }

    /* Month Navigation */
    .month-nav {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .month-nav .btn-nav {
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .month-nav .btn-nav:hover {
        background: rgba(255, 255, 255, 0.35);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        color: white;
    }

    .month-nav .month-label {
        font-size: 1.5rem;
        font-weight: 700;
        letter-spacing: 3px;
        min-width: 280px;
        text-align: center;
    }

    /* Filter Bar */
    .filter-bar {
        background: white;
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        margin-bottom: 1.5rem;
        border: 1px solid rgba(78, 205, 196, 0.18);
    }

    .filter-bar .form-control,
    .filter-bar .form-select {
        border: 2px solid #e8f4f8;
        border-radius: 10px;
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .filter-bar .form-control:focus,
    .filter-bar .form-select:focus {
        border-color: #4ecdc4;
        box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.18);
    }

    .filter-bar .btn-filter {
        background: linear-gradient(135deg, #4ecdc4, #00ffe7);
        color: black;
        border: none;
        border-radius: 10px;
        padding: 0.6rem 1.5rem;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .filter-bar .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 255, 231, 0.25);
    }

    .filter-bar .btn-clear {
        background: white;
        border: 2px solid #dee2e6;
        border-radius: 10px;
        padding: 0.6rem 1.25rem;
        font-weight: 600;
        color: #6c757d;
        transition: all 0.3s ease;
    }

    .filter-bar .btn-clear:hover {
        border-color: #dc3545;
        color: #dc3545;
    }

    /* Calendar Container */
    .calendar-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        border: 1px solid rgba(78, 205, 196, 0.18);
    }

    .calendar-scroll {
        overflow-x: auto;
        padding: 0;
    }

    .calendar-scroll::-webkit-scrollbar {
        height: 8px;
    }

    .calendar-scroll::-webkit-scrollbar-track {
        background: #f0f4f8;
    }

    .calendar-scroll::-webkit-scrollbar-thumb {
        background: linear-gradient(90deg, #4ecdc4, #00ffe7);
        border-radius: 4px;
    }

    /* Calendar Table */
    .calendar-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 1200px;
    }

    .calendar-table th,
    .calendar-table td {
        text-align: center;
        vertical-align: middle;
        font-size: 0.78rem;
        border: 1px solid #e8edf2;
    }

    /* Header Rows */
    .calendar-table thead .row-dias-semana th {
        background: linear-gradient(135deg, #009e8e, #4ecdc4);
        color: white;
        padding: 8px 4px;
        font-weight: 700;
        font-size: 0.7rem;
        letter-spacing: 1px;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .calendar-table thead .row-dias-numero th {
        background: linear-gradient(135deg, #4ecdc4, #00ffe7);
        color: black;
        padding: 6px 4px;
        font-weight: 900;
        font-size: 0.85rem;
        position: sticky;
        top: 32px;
        z-index: 10;
    }

    .calendar-table thead .row-dias-semana th.col-doctor,
    .calendar-table thead .row-dias-numero th.col-doctor {
        min-width: 180px;
        max-width: 220px;
        text-align: left;
        padding-left: 16px;
        position: sticky;
        left: 0;
        z-index: 20;
    }

    /* Weekend headers (mismo estilo, pero rosa más suave) */
    .calendar-table thead .row-dias-semana th.weekend-header {
        background: linear-gradient(135deg, #ff6fb1, #ff4d6d);
    }

    .calendar-table thead .row-dias-numero th.weekend-header {
        background: linear-gradient(135deg, #ff4d6d, #ff8fab);
        color: white;
    }

    /* Doctor Name Column */
    .calendar-table tbody td.col-doctor {
        min-width: 180px;
        max-width: 220px;
        text-align: left;
        padding: 10px 12px;
        background: #f8fffe;
        position: sticky;
        left: 0;
        z-index: 5;
        border-right: 2px solid #4ecdc4;
    }

    .doctor-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .doctor-info .doctor-name {
        font-weight: 800;
        font-size: 0.82rem;
        color: #009e8e;
        line-height: 1.2;
    }

    .doctor-info .doctor-specialty {
        font-size: 0.68rem;
        color: #4ecdc4;
        font-weight: 600;
        opacity: 0.85;
    }

    /* Shift Cells */
    .calendar-table tbody td.shift-cell {
        padding: 4px 2px;
        min-width: 48px;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }

    .calendar-table tbody td.shift-cell:hover {
        background: #e6fffb !important;
        transform: scale(1.02);
    }

    .calendar-table tbody td.shift-cell.weekend-cell {
        background: #fff5f7;
    }

    .calendar-table tbody tr:nth-child(even) td {
        background-color: #fafcff;
    }

    .calendar-table tbody tr:nth-child(even) td.weekend-cell {
        background-color: #fff0f3;
    }

    .calendar-table tbody tr:nth-child(even) td.col-doctor {
        background-color: #f0faf8;
    }

    /* Shift Badges */
    .shift-badge {
        display: inline-block;
        padding: 3px 6px;
        border-radius: 6px;
        font-weight: 900;
        font-size: 0.65rem;
        letter-spacing: 0.5px;
        color: white;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        min-width: 32px;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }

    .shift-badge:hover {
        transform: scale(1.15);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
    }

    .shift-badge.turno-A {
        background: linear-gradient(135deg, #2ecc71, #27ae60);
    }

    .shift-badge.turno-B {
        background: linear-gradient(135deg, #4ecdc4, #009e8e);
        color: #000;
        text-shadow: none;
    }

    .shift-badge.turno-C {
        background: linear-gradient(135deg, #9b59b6, #8e44ad);
    }

    .shift-badge.turno-BC {
        background: linear-gradient(135deg, #00ffe7, #4ecdc4);
        color: #000;
        text-shadow: none;
    }

    .shift-badge.turno-ABC {
        background: linear-gradient(135deg, #f4a261, #e76f51);
    }

    .shift-badge.turno-L {
        background: linear-gradient(135deg, #95a5a6, #7f8c8d);
    }

    .shift-badge.turno-LLAMADO {
        background: linear-gradient(135deg, #ff4d6d, #c9184a);
        font-size: 0.5rem;
    }

    /* Empty cell click area */
    .empty-cell {
        width: 100%;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .shift-cell:hover .empty-cell {
        background: rgba(78, 205, 196, 0.14);
    }

    .shift-cell:hover .empty-cell::after {
        content: '+';
        color: #009e8e;
        font-weight: 900;
        font-size: 1rem;
    }

    /* Legend */
    .legend-container {
        background: white;
        border-radius: 16px;
        padding: 1.5rem 2rem;
        margin-top: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(78, 205, 196, 0.18);
    }

    .legend-title {
        font-weight: 800;
        color: #009e8e;
        font-size: 1rem;
        margin-bottom: 1rem;
    }

    .legend-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.4rem 0.8rem;
        background: #f8fffe;
        border-radius: 10px;
        border: 1px solid #e8edf2;
        transition: all 0.2s ease;
    }

    .legend-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    }

    .legend-color {
        width: 28px;
        height: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
    }

    .legend-text {
        font-size: 0.8rem;
        font-weight: 700;
        color: #333;
    }

    .legend-hours {
        font-size: 0.7rem;
        color: #666;
        font-weight: 400;
    }

    .legend-color.turno-LLAMADO {
        width: auto !important;
        min-width: 90px;
        padding: 4px 12px;
        white-space: nowrap;
    }

    /* Weekend schedules box */
    .weekend-box {
        background: linear-gradient(135deg, #fff5f7, #ffe0e6);
        border: 2px solid #ff8fab;
        border-radius: 12px;
        padding: 1rem 1.5rem;
    }

    .weekend-box h6 {
        color: #c9184a;
        font-weight: 800;
    }

    /* Modal Styles */
    .modal-turno .modal-content {
        border-radius: 20px;
        border: 2px solid #4ecdc4;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    }

    .modal-turno .modal-header {
        background: linear-gradient(135deg, #009e8e, #4ecdc4);
        color: white;
        padding: 1.25rem 1.5rem;
        border: none;
    }

    .modal-turno .modal-title {
        font-weight: 800;
        font-size: 1.1rem;
    }

    .modal-turno .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.85;
        transition: transform 0.3s;
    }

    .modal-turno .btn-close:hover {
        transform: rotate(90deg);
        opacity: 1;
    }

    .modal-turno .modal-body {
        padding: 1.5rem;
    }

    .modal-turno .modal-footer {
        border-top: 1px solid #e8f4f8;
        padding: 1rem 1.5rem;
    }

    /* Shift Code Selector */
    .turno-selector {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 0.5rem;
        margin-top: 0.5rem;
    }

    .turno-option {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.6rem;
        border-radius: 10px;
        border: 2px solid #e8edf2;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: center;
        font-weight: 800;
        font-size: 0.85rem;
    }

    .turno-option:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    .turno-option.selected {
        border-width: 3px;
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .turno-option input[type="radio"] {
        display: none;
    }

    /* Today highlight */
    .calendar-table thead .today-col {
        background: linear-gradient(135deg, #ffd93d, #ffe8a1) !important;
        color: #333 !important;
    }

    .calendar-table tbody td.today-cell {
        background: #fffde7 !important;
        border-color: #ffd93d;
    }

    /* Stats row */
    .stats-row {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .stat-mini {
        background: white;
        border-radius: 14px;
        padding: 1rem 1.5rem;
        flex: 1;
        min-width: 160px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        display: flex;
        align-items: center;
        gap: 1rem;
        border-left: 4px solid;
        transition: all 0.3s ease;
    }

    .stat-mini:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .stat-mini .stat-icon {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        color: white;
    }

    .stat-mini .stat-value {
        font-size: 1.5rem;
        font-weight: 900;
        color: #009e8e;
        line-height: 1;
    }

    .stat-mini .stat-label {
        font-size: 0.75rem;
        color: #6c757d;
        font-weight: 500;
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .calendar-container {
        animation: fadeInUp 0.5s ease-out;
    }

    .filter-bar {
        animation: fadeInUp 0.3s ease-out;
    }

    .legend-container {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .turnos-header {
            padding: 1.5rem;
            border-radius: 14px;
        }

        .turnos-header h1 {
            font-size: 1.2rem;
        }

        .month-nav .month-label {
            font-size: 1rem;
            min-width: auto;
        }

        .month-nav .btn-nav {
            width: 36px;
            height: 36px;
        }
    }
</style>

@section('contenido')
    <div class="turnos-page">
        <div class="container-fluid px-4">

            {{-- Header --}}
            <div class="turnos-header">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <div>
                        <h1><i class="bi bi-calendar3-week me-2"></i>ROL DE TURNOS</h1>
                        <span class="subtitle">Gestión de turnos enfemeros</span>
                    </div>
                    <div class="month-nav">
                        <a href="{{ route('recepcionista.indexEnfer', ['mes' => $prevMes, 'anio' => $prevAnio]) }}"
                           class="btn-nav">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                        <span class="month-label">{{ $nombreMes }} {{ $anio }}</span>
                        <a href="{{ route('recepcionista.indexEnfer', ['mes' => $nextMes, 'anio' => $nextAnio]) }}"
                           class="btn-nav">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Stats --}}
            <div class="stats-row">
                <div class="stat-mini" style="border-color: #0077b6;">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #00b4d8, #0077b6);">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $enfermeros->total() }}</div>
                        <div class="stat-label">Enfermeros</div>
                    </div>
                </div>
                <div class="stat-mini" style="border-color: #2ecc71;">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #2ecc71, #27ae60);">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $diasEnMes }}</div>
                        <div class="stat-label">Días del mes</div>
                    </div>
                </div>
                <div class="stat-mini" style="border-color: #9b59b6;">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #9b59b6, #8e44ad);">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div>
                        @php
                            $totalAsignados = 0;
                            foreach ($grid as $enfermeroId => $dias_grid) {
                                foreach ($dias_grid as $turno) {
                                    if ($turno)
                                        $totalAsignados++;
                                }
                            }
                        @endphp
                        <div class="stat-value">{{ $totalAsignados }}</div>
                        <div class="stat-label">Turnos asignados</div>
                    </div>
                </div>
                <div class="stat-mini" style="border-color: #e67e22;">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #e67e22, #d35400);">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <div>
                        @php
                            $totalVacios = ($enfermeros->count() * $diasEnMes) - $totalAsignados;
                        @endphp
                        <div class="stat-value">{{ $totalVacios }}</div>
                        <div class="stat-label">Sin asignar</div>
                    </div>
                </div>
            </div>

            {{-- Filter --}}
            <div class="filter-bar">
                <form method="GET" action="{{ route('recepcionista.indexEnfer') }}" class="row g-2 align-items-end">
                    <input type="hidden" name="mes" value="{{ $mes }}">
                    <input type="hidden" name="anio" value="{{ $anio }}">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold" style="font-size:0.85rem;">
                            <i class="bi bi-search me-1"></i>Buscar Enfermero
                        </label>
                        <input type="text" name="nombre" class="form-control" placeholder="Nombre del enfermero..."
                               value="{{ request('nombre') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold" style="font-size:0.85rem;">
                            <i class="bi bi-heart-pulse me-1"></i>Especialidad
                        </label>
                        <select name="departamento" class="form-select">
                            <option value="">Todas</option>
                            @foreach($departamentos as $dep)
                                <option value="{{ $dep }}" {{ request('departamento') == $dep ? 'selected' : '' }}>
                                    {{ $dep }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-filter">
                            <i class="bi bi-funnel me-1"></i>Filtrar
                        </button>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('recepcionista.indexEnfer', ['mes' => $mes, 'anio' => $anio]) }}"
                           class="btn btn-clear">
                            <i class="bi bi-x-lg me-1"></i>Limpiar
                        </a>
                    </div>
                </form>
            </div>

            {{-- Calendar Grid --}}
            <div class="calendar-container">
                <div class="calendar-scroll">
                    <table class="calendar-table">
                        <thead>
                        {{-- Row 1: Day of week abbreviations --}}
                        <tr class="row-dias-semana">
                            <th class="col-doctor">NOMBRE DEL ENFERMERO</th>
                            @foreach($dias as $dia)
                                <th
                                    class="{{ $dia['esFinDeSemana'] ? 'weekend-header' : '' }} {{ $dia['fecha'] == now()->format('Y-m-d') ? 'today-col' : '' }}">
                                    {{ $dia['diaSemana'] }}
                                </th>
                            @endforeach
                        </tr>
                        {{-- Row 2: Day numbers --}}
                        <tr class="row-dias-numero">
                            <th class="col-doctor"></th>
                            @foreach($dias as $dia)
                                <th
                                    class="{{ $dia['esFinDeSemana'] ? 'weekend-header' : '' }} {{ $dia['fecha'] == now()->format('Y-m-d') ? 'today-col' : '' }}">
                                    {{ $dia['dia'] }}
                                </th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($enfermeros as $enfermero)
                            <tr>
                                <td class="col-doctor">
                                    <div class="doctor-info">
                                            <span class="doctor-name">
                                                {{ $enfermero->genero == 'Femenino' ? 'Licad.' : 'Lic.' }} {{ $enfermero->nombre }}  {{ $enfermero->apellido }}
                                            </span>
                                        <span class="doctor-specialty">
                                                {{ $enfermero->departamento ?? 'enfermeria' }}
                                            </span>
                                    </div>
                                </td>
                                @foreach($dias as $dia)
                                    @php $turno = $grid[$enfermero->id][$dia['dia']] ?? null; @endphp
                                    <td class="shift-cell {{ $dia['esFinDeSemana'] ? 'weekend-cell' : '' }} {{ $dia['fecha'] == now()->format('Y-m-d') ? 'today-cell' : '' }}"
                                        onclick="openTurnoModal({{ $enfermero->id }}, '{{ $enfermero->nombre }} {{ $enfermero->apellido }}', '{{ $dia['fecha'] }}', {{ $dia['dia'] }}, {{ $turno ? "'" . $turno->codigo_turno . "'" : 'null' }}, {{ $turno ? $turno->id : 'null' }}, {{ $turno && $turno->nota ? "'" . addslashes($turno->nota) . "'" : 'null' }})">
                                        @if($turno)
                                            <span class="shift-badge turno-{{ $turno->codigo_turno }}">
                                                    {{ $turno->codigo_turno }}
                                                </span>
                                        @else
                                            <div class="empty-cell"></div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $diasEnMes + 1 }}" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox" style="font-size:3rem;opacity:0.3;"></i>
                                    <p class="mt-2 mb-0">No se encontraron enfermeros</p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-3 d-flex justify-content-center">
                {{ $enfermeros->links() }}
            </div>

            {{-- Legend --}}
            <div class="legend-container">
                <div class="row">
                    <div class="col-lg-7">
                        <h6 class="legend-title"><i class="bi bi-palette me-2"></i>Horario de los Turnos</h6>
                        <div class="legend-grid">
                            @foreach($turnosCodigos as $codigo => $info)
                                <div class="legend-item">
                                    <div class="legend-color shift-badge turno-{{ $codigo }}"
                                         style="min-width:40px;text-align:center;">{{ $codigo }}</div>
                                    <div>
                                        <span class="legend-text">{{ $info['nombre'] }}</span>
                                        @if($info['inicio'] && $info['fin'])
                                            <br><span
                                                class="legend-hours">{{ $info['inicio'] }} – {{ $info['fin'] }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-5 mt-3 mt-lg-0">
                        <div class="weekend-box">
                            <h6><i class="bi bi-calendar-heart me-1"></i> Horario Fines de Semana</h6>
                            <ul class="mb-0 small" style="list-style:none;padding-left:0;">
                                <li><strong>Sábado:</strong> A = 7:00 AM – 2:00 PM</li>
                                <li class="text-muted"><em>Al llamado:</em></li>
                                <li><strong>Sábado:</strong> B = 2:00 PM – 7:00 AM</li>
                                <li><strong>Domingo:</strong> 24 hrs</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal: Assign / Edit Shift --}}
    <div class="modal fade modal-turno" id="turnoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-calendar-plus me-2"></i>
                        <span id="modalTitle">Asignar Turno</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="turnoForm" method="POST" action="{{ route('recepcionista.storeEnfer') }}">
                    @csrf
                    <input type="hidden" name="empleado_id" id="modalEmpleadoId">
                    <input type="hidden" name="fecha" id="modalFecha">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="bi bi-person-badge me-1 text-primary"></i>Enfermero
                            </label>
                            <div class="form-control bg-light" id="modalDoctorName" style="border:2px solid #e8f4f8;">—
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="bi bi-calendar-event me-1 text-primary"></i>Fecha
                            </label>
                            <div class="form-control bg-light" id="modalFechaDisplay" style="border:2px solid #e8f4f8;">
                                —
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="bi bi-clock me-1 text-primary"></i>Código de Turno
                            </label>
                            <div class="turno-selector" id="turnoSelector">
                                @foreach($turnosCodigos as $codigo => $info)
                                    <label class="turno-option"
                                           style="border-color: {{ $info['color'] }}; color: {{ $info['color'] }};"
                                           onclick="selectTurno(this, '{{ $codigo }}')">
                                        <input type="radio" name="codigo_turno" value="{{ $codigo }}">
                                        {{ $codigo }}
                                    </label>
                                @endforeach
                            </div>
                            <div id="turnoError" class="text-danger small mt-2 d-none">
                                <i class="bi bi-exclamation-circle me-1"></i>
                                Debes seleccionar un código de turno.
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-bold">
                                <i class="bi bi-chat-left-text me-1 text-primary"></i>Notas (opcional)
                            </label>
                            <textarea name="nota" id="modalNotas" class="form-control" rows="2"
                                      placeholder="Observaciones..."
                                      style="border:2px solid #e8f4f8;border-radius:10px;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                style="border-radius:10px;">Cancelar
                        </button>
                        <button type="button" class="btn btn-danger d-none" id="btnDeleteTurno"
                                style="border-radius:10px;"
                                onclick="deleteTurno()">
                            <i class="bi bi-trash me-1"></i>Eliminar
                        </button>
                        <button type="submit" class="btn text-white" id="btnSaveTurno"
                                style="background:linear-gradient(135deg,#00b4d8,#0077b6);border-radius:10px;">
                            <i class="bi bi-check-lg me-1"></i>Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Confirmación Eliminación --}}
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:15px;">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Confirmar eliminación
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="mb-0">
                        ¿Estás seguro de eliminar este turno?
                    </p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-danger"
                            onclick="confirmDeleteTurno()">
                        Sí, eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Hidden delete form --}}
    <form id="deleteForm" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('scripts')
    <script>
        let currentTurnoId = null;

        function openTurnoModal(empleadoId, doctorName, fecha, dia, currentCodigo, turnoId, notas) {
            document.getElementById('modalEmpleadoId').value = empleadoId;
            document.getElementById('modalFecha').value = fecha;
            document.getElementById('modalDoctorName').textContent = doctorName;
            document.getElementById('modalNotas').value = notas || '';
            currentTurnoId = turnoId;

            // Format date for display
            const parts = fecha.split('-');
            const displayDate = `${parts[2]}/${parts[1]}/${parts[0]}`;
            document.getElementById('modalFechaDisplay').textContent = `Día ${dia} — ${displayDate}`;

            // Reset selections
            document.querySelectorAll('.turno-option').forEach(opt => {
                opt.classList.remove('selected');
                opt.querySelector('input').checked = false;
            });

            if (currentCodigo) {
                document.getElementById('modalTitle').textContent = 'Editar Turno';
                document.getElementById('btnDeleteTurno').classList.remove('d-none');
                // Pre-select the current code
                document.querySelectorAll('.turno-option input').forEach(input => {
                    if (input.value === currentCodigo) {
                        input.checked = true;
                        input.closest('.turno-option').classList.add('selected');
                    }
                });
            } else {
                document.getElementById('modalTitle').textContent = 'Asignar Turno';
                document.getElementById('btnDeleteTurno').classList.add('d-none');
            }

            const modal = new bootstrap.Modal(document.getElementById('turnoModal'));
            modal.show();
        }

        function selectTurno(element, codigo) {
            document.querySelectorAll('.turno-option').forEach(opt => opt.classList.remove('selected'));
            element.classList.add('selected');
            element.querySelector('input').checked = true;
        }

        function deleteTurno() {
            if (!currentTurnoId) return;

            const modal = new bootstrap.Modal(
                document.getElementById('confirmDeleteModal')
            );

            modal.show();
        }

        function confirmDeleteTurno() {
            const form = document.getElementById('deleteForm');
            form.action = '{{ url("turnos") }}/' + currentTurnoId;
            form.submit();
        }

        document.getElementById('turnoForm').addEventListener('submit', function (e) {
            const checked = document.querySelector('input[name="codigo_turno"]:checked');
            if (!checked) {
                e.preventDefault();
                document.getElementById('turnoError').classList.remove('d-none');
            }
        });
    </script>
@endpush

