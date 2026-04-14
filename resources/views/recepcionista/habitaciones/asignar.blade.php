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
<link rel="stylesheet" href="{{ asset('css/formulario.css') }}">

@section('contenido')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .main-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        h1 {
            color: #0f766e;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 30px;
            text-align: center;
        }

        .info-banner {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            color: white;
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            text-align: center;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            color: #555;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .form-label .required {
            color: #ef4444;
            margin-left: 4px;
        }

        .form-control, .form-select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s;
            background: white;
        }

        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: #4ecdc4;
            box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.1);
        }

        .form-select option {
            padding: 10px;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .helper-text {
            color: #666;
            font-size: 13px;
            margin-top: 5px;
        }

        .habitacion-info {
            background: #f0f9ff;
            padding: 10px 15px;
            border-radius: 8px;
            margin-top: 10px;
            color: #0369a1;
            font-size: 13px;
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 14px 20px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-asignar {
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

        .btn-asignar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
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
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }

        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            border: none;
        }

        .alert-success {
            background: #d4f4f0;
            color: #0d5550;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .alert-info {
            background: #fff4e5;
            color: #856404;
            border-left: 4px solid #f39c12;
        }

        .text-info-emphasis {
            font-weight: bold;
        }

        /* =========================
           MODAL SELECTOR CLINICWEB
        ========================= */

        .modal-selector .modal-content.selector-content {
            background: #fff;
            border: 3px solid #24f3e2;
            box-shadow: 0 0 20px rgba(36, 243, 226, 0.4);
            border-radius: 18px;
            overflow: hidden;
            padding: 0;
            animation: popSelector 0.25s ease-out;
        }

        @keyframes popSelector {
            0% {
                transform: scale(.7);
                opacity: 0;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .modal-selector .selector-header {
            background: linear-gradient(90deg, #00e1ff, #00ffc8);
            padding: 15px 20px;
            border-bottom: none;
        }

        .modal-selector .modal-title {
            color: #fff;
            margin: 0;
            font-size: 26px;
            font-weight: 800;
        }

        .modal-selector .selector-close {
            filter: brightness(0) invert(1);
            transition: transform .35s ease, opacity .3s ease;
            opacity: 0.9;
        }

        .modal-selector .selector-close:hover {
            transform: rotate(180deg);
            opacity: 1;
        }

        .modal-selector .selector-body {
            padding: 24px 24px 18px;
            background: #fff;
        }

        .modal-selector .selector-footer {
            border-top: 1px solid #e5e5e5;
            padding: 18px 24px 22px;
            display: flex;
            justify-content: center;
            gap: 14px;
            background: #fff;
        }

        .table-container-modal {
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 20px;
        }

        .modal-selector table.dataTable {
            width: 100% !important;
            border-collapse: collapse;
        }

        .modal-selector table.dataTable thead th {
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

        .modal-selector table.dataTable tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s;
        }

        .modal-selector table.dataTable tbody tr:hover {
            background: #f8f9fa;
        }

        .modal-selector table.dataTable tbody td {
            padding: 18px;
            color: #666;
            vertical-align: middle;
        }

        .modal-selector .dataTables_wrapper .dataTables_length,
        .modal-selector .dataTables_wrapper .dataTables_filter {
            margin-bottom: 20px;
        }

        .modal-selector .dataTables_wrapper .dataTables_filter input {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 8px 15px;
            margin-left: 10px;
        }

        .modal-selector .dataTables_wrapper .dataTables_filter input:focus {
            outline: none;
            border-color: #4ecdc4;
            box-shadow: 0 0 0 0.25rem rgba(78, 205, 196, 0.25);
        }

        .modal-selector .dataTables_wrapper .dataTables_length select {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 5px 10px;
            margin: 0 10px;
        }

        .modal-selector .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 8px 12px !important;
            border-radius: 8px !important;
            transition: all 0.3s !important;
            box-shadow: none !important;
            font-weight: 600 !important;
        }

        .modal-selector .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            color: white !important;
            box-shadow: none !important;
            transform: translateY(-2px);
        }

        .modal-selector .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%) !important;
            color: white !important;
            border-color: #4ecdc4 !important;
        }

        .modal-selector .dataTables_wrapper .dataTables_info {
            font-size: 14px;
            padding-top: 15px;
        }

        .btn-modal-seleccionar {
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 13px;
            font-weight: 500;
            text-align: center;
            min-width: 120px;
            cursor: pointer;
            white-space: nowrap;
            background: linear-gradient(135deg, #4ecdc4 0%, #44b8af 100%);
            color: white;
            border: none;
        }

        .btn-modal-seleccionar:hover {
            background: linear-gradient(135deg, #44b8af 0%, #3aa39a 100%);
            box-shadow: 0 3px 10px rgba(78, 205, 196, 0.25);
            color: white;
        }

        .btn-open-selector {
            padding: 0.875rem 1.5rem;
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.3);
            white-space: nowrap;
        }

        .btn-open-selector:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
            color: white;
        }

        .btn-open-selector:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        #paciente_nombre,
        #habitacion_nombre {
            border: 2px solid #24f3e2;
            border-radius: 14px;
            background: white;
            padding: 10px 14px;
            font-size: 16px;
            box-shadow: 0 0 12px rgba(36, 243, 226, 0.20);
            transition: 0.2s;
        }

        #paciente_nombre:hover,
        #habitacion_nombre:hover {
            box-shadow: 0 0 18px rgba(36, 243, 226, 0.30);
        }

        .selector-inline {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        @media (max-width: 768px) {
            .button-group {
                flex-direction: column;
            }

            .selector-inline {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-open-selector {
                width: 100%;
            }
        }
    </style>

    <br><br>
    <h1 class="text-info-emphasis">Asignar Habitación a Paciente</h1>

    <div class="formulario">
        <div class="form-container">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            @if(count($habitacionesDisponibles) == 0)
                <div class="info-banner" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                    <i class="fas fa-exclamation-triangle"></i>
                    Todos los pacientes ya tienen habitación asignada.
                </div>
            @endif

            <form action="{{ route('recepcionista.habitaciones.store') }}" method="POST">
                @csrf

                <!-- Seleccionar Paciente -->
                <div class="form-group">
                    <label class="form-label">
                        @if($pacienteSeleccionado)
                            Paciente
                        @else
                            Seleccionar Paciente <span class="required">*</span>
                        @endif
                    </label>

                    @if($pacienteSeleccionado)
                        <input
                            type="text"
                            class="form-control"
                            value="{{ $pacienteSeleccionado->nombres }} - {{ $pacienteSeleccionado->numero_identidad }}"
                            readonly
                        >
                        <input type="hidden" name="paciente_id" value="{{ $pacienteSeleccionado->id }}">
                    @else
                        <input type="hidden" name="paciente_id" id="paciente_id" required>

                        <div class="selector-inline">
                            <input
                                type="text"
                                id="paciente_nombre"
                                class="form-control"
                                placeholder="Seleccione un paciente"
                                readonly
                                required
                            >

                            <button
                                type="button"
                                class="btn btn-open-selector"
                                data-bs-toggle="modal"
                                data-bs-target="#modalPacientes"
                                {{ count($pacientes) == 0 ? 'disabled' : '' }}
                            >
                                Buscar
                            </button>
                        </div>
                    @endif

                    @if(count($pacientes) == 0)
                        <p class="helper-text" style="color: #ef4444;">
                            <i class="fas fa-exclamation-triangle"></i>
                            No hay pacientes disponibles para asignar
                        </p>
                    @endif
                </div>

                <!-- Habitación Disponible -->
                <div class="form-group">
                    <label class="form-label">
                        Habitación Disponible <span class="required">*</span>
                    </label>

                    <input type="hidden" name="habitacion_id" id="habitacion_id" required>

                    <div class="selector-inline">
                        <input
                            type="text"
                            id="habitacion_nombre"
                            class="form-control"
                            placeholder="Seleccione una habitación"
                            readonly
                            required
                        >

                        <button
                            type="button"
                            class="btn btn-open-selector"
                            data-bs-toggle="modal"
                            data-bs-target="#modalHabitaciones"
                            {{ count($habitacionesDisponibles) == 0 ? 'disabled' : '' }}
                        >
                            Buscar
                        </button>
                    </div>

                    <div class="habitacion-info" id="habitacionInfo" style="display: none;">
                        <i class="fas fa-info-circle"></i>
                        <span id="habitacionDetalle"></span>
                    </div>
                </div>

                <div class="button-group">
                    <button
                        type="submit"
                        class="btn btn-asignar"
                        {{ count($habitacionesDisponibles) == 0 || (count($pacientes) == 0 && !$pacienteSeleccionado) ? 'disabled' : '' }}
                    >
                        <i class="fas fa-save"></i> Asignar Habitación
                    </button>

                    <a href="{{ route('listadocitas') }}" class="btn btn-cancel">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    @if(!$pacienteSeleccionado)
        <!-- Modal de Pacientes -->
        <div class="modal fade modal-selector" id="modalPacientes" tabindex="-1" aria-labelledby="modalPacientesLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content selector-content">
                    <div class="modal-header selector-header">
                        <h5 class="modal-title" id="modalPacientesLabel">Seleccionar Paciente</h5>
                        <button type="button" class="btn-close selector-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body selector-body">
                        <div class="table-container-modal">
                            <table id="tablaPacientesModal" class="table table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Identidad</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($pacientes as $paciente)
                                    <tr>
                                        <td>{{ $paciente->id }}</td>
                                        <td>{{ $paciente->numero_identidad ?? 'Sin identidad' }}</td>
                                        <td>{{ $paciente->nombres }}</td>
                                        <td>{{ $paciente->apellidos }}</td>
                                        <td>
                                            <button
                                                type="button"
                                                class="btn-modal-seleccionar seleccionar-paciente"
                                                data-id="{{ $paciente->id }}"
                                                data-nombre="{{ trim($paciente->nombres . ' ' . $paciente->apellidos) }}{{ $paciente->numero_identidad ? ' - ID: ' . $paciente->numero_identidad : '' }}"
                                            >
                                                Seleccionar
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="modal-footer selector-footer">
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal de Habitaciones -->
    <div class="modal fade modal-selector" id="modalHabitaciones" tabindex="-1" aria-labelledby="modalHabitacionesLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content selector-content">
                <div class="modal-header selector-header">
                    <h5 class="modal-title" id="modalHabitacionesLabel">Seleccionar Habitación</h5>
                    <button type="button" class="btn-close selector-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body selector-body">
                    <div class="table-container-modal">
                        <table id="tablaHabitacionesModal" class="table table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Número</th>
                                <th>Tipo</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($habitacionesDisponibles as $habitacion)
                                <tr>
                                    <td>{{ $habitacion->id }}</td>
                                    <td>{{ $habitacion->numero_habitacion }}</td>
                                    <td>{{ ucfirst($habitacion->tipo) }}</td>
                                    <td>{{ $habitacion->descripcion ?? 'Sin descripción' }}</td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn-modal-seleccionar seleccionar-habitacion"
                                            data-id="{{ $habitacion->id }}"
                                            data-nombre="Habitación {{ $habitacion->numero_habitacion }} - {{ ucfirst($habitacion->tipo) }}{{ $habitacion->descripcion ? ' (' . $habitacion->descripcion . ')' : '' }}"
                                        >
                                            Seleccionar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer selector-footer">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const habitacionIdInput = document.getElementById('habitacion_id');
            const habitacionNombreInput = document.getElementById('habitacion_nombre');
            const habitacionInfo = document.getElementById('habitacionInfo');
            const habitacionDetalle = document.getElementById('habitacionDetalle');

            @if(!$pacienteSeleccionado)
            const pacienteIdInput = document.getElementById('paciente_id');
            const pacienteNombreInput = document.getElementById('paciente_nombre');

            const tablaPacientes = $('#tablaPacientesModal').DataTable({
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
                    emptyTable: "No hay pacientes disponibles",
                    paginate: {
                        first: "Primero",
                        previous: "Anterior",
                        next: "Siguiente",
                        last: "Último"
                    }
                },
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                columnDefs: [
                    {
                        targets: 4,
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            function enlazarBotonesPaciente() {
                document.querySelectorAll('.seleccionar-paciente').forEach(boton => {
                    boton.addEventListener('click', function () {
                        pacienteIdInput.value = this.dataset.id;
                        pacienteNombreInput.value = this.dataset.nombre;

                        const modalElement = document.getElementById('modalPacientes');
                        const modalInstance = bootstrap.Modal.getOrCreateInstance(modalElement);
                        modalInstance.hide();
                    });
                });
            }

            enlazarBotonesPaciente();

            $('#modalPacientes').on('shown.bs.modal', function () {
                tablaPacientes.columns.adjust().responsive.recalc();
            });
            @endif

            const tablaHabitaciones = $('#tablaHabitacionesModal').DataTable({
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
                    emptyTable: "No hay habitaciones disponibles",
                    paginate: {
                        first: "Primero",
                        previous: "Anterior",
                        next: "Siguiente",
                        last: "Último"
                    }
                },
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                columnDefs: [
                    {
                        targets: 4,
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            function actualizarInfoHabitacion(texto) {
                if (texto) {
                    habitacionDetalle.textContent = texto;
                    habitacionInfo.style.display = 'block';
                } else {
                    habitacionDetalle.textContent = '';
                    habitacionInfo.style.display = 'none';
                }
            }

            function enlazarBotonesHabitacion() {
                document.querySelectorAll('.seleccionar-habitacion').forEach(boton => {
                    boton.addEventListener('click', function () {
                        habitacionIdInput.value = this.dataset.id;
                        habitacionNombreInput.value = this.dataset.nombre;
                        actualizarInfoHabitacion(this.dataset.nombre);

                        const modalElement = document.getElementById('modalHabitaciones');
                        const modalInstance = bootstrap.Modal.getOrCreateInstance(modalElement);
                        modalInstance.hide();
                    });
                });
            }

            enlazarBotonesHabitacion();

            $('#modalHabitaciones').on('shown.bs.modal', function () {
                tablaHabitaciones.columns.adjust().responsive.recalc();
            });
        });
    </script>
@endsection
