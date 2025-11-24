@extends('layouts.plantilla')

@section('titulo', 'Mis Citas')

@section('contenido')

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:whitesmoke;
            display: flex;
        }

        .text-info-emphasis{
            font-weight: bold;
        }

        /* Estilos para las alertas automáticas */
        .alert-auto-hide {
            animation: slideDown 0.3s ease;
            position: relative;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Mejorar el espaciado entre botones y hacerlos del mismo tamaño */
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

        /* Asegurar que ambos botones tengan el mismo tamaño */
        .btn-action-group .btn-warning,
        .btn-action-group .btn-danger {
            min-height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
    <div class="container mt-5">
        <h1 class="text-center text-info-emphasis">Mis Citas</h1>

        @if(session('success'))
            <div class="alert alert-success alert-auto-hide" id="autoHideAlert" data-auto-hide="true">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-auto-hide" id="autoHideAlert" data-auto-hide="true">
                {{ session('error') }}
            </div>
        @endif

        <br>

        <div class="row">
            @forelse($citas as $cita)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $cita->doctor_nombre ?? 'Doctor no asignado' }}</h5>
                            <p class="card-text">
                                <strong>Paciente:</strong> {{ session('paciente_nombre') ?? 'No definido' }}<br>
                                <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}<br>
                                <strong>Hora:</strong> {{ $cita->hora }}<br>
                                <strong>Especialidad:</strong> {{ $cita->especialidad ?? 'No definida' }}<br>
                                <strong>Estado:</strong>
                                <span class="badge bg-{{ $cita->estado == 'programada' ? 'success' : ($cita->estado == 'cancelada' ? 'danger' : 'warning') }}">
                                {{ ucfirst($cita->estado) }}
                            </span>
                            </p>
                            @if($cita->mensaje)
                                <div class="alert alert-info mt-2">{{ $cita->mensaje }}</div>
                            @endif

                            @if($cita->estado == 'programada')
                                <div class="btn-action-group mt-3">
                                    <button type="button" class="btn btn-warning btn-sm" onclick="confirmarReprogramacion({{ $cita->id }}, '{{ $cita->doctor_nombre }}', '{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}', '{{ $cita->hora }}')">
                                        Reprogramar
                                    </button>
                                    <!-- Formulario individual para cada cita -->
                                    <form action="{{ route('citas.cancelar', $cita->id) }}" method="POST" class="d-inline" id="formCancelar{{ $cita->id }}">
                                        @csrf
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmarCancelacion({{ $cita->id }}, '{{ $cita->doctor_nombre }}', '{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}', '{{ $cita->hora }}')">
                                            Cancelar
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                @if($cita->estado == 'programada')
                    <!-- Formulario oculto para reprogramar -->
                    <form action="{{ route('citas.reprogramar', $cita->id) }}" method="POST" id="formReprogramar{{ $cita->id }}" style="display: none;">
                        @csrf
                        <input type="hidden" name="nueva_fecha" id="hidden_nueva_fecha_{{ $cita->id }}">
                        <input type="hidden" name="nueva_hora" id="hidden_nueva_hora_{{ $cita->id }}">
                    </form>
                @endif
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        No tienes citas programadas.
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        function confirmarCancelacion(citaId, doctorNombre, fecha, hora) {
            showConfirmModal(
                '¿Cancelar Cita?',
                `¿Estás seguro de que deseas cancelar tu cita con el Dr. ${doctorNombre} programada para el ${fecha} a las ${hora}? Esta acción no se puede deshacer.`,
                'Sí, cancelar cita',
                function() {
                    // Enviar el formulario específico de esta cita
                    document.getElementById('formCancelar' + citaId).submit();
                }
            );
        }

        function confirmarReprogramacion(citaId, doctorNombre, fechaActual, horaActual) {
            const formHTML = `
                <div class="modal-reprogramar-form-group">
                    <label class="modal-reprogramar-label">Cita Actual</label>
                    <div style="background: #f8f9fa; padding: 12px; border-radius: 8px; margin-bottom: 15px;">
                        <strong>Dr. ${doctorNombre}</strong><br>
                        <small>Fecha: ${fechaActual} | Hora: ${horaActual}</small>
                    </div>
                </div>
                <div class="modal-reprogramar-form-group">
                    <label for="nueva_fecha_${citaId}" class="modal-reprogramar-label">Nueva Fecha</label>
                    <input type="date"
                           class="modal-reprogramar-input"
                           id="nueva_fecha_${citaId}"
                           name="nueva_fecha"
                           required
                           min="{{ date('Y-m-d') }}"
                           onchange="validarFechaHora(${citaId})">
                </div>
                <div class="modal-reprogramar-form-group">
                    <label for="nueva_hora_${citaId}" class="modal-reprogramar-label">Nueva Hora</label>
                    <input type="time"
                           class="modal-reprogramar-input"
                           id="nueva_hora_${citaId}"
                           name="nueva_hora"
                           required
                           onchange="validarFechaHora(${citaId})">
                </div>
                <div id="error-message-${citaId}" style="color: #e74c3c; font-size: 14px; margin-top: 10px; display: none;"></div>
            `;

            showReprogramarModal(
                'Reprogramar Cita',
                formHTML,
                function() {
                    // Validar antes de enviar
                    if (validarFechaHora(citaId)) {
                        document.getElementById('formReprogramar' + citaId).submit();
                    }
                }
            );
        }

        function validarFechaHora(citaId) {
            const fechaInput = document.getElementById('nueva_fecha_' + citaId);
            const horaInput = document.getElementById('nueva_hora_' + citaId);
            const errorDiv = document.getElementById('error-message-' + citaId);

            const fechaSeleccionada = new Date(fechaInput.value);
            const hoy = new Date();
            hoy.setHours(0, 0, 0, 0);

            if (fechaSeleccionada < hoy) {
                errorDiv.textContent = 'No puedes seleccionar una fecha pasada.';
                errorDiv.style.display = 'block';
                return false;
            }

            if (!fechaInput.value || !horaInput.value) {
                errorDiv.textContent = 'Por favor, completa ambos campos.';
                errorDiv.style.display = 'block';
                return false;
            }

            errorDiv.style.display = 'none';
            return true;
        }

        // Auto-ocultar alertas después de 10 segundos
        document.addEventListener('DOMContentLoaded', function() {
            // Ocultar alertas automáticamente
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert-auto-hide');
                alerts.forEach(alert => {
                    if (alert.getAttribute('data-auto-hide') === 'true') {
                        alert.style.opacity = '0';
                        alert.style.transition = 'opacity 0.5s ease';
                        setTimeout(() => {
                            alert.style.display = 'none';
                        }, 500);
                    }
                });
            }, 10000); // 10 segundos
        });

        // Sincronizar los campos del formulario oculto con los del modal
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('modal-reprogramar-input')) {
                const citaId = e.target.id.split('_').pop();
                const hiddenFecha = document.getElementById('hidden_nueva_fecha_' + citaId);
                const hiddenHora = document.getElementById('hidden_nueva_hora_' + citaId);

                if (e.target.name === 'nueva_fecha') {
                    hiddenFecha.value = e.target.value;
                } else if (e.target.name === 'nueva_hora') {
                    hiddenHora.value = e.target.value;
                }
            }
        });
    </script>
@endsection
