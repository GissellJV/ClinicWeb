@extends('layouts.plantillaRecepcion')
@section('contenido')

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:whitesmoke;
            display: flex;

        }
        .formulario .register-section {
            padding: 1rem 1rem 3rem 1rem;
        }

        .formulario .form-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            margin: 0 auto;
            border-top: 5px solid #4ecdc4;
            position: relative;
        }

        .formulario .form-title {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 2rem;
            text-align: center;
        }

        .formulario .form-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .formulario .form-control {
            color: #555;
            padding: 0.75rem 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .formulario .form-control:focus {
            outline: none;
            border-color: #4ecdc4;
            box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.1);
            background: white;
        }

        .formulario .form-control::placeholder {
            color: #999;
        }

        /* RADIO BOTONES */
        .formulario .form-check-input:checked {
            background-color: #4ecdc4;
            border-color: #4ecdc4;
        }

        .formulario .form-check-input:focus {
            box-shadow: 0 0 0 0.25rem rgba(78, 205, 196, 0.25);
            border-color: #4ecdc4;
        }

        /* INPUTS */
        .formulario .input-group-text {
            background: #e8f8f7;
            border: 2px solid #e0e0e0;
            border-right: none;
            color: #4ecdc4;
            font-weight: 600;
        }

        .formulario .input-group .form-control {
            border-left: none;
        }

        .formulario .input-group:focus-within .input-group-text {
            border-color: #4ecdc4;
        }

        .formulario .input-group:focus-within .form-control {
            border-color: #4ecdc4;
        }

        /*MENSAJES DE ERROR*/
        .formulario small.text-danger {
            font-size: 0.875rem;
            display: block;
            margin-top: 0.5rem;
        }

        /* BOTONES */
        .formulario .btn-register {
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

        .formulario .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        }

        .formulario .btn-cancel {
            padding: 0.875rem 2rem;
            background: white;
            border: 2px solid #dc3545;
            border-radius: 8px;
            color: #dc3545;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .formulario .btn-cancel:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }

        @media (max-width: 768px) {
            .formulario .form-container {
                padding: 2rem 1.5rem;
            }

            .formulario .form-title {
                font-size: 1.5rem;
            }
        }

    </style>

    <br><br><br>

    <div class="container py-4 formulario">

        <div class="register-section">
            <div class="form-container">

                <h2 class="form-title">Turnos de Doctores</h2>

                <!-- Modal Ver Detalles -->
                <div class="modal fade" id="verDetallesModal" tabindex="-1" aria-labelledby="verDetallesModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg rounded-4">
                            <div class="modal-header bg-mint text-white rounded-top-4">
                                <h5 class="modal-title fw-bold" id="verDetallesModalLabel">
                                    <i class="bi bi-calendar-check me-2"></i>Detalles del Turno
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-muted mb-0">Doctor</label>
                                        <div class="form-control bg-light-subtle border-0 shadow-sm" id="detalleEmpleado">—</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-muted mb-0">Especialidad</label>
                                        <div class="form-control bg-light-subtle border-0 shadow-sm" id="detalleDepartamento">—</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-muted mb-0">Paciente</label>
                                        <div class="form-control bg-light-subtle border-0 shadow-sm" id="detallePaciente">—</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-muted mb-0">Fecha</label>
                                        <div class="form-control bg-light-subtle border-0 shadow-sm" id="detalleFecha">—</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-muted mb-0">Hora</label>
                                        <div class="form-control bg-light-subtle border-0 shadow-sm" id="detalleHora">—</div>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold text-muted mb-0">Estado</label>
                                        <div class="form-control bg-light-subtle border-0 shadow-sm" id="detalleEstado">—</div>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold text-muted mb-0">Mensaje</label>
                                        <div class="form-control bg-light-subtle border-0 shadow-sm" id="detalleMensaje">—</div>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold text-muted mb-0">Motivo</label>
                                        <div class="form-control bg-light-subtle border-0 shadow-sm" id="detalleMotivo">—</div>
                                    </div>

                                </div>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary btn-cancel" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const verDetallesModal = document.getElementById('verDetallesModal');
                        verDetallesModal.addEventListener('show.bs.modal', event => {
                            const button = event.relatedTarget;

                            // Leer los datos del botón
                            const doctor = button.getAttribute('data-empleado');
                            const especialidad = button.getAttribute('data-departamento');
                            const paciente = button.getAttribute('data-paciente');
                            const fecha = button.getAttribute('data-fecha');
                            const hora = button.getAttribute('data-hora');
                            const estado = button.getAttribute('data-estado');
                            const mensaje = button.getAttribute('data-mensaje');
                            const motivo = button.getAttribute('data-motivo');

                            // Asignarlos dentro del modal
                            document.getElementById('detalleEmpleado').textContent = doctor;
                            document.getElementById('detalleDepartamento').textContent = especialidad;
                            document.getElementById('detallePaciente').textContent = paciente;
                            document.getElementById('detalleFecha').textContent = fecha;
                            document.getElementById('detalleHora').textContent = hora;
                            document.getElementById('detalleEstado').textContent = estado;
                            document.getElementById('detalleMensaje').textContent = mensaje;
                            document.getElementById('detalleMotivo').textContent = motivo;
                        });
                    });
                </script>

                <!-- Filtro -->
                <form method="GET" action="{{ route('recepcionista.index') }}" class="row g-2 mt-4">

                    <div class="col">
                        <label class="form-label">Doctor</label>
                        <input type="text" name="doctor" class="form-control" value="{{ request('doctor') }}">
                    </div>

                    <div class="col">
                        <label class="form-label">Especialidad</label>
                        <input type="text" name="especialidad" class="form-control" value="{{ request('especialidad') }}">
                    </div>

                    <div class="col">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="fecha" class="form-control" value="{{ request('fecha') }}">
                    </div>

                    <div class="col-auto d-flex align-items-end">
                        <button class="btn btn-register shadow-sm">Filtrar</button>
                    </div>

                </form>


                <!-- Tabla -->
                <div class="mt-5">
                    <table class="table table-hover align-middle">
                        <thead>
                        <tr>
                            <th>Doctor</th>
                            <th>Especialidad</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Paciente</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>

                        <tbody id="tablaTurnos">
                        @forelse ($citas as $cita)
                            <tr>
                                <td>{{ $cita->doctor_nombre }}</td>
                                <td>{{ $cita->especialidad }}</td>
                                <td>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</td>
                                <td>{{ $cita->hora }}</td>
                                <td>{{ $cita->paciente_nombre }}</td>
                                <td>{{ $cita->estado }}</td>
                                <td class="text-center">
                                    <button class="btn btn-outline-info btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#verDetallesModal"
                                            data-empleado="{{ $cita->doctor_nombre }}"
                                            data-departamento="{{ $cita->especialidad }}"
                                            data-paciente="{{ $cita->paciente_nombre }}"
                                            data-fecha="{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}"
                                            data-hora="{{ $cita->hora }}"
                                            data-estado="{{ $cita->estado }}"
                                            data-mensaje="{{ $cita->mensaje }}"
                                            data-motivo="{{ $cita->motivo }}">
                                        Ver más
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No hay turnos registrados</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $turnos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
