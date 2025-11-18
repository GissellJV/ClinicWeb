@extends('layouts.app')

@section('title', 'Asignar Habitación')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-bed"></i> Asignar Habitación a Paciente</h4>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('enfermeria.habitaciones.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="paciente_id" class="form-label">
                                <i class="fas fa-user"></i> Paciente *
                            </label>
                            <select name="paciente_id" id="paciente_id"
                                    class="form-select @error('paciente_id') is-invalid @enderror"
                                    required>
                                <option value="">-- Seleccione un paciente --</option>
                                @foreach($pacientes as $paciente)
                                    <option value="{{ $paciente->id }}" {{ old('paciente_id') == $paciente->id ? 'selected' : '' }}>
                                        {{ $paciente->nombre }} {{ $paciente->apellido }}
                                        (Exp: {{ $paciente->numero_expediente }})
                                    </option>
                                @endforeach
                            </select>
                            @error('paciente_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="habitacion_id" class="form-label">
                                <i class="fas fa-door-open"></i> Habitación Disponible *
                            </label>
                            <select name="habitacion_id" id="habitacion_id"
                                    class="form-select @error('habitacion_id') is-invalid @enderror"
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
                                <div class="alert alert-warning mt-2">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    No hay habitaciones disponibles en este momento
                                </div>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label for="observaciones" class="form-label">
                                <i class="fas fa-notes-medical"></i> Observaciones
                            </label>
                            <textarea name="observaciones"
                                      id="observaciones"
                                      rows="4"
                                      class="form-control @error('observaciones') is-invalid @enderror"
                                      placeholder="Ingrese observaciones adicionales (opcional)">{{ old('observaciones') }}</textarea>
                            @error('observaciones')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Máximo 500 caracteres</small>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('enfermeria.habitaciones.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary"
                                    @if($habitacionesDisponibles->isEmpty()) disabled @endif>
                                <i class="fas fa-save"></i> Asignar Habitación
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info adicional -->
            <div class="card mt-3">
                <div class="card-body bg-light">
                    <h6><i class="fas fa-info-circle"></i> Información</h6>
                    <ul class="mb-0 small">
                        <li>El paciente no puede tener más de una habitación activa</li>
                        <li>Solo se pueden asignar habitaciones con estado "disponible"</li>
                        <li>La habitación cambiará automáticamente a estado "ocupada"</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
