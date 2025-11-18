@extends('layouts.app')

@section('title', 'Resultados de Búsqueda')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="fas fa-search"></i> Resultados de Búsqueda</h2>
            <p class="text-muted mb-0">Búsqueda: <strong>"{{ $busqueda }}"</strong></p>
        </div>
        <a href="{{ route('recepcionista.habitaciones.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Nueva Búsqueda
        </a>
    </div>

    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        Se encontraron <strong>{{ $pacientes->count() }}</strong> resultado(s)
    </div>

    @if($pacientes->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h5>No se encontraron resultados</h5>
                <p class="text-muted">No hay pacientes que coincidan con tu búsqueda "{{ $busqueda }}"</p>
                <a href="{{ route('recepcionista.habitaciones.index') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-search"></i> Realizar Nueva Búsqueda
                </a>
            </div>
        </div>
    @else
        <div class="row">
            @foreach($pacientes as $paciente)
                <div class="col-lg-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-user"></i>
                                {{ $paciente->nombre }} {{ $paciente->apellido }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <p class="mb-2">
                                        <strong><i class="fas fa-file-medical"></i> Expediente:</strong><br>
                                        {{ $paciente->numero_expediente }}
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p class="mb-2">
                                        <strong><i class="fas fa-id-card"></i> Identidad:</strong><br>
                                        {{ $paciente->numero_identidad }}
                                    </p>
                                </div>
                                <div class="col-12">
                                    <p class="mb-0">
                                        <strong><i class="fas fa-phone"></i> Teléfono:</strong>
                                        {{ $paciente->telefono }}
                                    </p>
                                </div>
                            </div>

                            <hr>

                            @if($paciente->asignacionesHabitacion->isNotEmpty())
                                @php
                                    $asignacion = $paciente->asignacionesHabitacion->first();
                                @endphp
                                <div class="alert alert-success mb-0">
                                    <h6 class="alert-heading">
                                        <i class="fas fa-bed"></i> Habitación Asignada
                                    </h6>

                                    <div class="row">
                                        <div class="col-6">
                                            <p class="mb-1">
                                                <strong>Número:</strong><br>
                                                <span class="badge bg-success fs-6">{{ $asignacion->habitacion->numero_habitacion }}</span>
                                            </p>
                                        </div>
                                        <div class="col-6">
                                            <p class="mb-1">
                                                <strong>Tipo:</strong><br>
                                                <span class="badge bg-info">{{ ucfirst($asignacion->habitacion->tipo) }}</span>
                                            </p>
                                        </div>
                                    </div>

                                    <p class="mb-1 mt-2">
                                        <strong><i class="far fa-calendar"></i> Fecha de ingreso:</strong><br>
                                        {{ $asignacion->fecha_asignacion->format('d/m/Y H:i') }}
                                    </p>

                                    <p class="mb-0">
                                        <strong><i class="far fa-clock"></i> Días hospitalizado:</strong>
                                        <span class="badge bg-primary">{{ $asignacion->fecha_asignacion->diffInDays(now()) }} días</span>
                                    </p>

                                    @if($asignacion->observaciones)
                                        <hr>
                                        <p class="mb-0">
                                            <strong><i class="fas fa-notes-medical"></i> Observaciones:</strong><br>
                                            <small>{{ $asignacion->observaciones }}</small>
                                        </p>
                                    @endif
                                </div>
                            @else
                                <div class="alert alert-warning mb-0">
                                    <i class="fas fa-info-circle"></i>
                                    Este paciente no tiene habitación asignada actualmente
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
