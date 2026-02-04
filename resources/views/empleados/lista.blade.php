@extends('layouts.plantillaRecepcion')
<link rel="stylesheet" href="{{ asset('css/formulario.css') }}">
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@section('titulo', 'Lista de Empleados')

@section('contenido')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: whitesmoke;
        }

        .empleados-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 100px 20px 40px;
        }

        .text-info-emphasis {
            color: #2c3e50;
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 30px;
            text-align: center;
        }

        .alert-success-custom {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 18px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-size: 1.05rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-info-custom {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            padding: 60px 40px;
            text-align: center;
        }

        .alert-info-custom i {
            font-size: 4rem;
            color: #4ECDC4;
            margin-bottom: 20px;
        }

        .alert-info-custom h4 {
            color: #2c3e50;
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .alert-info-custom p {
            color: #7f8c8d;
            font-size: 1.1rem;
            margin-bottom: 20px;
        }

        /* Cards de Estadísticas */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
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
            border-left-color: #2c3e50;
            background: linear-gradient(135deg, #fff 0%, #e8eaf0 100%);
        }

        .stat-card.doctores {
            border-left-color: #4ecdc4;
            background: linear-gradient(135deg, #fff 0%, #e5f9f7 100%);
        }

        .stat-card.enfermeros {
            border-left-color: #f39c12;
            background: linear-gradient(135deg, #fff 0%, #fff4e5 100%);
        }

        .stat-card.recepcionistas {
            border-left-color: #e74c3c;
            background: linear-gradient(135deg, #fff 0%, #ffe5e5 100%);
        }

        .stat-card i {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .stat-card.total i {
            color: #4ECDC4;
        }

        .stat-card.doctores i {
            color: #4ECDC4;
        }

        .stat-card.enfermeros i {
            color: #f39c12;
        }

        .stat-card.recepcionistas i {
            color: #e74c3c;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-card.total .stat-number {
            color: #2c3e50;
        }

        .stat-card.doctores .stat-number {
            color: #4ecdc4;
        }

        .stat-card.enfermeros .stat-number {
            color: #f39c12;
        }

        .stat-card.recepcionistas .stat-number {
            color: #e74c3c;
        }

        .stat-label {
            font-size: 14px;
            color: #666;
            font-weight: 600;
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
        }

        table.dataTable thead th {
            padding: 18px;
            text-align: left;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border-bottom: 2px solid #e0e0e0;
            background: #4ECDC4;
            color: white;
            white-space: nowrap;
        }

        table.dataTable tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s;
        }

        table.dataTable tbody tr:hover {
            background: #f8fffe;
        }

        table.dataTable tbody td {
            padding: 18px;
            color: #555;
            vertical-align: middle;
        }

        .numero-empleado {
            background: #4ECDC4;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .nombre-empleado {
            font-weight: 600;
            color: #2c3e50;
            font-size: 15px;
        }

        .badge-custom {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .badge-doctor {
            background: #d4f4f0;
            color: #0d5550;
        }

        .badge-recepcionista {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-enfermero {
            background: #fff3cd;
            color: #856404;
        }

        .badge-default {
            background: #e2e8f0;
            color: #475569;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: nowrap;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 14px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
            text-decoration: none;
        }

        .btn-edit {
            background: #f59e0b;
            color: white;
        }

        .btn-edit:hover {
            background: #d97706;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        .btn-delete {
            background: #e74c3c;
            color: white;
        }

        .btn-delete:hover {
            background: #c0392b;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
        }

        .btn-nuevo {
            background: #4ECDC4;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .btn-nuevo:hover {
            background: #45b8b0;
            color: white;
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
            border-color: #4ECDC4;
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
            border: none !important;
            background: transparent !important;
            color: #6c757d !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            color: #6c757d !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            transform: none !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #4ECDC4 !important;
            color: white !important;
            border: none !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #45b8b0 !important;
            border: none !important;
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

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .empleados-container {
                padding: 80px 10px 20px;
            }
        }
        .alert-info-custom {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
            padding: 15px 45px 15px 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            font-size: 1.05rem;
            position: relative;
            text-align: left;

            border-left: solid #0c5460;
        }

        /* Botón en la esquina superior derecha */
        .alert-info-custom .btn-close {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        /* Botón + Nuevo Empleado */
        .btn-light {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-light:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 205, 196, 0.3);
            color: white;
        }

        /* === CONTENEDOR DEL MODAL === */
        .modal-content {
            background: #ffffff !important;
            border-radius: 22px !important;
            border: none !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
            overflow: hidden;
        }

        /* --- HEADER DEL MODAL --- */
        .modal-header {
            padding: 15px 20px !important;
            border-bottom: none !important;
        }

        .modal-title {
            color: #fff !important;
            margin: 0 !important;
            font-size: 26px !important;
            font-weight: 800 !important;
        }

        /* --- BOTÓN CERRAR --- */
        .btn-close {
            transition: transform .35s ease !important;
        }

        .btn-close:hover {
            transform: rotate(180deg) !important;
        }

        /* --- FOOTER DEL MODAL --- */
        .modal-footer {
            border-top: none !important;
            padding: 16px 24px !important;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        /* --- BOTONES --- */
        .modal-footer .btn-danger {
            border-radius: 10px !important;
            padding: 10px 20px !important;
            font-weight: 600 !important;
            transition: all 0.3s ease;
            border: none !important;
            cursor: pointer;
            color: white !important;
        }

        .modal-footer .btn-danger:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 0 15px rgba(255, 107, 107, 0.5) !important;
        }

        /* --- BODY DEL MODAL --- */
        .modal-body {
            padding: 30px !important;
        }

        /* --- PARÁGRAFOS DEL BODY --- */
        .modal-body p {
            font-size: 16px;
            color: #666;
            margin-bottom: 0.5rem;
        }

        .modal-body p small {
            font-size: 14px;
            color: #999;
        }
    </style>

    <div class="empleados-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-info-emphasis">
                Lista de Empleados
            </h1>
            <a href="{{ route('empleados.crear') }}" class="btn btn-light btn-sm">
               + Nuevo Empleado
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-info-custom">
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif


    @if($empleados->isEmpty())
            <div class="alert-info-custom">
                <i class="fas fa-users-slash"></i>
                <h4>No hay empleados registrados</h4>
                <p>Comienza agregando el primer empleado de la clínica</p>
                <a href="{{ route('empleados.crear') }}" class="btn-nuevo">
                    <i class="fas fa-plus"></i>
                    Registrar Primer Empleado
                </a>
            </div>
        @else
            <!-- Estadísticas -->
            <div class="stats-grid">
                <div class="stat-card total">
                    <div class="stat-number" id="totalCount">{{ $empleados->count() }}</div>
                    <div class="stat-label">Total Empleados</div>
                    <small style="color: #666;">Personal Activo</small>

                </div>

                <div class="stat-card doctores">
                    <div class="stat-number" id="doctoresCount">{{ $empleados->where('cargo', 'Doctor')->count() }}</div>
                    <div class="stat-label">Doctores</div>
                    <small style="color: #666;"> Personal Especialista</small>

                </div>

                <div class="stat-card enfermeros">
                    <div class="stat-number" id="enfermerosCount">{{ $empleados->where('cargo', 'Enfermero')->count() }}</div>
                    <div class="stat-label">Enfermeros</div>
                    <small style="color: #666;">Personal de Enfermeria</small>

                </div>

                <div class="stat-card recepcionistas">
                    <div class="stat-number" id="recepcionistasCount">{{ $empleados->where('cargo', 'Recepcionista')->count() }}</div>
                    <div class="stat-label">Recepcionistas</div>
                    <small style="color: #666;">Personal Administrativo</small>

                </div>
            </div>

            <!-- DataTable -->
            <div class="table-container-card">
                <div class="table-container">
                    <table id="empleadosTable" class="table table-hover">
                        <thead>
                        <tr>
                            <th>Nombre Completo</th>
                            <th>Identidad</th>
                            <th>Cargo</th>
                            <th>Departamento</th>
                            <th>Fecha Ingreso</th>
                            <th >Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($empleados as $empleado)
                            <tr data-cargo="{{ $empleado->cargo }}">

                                <td>
                                    <span class="nombre-empleado">
                                        {{ $empleado->nombre }} {{ $empleado->apellido }}
                                    </span>
                                </td>
                                <td>{{ $empleado->numero_identidad }}</td>
                                <td>
                                    @php
                                        $badgeClass = 'badge-default';
                                        if($empleado->cargo == 'Doctor') {
                                            $badgeClass = 'badge-doctor';
                                        } elseif($empleado->cargo == 'Recepcionista') {
                                            $badgeClass = 'badge-recepcionista';
                                        } elseif($empleado->cargo == 'Enfermero') {
                                            $badgeClass = 'badge-enfermero';
                                        }
                                    @endphp
                                    <span class="badge-custom {{ $badgeClass }}">
                                        {{ $empleado->cargo }}
                                    </span>
                                </td>
                                <td>{{ $empleado->departamento }}</td>
                                <td>{{ $empleado->fecha_ingreso->format('d/m/Y') }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('empleados.editar', $empleado->id) }}" class="btn-sm btn-edit">
                                            Editar
                                        </a>
                                        <button class="btn-sm btn-delete"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $empleado->id }}">
                                            Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal de Eliminar -->
                            <div class="modal fade" id="deleteModal{{ $empleado->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
                                        <div class="modal-header" style="border-bottom: 2px solid #f0f0f0;">
                                            <h5 class="modal-title">
                                                Confirmar Eliminación
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" style="padding: 30px;">
                                            <p style="font-size: 16px; color: #666;">
                                                ¿Estás seguro de que deseas eliminar al empleado <strong>{{ $empleado->nombre }} {{ $empleado->apellido }}</strong>?
                                            </p>
                                            <p style="font-size: 14px; color: #999;">
                                                Esta acción no se puede deshacer.
                                            </p>
                                        </div>
                                        <div class="modal-footer" style="border-top: 2px solid #f0f0f0; gap: 10px;">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px; padding: 10px 20px;">
                                                Cancelar
                                            </button>
                                            <form action="{{ route('empleados.eliminar', $empleado->id) }}" method="POST" style="margin: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" style="border-radius: 8px; padding: 10px 20px; background: #e74c3c; border: none;">
                                                   Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
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
            var table = $('#empleadosTable').DataTable({
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
                    zeroRecords: "No se encontraron empleados",
                    emptyTable: "No hay empleados registrados",
                    paginate: {
                        first: "Primero",
                        previous: "Anterior",
                        next: "Siguiente",
                        last: "Último"
                    }
                },
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                order: [[0, 'asc']], // Ordenar por número
                columnDefs: [
                    {
                        targets: 0, // Columna #
                        orderable: false
                    },
                    {
                        targets: 5, // Columna Acciones
                        orderable: false,
                        searchable: false
                    }
                ],
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip'
            });

            // Función para actualizar contadores
            function actualizarContadores() {
                let doctores = 0;
                let enfermeros = 0;
                let recepcionistas = 0;

                table.rows({search: 'applied'}).every(function() {
                    const node = this.node();
                    const cargo = $(node).data('cargo');

                    if (cargo === 'Doctor') {
                        doctores++;
                    } else if (cargo === 'Enfermero') {
                        enfermeros++;
                    } else if (cargo === 'Recepcionista') {
                        recepcionistas++;
                    }
                });

                const total = doctores + enfermeros + recepcionistas;

                $('#totalCount').text(total);
                $('#doctoresCount').text(doctores);
                $('#enfermerosCount').text(enfermeros);
                $('#recepcionistasCount').text(recepcionistas);
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
