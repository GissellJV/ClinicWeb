@extends('layouts.plantillaRecepcion')
<link rel="stylesheet" href="{{ asset('css/formulario.css') }}">
@section('contenido')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <style>
        body{
            padding-top: 100px;
        }

        .agendar-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .header-section {
            text-align: center;
            margin-bottom: 30px;
            background: #82e9de;
            color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .agendar-form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border: 1px solid #e0e0e0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .button-group {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .btn-primary {
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

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        }

        .btn-secondary {
            padding: 0.875rem 2rem;
            background: white;
            border: 2px solid #dc3545;
            border-radius: 8px;
            color: #dc3545;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }

        .alert-success {
            background: #d4edda;
            color: #82e9de;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }

        .loading {
            display: none;
            text-align: center;
            padding: 10px;
            color: #82e9de;
        }

        small.text-danger {
            font-size: 0.875em;
        }

        .text-info-emphasis {
            font-weight: bold;
        }

        /* =========================
           MODALES SELECTOR CLINICWEB
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

        /* Interior tipo DataTable de expedientes */
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

        .btn-cancel {
            padding: 0.875rem 2rem;
            background: white;
            border: 2px solid #131212;
            border-radius: 8px;
            color: #221414;
            font-weight: 600;
            font-size: 1.05rem;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
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
        #doctor_nombre {
            border: 2px solid #24f3e2;
            border-radius: 14px;
            background: white;
            padding: 10px 14px;
            font-size: 16px;
            box-shadow: 0 0 12px rgba(36, 243, 226, 0.20);
            transition: 0.2s;
        }

        #paciente_nombre:hover,
        #doctor_nombre:hover {
            box-shadow: 0 0 18px rgba(36, 243, 226, 0.30);
        }

        @media (max-width: 768px) {
            .button-group {
                flex-direction: column;
            }

            .btn-open-selector {
                width: 100%;
            }
        }
    </style>

    <div class="formulario">
        <div class="register-section">
            <h1 class="text-center text-info-emphasis">Agendar Cita - Recepción</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div id="mensajeFormulario" class="alert alert-danger" style="display: none;"></div>

        <div class="form-container">
            <form method="POST" action="{{ route('recepcionista.citas.guardar') }}" id="agendarForm" novalidate>
                @csrf

                <div class="form-group">
                    <label class="form-label" for="paciente_nombre">Paciente</label>
                    <input type="hidden" id="paciente_id" name="paciente_id" required>

                    <div style="display: flex; gap: 10px; align-items: center;">
                        <input
                            type="text"
                            id="paciente_nombre"
                            class="form-control"
                            placeholder="Seleccione un paciente"
                            readonly
                            required
                        >

                        <button type="button" class="btn btn-open-selector" data-bs-toggle="modal" data-bs-target="#modalPacientes">
                            Buscar
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="especialidad" class="form-label">Especialidad</label>
                    <select id="especialidad" name="especialidad" class="form-control" required>
                        <option value="">Seleccionar especialidad</option>
                        @foreach($especialidades as $especialidad)
                            <option value="{{ $especialidad }}">{{ $especialidad }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="doctor_nombre" class="form-label">Doctor</label>
                    <input type="hidden" id="empleado_id" name="empleado_id" required>

                    <div style="display: flex; gap: 10px; align-items: center;">
                        <input
                            type="text"
                            id="doctor_nombre"
                            class="form-control"
                            placeholder="Seleccione un doctor"
                            readonly
                            required
                        >

                        <button type="button" class="btn btn-open-selector" id="btnAbrirModalDoctor" disabled>
                            Buscar
                        </button>
                    </div>

                    <div id="loadingDoctores" class="loading" style="display:none;">Cargando doctores...</div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="fecha">Fecha de la Cita</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" min="{{ date('Y-m-d') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="hora">Hora de la Cita</label>
                    <select class="form-control" id="hora" name="hora" required>
                        <option value="">Seleccionar hora</option>
                        <option value="08:00">08:00 AM</option>
                        <option value="09:00">09:00 AM</option>
                        <option value="10:00">10:00 AM</option>
                        <option value="11:00">11:00 AM</option>
                        <option value="14:00">02:00 PM</option>
                        <option value="15:00">03:00 PM</option>
                        <option value="16:00">04:00 PM</option>
                        <option value="17:00">05:00 PM</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="tipo_consulta">Tipo de Consulta</label>
                    <select class="form-control" id="tipo_consulta" name="tipo_consulta" required>
                        <option value="">Seleccionar tipo</option>
                        <option value="Primera vez">Primera vez</option>
                        <option value="Control">Control</option>
                        <option value="Emergencia">Emergencia</option>
                        <option value="Examen">Examen</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="motivo">Descripción (Opcional)</label>
                    <textarea class="form-control" id="motivo" name="motivo" rows="3" placeholder="motivo breve de la consulta"></textarea>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-calendar-check"></i> Agendar Cita
                    </button>
                    <a href="{{ route('listadocitas') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

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
                                    <td>{{ $paciente->numero_identidad }}</td>
                                    <td>{{ $paciente->nombres }}</td>
                                    <td>{{ $paciente->apellidos }}</td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn-modal-seleccionar seleccionar-paciente"
                                            data-id="{{ $paciente->id }}"
                                            data-nombre="{{ $paciente->nombres }} {{ $paciente->apellidos }}"
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

    <!-- Modal de Doctores -->
    <div class="modal fade modal-selector" id="modalDoctores" tabindex="-1" aria-labelledby="modalDoctoresLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content selector-content">
                <div class="modal-header selector-header">
                    <h5 class="modal-title" id="modalDoctoresLabel">Seleccionar Doctor</h5>
                    <button type="button" class="btn-close selector-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body selector-body">
                    <div class="table-container-modal">
                        <table id="tablaDoctoresModal" class="table table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre Completo</th>
                                <th>Especialidad</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer selector-footer">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancelar</button>
                </div>
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
        const btnAbrirModalDoctor = document.getElementById('btnAbrirModalDoctor');
        const especialidadSelect = document.getElementById('especialidad');
        const loadingDoctores = document.getElementById('loadingDoctores');
        const mensajeFormulario = document.getElementById('mensajeFormulario');

        function mostrarMensajeFormulario(mensaje) {
            if (mensajeFormulario) {
                mensajeFormulario.textContent = mensaje;
                mensajeFormulario.style.display = 'block';
            }
        }

        function limpiarMensajeFormulario() {
            if (mensajeFormulario) {
                mensajeFormulario.textContent = '';
                mensajeFormulario.style.display = 'none';
            }
        }

        function enlazarBotonesPaciente() {
            document.querySelectorAll('.seleccionar-paciente').forEach(boton => {
                boton.addEventListener('click', function () {
                    const id = this.dataset.id;
                    const nombre = this.dataset.nombre;

                    document.getElementById('paciente_id').value = id;
                    document.getElementById('paciente_nombre').value = nombre;

                    const modalElement = document.getElementById('modalPacientes');
                    const modalInstance = bootstrap.Modal.getOrCreateInstance(modalElement);
                    modalInstance.hide();

                    limpiarMensajeFormulario();
                });
            });
        }

        function enlazarBotonesDoctor() {
            document.querySelectorAll('.seleccionar-doctor').forEach(boton => {
                boton.addEventListener('click', function () {
                    const id = this.dataset.id;
                    const nombre = this.dataset.nombre;

                    document.getElementById('empleado_id').value = id;
                    document.getElementById('doctor_nombre').value = nombre;

                    const modalElement = document.getElementById('modalDoctores');
                    const modalInstance = bootstrap.Modal.getOrCreateInstance(modalElement);
                    modalInstance.hide();

                    limpiarMensajeFormulario();
                });
            });
        }

        $(document).ready(function() {
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

            const tablaDoctores = $('#tablaDoctoresModal').DataTable({
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
                    emptyTable: "No hay doctores disponibles",
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
                        targets: 3,
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            enlazarBotonesPaciente();

            $('#modalPacientes').on('shown.bs.modal', function () {
                tablaPacientes.columns.adjust().responsive.recalc();
            });

            $('#modalDoctores').on('shown.bs.modal', function () {
                tablaDoctores.columns.adjust().responsive.recalc();
            });

            especialidadSelect.addEventListener('change', function () {
                document.getElementById('empleado_id').value = '';
                document.getElementById('doctor_nombre').value = '';

                tablaDoctores.clear().draw();

                if (this.value) {
                    btnAbrirModalDoctor.disabled = false;
                    limpiarMensajeFormulario();
                } else {
                    btnAbrirModalDoctor.disabled = true;
                }
            });

            btnAbrirModalDoctor.addEventListener('click', function () {
                const especialidad = especialidadSelect.value;

                if (!especialidad) {
                    mostrarMensajeFormulario('Debe seleccionar una especialidad antes de buscar un doctor.');
                    return;
                }

                limpiarMensajeFormulario();
                loadingDoctores.style.display = 'block';

                tablaDoctores.clear().draw();

                fetch(`/recepcionista/doctores-especialidad/${encodeURIComponent(especialidad)}`)
                    .then(response => response.json())
                    .then(data => {
                        tablaDoctores.clear();

                        if (data.length > 0) {
                            data.forEach(doctor => {
                                const nombreCompleto = `${doctor.nombre ?? ''} ${doctor.apellido ?? ''}`.trim();

                                tablaDoctores.row.add([
                                    doctor.id,
                                    nombreCompleto,
                                    doctor.departamento ?? '',
                                    `<button
                                        type="button"
                                        class="btn-modal-seleccionar seleccionar-doctor"
                                        data-id="${doctor.id}"
                                        data-nombre="${nombreCompleto}"
                                    >
                                        Seleccionar
                                    </button>`
                                ]);
                            });
                        }

                        tablaDoctores.draw();

                        setTimeout(() => {
                            enlazarBotonesDoctor();
                        }, 100);

                        const modalElement = document.getElementById('modalDoctores');
                        const modalInstance = bootstrap.Modal.getOrCreateInstance(modalElement);
                        modalInstance.show();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        mostrarMensajeFormulario('Ocurrió un error al cargar los doctores.');
                    })
                    .finally(() => {
                        loadingDoctores.style.display = 'none';
                    });
            });

            document.getElementById('fecha').min = new Date().toISOString().split('T')[0];

            document.getElementById('agendarForm').addEventListener('submit', function(e) {
                const fechaCita = document.getElementById('fecha').value;
                const hoy = new Date().toISOString().split('T')[0];
                const pacienteId = document.getElementById('paciente_id').value;
                const doctorId = document.getElementById('empleado_id').value;
                const especialidad = document.getElementById('especialidad').value;
                const hora = document.getElementById('hora').value;
                const motivo = document.getElementById('motivo').value.trim();

                limpiarMensajeFormulario();

                if (!pacienteId) {
                    e.preventDefault();
                    mostrarMensajeFormulario('Debe seleccionar un paciente.');
                    return false;
                }

                if (!especialidad) {
                    e.preventDefault();
                    mostrarMensajeFormulario('Debe seleccionar una especialidad.');
                    return false;
                }

                if (!doctorId) {
                    e.preventDefault();
                    mostrarMensajeFormulario('Debe seleccionar un doctor.');
                    return false;
                }

                if (!fechaCita) {
                    e.preventDefault();
                    mostrarMensajeFormulario('Debe seleccionar una fecha para la cita.');
                    return false;
                }

                if (fechaCita < hoy) {
                    e.preventDefault();
                    mostrarMensajeFormulario('La fecha de la cita no puede ser anterior a hoy.');
                    return false;
                }

                if (!hora) {
                    e.preventDefault();
                    mostrarMensajeFormulario('Debe seleccionar una hora para la cita.');
                    return false;
                }

                if (!motivo) {
                    e.preventDefault();
                    mostrarMensajeFormulario('Debe ingresar el motivo de la consulta.');
                    return false;
                }

                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Agendando...';
                submitBtn.disabled = true;
            });
        });
    </script>
@endsection
