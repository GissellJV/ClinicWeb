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
            font-weight: 600;
            font-size: 1.1rem;


            background: #00ffe7;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            color: black;
            transition: box-shadow .25s ease;
        }

        .formulario .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 15px #00ffe7;
            background: linear-gradient(135deg, #4ecdc4 0%, #00ffe7 100%);
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
            border-bottom: 2px solid #e0e0e0;
            color: white !important;
            background: #4ecdc4 !important;
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

        .field-label-modern i {
            margin-right: 0.5rem;
            color: #4ecdc4;
        }

        .field-value-modern:hover {
            border-color: #4ecdc4;
            box-shadow: 0 4px 12px rgba(78, 205, 196, 0.2);
            transform: translateX(5px);
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



        .btn-close-modal:hover {
            background: #d5d5d5;
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

        /* --- CONTENEDOR DEL MODAL --- */
        .modal-content-modern {
            background: #ffffffee;
            backdrop-filter: blur(12px);
            border-radius: 22px;
            border: 2px solid #00ffc8;
            box-shadow: 0 0 30px #00ffe680;
            overflow: hidden;
        }

        /* --- HEADER CON DEGRADADO --- */
        .modal-header-modern {
            background: linear-gradient(135deg, #00eaff, #00ffbd);
            padding: 18px 24px;
            border-bottom: none;
        }

        .modal-title-modern {
            font-weight: 700;
            color: #fff;
        }

        /* --- X con ANIMACIÓN --- */
        .btn-x-rotate {
            transition: transform .35s ease;
        }

        .btn-x-rotate:hover {
            transform: rotate(180deg);
        }

        /* --- BODY MODERNO --- */
        .modal-body-modern {
            padding: 28px;
        }

        /* Labels */
        .field-label-modern {
            font-weight: 600;
            color: #000000;
            display: block;
            margin-bottom: 4px;
        }

        /* Valores */
        .field-value-modern {
            padding: 12px 16px;
            background: #f7fffe;
            border: 2px solid #00e5d2;
            border-radius: 14px;
            font-size: 15px;
            box-shadow: inset 0 0 6px #00ffe660;
            overflow: hidden;
        }

        /* --- FOOTER --- */
        .modal-footer-modern {
            border-top: none;
            padding: 16px 24px;
            display: flex;
            justify-content: flex-end;
        }



    </style>

    <br><br><br>

    <div class="container py-4 formulario">
        <h1 class="text-info-emphasis">Turnos de Doctores</h1>

        <div class="register-section">
            <div class="form-container">



                <!-- Modal Ver Detalles -->
                <div class="modal fade" id="verDetallesModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content modal-content-modern">

                            <!-- HEADER moderno -->
                            <div class="modal-header modal-header-modern">
                                <h5 class="modal-title modal-title-modern">
                                    <i class="bi bi-info-circle me-2"></i> Detalles del Turno
                                </h5>

                                <!-- X con animación -->
                                <button type="button" class="btn-close btn-close-modern btn-x-rotate" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- BODY moderno -->
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

                            <!-- FOOTER moderno -->
                            <div class="modal-footer modal-footer-modern">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px; padding: 10px 20px;">
                                    Cerrar
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
