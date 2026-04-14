@extends('layouts.plantillaDoctor')
<link rel="stylesheet" href="{{ asset('css/formulario.css') }}">
@section('contenido')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <style>
        .formulario .form-container {
            max-width: 650px;
        }

        .text-info-emphasis {
            font-weight: bold;
        }
        .campo-info{
            background: #eaf4f4;
            border: 1px solid #cfe2e2;
            border-radius: 12px;
            padding: 12px;
            font-weight: 500;
            color: #1c6b6b;
        }

        .formulario .btn-register {
            flex: 1;
            text-align: center;
        }

        .formulario .btn-cancel {
            flex: 1;
            text-align: center;
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

        /* MODAL SELECTOR*/
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
            0% { transform: scale(.7); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
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

        .modal-selector .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%) !important;
            color: white !important;
            border-color: #4ecdc4 !important;
        }

        .btn-modal-seleccionar {
            padding: 8px 20px;
            border-radius: 5px;
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
        }
    </style>

    <div class="formulario">
        <section class="register-section" style="margin-top: 35px;">
            <h1 class="text-center text-info-emphasis">Incapacidad Médica</h1>
            <div class="form-container"  style="margin-top: 35px;">



                {{-- Mensaje de exito --}}
                @if(session('success'))
                    <div class="alert alert-info-custom alert-dismissible fade show mb-4" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                @endif


                <form action="{{ route('doctor.guardar-incapacidad') }}" method="POST" novalidate>
                    @csrf

                    {{-- Selector de Paciente con Modal --}}
                    <div class="mb-4">
                        <label class="form-label">Paciente</label>
                        <input type="hidden" name="paciente_id" id="paciente_id" value="{{ old('paciente_id') }}">

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
                                class="btn-open-selector"
                                data-bs-toggle="modal"
                                data-bs-target="#modalPacientes"
                            >
                                Buscar
                            </button>
                        </div>

                        @error('paciente_id')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="mb-4">
                        <label for="nombre_doctor" class="form-label">
                            Doctor que Emite
                        </label>
                        <div class="campo-info">

                            {{ $empleado->nombre ?? session('nombre') }} {{ $empleado->apellido ?? '' }}
                        </div>
                    </div>

                    {{-- Fecha de Inicio --}}
                    <div class="mb-4">
                        <label for="fecha_inicio" class="form-label">
                            Fecha de Inicio
                        </label>
                        <div class="input-group">
                            <input
                                type="date"
                                id="fecha_inicio"
                                name="fecha_inicio"
                                class="form-control @error('fecha_inicio')  @enderror"
                                value="{{ old('fecha_inicio') }}"

                            >
                        </div>
                        @error('fecha_inicio')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Fecha de Fin --}}
                    <div class="mb-4">
                        <label for="fecha_fin" class="form-label">
                            Fecha de Fin
                        </label>
                        <div class="input-group">
                            <input
                                type="date"
                                id="fecha_fin"
                                name="fecha_fin"
                                class="form-control @error('fecha_fin')  @enderror"
                                value="{{ old('fecha_fin') }}"
                            >
                        </div>
                        @error('fecha_fin')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Motivo --}}
                    <div class="mb-4">
                        <label for="motivo" class="form-label">
                            Motivo de la Incapacidad
                        </label>
                        <textarea
                            id="motivo"
                            name="motivo"
                            class="form-control @error('motivo')  @enderror"
                            rows="4"
                            maxlength="1000"
                        >{{ old('motivo') }}</textarea>
                        @error('motivo')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                    {{-- Botones --}}
                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" class="btn-register">
                            Emitir Incapacidad
                        </button>

                        <a href="{{ route('doctor.listaIncapacidades') }}" class="btn-cancel" style="text-decoration-line: none">
                            Cancelar
                        </a>

                    </div>

                </form>
            </div>
        </section>
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

    <script src= "https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src= "https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src= "https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
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
                columnDefs: [{ targets: 3, orderable: false, searchable: false }]
            });

            document.querySelectorAll('.seleccionar-paciente').forEach(boton => {
                boton.addEventListener('click', function () {
                    pacienteIdInput.value = this.dataset.id;
                    pacienteNombreInput.value = this.dataset.nombre;

                    const modalInstance = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalPacientes'));
                    modalInstance.hide();
                });
            });

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
                    setTimeout(() => alert.remove(), 500);
                });
            }, 2500);
        });
    </script>
    <script>
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.style.transition = "opacity 0.5s";
                alert.style.opacity = "0";
                setTimeout(()=> alert.remove(), 500);
            });
        }, 2500);
    </script>
@endsection
