@extends('layouts.plantillaRecepcion')
@section('titulo', 'Historial de Traslados')

@section('contenido')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <style>
        .traslados-container {
            max-width: 1200px;
            margin: 100px auto 50px auto;
            padding: 0 20px;
        }
        .page-header { text-align: center; margin-bottom: 35px; }
        .page-header h2 { color: #2c3e50; font-size: 2rem; margin-bottom: 8px; }
        .page-header p  { color: #7f8c8d; font-size: 1rem; }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 18px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.07);
            border-left: 5px solid;
            transition: transform 0.3s;
        }
        .stat-card:hover { transform: translateY(-4px); }
        .stat-card.total      { border-color: #3498db; background: linear-gradient(135deg,#fff,#e3f2fd); }
        .stat-card.pendiente  { border-color: #f39c12; background: linear-gradient(135deg,#fff,#fff4e5); }
        .stat-card.completado { border-color: #2ecc71; background: linear-gradient(135deg,#fff,#e8f8f0); }
        .stat-card.cancelado  { border-color: #e74c3c; background: linear-gradient(135deg,#fff,#fdecea); }
        .stat-number { font-size: 2.2rem; font-weight: 800; margin-bottom: 4px; }
        .stat-card.total      .stat-number { color: #3498db; }
        .stat-card.pendiente  .stat-number { color: #f39c12; }
        .stat-card.completado .stat-number { color: #2ecc71; }
        .stat-card.cancelado  .stat-number { color: #e74c3c; }
        .stat-label { font-size: 0.88rem; color: #666; font-weight: 600; }

        /* Igual que archivados */
        .table-container {
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            padding: 25px;
            margin-bottom: 30px;
        }
        .table-container h4 {
            font-size: 1.2rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .table-container h4 i { color: #4ECDC4; }

        table.dataTable {
            width: 100% !important;
            border-collapse: collapse;
        }
        table.dataTable thead th {
            padding: 20px;
            text-align: left;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border-bottom: 2px solid #e0e0e0;
            color: white !important;
            background: #4ecdc4 !important;
        }
        table.dataTable tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s;
        }
        table.dataTable tbody tr:hover { background: #f8f9fa; }
        table.dataTable tbody td {
            padding: 20px;
            color: #666;
            vertical-align: middle;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter { margin-bottom: 20px; }
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
        .dataTables_wrapper .dataTables_info { font-size: 14px; padding-top: 15px; }

        .patient-name { font-weight: 700; color: #2c3e50; }
        .unit-name    { font-weight: 600; color: #4ECDC4; }

        .badge-estado {
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            white-space: nowrap;
        }
        .badge-Pendiente  { background: #fff3cd; color: #856404; }
        .badge-Finalizado { background: #d4edda; color: #155724; }
        .badge-Cancelado  { background: #f8d7da; color: #721c24; }
        .badge-En-Curso   { background: #cce5ff; color: #004085; }
    </style>

    <div class="traslados-container">

        <div class="page-header">
            <h2><i class="bi bi-truck me-2" style="color:#4ECDC4;"></i>Historial de Traslados</h2>
            <p>Registro completo de traslados en ambulancia solicitados por los pacientes</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Estadísticas --}}
        <div class="stats-grid">
            <div class="stat-card total">
                <div class="stat-number">{{ $total }}</div>
                <div class="stat-label"><i class="bi bi-list-ul me-1"></i>Total Traslados</div>
            </div>
            <div class="stat-card pendiente">
                <div class="stat-number">{{ $pendientes }}</div>
                <div class="stat-label"><i class="bi bi-hourglass-split me-1"></i>Pendientes</div>
            </div>
            <div class="stat-card completado">
                <div class="stat-number">{{ $completados }}</div>
                <div class="stat-label"><i class="bi bi-check-circle me-1"></i>Finalizados</div>
            </div>
            <div class="stat-card cancelado">
                <div class="stat-number">{{ $cancelados }}</div>
                <div class="stat-label"><i class="bi bi-x-circle me-1"></i>Cancelados</div>
            </div>
        </div>

        {{-- Tabla --}}
        <div class="table-container">
            <h4><i class="bi bi-clock-history"></i>Registros de Traslados</h4>

            <table id="trasladosTable" class="table table-hover">
                <thead>
                <tr>
                    <th>PACIENTE</th>
                    <th>DESTINO</th>
                    <th>AMBULANCIA</th>
                    <th>FECHA Y HORA</th>
                    <th>COSTO</th>
                    <th>ESTADO</th>
                </tr>
                </thead>
                <tbody class="table-group-divider">
                @foreach($traslados as $traslado)
                    <tr>
                        <td>
                                <span class="patient-name">
                                    {{ $traslado->paciente->nombres ?? 'N/A' }}
                                    {{ $traslado->paciente->apellidos ?? '' }}
                                </span>
                        </td>
                        <td>
                            <i class="bi bi-geo-alt-fill me-1" style="color:#4ECDC4;"></i>
                            {{ $traslado->direccion_destino }}
                        </td>
                        <td>
                                <span class="unit-name">
                                    <i class="bi bi-truck me-1"></i>{{ $traslado->unidad_asignada }}
                                </span>
                        </td>
                        <td>
                            <i class="bi bi-calendar-event me-1" style="color:#888;"></i>
                            {{ \Carbon\Carbon::parse($traslado->fecha_traslado)->format('d/m/Y H:i') }}
                        </td>
                        <td>
                            <strong style="color:#2c3e50;">
                                L. {{ number_format($traslado->costo_estimado, 2) }}
                            </strong>
                        </td>
                        <td>
                                <span class="badge-estado badge-{{ str_replace(' ', '-', $traslado->estado) }}">
                                    {{ $traslado->estado }}
                                </span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
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
        $(document).ready(function() {
            $('#trasladosTable').DataTable({
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
                    zeroRecords:    "No se encontraron traslados",
                    emptyTable:     "No hay traslados registrados",
                    paginate: {
                        first:    "Primero",
                        previous: "Anterior",
                        next:     "Siguiente",
                        last:     "Último"
                    }
                },
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                order: [[3, 'desc']],
                columnDefs: [
                    { targets: 5, orderable: false, searchable: false }
                ]
            });
        });
    </script>

@endsection
