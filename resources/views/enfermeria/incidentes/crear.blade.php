@extends('layouts.plantillaEnfermeria')
@section('titulo', 'Registrar Incidente')
@section('contenido')

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

        .page-wrapper { padding: 80px 20px 40px; }

        .form-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            padding: 2.5rem;
            max-width: 750px;
            margin: 0 auto;
            border-top: 5px solid #4ecdc4;
        }

        .form-title {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 0.3rem;
            text-align: center;
        }

        .form-subtitle {
            text-align: center;
            color: #777;
            margin-bottom: 2rem;
            font-size: 1rem;
        }

        .form-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
            display: block;
        }

        .form-control {
            color: #555;
            padding: 0.75rem 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
            width: 100%;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: #4ecdc4;
            box-shadow: 0 0 0 3px rgba(78,205,196,0.1);
            background: white;
        }

        .form-control[readonly] {
            background: #f0f0f0;
            color: #888;
            cursor: not-allowed;
        }

        textarea.form-control { resize: vertical; min-height: 100px; }

        .form-group { margin-bottom: 1.5rem; }

        .fechas-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        @media (max-width: 600px) { .fechas-grid { grid-template-columns: 1fr; } }

        .fecha-box {
            background: #f0fdfa;
            border: 2px solid #4ecdc4;
            border-radius: 10px;
            padding: 14px;
        }

        .fecha-titulo {
            font-weight: 700;
            color: #00796b;
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .fecha-box .form-control { background: white; border-color: #c8eeeb; }
        .fecha-box .form-control[readonly] { background: #f0f0f0; }

        /* Botones */
        .button-group { display: flex; gap: 15px; margin-top: 2rem; justify-content: flex-end; }

        .btn-register,
        .btn-cancel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            height: 56px;
            flex: 0 0 220px;
            box-sizing: border-box;
            font-size: 1rem;
            font-weight: 600;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            white-space: nowrap;
        }

        .btn-register {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            border: none;
            color: white;
            box-shadow: 0 4px 15px rgba(78,205,196,0.3);
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78,205,196,0.4);
            color: white;
        }

        .btn-cancel {
            background: white;
            border: 2px solid #dc3545;
            color: #dc3545;
        }

        .btn-cancel:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(220,53,69,0.3);
        }

        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .alert-success { background: #e8f5e9; border-left: 4px solid #4caf50; color: #2e7d32; }
        .alert-danger  { background: #ffebee; border-left: 4px solid #f44336; color: #c62828; }

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

        .btn-cancel-modal {
            padding: 0.875rem 2rem;
            background: white;
            border: 2px solid #131212;
            border-radius: 8px;
            color: #221414;
            font-weight: 600;
            font-size: 1.05rem;
            transition: all 0.3s ease;
        }

        .btn-cancel-modal:hover {
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
            cursor: pointer;
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
            color: #555;
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

    <div class="page-wrapper">
        @if(session('success'))
            <div class="alert alert-success" style="max-width:750px; margin: 0 auto 20px;">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger" style="max-width:750px; margin: 0 auto 20px;">
                <ul style="margin:0; padding-left:18px;">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <div class="form-container">
            <h1 class="form-title">Registrar Incidente</h1>
            <p class="form-subtitle">Complete el formulario con los detalles del incidente</p>

            <form action="{{ route('incidentes.guardar') }}" method="POST">
                @csrf

                {{-- FECHAS --}}
                <div class="form-group">
                    <div class="fechas-grid">
                        <div class="fecha-box">
                            <div class="fecha-titulo">
                                <i class="bi bi-calendar-event"></i> Fecha del Incidente
                            </div>
                            <input type="datetime-local" class="form-control" name="fecha_hora_incidente"
                                   value="{{ old('fecha_hora_incidente') }}" required>
                            <small class="text-muted">Seleccione la fecha y hora aproximada del incidente</small>
                        </div>
                        <div class="fecha-box">
                            <div class="fecha-titulo">
                                <i class="bi bi-clock"></i> Fecha de Registro
                            </div>
                            <input type="text" class="form-control" value="{{ now()->format('d/m/Y H:i') }}" readonly>
                            <small class="text-muted">Esta se genera automáticamente</small>
                        </div>
                    </div>
                </div>

                {{-- PACIENTE --}}
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-person-fill me-1" style="color:#4ecdc4;"></i> Paciente Involucrado *
                    </label>

                    <input type="hidden" id="paciente_id" name="paciente_id" value="{{ old('paciente_id') }}" required>

                    <div class="selector-inline">
                        <input
                            type="text"
                            id="paciente_nombre"
                            class="form-control"
                            placeholder="-- Seleccione un paciente --"
                            readonly
                            required
                        >

                        <button type="button" class="btn-open-selector" data-bs-toggle="modal" data-bs-target="#modalPacientes">
                            Buscar
                        </button>
                    </div>
                </div>

                {{-- TIPO --}}
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-tag-fill me-1" style="color:#4ecdc4;"></i> Tipo de Incidente *
                    </label>
                    <select class="form-control" name="tipo_incidente" required>
                        <option value="">Seleccionar tipo</option>
                        <option value="Caída"         {{ old('tipo_incidente') == 'Caída' ? 'selected' : '' }}>Caída</option>
                        <option value="Medicación"    {{ old('tipo_incidente') == 'Medicación' ? 'selected' : '' }}>Medicación</option>
                        <option value="Alergia"       {{ old('tipo_incidente') == 'Alergia' ? 'selected' : '' }}>Alergia</option>
                        <option value="Equipo Médico" {{ old('tipo_incidente') == 'Equipo Médico' ? 'selected' : '' }}>Equipo Médico</option>
                        <option value="Otro"          {{ old('tipo_incidente') == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>

                {{-- GRAVEDAD --}}
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-exclamation-triangle-fill me-1" style="color:#4ecdc4;"></i> Gravedad *
                    </label>
                    <select class="form-control" name="gravedad" required>
                        <option value="">Seleccionar gravedad</option>
                        <option value="Leve"     {{ old('gravedad') == 'Leve' ? 'selected' : '' }}>Leve</option>
                        <option value="Moderado" {{ old('gravedad') == 'Moderado' ? 'selected' : '' }}>Moderado</option>
                        <option value="Grave"    {{ old('gravedad') == 'Grave' ? 'selected' : '' }}>Grave</option>
                        <option value="Crítico"  {{ old('gravedad') == 'Crítico' ? 'selected' : '' }}>Crítico</option>
                    </select>
                </div>

                {{-- DESCRIPCIÓN --}}
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-file-text-fill me-1" style="color:#4ecdc4;"></i> Descripción del Incidente *
                    </label>
                    <textarea class="form-control" name="descripcion" rows="4"
                              placeholder="Describa detalladamente qué ocurrió..." required>{{ old('descripcion') }}</textarea>
                </div>

                {{-- ACCIONES --}}
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-list-check me-1" style="color:#4ecdc4;"></i>
                        Acciones Tomadas <span style="color:#999; font-weight:400;">(Opcional)</span>
                    </label>
                    <textarea class="form-control" name="acciones_tomadas" rows="3"
                              placeholder="Describa las acciones que se tomaron inmediatamente...">{{ old('acciones_tomadas') }}</textarea>
                </div>

                <input type="hidden" name="estado" value="Pendiente">
                <input type="hidden" name="empleado_id" value="{{ session('empleado_id') }}">
                <input type="hidden" name="empleado_nombre" value="{{ session('empleado_nombre') }}">

                <div class="button-group">
                    <a href="{{ route('incidentes.index') }}" class="btn-cancel">Cancelar</a>
                    <button type="submit" class="btn-register">Guardar Incidente</button>
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
                                    <td>{{ $paciente->numero_identidad ?? 'Sin identidad' }}</td>
                                    <td>{{ $paciente->nombres }}</td>
                                    <td>{{ $paciente->apellidos }}</td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn-modal-seleccionar seleccionar-paciente"
                                            data-id="{{ $paciente->id }}"
                                            data-nombre="{{ trim($paciente->nombres . ' ' . $paciente->apellidos) }}{{ $paciente->numero_identidad ? ' - ' . $paciente->numero_identidad : '' }}"
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
                    <button type="button" class="btn-cancel-modal" data-bs-dismiss="modal">Cancelar</button>
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

            @if(old('paciente_id'))
                @foreach($pacientes as $paciente)
                @if(old('paciente_id') == $paciente->id)
                pacienteNombreInput.value = @json(trim($paciente->nombres . ' ' . $paciente->apellidos) . ($paciente->numero_identidad ? ' - ' . $paciente->numero_identidad : ''));
            @endif
            @endforeach
            @endif
        });
    </script>

@endsection
