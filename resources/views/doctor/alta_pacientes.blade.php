@extends('layouts.plantillaDoctor')

@section('contenido')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: whitesmoke;
            min-height: 100vh;
        }

        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 100px 30px 40px;
        }

        .text-info-emphasis {
            color: #2c3e50;
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 30px;
            text-align: center;
        }

        /* ── Alert Cards ── */
        .stock-alerts {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .alert-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border-left: 5px solid;
            transition: all 0.3s;
            text-align: left;
        }

        .alert-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        }

        .alert-card.emergencia {
            border-left-color: #e74c3c;
            background: linear-gradient(135deg, #fff 0%, #ffe5e5 100%);
        }

        .alert-card.individual {
            border-left-color: #4ecdc4;
            background: linear-gradient(135deg, #fff 0%, #e5f9f7 100%);
        }

        .alert-card.doble {
            border-left-color: #f39c12;
            background: linear-gradient(135deg, #fff 0%, #fff4e5 100%);
        }

        .alert-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }


        .alert-card.emergencia .alert-card-icon {
            background: rgba(231,76,60,0.12);
            color: #e74c3c;
        }

        .alert-card.individual .alert-card-icon {
            background: rgba(78,205,196,0.15);
            color: #4ecdc4;
        }

        .alert-card.doble .alert-card-icon {
            background: rgba(243,156,18,0.12);
            color: #f39c12;
        }

        .alert-number {
            font-size: 32px;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 4px;
        }

        .alert-card.emergencia .alert-number { color: #e74c3c; }
        .alert-card.individual  .alert-number { color: #4ecdc4; }
        .alert-card.doble       .alert-number { color: #f39c12; }

        .alert-label {
            font-size: 14px;
            color: #666;
            font-weight: 600;
        }

        .alert-sublabel {
            font-size: 12px;
            color: #999;
            margin-top: 2px;
        }

        /* Tabla */
        .table-container {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        table.dataTable {
            width: 100% !important;
            border-collapse: collapse;
        }

        table.dataTable thead th {
            padding: 18px 15px;
            text-align: left;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border-bottom: 2px solid #e0e0e0;
            background: #4ecdc4 !important;
            color: white;
        }

        table.dataTable tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s;
        }

        table.dataTable tbody tr:hover { background: #f8f9fa; }

        table.dataTable tbody td {
            padding: 18px 15px;
            color: #666;
            vertical-align: middle;
        }

        .patient-name {
            font-weight: 600;
            color: #0e0d0d;
            font-size: 1rem;
        }

        .date-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .date-badge.ingreso { background: #e3f2fd; color: #1976d2; }
        .date-badge.alta    { background: #e8f5e9; color: #388e3c; }

        .dias-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            color: white;
        }

        .motivo-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            background: #fff3cd;
            color: #856404;
        }

        .observaciones-text {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* DataTables personalizado */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter { margin-bottom: 20px; }

        .dataTables_wrapper .dataTables_filter input {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 8px 15px;
            margin-left: 10px;
            transition: all 0.3s;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            outline: none;
            border-color: #4ecdc4;
            box-shadow: 0 0 0 0.2rem rgba(78,205,196,0.25);
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
            background: #f8f9fa !important;
            border-color: #e0e0e0 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%) !important;
            color: white !important;
            border-color: #4ecdc4 !important;
        }

        .dataTables_wrapper .dataTables_info {
            font-size: 14px;
            padding-top: 15px;
            color: #666;
        }

        @media (max-width: 768px) {
            .main-container { padding: 80px 15px 40px; }
            .table-container { padding: 15px; }
        }
    </style>

    <div class="main-container">

        <h2 class="text-info-emphasis">
            Historial de Altas
        </h2>

        {{-- ── Alert Cards ── --}}


        <div class="stock-alerts">

            {{-- Total de altas --}}
            <div class="alert-card individual">
                <div class="alert-card-header">
                    <div>
                        <div class="alert-number">{{ $totalAltas }}</div>
                        <div class="alert-label">Total Pacientes de Alta</div>
                        <div class="alert-sublabel">Registros </div>
                    </div>
                    <div class="alert-card-icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                </div>
            </div>

            {{-- Altas este mes --}}
            <div class="alert-card doble">
                <div class="alert-card-header">
                    <div>
                        <div class="alert-number">{{ $altasMes }}</div>
                        <div class="alert-label">Altas Este Mes</div>
                        <div class="alert-sublabel">{{ \Carbon\Carbon::now()->locale('es')->translatedFormat('F Y') }}</div>                    </div>
                    <div class="alert-card-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
            </div>

            {{-- Promedio de días --}}
            <div class="alert-card emergencia">
                <div class="alert-card-header">
                    <div>
                        <div class="alert-number">{{ $promedioDias }}</div>
                        <div class="alert-label">Promedio de Días Internado</div>
                        <div class="alert-sublabel">Por paciente</div>
                    </div>
                    <div class="alert-card-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>

        </div>
        {{-- ── Fin Alert Cards ── --}}

        <div class="table-container">
            <table id="expedientesTable" class="table table-hover">
                <thead>
                <tr>
                    <th>Paciente</th>
                    <th>Identidad</th>
                    <th>Fecha Ingreso</th>
                    <th>Fecha Alta</th>
                    <th>Días</th>
                    <th>Motivo</th>
                    <th>Observaciones</th>
                </tr>
                </thead>
                <tbody class="table-group-divider">
                @forelse($pacientes as $asignacion)
                    <tr>
                        <td class="patient-name">
                            {{ $asignacion->paciente->nombres }} {{ $asignacion->paciente->apellidos }}
                        </td>
                        <td>
                            {{ $asignacion->paciente->numero_identidad }}
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($asignacion->fecha_asignacion)->format('d/m/Y') }}
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($asignacion->fecha_salida)->format('d/m/Y') }}
                        </td>
                        <td>
                            <span class="dias-badge">
                                <i class="fas fa-calendar-alt"></i>
                                {{ (int) \Carbon\Carbon::parse($asignacion->fecha_asignacion)->diffInDays(\Carbon\Carbon::parse($asignacion->fecha_salida)) }} días
                            </span>
                        </td>
                        <td>
                            {{ $asignacion->motivo_alta ?? '-' }}
                        </td>
                        <td>
                            {{ $asignacion->observaciones ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-inbox" style="font-size: 3rem; display: block; margin-bottom: 10px;"></i>
                            No se encontraron pacientes dados de alta
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#expedientesTable').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    processing:     "Procesando...",
                    search:         "Buscar:",
                    lengthMenu:     "Mostrar _MENU_ registros",
                    info:           "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty:      "Mostrando 0 a 0 de 0 registros",
                    infoFiltered:   "(filtrado de _MAX_ registros totales)",
                    loadingRecords: "Cargando...",
                    zeroRecords:    "No se encontraron registros",
                    emptyTable:     "No hay pacientes dados de alta",
                    paginate: {
                        first:    "Primero",
                        previous: "Anterior",
                        next:     "Siguiente",
                        last:     "Último"
                    }
                },
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, 'Todos']],
                order: [[3, 'desc']],
                columnDefs: [
                    { targets: 0, width: '220px' },
                    { targets: 2, width: '220px' },
                    { targets: 3, width: '220px' },
                    { targets: 4, width: '220px' },
                    { targets: 5, width: '220px' },
                    { targets: 6, orderable: false, width: '200px' }
                ]
            });

            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (el) { return new bootstrap.Tooltip(el); });
        });
    </script>

@endsection
