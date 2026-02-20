@extends('layouts.plantillaRecepcion')

@section('title', 'Habitaciones Ocupadas')

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
            padding-top: 100px;
        }

        .administracion .btn {
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .administracion .btn-primary {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            color: white;
        }

        .administracion .btn-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(78, 205, 196, 0.3);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: scale(1.05);
        }

        /* Alertas de Estadísticas */
        .stock-alerts {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .alert-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border-left: 5px solid;
            transition: all 0.3s;
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

        .alert-card.total {
            border-left-color: #2c3e50;
            background: linear-gradient(135deg, #fff 0%, #e8eaf0 100%);
        }

        .alert-number {
            font-size: 32px;
            font-weight: 700;
        }

        .alert-card.emergencia .alert-number {
            color: #e74c3c;
        }

        .alert-card.individual .alert-number {
            color: #4ecdc4;
        }

        .alert-card.doble .alert-number {
            color: #f39c12;
        }

        .alert-card.total .alert-number {
            color: #2c3e50;
        }

        .alert-label {
            font-size: 14px;
            color: #666;
            font-weight: 600;
        }

        .administracion .inventory-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            overflow: visible;
            padding: 25px;
            margin: 0 -15px;
        }

        .administracion .table-container {
            overflow-x: visible !important;
            width: 100%;
            margin: 0 auto;
        }

        .container {
            max-width: 100% !important;
            padding: 0 30px;
        }

        table.dataTable {
            width: 100% !important;
            border-collapse: collapse;
            table-layout: auto;
            white-space: nowrap;
        }

        table.dataTable thead th {
            padding: 20px;
            text-align: center;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border-bottom: 2px solid #e0e0e0;
            color: #2c3e50;
            background: white;
            white-space: normal;
            word-wrap: break-word;
        }

        table.dataTable tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s;
        }

        table.dataTable tbody tr:hover {
            background: #f8f9fa;
        }

        table.dataTable tbody td {
            padding: 20px 15px;
            color: #666;
            white-space: normal;
            vertical-align: middle;
            word-wrap: break-word;
        }

        /* Resaltar filas según tipo de habitación */
        table.dataTable tbody tr.tipo-emergencia {
            background-color: #ffe5e5 !important;
        }

        table.dataTable tbody tr.tipo-individual {
            background-color: #e5f9f7 !important;
        }

        table.dataTable tbody tr.tipo-doble {
            background-color: #fff4e5 !important;
        }

        table.dataTable tbody tr.tipo-emergencia:hover {
            background-color: #ffd1d1 !important;
        }

        table.dataTable tbody tr.tipo-individual:hover {
            background-color: #ccf2ed !important;
        }

        table.dataTable tbody tr.tipo-doble:hover {
            background-color: #ffe5cc !important;
        }

        table.dataTable tbody tr.tipo-uci {
            background-color: #e8eaf0 !important;
        }

        table.dataTable tbody tr.tipo-uci:hover {
            background-color: #d4d7e0 !important;
        }

        .administracion .patient-name {
            font-weight: 600;
            color: #333;
            font-size: 16px;
            white-space: nowrap;
        }

        .administracion .badge-tipo {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
        }

        .badge-tipo.tipo-emergencia {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-tipo.tipo-individual {
            background: #d4f4f0;
            color: #0d5550;
        }

        .badge-tipo.tipo-doble {
            background: #fff3cd;
            color: #856404;
        }

        .badge-tipo.tipo-uci {
            background: #e8eaf0;
            color: #2c3e50;
        }

        .habitacion-badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 16px;
        }

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

        .btn-liberar {
            background: #f39c12;
            color: white;
        }

        .btn-liberar:hover {
            background: #e67e22;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(243, 156, 18, 0.3);
        }

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
            .administracion .inventory-card {
                padding: 15px;
                margin: 0;
            }

            table.dataTable thead th,
            table.dataTable tbody td {
                padding: 15px 10px;
            }

            .stock-alerts {
                grid-template-columns: 1fr;
            }

            .container {
                padding: 0 15px;
            }

            .btn-sm {
                min-width: 90px;
                padding: 8px 12px;
                font-size: 13px;
            }
        }
        table.dataTable thead th {
            padding: 20px;
            text-align: left;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border-bottom: 2px solid #e0e0e0;
            background:  #4ecdc4 !important;
            color: white;
            white-space: nowrap;
        }
        .text-info-emphasis {

            font-weight: bold;
        }
    </style>

    <div class="administracion">
        <div class="container mt-5 pt-5">
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

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="text-info-emphasis">
                    <i class="fas fa-bed me-2"></i>Habitaciones Ocupadas
                </h2>


            </div>

            @if($asignaciones->isEmpty())
                <div class="inventory-card text-center py-5">
                    <i class="fas fa-bed fa-3x mb-3" style="color: #4ECDC4;"></i>
                    <h5 style="color: #4ECDC4;">No hay habitaciones ocupadas</h5>
                    <p class="text-muted">Actualmente todas las habitaciones están disponibles</p>
                    <a href="{{ route('recepcionista.habitaciones.asignar') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus"></i> Asignar Primera Habitación

                    </a>

                </div>
            @else
                <!-- Estadísticas por tipo de habitación -->
                <div class="stock-alerts">
                    @php
                        $porTipo = $asignaciones->groupBy(function($item) {
                            return $item->habitacion->tipo;
                        });
                        $emergencia = $porTipo->get('emergencia', collect())->count();
                        $individual = $porTipo->get('individual', collect())->count();
                        $doble = $porTipo->get('doble', collect())->count();
                        $uci = $porTipo->get('uci', collect())->count();
                    @endphp

                    <div class="alert-card total">
                        <div>
                            <div class="alert-number" id="uciCount">{{ $uci }}</div>
                            <div class="alert-label">
                                <i class="fas fa-heartbeat me-1"></i>UCI
                            </div>
                        </div>
                        <small style="color: #666;">Unidad de Cuidados Intensivos</small>
                    </div>

                    <div class="alert-card emergencia">
                        <div>
                            <div class="alert-number" id="emergenciaCount">{{ $emergencia }}</div>
                            <div class="alert-label">
                                <i class="fas fa-ambulance me-1"></i>Emergencia
                            </div>
                        </div>
                        <small style="color: #666;">Atención Inmediata</small>
                    </div>

                    <div class="alert-card individual">
                        <div>
                            <div class="alert-number" id="individualCount">{{ $individual }}</div>
                            <div class="alert-label">
                                <i class="fas fa-user me-1"></i>Individual
                            </div>
                        </div>
                        <small style="color: #666;">Hospitalización Estándar</small>
                    </div>

                    <div class="alert-card doble">
                        <div>
                            <div class="alert-number" id="dobleCount">{{ $doble }}</div>
                            <div class="alert-label">
                                <i class="fas fa-users me-1"></i>Doble
                            </div>
                        </div>
                        <small style="color: #666;">Hospitalización Compartida</small>
                    </div>
                </div>

                <!-- DataTable -->
                <div class="inventory-card">
                    <div class="table-container">
                        <table id="habitacionesTable" class="table table-hover">
                            <thead>
                            <tr>
                                <th>Habitación</th>
                                <th>Tipo</th>
                                <th>Paciente</th>
                                <th>Identidad</th>
                                <th>Teléfono</th>
                                <th>Ingreso</th>
                                <th>Días</th>
                                <th>Observaciones</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($asignaciones as $asignacion)
                                @php
                                    $tipoClass = 'tipo-' . strtolower($asignacion->habitacion->tipo);
                                    $badgeClass = 'badge-tipo tipo-' . strtolower($asignacion->habitacion->tipo);
                                @endphp

                                <tr class="{{ $tipoClass }}" data-tipo="{{ strtolower($asignacion->habitacion->tipo) }}">
                                    <td>
                                            <span class="habitacion-badge">
                                                {{ $asignacion->habitacion->numero_habitacion }}
                                            </span>
                                    </td>
                                    <td>
                                            <span class="{{ $badgeClass }}">
                                                @if($asignacion->habitacion->tipo == 'emergencia')
                                                    <i class="fas fa-ambulance"></i>
                                                @elseif($asignacion->habitacion->tipo == 'individual')
                                                    <i class="fas fa-user"></i>
                                                @else
                                                    <i class="fas fa-users"></i>
                                                @endif
                                                {{ ucfirst($asignacion->habitacion->tipo) }}
                                            </span>
                                    </td>
                                    <td class="patient-name">
                                        {{ $asignacion->paciente->nombres }} {{ $asignacion->paciente->apellidos }}
                                    </td>
                                    <td>{{ $asignacion->paciente->numero_identidad }}</td>
                                    <td>{{ $asignacion->paciente->telefono }}</td>
                                    <td>{{ $asignacion->fecha_asignacion->format('d/m/Y H:i') }}</td>
                                    <td>
                                            <span class="dias-badge">
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ $asignacion->fecha_asignacion->startOfDay()->diffInDays(now()->startOfDay()) + 1 }} días
                                            </span>
                                    </td>
                                    <td>
                                        @if($asignacion->observaciones)
                                            {{ Str::limit($asignacion->observaciones, 30) }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn-sm btn-liberar"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalLiberar{{ $asignacion->id }}">
                                            <i class="fas fa-door-open"></i> Liberar
                                        </button>

                                        <!-- Modal de Confirmación -->
                                        <div class="modal fade" id="modalLiberar{{ $asignacion->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content" style="border-radius: 15px; border: none;">
                                                    <div class="modal-header text-white" style="background: linear-gradient(135deg, #4ecdc4 0%, #4FC3C3 100%);">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-exclamation-triangle"></i> Confirmar Liberación
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body" style="padding: 30px;">
                                                        <p class="mb-2">¿Está seguro de que desea liberar la habitación?</p>
                                                        <div class="alert alert-info mb-0">
                                                            <strong>Habitación:</strong> {{ $asignacion->habitacion->numero_habitacion }}<br>
                                                            <strong>Paciente:</strong> {{ $asignacion->paciente->nombres }} {{ $asignacion->paciente->apellidos }}<br>
                                                            <small class="text-muted">El paciente será dado de alta.</small>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer" style="gap: 10px;">
                                                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                                                            <i class="fas fa-times"></i> Cancelar
                                                        </button>
                                                        <form action="{{ route('recepcionista.habitaciones.liberar', $asignacion->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-register">
                                                                <i class="fas fa-door-open"></i> Sí, Liberar
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
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
            var table = $('#habitacionesTable').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    processing: "Procesando...",
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ registros",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty: "Mostrando 0 a 0 de 0 registros",
                    infoFiltered: "(filtrado de _MAX_ registros totales)",
                    loadingRecords: "Cargando...",
                    zeroRecords: "No se encontraron registros",
                    emptyTable: "No hay habitaciones ocupadas",
                    paginate: {
                        first: "Primero",
                        previous: "Anterior",
                        next: "Siguiente",
                        last: "Último"
                    }
                },
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, 'Todos']],
                order: [[5, 'desc']], // Ordenar por fecha de ingreso descendente
                scrollX: false,
                columnDefs: [
                    {
                        targets: 8, // Columna de acciones
                        orderable: false,
                        searchable: false,
                        width: '120px'
                    },
                    {
                        targets: 7, // Columna de observaciones
                        width: '200px'
                    }
                ]
            });

            // Actualizar contadores cuando se filtra la tabla
            function actualizarContadores() {
                let emergencia = 0;
                let individual = 0;
                let doble = 0;
                let uci = 0;

                table.rows({search: 'applied'}).every(function() {
                    const node = this.node();
                    const tipo = $(node).data('tipo');

                    if (tipo === 'emergencia') {
                        emergencia++;
                    } else if (tipo === 'individual') {
                        individual++;
                    } else if (tipo === 'doble') {
                        doble++;
                    } else if (tipo === 'uci') {
                        uci++;
                    }
                });

                $('#emergenciaCount').text(emergencia);
                $('#individualCount').text(individual);
                $('#dobleCount').text(doble);
                $('#uciCount').text(uci);
            }

            // Actualizar contadores al buscar/filtrar
            table.on('search.dt', function() {
                actualizarContadores();
            });

            // Inicializar contadores
            actualizarContadores();
        });
    </script>

@endsection
