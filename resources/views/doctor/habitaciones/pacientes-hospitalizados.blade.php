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

        /* Alertas de Estadísticas */
        .stock-alerts {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
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
        }

        .administracion .table-container {
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
            color: #2c3e50;
            background: white;
            white-space: nowrap;
        }

        table.dataTable tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s;
        }

        table.dataTable tbody tr:hover {
            background: #f8f9fa;
        }

        table.dataTable tbody td {
            padding: 20px;
            color: #666;
            white-space: nowrap;
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
        .dataTables_wrapper .dataTables_info {
            font-size: 14px;
            padding-top: 15px;
        }

        @media (max-width: 1200px) {
            .administracion .inventory-card {
                padding: 15px;
            }

            table.dataTable thead th,
            table.dataTable tbody td {
                padding: 15px 10px;
            }

            .stock-alerts {
                grid-template-columns: 1fr;
            }
        }
        .text-info-emphasis {

            font-weight: bold;
            text-align: center;
        }
    </style>

    <div class="administracion">
        <br>
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

            <div class="page-header" style=" align-items: center; margin-bottom: 30px;">
                <h2 class=" text-info-emphasis" style="margin: 0;">
                    <i class="fas fa-user-md me-2"></i>Pacientes Hospitalizados
                </h2>

            </div>

            @if($asignaciones->isEmpty())
                <div class="inventory-card text-center py-5">
                    <i class="fas fa-bed fa-3x mb-3" style="color: #4ECDC4;"></i>
                    <h5 style="color: #4ECDC4;">No hay pacientes hospitalizados</h5>
                    <p class="text-muted">Actualmente no hay pacientes con habitación asignada</p>
                </div>
            @else
                <!-- Estadísticas por tipo de habitación -->
                <div class="stock-alerts">
                    <div class="alert-card" style="border-left-color: #2c3e50; background: linear-gradient(135deg, #fff 0%, #e8eaf0 100%);">
                        <div>
                            <div class="alert-number" id="uciCount" style="color: #2c3e50;">{{ $asignaciones->where('habitacion.tipo', 'uci')->count() }}</div>
                            <div class="alert-label">
                                <i class="fas fa-hospital-user me-1"></i>UCI
                            </div>
                        </div>
                        <small style="color: #666;">Unidad de Cuidados Intensivos</small>
                    </div>

                    <div class="alert-card emergencia">
                        <div>
                            <div class="alert-number" id="emergenciaCount">{{ $asignaciones->where('habitacion.tipo', 'emergencia')->count() }}</div>
                            <div class="alert-label">
                                <i class="fas fa-ambulance me-1"></i>Emergencia
                            </div>
                        </div>
                        <small style="color: #666;">Atención Inmediata</small>
                    </div>

                    <div class="alert-card individual">
                        <div>
                            <div class="alert-number" id="individualCount">{{ $asignaciones->where('habitacion.tipo', 'individual')->count() }}</div>
                            <div class="alert-label">
                                <i class="fas fa-user me-1"></i>Individual
                            </div>
                        </div>
                        <small style="color: #666;">Hospitalización Estándar</small>
                    </div>

                    <div class="alert-card doble">
                        <div>
                            <div class="alert-number" id="dobleCount">{{ $asignaciones->where('habitacion.tipo', 'doble')->count() }}</div>
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
                        <table id="pacientesTable" class="table table-hover">
                            <thead>
                            <tr>
                                <th>Habitación</th>
                                <th>Tipo</th>
                                <th>Paciente</th>
                                <th>Identidad</th>
                                <th>Teléfono</th>
                                <th>fecha Ingreso</th>
                                <th>Días</th>
                                <th>Observaciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($asignaciones as $asignacion)
                                @php
                                    $tipoClass = 'tipo-' . strtolower($asignacion->habitacion->tipo);
                                    $badgeClass = 'badge-tipo tipo-' . strtolower($asignacion->habitacion->tipo);
                                @endphp

                                <tr class="{{ $tipoClass }}" data-tipo="{{ $asignacion->habitacion->tipo }}">
                                    <td><strong>{{ $asignacion->habitacion->numero_habitacion }}</strong></td>
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
                                    <td class="patient-name">{{ $asignacion->paciente->nombres }} {{ $asignacion->paciente->apellidos }}</td>
                                    <td>{{ $asignacion->paciente->numero_identidad }}</td>
                                    <td>{{ $asignacion->paciente->telefono }}</td>
                                    <td>{{ $asignacion->fecha_asignacion->format('d/m/Y') }}</td>
                                    <td>
                                            <span class="dias-badge">
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ $asignacion->fecha_asignacion->startOfDay()->diffInDays(now()->startOfDay()) + 1 }} días
                                            </span>
                                    <td>{{ $asignacion->observaciones ?? '-' }}</td>
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
            var table = $('#pacientesTable').DataTable({
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
                    emptyTable: "No hay pacientes hospitalizados",
                    paginate: {
                        first: "Primero",
                        previous: "Anterior",
                        next: "Siguiente",
                        last: "Último"
                    }
                },
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                order: [[5, 'desc']], // Ordenar por fecha de ingreso descendente
                columnDefs: [
                    {
                        targets: 7, // Columna de observaciones
                        orderable: false,
                        searchable: true
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
                    const tipo = String($(node).data('tipo')).toLowerCase();

                    if (tipo === 'emergencia') {
                        emergencia++;
                    } else if (tipo === 'individual') {
                        individual++;
                    } else if (tipo === 'doble') {
                        doble++;
                    }else if (tipo === 'uci') {
                        uci++;
                    }
                });

                const total = emergencia + individual + doble + uci;

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
