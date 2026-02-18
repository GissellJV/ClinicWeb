@extends('layouts.plantillaRecepcion')
@section('contenido')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .main-container {
            max-width: 1400px;
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
            text-align: left;
        }

        /* Estadísticas */
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

        /* ENCABEZADOS UNIFORMES - TODOS VERDES */
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
            padding: 16px 12px;
            color: #666;
            text-align: left;
            border: none;
            font-size: 14px;
        }

        /* Nombres de pacientes centrados y no clickeables */
        .patient-name {
            font-weight: 600;
            color: #333;
            font-size: 14px;
            display: block;
            text-align: left;
        }

        .doctor-name {
            color: #555;
            font-size: 14px;
            text-align: left;
        }

        /* ESTADOS - COLORES UNIFORMES */
        .badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            min-width: 120px;
            margin: 0 auto;
        }
        .badge-pill {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 13px;
            min-width: 120px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .bg-warning {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%) !important;
            color: #856404 !important;
            border: 1px solid #ffeaa7;
        }

        .bg-success {
            background: linear-gradient(135deg, #d4f4f0 0%, #b8e8e2 100%) !important;
            color: #0d5550 !important;
            border: 1px solid #b8e8e2;
        }

        .bg-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%) !important;
            color: #721c24 !important;
            border: 1px solid #f5c6cb;
        }

        .bg-info {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%) !important;
            color: #0c5460 !important;
            border: 1px solid #bee5eb;
        }

        .bg-secondary {
            background: linear-gradient(135deg, #e2e3e5 0%, #d6d8db 100%) !important;
            color: #383d41 !important;
            border: 1px solid #d6d8db;
        }


        .action-status {
            font-weight: 600;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 12px;
            border-radius: 20px;
            min-width: 130px;
            margin: 0 auto;
        }
        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: nowrap;
            align-items: center;
            justify-content: center;
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

        .text-success-action {
            background: linear-gradient(135deg, #d4f4f0 0%, #b8e8e2 100%);
            color: #0d5550;
            border: 1px solid #b8e8e2;
        }

        .text-danger-action {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .text-warning-action {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        .text-muted-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 12px;
            min-width: 130px;
            margin: 0 auto;
        }
        .text-muted{
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 12px;
            min-width: 130px;
            margin: 0 auto;
        }



        /* BOTÓN ASIGNAR HABITACIÓN - VERDE COMO LOS ENCABEZADOS */
        .btn-habitacion {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            color: white !important;
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
            text-decoration-line: none;
        }

        .btn-habitacion:hover {
            background: linear-gradient(135deg, #44a08d 0%, #3a8f7f 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(78, 205, 196, 0.3);
            color: white;
            text-decoration: none;
        }

        /* Botón Confirmar */
        .btn-confirmar {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 13px;
            min-width: 130px;
            margin: 0 auto;
            box-shadow: 0 2px 8px rgba(78, 205, 196, 0.2);
        }

        .btn-confirmar:hover {
            background: linear-gradient(135deg, #44a08d 0%, #3a8f7f 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(78, 205, 196, 0.3);
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

        }
            .text-info-emphasis {
            font-weight: bold;
        }
    </style>

    <div class="main-container">
        <br><br>
        <h1 class="text-info-emphasis">Pacientes con Citas Programadas</h1>

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
                    <p style="margin: 5px 0 0 0; font-size: 17px;">{{ session('success') }}</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger " role="alert" style="
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
                    <p style="margin: 5px 0 0 0; font-size: 17px;">{{ session('error') }}</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
            <table id="citasTable" class="table table-hover display nowrap" style="width:100%">
                <thead>
                <tr>
                    <th class="text-center">PACIENTE</th>
                    <th class="text-center">DOCTOR</th>
                    <th class="text-center">FECHA</th>
                    <th class="text-center">HORA</th>
                    <th class="text-center">ESPECIALIDAD</th>
                    <th class="text-center">ESTADO</th>
                    <th colspan="2" class="text-center">ACCIÓN</th>
                    <th class="text-center">MOTIVO</th>

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
                                @elseif($cita->estado == 'reprogramada') bg-danger
                                @elseif($cita->estado == 'completada') bg-secondary
                                @endif">

                                {{ ucfirst($cita->estado) }}
                            </span>
                        </td>
                        <td class="action-buttons">

                            @if($cita->estado == 'pendiente')
                                <form action="{{ route('citas.confirmar', $cita->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-sm btn-success">
                                        <i class="fas fa-check"></i> Confirmar
                                    </button>
                                </form>
                            @elseif($cita->estado == 'programada')
                                <span class="text-success fw-bold"> Confirmada</span>
                            @elseif($cita->estado == 'cancelada')
                                <span class="text-danger fw-bold"> Cancelada</span>
                            @elseif($cita->estado == 'reprogramada')
                                <span class=" fw-bold" style=" color: #A55B65"> Reprogramada</span>
                            @else
                                <span class="text-muted fw-bold">Finalizada</span>
                            @endif
                        </td>
                        <td>
                            @if($cita->paciente && in_array($cita->estado, ['programada', 'pendiente', 'reprogramada']))
                                <a href="{{ route('recepcionista.habitaciones.asignar', ['paciente_id' => $cita->paciente->id]) }}"
                                   class="btn-habitacion fw-bold">
                                   Asignar Habitación
                                </a>
                            @else
                                <span class="action-buttons text-muted-action fw-bold">
                                  No disponible
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($cita->estado == 'cancelada')
                                {{ $cita->motivo_cancelacion ?? 'Sin motivo' }}
                            @else
                                 —
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <i class="fas fa-calendar-times fa-2x text-muted mb-3"></i><br>
                            No hay citas programadas
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#citasTable').DataTable({
                responsive: false,
                autoWidth: false,
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                scrollX: false,
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
                order: [[2, 'desc']],
                columnDefs: [
                    {
                        targets: [6, 7],
                        orderable: false,
                        searchable: false
                    },
                    {
                        targets: '_all',
                        className: 'text-center'
                    }
                ],
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>'
            });

            function actualizarContadores() {
                let pendientes = 0;
                let programadas = 0;
                let reprogramadas = 0;
                let completadas = 0;

                table.rows({search: 'applied'}).every(function() {
                    const node = this.node();
                    const estado = $(node).data('estado');

                    if (estado === 'pendiente') {
                        pendientes++;
                    } else if (estado === 'programada') {
                        programadas++;
                    } else if (estado === 'reprogramada') {
                        reprogramadas++;
                    } else if (estado === 'completada') {
                        completadas++;
                    }
                });

                $('#pendientesCount').text(pendientes);
                $('#confirmadasCount').text(programadas);
                $('#reprogramadasCount').text(reprogramadas);
                $('#completadasCount').text(completadas);
            }

            actualizarContadores();

            table.on('search.dt', function() {
                actualizarContadores();
            });

            // Prevenir clics en nombres de pacientes
            $(document).on('click', '.patient-name', function(e) {
                e.preventDefault();
                e.stopPropagation();
                return false;
            });
        });
    </script>

@endsection
