@extends('layouts.plantillaRecepcion')
@section('contenido')

    <style>
        body {
            background:whitesmoke;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;

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

        .stat-card {
            border: none;
            border-radius: 15px;
            color: white;
            padding: 1.2rem;
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

        .table thead th {
            background: #4ecdc4 ;
        }

        .table.table-hover tbody tr:hover,
        .table.table-hover tbody tr:hover td {
            background: rgb(222, 251, 249);
            color: rgba(28, 27, 27, 0.95);
        }
        .text-info-emphasis{
            font-weight: bold;
        }

        .demo-container {
            max-width: 800px;
            padding: 2rem;
        }

        .demo-card {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .demo-title {
            color: #009e8e;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .demo-subtitle {
            color: #6c757d;
            margin-bottom: 2rem;
        }

        .btn-demo {
            background: linear-gradient(135deg, #4ecdc4, #00bfa6);
            color: white;
            border: none;
            padding: 1rem 2.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.3);
            margin: 0.5rem;
        }

        .btn-demo:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(78, 205, 196, 0.4);
        }

        .btn-demo i {
            margin-right: 0.5rem;
        }

        /* === ESTILOS DEL MODAL === */
        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-50px) scale(0.9);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal.show .modal-dialog {
            animation: modalSlideIn 0.3s ease-out;
        }

        .modal-content-modern {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .modal-header-modern {
            background: linear-gradient(135deg, #00bfa6, #009e8e);
            color: white;
            padding: 1.5rem 2rem;
            border: none;
        }

        .modal-title-modern {
            font-weight: 700;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
        }

        .modal-title-modern i {
            font-size: 1.6rem;
            margin-right: 0.75rem;
        }

        .btn-close-modern {
            filter: brightness(0) invert(1);
            opacity: 0.8;
            transition: all 0.3s ease;
        }

        .btn-close-modern:hover {
            opacity: 1;
            transform: rotate(90deg);
        }

        .modal-body-modern {
            padding: 2rem;
            background: linear-gradient(180deg, #ffffff, #f8fffe);
        }

        .field-label-modern {
            font-weight: 600;
            color: #009e8e;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .field-label-modern i {
            margin-right: 0.5rem;
            color: #4ecdc4;
        }

        .field-value-modern {
            background: white;
            border: 2px solid #e7fffc;
            border-radius: 12px;
            padding: 0.875rem 1.25rem;
            font-size: 1rem;
            color: #2c3e50;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .field-value-modern::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: linear-gradient(180deg, #4ecdc4, #00bfa6);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .field-value-modern:hover {
            border-color: #4ecdc4;
            box-shadow: 0 4px 12px rgba(78, 205, 196, 0.2);
            transform: translateX(5px);
        }

        .field-value-modern:hover::before {
            transform: scaleY(1);
        }

        .estado-badge {
            display: inline-block;
            padding: 0.5rem 1.25rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .estado-confirmada {
            background: linear-gradient(135deg, #4ecdc4, #00bfa6);
            color: white;
            box-shadow: 0 4px 12px rgba(78, 205, 196, 0.3);
        }

        .estado-pendiente {
            background: linear-gradient(135deg, #ffd93d, #f6c23e);
            color: #856404;
            box-shadow: 0 4px 12px rgba(255, 217, 61, 0.3);
        }

        .estado-cancelada {
            background: linear-gradient(135deg, #ff6b6b, #ee5a6f);
            color: white;
            box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
        }

        .modal-footer-modern {
            background: #f8fffe;
            border-top: 2px solid #e7fffc;
            padding: 1.5rem 2rem;
        }

        .btn-close-modal {
            background: white;
            border: 2px solid #dc3545;
            color: #dc3545;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-close-modal::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(78, 205, 196, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.4s ease, height 0.4s ease;
        }

        .btn-close-modal:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-close-modal:hover {
            background: linear-gradient(135deg, #dc3545, #ff6b6b);
            color: white;
            border-color: #dc3545;
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
            transform: translateY(-2px);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal.show .field-group {
            animation: fadeInUp 0.4s ease-out backwards;
        }

        .modal.show .field-group:nth-child(1) {
            animation-delay: 0.05s;
        }

        .modal.show .field-group:nth-child(2) {
            animation-delay: 0.1s;
        }

        .modal.show .field-group:nth-child(3) {
            animation-delay: 0.15s;
        }

        .modal.show .field-group:nth-child(4) {
            animation-delay: 0.2s;
        }

        .modal.show .field-group:nth-child(5) {
            animation-delay: 0.25s;
        }

        .modal.show .field-group:nth-child(6) {
            animation-delay: 0.3s;
        }

        .modal.show .field-group:nth-child(7) {
            animation-delay: 0.35s;
        }

        .modal.show .field-group:nth-child(8) {
            animation-delay: 0.4s;
        }
    </style>

    <br><br><br>
    <h1 class="text-center text-info-emphasis">Turnos de Doctores</h1>
    <div class="container py-4 formulario">

        <div class="register-section">
            <div class="form-container">



                <!-- Modal Ver Detalles -->
                <div class="modal fade" id="verDetallesModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content modal-content-modern">
                            <div class="modal-header modal-header-modern">
                                <h5 class="modal-title modal-title-modern">
                                    Detalles del Turno
                                </h5>
                                <button type="button" class="btn-close btn-close-modern" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body modal-body-modern">
                                <div class="row g-4">
                                    <div class="col-md-6 field-group">
                                        <label class="field-label-modern">
                                            <i class="bi bi-person-badge"></i> Doctor
                                        </label>
                                        <div class="field-value-modern" id="detalleEmpleado">—</div>
                                    </div>

                                    <div class="col-md-6 field-group">
                                        <label class="field-label-modern">
                                            <i class="bi bi-heart-pulse"></i> Especialidad
                                        </label>
                                        <div class="field-value-modern" id="detalleDepartamento">—</div>
                                    </div>

                                    <div class="col-md-6 field-group">
                                        <label class="field-label-modern">
                                            <i class="bi bi-person"></i> Paciente
                                        </label>
                                        <div class="field-value-modern" id="detallePaciente">—</div>
                                    </div>

                                    <div class="col-md-6 field-group">
                                        <label class="field-label-modern">
                                            <i class="bi bi-calendar-event"></i> Fecha
                                        </label>
                                        <div class="field-value-modern" id="detalleFecha">—</div>
                                    </div>

                                    <div class="col-md-6 field-group">
                                        <label class="field-label-modern">
                                            <i class="bi bi-clock"></i> Hora
                                        </label>
                                        <div class="field-value-modern" id="detalleHora">—</div>
                                    </div>

                                    <div class="col-md-6 field-group">
                                        <label class="field-label-modern">
                                            <i class="bi bi-check-circle"></i> Estado
                                        </label>
                                        <div class="field-value-modern">
                                            <span class="estado-badge estado-confirmada" id="detalleEstado">—</span>
                                        </div>
                                    </div>

                                    <div class="col-md-12 field-group">
                                        <label class="field-label-modern">
                                            <i class="bi bi-chat-left-text"></i> Mensaje
                                        </label>
                                        <div class="field-value-modern" id="detalleMensaje" style="min-height: 60px;">—</div>
                                    </div>

                                    <div class="col-md-12 field-group">
                                        <label class="field-label-modern">
                                            <i class="bi bi-file-text"></i> Motivo
                                        </label>
                                        <div class="field-value-modern" id="detalleMotivo" style="min-height: 60px;">—</div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer modal-footer-modern">
                                <button type="button" class="btn btn-close-modal" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle me-2"></i>Cerrar
                                </button>
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

                    <div class="col-md-4 dropdown">
                        <label class="form-label fw-semibold">Especialidad</label>
                        <button class="form-control text-start dropdown-toggle bg-white"
                                type="button"
                                id="dropdownEspecialidad"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                                style="color: #495057; border: 1px solid #ced4da;">
                            {{ request('especialidad') ?? 'Seleccione una especialidad' }}
                        </button>

                        <ul class="dropdown-menu w-100" aria-labelledby="dropdownEspecialidad">
                            <li><a class="dropdown-item" href="#" onclick="seleccionarEspecialidad('')">Seleccione una especialidad</a></li>
                            <li><hr class="dropdown-divider"></li>
                            @foreach($especialidads as $esp)
                                <li><a class="dropdown-item" href="#" onclick="seleccionarEspecialidad('{{ $esp }}')">{{ $esp }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <input type="hidden" name="especialidad" id="inputEspecialidad" value="{{ request('especialidad') }}">
                    <script>
                        function seleccionarEspecialidad(valor) {
                            document.getElementById('inputEspecialidad').value = valor;
                            document.getElementById('dropdownEspecialidad').innerText = valor || 'Seleccione una especialidad';
                        }
                    </script>


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
                        {{ $citas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
