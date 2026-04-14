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
        body { background: whitesmoke; padding-top: 100px; }
        .text-info-emphasis { font-weight: bold; color: #2C5F5D; margin-bottom: 20px; }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            font-weight: 600;
        }

        /* Bloqueo de alertas externas */
        body > .alert, .main-content > .alert, header + .alert, .container > .alert {
            display: none !important;
        }

        /* Estilo de Alerta Bootstrap (segunda captura) */
        .custom-alert {
            box-shadow: none !important;
            border-left: none !important;
            padding: 1rem 1.25rem !important;
            border-radius: 0.375rem !important;
            position: relative;
            border: 1px solid transparent;
            margin-bottom: 1rem;
            animation: slideIn 0.5s ease-out;
        }

        .alert-premium-success {
            color: #0f5132 !important;
            background-color: #d1e7dd !important;
            border-color: #badbcc !important;
        }

        .alert-premium-error {
            color: #842029 !important;
            background-color: #f8d7da !important;
            border-color: #f5c2c7 !important;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* === CORRECCIÓN DE BOTONES: 50/50 Y HOVER === */
        .btn-container-left {
            display: flex;
            gap: 15px;
            justify-content: center; /* Centrados para ocupar el 50% cada uno */
            margin-top: 35px;
        }

        .btn-custom {
            width: 50%; /* Tamaño 50/50 */
            height: 46px;
            border-radius: 8px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 1rem;
            border: none;
            cursor: pointer;
        }

        /* Estilo y Hover: Crear Registro */
        .btn-custom-confirm {
            background: #4ecdc4;
            color: white;
        }

        .btn-custom-confirm:hover {
            background: #3dbbb2; /* Color más oscuro al pasar el cursor */
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(78, 205, 196, 0.3);
        }

        /* Estilo y Hover: Cancelar */
        .btn-custom-cancel {
            background: white;
            border: 2px solid #dc3545;
            color: #dc3545;
        }

        .btn-custom-cancel:hover {
            background: #dc3545; /* Fondo rojo al pasar el cursor */
            color: white;
            transform: translateY(-2px);
        }

        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
            display: block;
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

        #paciente_nombre {
            border: 2px solid #24f3e2;
            border-radius: 14px;
            background: white;
            padding: 10px 14px;
            font-size: 16px;
            box-shadow: 0 0 12px rgba(36, 243, 226, 0.20);
            transition: 0.2s;
        }

        #paciente_nombre:hover {
            box-shadow: 0 0 18px rgba(36, 243, 226, 0.30);
        }

        .selector-inline {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        @media (max-width: 768px) {
            .selector-inline {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-open-selector,
            .btn-container-left {
                width: 100%;
            }

            .btn-container-left {
                flex-direction: column;
                margin-left: 0;
            }
        }
    </style>

    <div class="formulario">
        <div class="register-section">
            <h1 class="text-center text-info-emphasis">Registro de Visitantes</h1>

            <div class="form-container shadow-sm">

                {{-- Notificación de ÉXITO (Ahora dentro del contenedor y con el mismo estilo del error) --}}
                @if(session('success'))
                    <div class="custom-alert alert-premium-success alert alert-dismissible fade show" role="alert">
                        <div class="msg-content">
                            <strong>¡Éxito!</strong> <span>{{ session('success') }}</span>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif(session('error') || session('error_habitacion'))
                    <div class="custom-alert alert-premium-error alert alert-dismissible fade show" role="alert">
                        <div class="msg-content">
                            <strong>Atención:</strong> <span>{{ session('error') ?? session('error_habitacion') }}</span>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('visitantes.store') }}" id="visitanteForm" novalidate>
                    @csrf

                    <div class="mb-4">
                        <label class="form-label" for="nombre_visitante">Nombre Completo del Visitante</label>
                        <input type="text" class="form-control @error('nombre_visitante') is-invalid @enderror"
                               id="nombre_visitante" name="nombre_visitante" placeholder="Ej: Juan Pérez"
                               value="{{ old('nombre_visitante') }}">
                        @error('nombre_visitante')
                        <div class="invalid-feedback">El nombre es requerido.</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="dni_visitante">Documento de Identidad (DNI)</label>
                        <input type="text" class="form-control @error('dni_visitante') is-invalid @enderror"
                               id="dni_visitante" name="dni_visitante" placeholder="0000-0000-00000"
                               value="{{ old('dni_visitante') }}">
                        @error('dni_visitante')
                        <div class="invalid-feedback">DNI inválido o requerido.</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="paciente_nombre">Paciente a Visitar</label>

                        <input type="hidden" id="paciente_id" name="paciente_id" value="{{ old('paciente_id') }}">

                        <div class="selector-inline">
                            <input
                                type="text"
                                id="paciente_nombre"
                                class="form-control @error('paciente_id') is-invalid @enderror"
                                placeholder="Seleccionar paciente internado..."
                                readonly
                                required
                            >

                            <button type="button" class="btn btn-open-selector" data-bs-toggle="modal" data-bs-target="#modalPacientes">
                                Buscar
                            </button>
                        </div>

                        @error('paciente_id')
                        <div class="invalid-feedback">Debe seleccionar un paciente.</div>
                        @enderror
                    </div>

                    <div class="btn-container-left">
                        {{-- Orden corregido: Confirmar primero, Cancelar después --}}
                        <button type="submit" class="btn-custom btn-custom-confirm">Crear Registro</button>
                        <a href="{{ url('/') }}" class="btn-custom btn-custom-cancel">Cancelar</a>
                        <button type="submit" class="btn-custom btn-custom-confirm">Crear Registro</button>
                    </div>
                </form>
            </div>
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
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pacientes as $paciente)
                                <tr>
                                    <td>{{ $paciente->id }}</td>
                                    <td>{{ $paciente->nombres }}</td>
                                    <td>{{ $paciente->apellidos }}</td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn-modal-seleccionar seleccionar-paciente"
                                            data-id="{{ $paciente->id }}"
                                            data-nombre="{{ trim($paciente->nombres . ' ' . $paciente->apellidos) }}"
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
                        targets: 3,
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

            @if(old('paciente_id'))
                @foreach($pacientes as $paciente)
                @if(old('paciente_id') == $paciente->id)
                pacienteNombreInput.value = @json(trim($paciente->nombres . ' ' . $paciente->apellidos));
            @endif
            @endforeach
            @endif
        });
    </script>
@endsection
