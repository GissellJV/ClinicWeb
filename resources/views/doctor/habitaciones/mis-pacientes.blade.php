@extends('layouts.app')

@section('title', 'Pacientes Hospitalizados')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #4ECDC4;">
                <i class="fas fa-user-md me-2"></i>Pacientes Hospitalizados
            </h2>
            <p class="text-muted mb-0">Listado de todos los pacientes con habitación asignada</p>
        </div>
        <a href="{{ route('doctor.habitaciones.index') }}" class="btn text-white" style="background: linear-gradient(135deg, #4ecdc4 0%, #4FC3C3 100%);">
            <i class="fas fa-search me-2"></i>Buscar Paciente
        </a>
    </div>

    @if($asignaciones->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-bed fa-3x mb-3" style="color: #4ECDC4;"></i>
                <h5 style="color: #4ECDC4;">No hay pacientes hospitalizados</h5>
                <p class="text-muted">Actualmente no hay pacientes con habitación asignada</p>
            </div>
        </div>
    @else
        <div class="alert text-white mb-4" style="background: linear-gradient(135deg, #4ecdc4 0%, #4FC3C3 100%);">
            <i class="fas fa-info-circle me-2"></i>
            Total de pacientes hospitalizados: <strong>{{ $asignaciones->count() }}</strong>
        </div>

        <div class="row">
            @foreach($asignaciones as $asignacion)
                <div class="col-lg-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #4ecdc4 0%, #4FC3C3 100%);">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-bed me-2"></i>Habitación {{ $asignacion->habitacion->numero_habitacion }}
                                </h5>
                                <span class="badge bg-light text-dark">
                                    {{ ucfirst($asignacion->habitacion->tipo) }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-3" style="color: #4ECDC4;">
                                <i class="fas fa-user-injured me-2"></i>Paciente
                            </h6>
                            <p class="mb-2">
                                <strong>{{ $asignacion->paciente->nombres }} {{ $asignacion->paciente->apellidos }}</strong>
                            </p>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <small class="text-muted">Identidad</small><br>
                                    <strong>{{ $asignacion->paciente->numero_identidad }}</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Teléfono</small><br>
                                    <strong>{{ $asignacion->paciente->telefono }}</strong>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">Fecha de ingreso</small><br>
                                    <strong>{{ $asignacion->fecha_asignacion->format('d/m/Y') }}</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Días hospitalizado</small><br>
                                    <span class="badge text-white" style="background: linear-gradient(135deg, #4ecdc4 0%, #4FC3C3 100%);">
                                        {{ $asignacion->fecha_asignacion->diffInDays(now()) }} días
                                    </span>
                                </div>
                            </div>

                            @if($asignacion->observaciones)
                                <hr>
                                <small class="text-muted">Observaciones</small>
                                <p class="mb-0">{{ $asignacion->observaciones }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
