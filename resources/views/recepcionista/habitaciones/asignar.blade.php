@extends('layouts.plantillaRecepcion')
<link rel="stylesheet" href="{{ asset('css/formulario.css') }}">
@section('title', 'Asignar Habitación')

@section('contenido')
    <style>
        body{
            padding-top: 70px;
        }
    </style>
    <div class="formulario mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                    <div class="register-section">
                        <h1 class="text-center text-info-emphasis">
                            Asignar Habitación a Paciente
                        </h1>


                    <div class="card-body p-4">
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <strong>Errores:</strong>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                    </div>
                    <div class="form-container">
                        <form action="{{ route('recepcionista.habitaciones.store') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label for="paciente_id" class="form-label">
                                    Seleccionar Paciente *
                                </label>
                                <select name="paciente_id" id="paciente_id"
                                        class="form-select form-select-lg @error('paciente_id') is-invalid @enderror"
                                        required>
                                    <option value="">-- Seleccione un paciente --</option>
                                    @foreach($pacientes as $paciente)
                                        <option value="{{ $paciente->id }}" {{ old('paciente_id') == $paciente->id ? 'selected' : '' }}>
                                            {{ $paciente->nombres }} {{ $paciente->apellidos }}
                                            ({{ $paciente->expediente->numero_expediente ?? 'Sin expediente' }})
                                            {{ $paciente->nombres }} {{ $paciente->apellidos }}
                                            (Identidad: {{ $paciente->numero_identidad }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('paciente_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if($pacientes->isEmpty())
                                    <div class="alert alert-info mt-3">
                                        <strong>Todos los pacientes ya tienen habitación asignada.</strong>
                                    </div>
                                @else
                                    <small class="text-muted">
                                        Hay {{ $pacientes->count() }} paciente(s) sin habitación asignada
                                    </small>
                                @endif
                            </div>

                            <div class="mb-4">
                                <label for="habitacion_id" class="form-label">
                                    Habitación Disponible *
                                </label>
                                <select name="habitacion_id" id="habitacion_id"
                                        class="form-select form-select-lg @error('habitacion_id') is-invalid @enderror"
                                        required>
                                    <option value="">-- Seleccione una habitación --</option>
                                    @foreach($habitacionesDisponibles as $habitacion)
                                        <option value="{{ $habitacion->id }}" {{ old('habitacion_id') == $habitacion->id ? 'selected' : '' }}>
                                            Habitación {{ $habitacion->numero_habitacion }} - {{ ucfirst($habitacion->tipo) }}
                                            @if($habitacion->descripcion)
                                                ({{ $habitacion->descripcion }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('habitacion_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if($habitacionesDisponibles->isEmpty())
                                    <div class="alert alert-warning mt-3">
                                        <strong>No hay habitaciones disponibles en este momento.</strong>
                                    </div>
                                @else
                                    <small class="text-muted">
                                        Hay {{ $habitacionesDisponibles->count() }} habitación(es) disponible(s)
                                    </small>
                                @endif
                            </div>

                            <div class="mb-4">
                                <label for="observaciones" class="form-label">
                                    Observaciones
                                </label>
                                <textarea name="observaciones"
                                          id="observaciones"
                                          rows="4"
                                          class="form-control @error('observaciones') is-invalid @enderror"
                                          placeholder="Ingrese observaciones adicionales sobre la asignación (opcional)">{{ old('observaciones') }}</textarea>
                                @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Máximo 500 caracteres</small>
                            </div>

                            <hr>

                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('recepcionista.habitaciones.ocupadas') }}" class="btn btn-secondary btn-lg">
                                    Cancelar
                                </a>
                                <button type="submit" class="btn btn-lg text-white"
                                        style="background: linear-gradient(135deg, #4ecdc4 0%, #4FC3C3 100%);"
                                        @if($habitacionesDisponibles->isEmpty() || $pacientes->isEmpty()) disabled @endif>
                                    Asignar Habitación
                                </button>
                            </div>
                        </form>
                    </div>

                    </div>


                <!-- Información adicional -->
                <div class="row justify-content-center mt-4">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body bg-light">
                                <h6 class="mb-3">Información Importante</h6>
                                <ul class="mb-0 small">
                                    <li>Un paciente no puede tener más de una habitación activa al mismo tiempo</li>
                                    <li>Solo se pueden asignar habitaciones con estado "disponible"</li>
                                    <li>La habitación cambiará automáticamente a estado "ocupada" al asignarla</li>
                                    <li>La fecha y hora de asignación se registrará automáticamente</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            // Mejorar la experiencia del usuario
            document.getElementById('paciente_id').addEventListener('change', function() {
                if(this.value) {
                    this.classList.add('border-success');
                    this.classList.remove('border-danger');
                }
            });

            document.getElementById('habitacion_id').addEventListener('change', function() {
                if(this.value) {
                    this.classList.add('border-success');
                    this.classList.remove('border-danger');
                }
            });

            // Deshabilitar el botón si no hay opciones disponibles
            document.addEventListener('DOMContentLoaded', function() {
                const pacientesSelect = document.getElementById('paciente_id');
                const habitacionesSelect = document.getElementById('habitacion_id');
                const submitBtn = document.querySelector('button[type="submit"]');

                function checkFormValidity() {
                    const hasPacientes = pacientesSelect.options.length > 1; // Más de 1 porque incluye la opción vacía
                    const hasHabitaciones = habitacionesSelect.options.length > 1;

                    if (!hasPacientes || !hasHabitaciones) {
                        submitBtn.disabled = true;
                    }
                }

                checkFormValidity();
            });
        </script>
    @endsection
@endsection
