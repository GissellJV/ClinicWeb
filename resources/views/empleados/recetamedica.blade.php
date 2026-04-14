@extends('layouts.plantillaDoctor')
<link rel="stylesheet" href="{{ asset('css/formulario.css') }}">
@section('contenido')
    <style>

        body {
            flex-direction: column; /* para que footer esté al final */
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:whitesmoke;
            display: flex;
        }

        .main-container {
            flex: 1; /* ocupa espacio disponible y empuja footer */
        }

        footer {
            width: 100%;
            margin-top: auto; /* asegura que se quede abajo */
            text-align: center;
            padding: 20px 0;
        }

        .receta-header h2 {
            color: rgba(28, 27, 27, 0.95);
            font-size: 24px;
            font-weight: 600;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .receta-header p {
            color: rgba(28, 27, 27, 0.95);
            font-size: 14px;
            margin-top: 8px;
            margin-bottom: 0;
        }

        .form-control-custom:focus {
            outline: none;
            border-color: #4ecdc4;
            box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.1);
        }

        .form-control-custom::placeholder {
            color: #999;
        }

        textarea.form-control-custom {
            min-height: 100px;
            resize: vertical;
        }

        .btn-generar {
            padding: 0.875rem 2rem;
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.3);
            margin-left: 5px;
        }

        .btn-generar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        }

        @media (max-width: 768px) {

            .receta-header h2 {
                font-size: 20px;
            }
        }

        .text-info-emphasis{
            font-weight: bold;
        }

        .botones-container{
            display: flex;
            gap: 10px;
        }

        .botones-container button{
            flex: 1;
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

            .btn-open-selector {
                width: 100%;
            }

            .botones-container {
                flex-direction: column;
            }
        }

        .dataTables_wrapper .dataTables_length label {
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap; /* evita que se vaya a otra línea */
        }

        .dataTables_wrapper .dataTables_length select {
            width: auto !important;
            display: inline-block;
        }

        .dataTables_wrapper .dataTables_filter {
            white-space: nowrap;
        }
    </style>

    <div class="formulario">
        <div class="register-section" style="margin-top: 70px">
            <h1 class="text-center text-info-emphasis">Receta Médica</h1>
            <br>
        <div class="form-container" >

                    <form method="POST" action="{{ route('receta.pdf') }}">
                        @csrf

                        <!-- PACIENTE -->
                        <label class="form-label">Paciente</label>
                        <input type="hidden" name="paciente_id" id="paciente_id" placeholder="Nombre del paciente" value="{{old('nombre_paiente')}}">

                        <div class="selector-inline">
                            <input
                                type="text"
                                id="paciente_nombre"
                                class="form-control"
                                placeholder="Seleccione paciente"
                                readonly
                                required
                            >

                            <button
                                type="button"
                                class="btn-open-selector"
                                data-bs-toggle="modal"
                                data-bs-target="#modalPacientes"
                            >
                                Buscar
                            </button>
                        </div>

                        <div class="mb-3">
                            <label for="medicamento" class="form-label">Medicamento</label>
                            <input type="text" name="medicamento" id="medicamento" class="form-control" placeholder="Nombre del medicamento" value="{{old('medicamento')}}">
                            @error('medicamento')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="dosis" class="form-label">Dosis</label>
                            <input type="text" name="dosis" id="dosis" class="form-control" placeholder="Ej: 500mg cada 8 horas" value="{{old('dosis')}}">
                            @error('dosis')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="duracion" class="form-label">Duración del tratamiento</label>
                            <input type="text" name="duracion" id="duracion" class="form-control" placeholder="Ej: 7 días" value="{{old('duracion')}}">
                            @error('duracion')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <textarea name="observaciones" id="observaciones" class="form-control" placeholder="Indicaciones adicionales "></textarea>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="atendido" id="atendido" value="1">
                            <label class="form-check-label" for="atendido">
                                Paciente atendido
                            </label>
                        </div>

                        <div class="botones-container">
                            <button type="submit" class="btn-generar">Generar Receta</button>

                            <button type="reset" class="btn-cancel">
                                Cancelar
                            </button>
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
                            @foreach($pacientes as $p)
                                <tr>
                                    <td>{{ $p->id }}</td>
                                    <td>{{ $p->nombres }}</td>
                                    <td>{{ $p->apellidos }}</td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn-modal-seleccionar seleccionar-paciente"
                                            data-id="{{ $p->id }}"
                                            data-nombre="{{ trim($p->nombres . ' ' . $p->apellidos) }}"
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
                dom: '<"row mb-3"<"col-md-6 d-flex align-items-center"l><"col-md-6 d-flex justify-content-end"f>>' +
                    '<"row"<"col-12"tr>>' +
                    '<"row mt-3"<"col-md-6"i><"col-md-6 d-flex justify-content-end"p>>',
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
                @foreach($pacientes as $p)
                @if(old('paciente_id') == $p->id)
                pacienteNombreInput.value = @json(trim($p->nombres . ' ' . $p->apellidos));
            @endif
            @endforeach
            @endif

            setTimeout(() => {
                document.querySelectorAll('.alert').forEach(alert => {
                    alert.style.transition = "opacity 0.5s";
                    alert.style.opacity = "0";
                    setTimeout(() => alert.remove(), 1000);
                });
            }, 300000);
        });
    </script>

@endsection
