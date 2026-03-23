@extends('layouts.plantillaDoctor')

@section('contenido')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            background: whitesmoke;
        }

        body {
            flex: 1;
        }

        .main-container {
            display: flex;
            flex-direction: column;
            flex: 1;
            width: 100%;
            box-sizing: border-box;
            padding: 0;
        }

        .citas-container {
            flex: 1;
            margin: 100px auto 0 auto;
            max-width: 1200px;
            width: 100%;
            padding: 0 20px;
            box-sizing: border-box;
        }

        footer {
            width: 100%;
            margin-top: auto;
            padding: 20px 0;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            color: #2c3e50;
            font-size: 2.2rem;
            margin-bottom: 10px;
        }

        .header p {
            color: #7f8c8d;
            font-size: 1.1rem;
        }

        /* Cards de Estadísticas - Estilo Mejorado */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border-left: 5px solid;
            transition: all 0.3s;
            text-align: left;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        }

        .stat-card.total {
            border-left-color: #3498db;
            background: linear-gradient(135deg, #fff 0%, #e3f2fd 100%);
        }

        .stat-card.hoy {
            border-left-color: #4ECDC4;
            background: linear-gradient(135deg, #fff 0%, #e5f9f7 100%);
        }

        .stat-card.pendientes {
            border-left-color: #f39c12;
            background: linear-gradient(135deg, #fff 0%, #fff4e5 100%);
        }

        .stat-card.completadas {
            border-left-color: #2ecc71;
            background: linear-gradient(135deg, #fff 0%, #e8f8f0 100%);
        }

        .stat-card i {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .stat-card.total i {
            color: #3498db;
        }

        .stat-card.hoy i {
            color: #4ECDC4;
        }

        .stat-card.pendientes i {
            color: #f39c12;
        }

        .stat-card.completadas i {
            color: #2ecc71;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-card.total .stat-number {
            color: #3498db;
        }

        .stat-card.hoy .stat-number {
            color: #4ECDC4;
        }

        .stat-card.pendientes .stat-number {
            color: #f39c12;
        }

        .stat-card.completadas .stat-number {
            color: #2ecc71;
        }

        .stat-label {
            font-size: 14px;
            color: #666;
            font-weight: 600;
        }

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

        .filter-group select,
        .filter-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e8f4f3;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .filter-group select:focus,
        .filter-group input:focus {
            outline: none;
            border-color: #4ECDC4;
            box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.1);
        }

        .btn-filter {
            padding: 12px 30px;
            background: #4ECDC4;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-filter:hover {
            background: #45b8b0;
            transform: translateY(-2px);
        }

        .citas-list {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .citas-list h3 {
            color: #2c3e50;
            margin-bottom: 25px;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .citas-list h3 i {
            color: #4ECDC4;
        }

        .cita-card {
            border: 2px solid #e8f4f3;
            border-radius: 12px;
            padding: 28px;
            margin-bottom: 18px;
            transition: all 0.3s ease;
        }
        .cita-card:hover {
            border-color: #4ECDC4;
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.1);
        }
        .cita-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 20px;
        }
        .paciente-info h4 {
            color: #2c3e50;
            font-size: 1.5rem;
            margin-bottom: 6px;
        }
        .paciente-info p {
            color: #7f8c8d;
            font-size: 1rem;
        }
        .badge {
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 0.95rem;
            font-weight: 600;
        }
        .badge-programada { background: #d4edda; color: #155724; }
        .badge-pendiente  { background: #fff3cd; color: #856404; }
        .badge-completada { background: #d1ecf1; color: #0c5460; }
        .badge-cancelada  { background: #f8d7da; color: #721c24; }
        .cita-detalles {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
            background: #f8fffe;
            border-radius: 8px;
            margin-bottom: 18px;
        }
        .detalle-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .detalle-item i {
            color: #4ECDC4;
            font-size: 1.5rem;
        }
        .detalle-text span {
            display: block;
            font-size: 0.85rem;
            color: #7f8c8d;
            margin-bottom: 4px;
        }
        .detalle-text strong {
            color: #2c3e50;
            font-size: 1.1rem;
        }
        .motivo-consulta {
            padding: 18px;
            background: #fff;
            border-left: 4px solid #4ECDC4;
            border-radius: 8px;
            margin-bottom: 18px;
        }
        .motivo-consulta h5 {
            color: #2c3e50;
            font-size: 1rem;
            margin-bottom: 8px;
        }
        .motivo-consulta p {
            color: #555;
            line-height: 1.6;
            font-size: 1rem;
        }
        .cita-acciones {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        .btn-ver { background: #4ECDC4; color: white; }
        .btn-ver:hover { background: #45b8b0; color: white; }
        .btn-evaluar { background: linear-gradient(135deg, #9b59b6, #8e44ad); color: white; }
        .btn-evaluar:hover { background: linear-gradient(135deg, #8e44ad, #7d3c98); color: white; transform: translateY(-2px); }
        .btn-evaluado { background: linear-gradient(135deg, #27ae60, #2ecc71); color: white; }
        .btn-evaluado:hover { background: linear-gradient(135deg, #229954, #27ae60); color: white; transform: translateY(-2px); }
        .btn-completar { background: #2ecc71; color: white; }
        .btn-completar:hover { background: #27ae60; }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #7f8c8d;
        }

        .empty-state i {
            font-size: 4rem;
            color: #bdc3c7;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .cita-header {
                flex-direction: column;
                gap: 15px;
            }

            .cita-acciones {
                justify-content: flex-start;
                width: 100%;
            }

            .filters-row {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        .text-info-emphasis {
            font-weight: bold;
        }
    </style>

    <div class="citas-container">
        <!-- Header -->
        <br><br>
        <div class="header">
            <h2 class="text-center text-info-emphasis">
                Mis Citas Programadas
            </h2>
        </div>

        <!-- Estadísticas -->
        <div class="stats-grid">
            <div class="stat-card total">

                <div class="stat-number">{{ $citas->total() }}</div>
                <div class="stat-label">Total de Citas</div>
                <small style="color: #666;">Registradas</small>

            </div>

            <div class="stat-card hoy">

                <div class="stat-number">{{ $citasHoy }}</div>
                <div class="stat-label">Citas de Hoy</div>
                <small style="color: #666;">Programadas para hoy</small>

            </div>

            <div class="stat-card pendientes">

                <div class="stat-number">{{ $citas->where('estado', 'programada')->count() + $citas->where('estado', 'pendiente')->count() }}</div>
                <div class="stat-label">Pendientes</div>
                <small style="color: #666;">En espera de atención</small>

            </div>

            <div class="stat-card completadas">

                <div class="stat-number">{{ $citas->where('estado', 'completada')->count() }}</div>
                <div class="stat-label">Completadas</div>
                <small style="color: #666;">Atenciones Finalizadas</small>

            </div>
        </div>

        <!-- Filtros -->
        <div class="filters-card">
            <form method="GET" action="{{ route('doctor.citas') }}">
                <div class="filters-row">
                    <div class="filter-group">
                        <label><i class="fas fa-user"></i> Paciente</label>
                        <input
                            type="text"
                            name="paciente"
                            placeholder="Buscar paciente"
                            value="{{ request('paciente') }}"
                            onkeyup="this.form.submit()">
                    </div>
                    <div class="filter-group">
                        <label><i class="fas fa-calendar"></i> Fecha</label>
                        <input type="date" name="fecha" value="{{ request('fecha') }}">
                    </div>

                    <div class="filter-group">
                        <label><i class="fas fa-filter"></i> Estado</label>
                        <select name="estado">
                            <option value="">Todos los estados</option>
                            <option value="programada" {{ request('estado') == 'programada' ? 'selected' : '' }}>Programada</option>
                            <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="completada" {{ request('estado') == 'completada' ? 'selected' : '' }}>Completada</option>
                            <option value="cancelada" {{ request('estado') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label><i class="fas fa-sort"></i> Ordenar por</label>
                        <select name="orden">
                            <option value="fecha_asc" {{ request('orden') == 'fecha_asc' ? 'selected' : '' }}>Fecha (más próxima)</option>
                            <option value="fecha_desc" {{ request('orden') == 'fecha_desc' ? 'selected' : '' }}>Fecha (más lejana)</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <button type="submit" class="btn-filter">
                            <i class="fas fa-search"></i> Filtrar
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Lista de Citas -->
        <div class="citas-list">
            <h3><i class="fas fa-list"></i> Listado de Citas</h3>

            @if(session('success'))
                <div class="alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if($citas->count() > 0)
                <div style="overflow-x:auto;">
                    <table id="citasTable" class="table table-hover" style="width:100%;">
                        <thead>
                        <tr>
                            <th>Paciente</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Especialidad</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                            <th>Cirugía</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($citas as $cita)
                            <tr>
                                <td>
                                    <div style="display:flex; align-items:center; gap:9px;">
                                        <div style="width:34px; height:34px; border-radius:50%; background:#e1f5ee; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:600; color:#0f6e56; flex-shrink:0;">
                                            {{ strtoupper(substr($cita->paciente_nombre, 0, 1)) }}{{ strtoupper(substr(strrchr($cita->paciente_nombre, ' ') ?: $cita->paciente_nombre, 1, 1)) }}
                                        </div>
                                        <div>
                                            <div style="font-weight:600; font-size:14px; color:#2c3e50;">{{ $cita->paciente_nombre }}</div>
                                            <div style="font-size:11px; color:#7f8c8d;">ID: {{ $cita->paciente_id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</td>
                                <td>{{ $cita->hora }}</td>
                                <td><span style="font-size:12px; padding:3px 9px; border-radius:4px; background:#f0f0f0; color:#555;">{{ $cita->especialidad }}</span></td>
                                <td>{{ $cita->paciente->telefono ?? '—' }}</td>
                                <td style="white-space:nowrap;">
                                    <div style="display:flex; gap:5px; align-items:center; flex-wrap:wrap;">
                                        <a href="{{ route('expediente.ver', $cita->paciente_id) }}" class="btn btn-ver" style="padding:6px 12px; font-size:12px;">
                                            <i class="fas fa-file-medical"></i> Expediente
                                        </a>

                                        @if(in_array($cita->estado, ['programada', 'pendiente']))
                                            @php
                                                $evaluacionExiste = \App\Models\EvaluacionPrequirurgica::where('cita_id', $cita->id)->first();
                                            @endphp

                                            @if(!$evaluacionExiste)
                                                <a href="{{ route('doctor.evaluacion.crear', $cita->id) }}" class="btn btn-evaluar" style="padding:6px 12px; font-size:12px;">
                                                    Evaluar
                                                </a>
                                            @else
                                                <a href="{{ route('doctor.evaluacion.ver', $evaluacionExiste->id) }}" class="btn btn-evaluado" style="padding:6px 12px; font-size:12px;">
                                                    Ver Eval.
                                                </a>
                                            @endif

                                            <form method="POST" action="{{ route('doctor.cita.completar', $cita->id) }}" style="margin:0;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-completar" style="padding:6px 12px; font-size:12px;">
                                                    Completar
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <h3>No hay citas programadas</h3>
                    <p>No tienes citas médicas en este momento</p>
                </div>
            @endif
        </div>
    </div>

    {{-- DataTables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <style>
        table.dataTable thead th {
            background: #4ecdc4 !important;
            color: white !important;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border-bottom: none !important;
        }
        table.dataTable tbody tr:hover { background: #f8fffe !important; }
        table.dataTable tbody td { vertical-align: middle; color: #2c3e50; }
        .dataTables_wrapper .dataTables_filter input {
            border: 2px solid #e0e0e0; border-radius: 8px; padding: 6px 12px; margin-left: 8px;
        }
        .dataTables_wrapper .dataTables_filter input:focus { outline: none; border-color: #4ecdc4; }
        .dataTables_wrapper .dataTables_length select {
            border: 2px solid #e0e0e0; border-radius: 8px; padding: 4px 8px; margin: 0 8px;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 6px 10px !important; border-radius: 8px !important;
            font-weight: 600 !important; box-shadow: none !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            color: white !important; box-shadow: none !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #4ecdc4, #44a08d) !important;
            color: white !important; border-color: #4ecdc4 !important;
        }
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter { margin-bottom: 16px; }
        .dataTables_wrapper .dataTables_info { font-size: 13px; padding-top: 12px; }
    </style>
    <script>
        $(document).ready(function() {
            $('#citasTable').DataTable({
                responsive: true,
                autoWidth: false,
                searching: false,
                language: {
                    lengthMenu: "Mostrar _MENU_ registros",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty: "Mostrando 0 a 0 de 0 registros",
                    infoFiltered: "(filtrado de _MAX_ registros totales)",
                    zeroRecords: "No se encontraron citas",
                    emptyTable: "No hay citas disponibles",
                    paginate: { first:"Primero", previous:"Anterior", next:"Siguiente", last:"Último" }
                },
                pageLength: 10,
                lengthMenu: [[5, 10, 25, -1], [5, 10, 25, "Todos"]],
                order: [[1, 'desc']],
                columnDefs: [{ targets: 6, orderable: false, searchable: false }]
            });
        });
    </script>

@endsection
