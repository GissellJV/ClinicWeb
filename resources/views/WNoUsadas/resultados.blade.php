@extends('layouts.app')

@section('title', 'Resultados - Habitaciones')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #4ECDC4;">
                <i class="fas fa-search me-2"></i>Resultados de Búsqueda
            </h2>
            <p class="text-muted mb-0">Búsqueda: <strong>"{{ $busqueda }}"</strong></p>
        </div>
        <a href="{{ route('doctor.habitaciones.index') }}" class="btn text-white" style="background: linear-gradient(135deg, #4ecdc4 0%, #4FC3C3 100%);">
            <i class="fas fa-arrow-left me-2"></i>Nueva Búsqueda
        </a>
    </div>

    <div class="alert text-white mb-4" style="background: linear-gradient(135deg, #4ecdc4 0%, #4FC3C3 100%);">
        <i class="fas fa-info-circle me-2"></i>
        Se encontraron <strong>{{ $pacientes->count() }}</strong> paciente(s)
    </div>

    @if($pacientes->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-search fa-3x mb-3" style="color: #4ECDC4;"></i>
                <h5 style="color: #4ECDC4;">No se encontraron resultados</h5>
                <p class="text-muted">No hay pacientes que coincidan con tu búsqueda</p>
                <a href="{{ route('doctor.habitaciones.index') }}" class="btn text-white mt-3" style="background: linear-gradient(135deg, #4ecdc4 0%, #4FC3C3 100%);">
                    <i class="fas fa-search me-2"></i>Nueva Búsqueda
                </a>
            </div>
        </div>
    @else
        <div class="row">
            @foreach($pacientes as $paciente)
                <div class="col-lg-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #4ecdc4 0%, #4FC3C3 100%);">
                            <h5 class="mb-0">
                                <i class="fas fa-user-injured me-2"></i>
                                {{ $paciente->nombres }} {{ $paciente->apellidos }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <p class="mb-2">
                                        <strong><i class="fas fa-id-card me-2" style="color: #4ECDC4;"></i>Identidad:</strong><br>
                                        {{ $paciente->numero_identidad }}
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p class="mb-2">
                                        <strong><i class="fas fa-phone me-2" style="color: #4ECDC4;"></i>Teléfono:</strong><br>
                                        {{ $paciente->telefono }}
                                    </p>
                                </div>
                                <div class="col-12">
                                    <p class="mb-0">
                                        <strong><i class="fas fa-birthday-cake me-2" style="color: #4ECDC4;"></i>Edad:</strong>
                                        {{ $paciente->fecha_nacimiento ? \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age . ' años' : 'N/A' }}
                                    </p>
                                </div>
                            </div>

                            <hr>

                            @if($paciente->asignacionesHabitacion->isNotEmpty())
                                @php
                                    $asignacion = $paciente->asignacionesHabitacion->first();
                                @endphp
                                <div class="alert text-white mb-0" style="background: linear-gradient(135deg, #4ecdc4 0%, #4FC3C3 100%);">
                                    <h6 class="alert-heading mb-3">
                                        <i class="fas fa-bed me-2"></i>Habitación Asignada
                                    </h6>

                                    <div class="row">
                                        <div class="col-6">
                                            <p class="mb-1">
                                                <strong>Número:</strong><br>
                                                <span class="badge bg-light text-dark fs-6">{{ $asignacion->habitacion->numero_habitacion }}</span>
                                            </p>
                                        </div>
                                        <div class="col-6">
                                            <p class="mb-1">
                                                <strong>Tipo:</strong><br>
                                                <span class="badge bg-light text-dark">{{ ucfirst($asignacion->habitacion->tipo) }}</span>
                                            </p>
                                        </div>
                                    </div>

                                    <p class="mb-1 mt-2">
                                        <strong><i class="far fa-calendar me-2"></i>Ingreso:</strong>
                                        {{ $asignacion->fecha_asignacion->format('d/m/Y H:i') }}
                                    </p>

                                    <p class="mb-0">
                                        <strong><i class="far fa-clock me-2"></i>Días hospitalizado:</strong>
                                        <span class="badge bg-light text-dark">{{ $asignacion->fecha_asignacion->diffInDays(now()) }} días</span>
                                    </p>

                                    @if($asignacion->observaciones)
                                        <hr class="my-3">
                                        <p class="mb-0">
                                            <strong>Observaciones:</strong><br>
                                            <small>{{ $asignacion->observaciones }}</small>
                                        </p>
                                    @endif
                                </div>
                            @else
                                <div class="alert alert-warning mb-0">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Este paciente no está hospitalizado actualmente
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
