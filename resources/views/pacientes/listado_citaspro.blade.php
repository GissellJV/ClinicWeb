@extends('layouts.plantillaRecepcion')
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

        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px 15px;
        }

        @media (min-width: 1400px) {
            .main-container {
                max-width: 1320px;
            }
        }

        h1 {
            color: #0f766e;
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 30px;
        }

        .alert {
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
        }

        /* Estadísticas - Mismo estilo que habitaciones ocupadas */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border-left: 5px solid;
            transition: all 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        }

        /* Completadas - Gris azulado */
        .stat-card.completadas {
            border-left-color: #2c3e50;
            background: linear-gradient(135deg, #fff 0%, #e8eaf0 100%);
        }

        .stat-card.completadas h3 {
            color: #2c3e50;
        }

        /* Pendientes - Amarillo */
        .stat-card.pendientes {
            border-left-color: #f39c12;
            background: linear-gradient(135deg, #fff 0%, #fff4e5 100%);
        }

        .stat-card.pendientes h3 {
            color: #f39c12;
        }

        /* Confirmadas - Turquesa */
        .stat-card.confirmadas {
            border-left-color: #4ecdc4;
            background: linear-gradient(135deg, #fff 0%, #e5f9f7 100%);
        }

        .stat-card.confirmadas h3 {
            color: #4ecdc4;
        }

        /* Reprogramadas - Rojo */
        .stat-card.reprogramadas {
            border-left-color: #e74c3c;
            background: linear-gradient(135deg, #fff 0%, #ffe5e5 100%);
        }

        .stat-card.reprogramadas h3 {
            color: #e74c3c;
        }

        .stat-card h3 {
            font-size: 32px;
            font-weight: 700;
            margin: 0;
        }

        .stat-card p {
            color: #666;
            margin: 5px 0 0 0;
            font-size: 14px;
            font-weight: 600;
        }

        .stat-card small {
            color: #666;
            font-size: 0.85rem;
        }

        /* Tabla Container */
        .table-container-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            overflow: visible;
            padding: 25px;
        }

        .table-container {
            overflow-x: visible;
            width: 100%;
            margin: 0 auto;
        }

        table.dataTable {
            width: 100% !important;
            border-collapse: collapse;
            table-layout: auto;
            white-space: nowrap;
        }

        table.dataTable thead th {
            padding: 20px;
            text-align: left;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border-bottom: 2px solid #e0e0e0;
            background: #4ecdc4 !important;
            color: white;
            white-space: nowrap;
        }

        table.dataTable tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s;
        }

        table.dataTable tbody tr:hover {
            background: #f0fdfa;
            transform: scale(1.01);
        }

        table.dataTable tbody td {
            padding: 20px;
            color: #666;
            white-space: nowrap;
            vertical-align: middle;
        }

        .patient-name {
            font-weight: 600;
            color: #333;
            font-size: 16px;
        }

        .doctor-name {
            color: #555;
            font-size: 15px;
        }

        .badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .bg-warning {
            background: #fff3cd !important;
            color: #856404 !important;
        }

        .bg-success {
            background: #d4f4f0 !important;
            color: #0d5550 !important;
        }

        .bg-danger {
            background: #f8d7da !important;
            color: #721c24 !important;
        }

        .bg-info {
            border-left-color:#e74c3c;
            background:linear-gradient(135deg, #fff 0%, #ffe5e5 100%);
            color: #721c24 !important;
        }

        .bg-secondary {
            background: #6b7280 !important;
            color: white !important;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: nowrap;
        }

        .btn-sm {
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            min-width: 110px;
            justify-content: center;
        }

        .btn-success {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            color: white;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #44a08d 0%, #3a8f7f 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(78, 205, 196, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }

        /* DataTables */
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
        }

        @media (max-width: 1200px) {
            .table-container-card {
                padding: 15px;
            }

            table.dataTable thead th,
            table.dataTable tbody td {
                padding: 15px 10px;
            }

            .stats-container {
                grid-template-columns: 1fr;
            }

            .main-container {
                padding: 20px 10px;
            }

            .btn-sm {
                min-width: 90px;
                padding: 8px 12px;
                font-size: 13px;
            }
        }

        .text-info-emphasis {
            font-weight: bold;
        }
    </style>

    <div class="main-container">
        <br><br>
        <h1 class="text-info-emphasis">Pacientes con Citas Programadas</h1>

        @if(session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif

        <!-- Estadísticas rápidas -->
        <div class="stats-container">
            <div class="stat-card completadas">
                <div>
                    <h3 id="completadasCount">0</h3>
                    <p><i class="fas fa-check-circle me-1"></i>Completadas</p>
                </div>
                <small>Citas finalizadas</small>
            </div>
            <div class="stat-card pendientes">
                <div>
                    <h3 id="pendientesCount">0</h3>
                    <p><i class="fas fa-clock me-1"></i>Pendientes</p>
                </div>
                <small>Por confirmar</small>
            </div>
            <div class="stat-card confirmadas">
                <div>
                    <h3 id="confirmadasCount">0</h3>
                    <p><i class="fas fa-calendar-check me-1"></i>Confirmadas</p>
                </div>
                <small>Programadas</small>
            </div>
            <div class="stat-card reprogramadas">
                <div>
                    <h3 id="reprogramadasCount">0</h3>
                    <p><i class="fas fa-redo me-1"></i>Reprogramadas</p>
                </div>
                <small>Cambios de fecha</small>
            </div>
        </div>

        <div class="table-container-card">
            <div class="table-container">
                <table id="citasTable" class="table table-hover">
                    <thead>
                    <tr>
                        <th>Paciente</th>
                        <th>Doctor</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Especialidad</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($citas as $cita)
                        <tr data-estado="{{ $cita->estado }}">
                            <td>
                                <span class="patient-name">
                                    @if($cita->paciente)
                                        {{ $cita->paciente->nombres }} {{ $cita->paciente->apellidos }}
                                    @else
                                        {{ $cita->paciente_nombre ?? 'No Definido' }}
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span class="doctor-name">
                                    @if($cita->doctor)
                                        {{ $cita->doctor->genero === 'Femenino' ? 'Dra.' : 'Dr.' }} {{ $cita->doctor->nombre }} {{ $cita->doctor->apellido ?? '' }}
                                    @else
                                        {{ $cita->doctor_nombre ?? 'No Definido' }}
                                    @endif
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</td>
                            <td><strong>{{ $cita->hora }}</strong></td>
                            <td>{{ $cita->especialidad ?? 'No definida' }}</td>
                            <td>
                                <span class="badge
                                    @if($cita->estado == 'pendiente') bg-warning
                                    @elseif($cita->estado == 'programada') bg-success
                                    @elseif($cita->estado == 'cancelada') bg-danger
                                    @elseif($cita->estado == 'reprogramada') bg-info
                                    @else bg-secondary @endif">
                                    {{ ucfirst($cita->estado) }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    @if($cita->estado == 'pendiente')
                                        <form action="{{ route('citas.confirmar', $cita->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn-sm btn-success">
                                                <i class="fas fa-check"></i> Confirmar
                                            </button>
                                        </form>
                                    @elseif($cita->estado == 'programada')
                                        <span class="text-success fw-bold">✓ Confirmada</span>
                                    @elseif($cita->estado == 'cancelada')
                                        <span class="text-danger fw-bold">✗ Cancelada</span>
                                    @elseif($cita->estado == 'reprogramada')
                                        <span class=" fw-bold" style=" color: #A55B65">↻ Reprogramada</span>
                                    @else
                                        <span class="text-muted">Sin acción</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- jQuery (necesario para DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inicializar DataTable
            var table = $('#citasTable').DataTable({
                responsive: true,
                autoWidth: false,
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                language: {
                    processing: "Procesando...",
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ registros",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty: "Mostrando 0 a 0 de 0 registros",
                    infoFiltered: "(filtrado de _MAX_ registros totales)",
                    loadingRecords: "Cargando...",
                    zeroRecords: "No se encontraron citas",
                    emptyTable: "No hay citas programadas",
                    paginate: {
                        first: "Primero",
                        previous: "Anterior",
                        next: "Siguiente",
                        last: "Último"
                    }
                },
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, 'Todos']],
                order: [[2, 'desc']], // Ordenar por fecha descendente
                columnDefs: [
                    {
                        targets: 6, // Columna de acciones
                        orderable: false,
                        searchable: false
                    }
                ],
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip'
            });

            // Función para actualizar contadores
            function actualizarContadores() {
                let pendientes = 0;
                let confirmadas = 0;
                let reprogramadas = 0;
                let completadas = 0;

                table.rows({search: 'applied'}).every(function() {
                    const node = this.node();
                    const estado = $(node).data('estado');

                    if (estado === 'pendiente') {
                        pendientes++;
                    } else if (estado === 'programada') {
                        confirmadas++;
                    } else if (estado === 'reprogramada') {
                        reprogramadas++;
                    } else if (estado === 'completada') {
                        completadas++;
                    }
                });

                $('#pendientesCount').text(pendientes);
                $('#confirmadasCount').text(confirmadas);
                $('#reprogramadasCount').text(reprogramadas);
                $('#completadasCount').text(completadas);
            }

            // Actualizar contadores al cargar
            actualizarContadores();

            // Actualizar contadores cuando se filtra la tabla
            table.on('search.dt', function() {
                actualizarContadores();
            });
        });
    </script>

@endsection
