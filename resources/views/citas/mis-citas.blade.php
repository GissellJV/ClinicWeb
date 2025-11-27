@extends('layouts.plantilla')

@section('titulo', 'Mis Citas')

@section('contenido')

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: whitesmoke;
            display: flex;
        }

        .text-info-emphasis {
            font-weight: bold;
        }

        .card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .list-group-item {
            border: none;
            padding-left: 0;
            padding-right: 0;
        }

        .list-group-flush > .list-group-item {
            border-bottom: 1px solid #e9ecef;
        }

        .btn-action-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-action-group .btn {
            flex: 1;
            min-width: 130px;
            max-width: 140px;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 600;
        }

        /* Estilos mejorados para los modales */
        .modal-content {
            border-radius: 15px;
            border: none;
            overflow: hidden;
        }

        .modal-header {
            border: none;
            padding: 30px 30px 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .modal-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            font-size: 35px;
        }

        .modal-icon-danger {
            background-color: #fee;
            color: #dc3545;
        }

        .modal-icon-warning {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        }

        .modal-title {
            font-size: 22px;
            font-weight: 600;
            margin: 0;
            color: #333;
        }

        .modal-body {
            padding: 20px 30px 30px;
            text-align: center;
        }

        .modal-body p {
            color: #666;
            margin-bottom: 20px;
            font-size: 15px;
        }

        .cita-info-box {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin: 15px 0;
            text-align: left;
        }

        .cita-info-box strong {
            color: #333;
            display: inline-block;
            width: 80px;
        }

        .modal-footer {
            border: none;
            padding: 0 30px 30px;
            justify-content: center;
            gap: 10px;
        }

        .modal-footer .btn {
            min-width: 120px;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
            border: none;
        }

        .btn-modal-cancel {
            background-color: #e9ecef;
            color: #666;
        }

        .btn-modal-cancel:hover {
            background-color: #d3d6d9;
        }

        .btn-modal-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-modal-danger:hover {
            background-color: #bb2d3b;
        }

        .btn-modal-warning {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        }

        .btn-modal-warning:hover {
            background-color: #e0a800;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 10px 15px;
        }

        .form-control:focus {
            border-color: #ffc107;
            box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            text-align: left;
            display: block;
        }

        .btn-close {
            position: absolute;
            right: 15px;
            top: 15px;
        }
    </style>

    <div class="container mt-5">
        <h1 class="text-center text-info-emphasis">Mis Citas</h1>

        @if(session('success'))
            <div class="alert alert-success alert-auto-hide" data-auto-hide="true">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-auto-hide" data-auto-hide="true">
                {{ session('error') }}
            </div>
        @endif

        <div class="row">
            @forelse($citas as $cita)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                @if($cita->doctor)
                                    {{ $cita->doctor->genero === 'Femenino' ? 'Dra.' : 'Dr.' }} {{ $cita->doctor->nombre }} {{ $cita->doctor->apellido ?? '' }}
                                @else
                                    {{ $cita->doctor_nombre ?? 'No Definido' }}
                                @endif
                            </h5>

                            <ul class="list-group mb-3">
                                <li class="list-group-item">
                                    <strong>Paciente:</strong> {{ session('paciente_nombre') ?? 'No definido' }}
                                </li>

                                <li class="list-group-item">
                                    <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}
                                </li>

                                <li class="list-group-item">
                                    <strong>Hora:</strong> {{ $cita->hora }}
                                </li>

                                <li class="list-group-item">
                                    <strong>Especialidad:</strong> {{ $cita->especialidad ?? 'No definida' }}
                                </li>

                                <li class="list-group-item">
                                    <strong>Estado:</strong>
                                    <span class="badge bg-{{ $cita->estado == 'programada' ? 'success' : ($cita->estado == 'cancelada' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($cita->estado) }}
                                </span>
                                </li>
                            </ul>

                            @if($cita->mensaje)
                                <div class="alert alert-info mt-2">{{ $cita->mensaje }}</div>
                            @endif

                            @if($cita->estado == 'programada')
                                <div class="btn-action-group mt-3">

                                    <!-- BOTÓN REPROGRAMAR -->
                                    <button type="button" class="btn btn-warning btn-sm"
                                            onclick="confirmarReprogramacion(
                                            {{ $cita->id }},
                                            '{{ $cita->doctor_nombre }}',
                                            '{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}',
                                            '{{ $cita->hora }}'
                                        )">
                                        Reprogramar
                                    </button>

                                    <!-- BOTÓN CANCELAR -->
                                    <form action="{{ route('citas.cancelar', $cita->id) }}" method="POST" id="formCancelar{{ $cita->id }}" class="d-inline">
                                        @csrf
                                        <button type="button" class="btn btn-danger btn-sm"
                                                onclick="confirmarCancelacion(
                                                {{ $cita->id }},
                                                '{{ $cita->doctor_nombre }}',
                                                '{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}',
                                                '{{ $cita->hora }}'
                                            )">
                                            Cancelar
                                        </button>
                                    </form>

                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- FORMULARIO OCULTO PARA REPROGRAMAR -->
                @if($cita->estado == 'programada')
                    <form action="{{ route('citas.reprogramar', $cita->id) }}" method="POST" id="formReprogramar{{ $cita->id }}" style="display: none;">
                        @csrf
                        <input type="hidden" name="nueva_fecha" id="hidden_nueva_fecha_{{ $cita->id }}">
                        <input type="hidden" name="nueva_hora" id="hidden_nueva_hora_{{ $cita->id }}">
                    </form>
                @endif

            @empty
                <div class="col-12">
                    <div class="alert alert-info">No tienes citas programadas.</div>
                </div>
            @endforelse

            <div class="mt-3">
                {{ $citas->links() }}
            </div>

        </div>
    </div>

    <div class="modal fade" id="modalCancelar" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                <div class="modal-header">
                    <div class="modal-icon modal-icon-danger">

                    </div>
                    <h5 class="modal-title">¿Cancelar Cita?</h5>
                </div>

                <div class="modal-body">
                    <p>¿Estás seguro de que deseas cancelar esta cita médica?</p>

                    <div class="cita-info-box" id="modalCancelarTexto"></div>

                    <p class="text-muted mb-0" style="font-size: 13px;">Esta acción no se puede deshacer</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-modal-cancel" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-modal-danger" id="btnConfirmarCancelar">Sí, cancelar cita</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalReprogramar" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                <div class="modal-header">
                    <div class="modal-icon modal-icon-warning">

                    </div>
                    <h5 class="modal-title">Reprogramar Cita</h5>
                </div>

                <div class="modal-body" id="modalReprogramarContenido"></div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-modal-cancel" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-modal-warning" id="btnConfirmarReprogramar">Guardar cambios</button>
                </div>

            </div>
        </div>
    </div>

    <script>

        function confirmarCancelacion(id, doctor, fecha, hora) {

            document.getElementById('modalCancelarTexto').innerHTML = `
                <strong>Doctor:</strong> ${doctor}<br>
                <strong>Fecha:</strong> ${fecha}<br>
                <strong>Hora:</strong> ${hora}
            `;

            document.getElementById('btnConfirmarCancelar').onclick = function () {
                document.getElementById('formCancelar' + id).submit();
            };

            new bootstrap.Modal(document.getElementById('modalCancelar')).show();
        }


        function confirmarReprogramacion(id, doctor, fecha, hora) {

            document.getElementById('modalReprogramarContenido').innerHTML = `
                <p>Selecciona la nueva fecha y hora para tu cita</p>

                <div class="cita-info-box mb-3">
                    <strong>Doctor:</strong> ${doctor}<br>
                    <strong>Fecha actual:</strong> ${fecha}<br>
                    <strong>Hora actual:</strong> ${hora}
                </div>

                <div class="mb-3">
                    <label class="form-label">Nueva Fecha</label>
                    <input type="date" class="form-control" id="modal_fecha_${id}" required min="{{ date('Y-m-d') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nueva Hora</label>
                    <input type="time" class="form-control" id="modal_hora_${id}" required>
                </div>
            `;

            document.getElementById('btnConfirmarReprogramar').onclick = function () {

                let nuevaFecha = document.getElementById('modal_fecha_' + id).value;
                let nuevaHora = document.getElementById('modal_hora_' + id).value;

                if (!nuevaFecha || !nuevaHora) {
                    return;
                }

                document.getElementById('hidden_nueva_fecha_' + id).value = nuevaFecha;
                document.getElementById('hidden_nueva_hora_' + id).value = nuevaHora;

                document.getElementById('formReprogramar' + id).submit();
            };

            new bootstrap.Modal(document.getElementById('modalReprogramar')).show();
        }
    </script>

@endsection
