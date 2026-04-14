@php
    if (session('tipo_usuario') === 'empleado') {
    switch (session('cargo')) {
    case 'Recepcionista':
    $layout = 'layouts.plantillaRecepcion';
    break;
    case 'Administrador':
    $layout = 'layouts.plantillaAdmin';
    break;
    default:
    $layout = 'layouts.plantilla';
    }
    } else {
    $layout = 'layouts.plantilla';
    }
@endphp

@extends($layout)
@section('contenido')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <style>
        .page-wrapper {
            max-width: 1300px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .page-header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #0f766e;
            margin: 0;
        }

        .page-header h1 span {
            color: #4ecdc4;
        }

        /* Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 18px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.07);
            border-left: 5px solid;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: transform 0.2s;
        }

        .stat-card:hover { transform: translateY(-3px); }
        .stat-card.pendientes { border-left-color: #f39c12; }
        .stat-card.programadas { border-left-color: #4ecdc4; }
        .stat-card.completadas { border-left-color: #27ae60; }
        .stat-card.canceladas { border-left-color: #e74c3c; }

        .stat-icon {
            font-size: 2rem;
            width: 50px;
            text-align: center;
        }

        .stat-card.pendientes .stat-icon { color: #f39c12; }
        .stat-card.programadas .stat-icon { color: #4ecdc4; }
        .stat-card.completadas .stat-icon { color: #27ae60; }
        .stat-card.canceladas .stat-icon { color: #e74c3c; }

        .stat-info h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            line-height: 1;
        }

        .stat-info p {
            margin: 4px 0 0;
            font-size: 0.85rem;
            color: #666;
            font-weight: 600;
        }

        /* Tabs */
        .tabs-container {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
            background: white;
            padding: 8px;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.07);
            width: fit-content;
        }

        .tab-btn {
            padding: 10px 22px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s;
            background: transparent;
            color: #666;
        }

        .tab-btn.active {
            background: linear-gradient(135deg, #4ecdc4, #00bfa6);
            color: white;
            box-shadow: 0 4px 12px rgba(78,205,196,0.4);
        }

        .tab-btn:not(.active):hover {
            background: #f0fdfa;
            color: #0f766e;
        }

        /* Table Card */
        .table-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .table-card table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-card thead th {
            background: linear-gradient(135deg, #4ecdc4, #00bfa6);
            color: white;
            padding: 15px 18px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: left;
            white-space: nowrap;
        }

        .table-card tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: background 0.2s;
        }

        .table-card tbody tr:hover { background: #f0fdfa; }

        .table-card tbody td {
            padding: 14px 18px;
            font-size: 14px;
            color: #555;
            vertical-align: middle;
        }

        .patient-name {
            font-weight: 700;
            color: #222;
            font-size: 14px;
        }

        .doctor-name {
            color: #444;
            font-size: 13px;
        }

        .num-cell-cirugia {
            font-weight: 700;
            color: #7f8c8d;
            font-size: 0.73rem;
            text-align: center;
        }

        /* Badges estado */
        .badge-estado {
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            display: inline-block;
            white-space: nowrap;
        }

        .badge-pendiente   { background: #fff3cd; color: #856404; border: 1px solid #ffc107; }
        .badge-programada  { background: #d4f4f0; color: #0d5550; border: 1px solid #4ecdc4; }
        .badge-completada  { background: #d4edda; color: #155724; border: 1px solid #28a745; }
        .badge-cancelada   { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .badge-en_proceso  { background: #cce5ff; color: #004085; border: 1px solid #b8daff; }

        /* Badges riesgo */
        .badge-riesgo {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            display: inline-block;
        }

        .badge-bajo   { background: #d4edda; color: #155724; }
        .badge-medio  { background: #fff3cd; color: #856404; }
        .badge-alto   { background: #f8d7da; color: #721c24; }

        /* Botón agendar */
        .btn-agendar {
            background: linear-gradient(135deg, #9b59b6, #8e44ad);
            color: white;
            padding: 7px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
            white-space: nowrap;
            border: none;
            cursor: pointer;
        }

        .btn-agendar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(155,89,182,0.4);
            color: white;
            text-decoration: none;
        }

        .btn-ver {
            background: linear-gradient(135deg, #4ecdc4, #00bfa6);
            color: white;
            padding: 7px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .btn-ver:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(78,205,196,0.4);
            color: white;
            text-decoration: none;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #aaa;
        }

        .empty-state i {
            font-size: 3.5rem;
            margin-bottom: 15px;
            color: #cce8e6;
        }

        .empty-state h4 {
            color: #888;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .section-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #9b59b6;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-label::after {
            content: '';
            flex: 1;
            height: 2px;
            background: linear-gradient(90deg, #9b59b618, transparent);
            border-radius: 2px;
        }

        /* ── DataTables Controls igual que archivados ── */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 20px;
        }
        .dataTables_wrapper .dataTables_filter input {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 8px 15px;
            margin-left: 10px;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            outline: none;
            border-color: #4ecdc4;
        }
        .dataTables_wrapper .dataTables_length select {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 5px 10px;
            margin: 0 10px;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 8px 12px !important;
            border-radius: 8px !important;
            transition: all 0.3s !important;
            box-shadow: none !important;
            font-weight: 600 !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            color: white !important;
            box-shadow: none !important;
            transform: translateY(-2px);
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%) !important;
            color: white !important;
            border-color: #4ecdc4 !important;
        }
        .dataTables_wrapper .dataTables_info {
            font-size: 14px;
            padding-top: 15px;
            padding-left: 10px;
        }
        /* Espacio entre label de sección y controles DataTables */
        .section-label {
            margin-bottom: 20px !important;
        }
        .table-card {
            padding-top: 20px !important;
        }
    </style>

    <div class="page-wrapper">

        {{-- HEADER --}}
        <div class="page-header">
            <h1>Gestión de Cirugías</h1>
        </div>

        {{-- STATS --}}
        <div class="stats-grid">
            <div class="stat-card pendientes">

                <div class="stat-info">
                    <h3>{{ $evaluacionesPendientes }}</h3>
                    <p>Pendientes de programar</p>
                </div>
            </div>
            <div class="stat-card programadas">

                <div class="stat-info">
                    <h3>{{ $cirugiasProgramadas }}</h3>
                    <p>Cirugías programadas</p>
                </div>
            </div>
            <div class="stat-card completadas">

                <div class="stat-info">
                    <h3>{{ $cirugiasCompletadas }}</h3>
                    <p>Completadas</p>
                </div>
            </div>
            <div class="stat-card canceladas">

                <div class="stat-info">
                    <h3>{{ $cirugiasCanceladas }}</h3>
                    <p>Canceladas</p>
                </div>
            </div>
        </div>

        {{-- TABS --}}
        <div class="tabs-container">
            <button class="tab-btn active" onclick="mostrarTab('pendientes', this)">
                Por Programar
                @if($evaluacionesPendientes > 0)
                    <span style="background:#f39c12; color:white; border-radius:50%; width:20px; height:20px; display:inline-flex; align-items:center; justify-content:center; font-size:11px; margin-left:4px;">{{ $evaluacionesPendientes }}</span>
                @endif
            </button>
            <button class="tab-btn" onclick="mostrarTab('programadas', this)">
                Programadas
            </button>
        </div>

        {{-- TAB: POR PROGRAMAR --}}
        <div id="tab-pendientes">
            <p class="section-label">Evaluaciones aprobadas por el doctor — pendientes de asignar quirófano</p>

            <div class="table-card">
                @if($evaluaciones->count() > 0)
                    <table id="tablaPendientes" class="table table-hover">
                        <thead>
                        <tr>
                            <th style="width:40px;">#</th>
                            <th>PACIENTE</th>
                            <th>DOCTOR</th>
                            <th>TIPO DE CIRUGÍA</th>
                            <th>DIAGNÓSTICO</th>
                            <th>RIESGO</th>
                            <th>FECHA EVALUACIÓN</th>
                            <th>ACCIÓN</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($evaluaciones as $eval)
                            <tr>
                                <td class="num-cell-cirugia"></td>
                                <td>
                                    <span class="patient-name">
                                        {{ $eval->paciente->nombres ?? '' }} {{ $eval->paciente->apellidos ?? '' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="doctor-name">
                                        {{ $eval->doctor->genero === 'Femenino' ? 'Dra.' : 'Dr.' }}
                                        {{ $eval->doctor->nombre ?? '' }} {{ $eval->doctor->apellido ?? '' }}
                                    </span>
                                </td>
                                <td>{{ $eval->tipo_cirugia }}</td>
                                <td style="max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="{{ $eval->diagnostico }}">
                                    {{ $eval->diagnostico }}
                                </td>
                                <td>
                                    <span class="badge-riesgo badge-{{ $eval->nivel_riesgo }}">
                                        {{ ucfirst($eval->nivel_riesgo) }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($eval->created_at)->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('recepcionista.cirugia.programar', $eval->id) }}" class="btn-agendar">
                                        Agendar Cirugía
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <i class="bi bi-clipboard2-x"></i>
                        <h4>Sin evaluaciones pendientes</h4>
                        <p>No hay cirugías pendientes de programar por el momento.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- TAB: PROGRAMADAS --}}
        <div id="tab-programadas" style="display:none;">
            <p class="section-label">Cirugías ya asignadas a quirófano</p>

            <div class="table-card">
                @if($cirugias->count() > 0)
                    <table id="tablaProgramadas" class="table table-hover">
                        <thead>
                        <tr>
                            <th style="width:40px;">#</th>
                            <th>PACIENTE</th>
                            <th>DOCTOR</th>
                            <th>TIPO DE CIRUGÍA</th>
                            <th>QUIRÓFANO</th>
                            <th>FECHA</th>
                            <th>HORA</th>
                            <th>ESTADO</th>
                            <th>ACCIÓN</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cirugias as $cirugia)
                            <tr>
                                <td class="num-cell-cirugia"></td>
                                <td>
                                    <span class="patient-name">
                                        {{ $cirugia->paciente->nombres ?? '' }} {{ $cirugia->paciente->apellidos ?? '' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="doctor-name">
                                        {{ $cirugia->doctor->genero === 'Femenino' ? 'Dra.' : 'Dr.' }}
                                        {{ $cirugia->doctor->nombre ?? '' }} {{ $cirugia->doctor->apellido ?? '' }}
                                    </span>
                                </td>
                                <td>{{ $cirugia->tipo_cirugia }}</td>
                                <td><strong>Quirófano {{ $cirugia->quirofano }}</strong></td>
                                <td>{{ \Carbon\Carbon::parse($cirugia->fecha_cirugia)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($cirugia->hora_inicio)->format('h:i A') }}</td>
                                <td>
                                    <span class="badge-estado badge-{{ $cirugia->estado }}">
                                        {{ ucfirst(str_replace('_', ' ', $cirugia->estado)) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('recepcionista.cirugia.ver', $cirugia->id) }}" class="btn-ver">
                                        Ver detalle
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <i class="bi bi-calendar2-x"></i>
                        <h4>Sin cirugías programadas</h4>
                        <p>Aún no se han agendado cirugías en quirófano.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script>
        function mostrarTab(tab, btn) {
            document.getElementById('tab-pendientes').style.display = 'none';
            document.getElementById('tab-programadas').style.display = 'none';
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.getElementById('tab-' + tab).style.display = 'block';
            btn.classList.add('active');
        }

        var langConfig = {
            processing:     "Procesando...",
            search:         "Buscar:",
            lengthMenu:     "Mostrar _MENU_ registros",
            info:           "Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoEmpty:      "Mostrando 0 a 0 de 0 registros",
            infoFiltered:   "(filtrado de _MAX_ registros totales)",
            loadingRecords: "Cargando...",
            zeroRecords:    "No se encontraron registros",
            emptyTable:     "No hay datos disponibles",
            paginate: {
                first:    "Primero",
                previous: "Anterior",
                next:     "Siguiente",
                last:     "Último"
            }
        };

        $(document).ready(function() {

            // Tabla Por Programar
            if ($('#tablaPendientes').length) {
                $('#tablaPendientes').DataTable({
                    responsive: true,
                    autoWidth: false,
                    language: langConfig,
                    pageLength: 10,
                    lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                    order: [[6, 'desc']],
                    columnDefs: [
                        { targets: 0, orderable: false, searchable: false },
                        { targets: 7, orderable: false, searchable: false }
                    ],
                    drawCallback: function() {
                        const info = this.api().page.info();
                        this.api().column(0, { search: 'applied', order: 'applied', page: 'current' })
                            .nodes().each(function(cell, i) {
                            cell.innerHTML = '<span class="num-cell-cirugia">' + (info.start + i + 1) + '</span>';
                        });
                    }
                });
            }

            // Tabla Programadas
            if ($('#tablaProgramadas').length) {
                $('#tablaProgramadas').DataTable({
                    responsive: true,
                    autoWidth: false,
                    language: langConfig,
                    pageLength: 10,
                    lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                    order: [[5, 'asc']],
                    columnDefs: [
                        { targets: 0, orderable: false, searchable: false },
                        { targets: 8, orderable: false, searchable: false }
                    ],
                    drawCallback: function() {
                        const info = this.api().page.info();
                        this.api().column(0, { search: 'applied', order: 'applied', page: 'current' })
                            .nodes().each(function(cell, i) {
                            cell.innerHTML = '<span class="num-cell-cirugia">' + (info.start + i + 1) + '</span>';
                        });
                    }
                });
            }

        });
    </script>

@endsection
