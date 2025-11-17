@extends('layouts.app')

@section('title', 'Pacientes Hospitalizados')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="fas fa-user-md"></i> Pacientes Hospitalizados</h2>
            <p class="text-muted mb-0">Listado de todos los pacientes con habitación asignada</p>
        </div>
        <a href="{{ route('doctor.habitaciones.index') }}" class="btn btn-secondary">
            <i class="fas fa-search"></i> Buscar Paciente
        </a>
    </div>

    @if($asignaciones->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-bed fa-3x text-success mb-3"></i>
                <h5>No hay pacientes hospitalizados</h5>
                <p class="text-muted">Actualmente no hay pacientes con habitación asignada</p>
            </div>
        </div>
    @else
        <div class="alert alert-info mb-4">
            <i class="fas fa-info-circle"></i>
            Total de pacientes hospitalizados: <strong>{{ $asignaciones->count() }}</strong>
        </div>

        <div class="row">
            @foreach($asignaciones as $asignacion)
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-bed"></i> Habitación {{ $asignacion->habitacion->numero_habitacion }}
                                </h5>
                                <span class="badge bg-light text-dark">
                            {{ ucfirst($asignacion->habitacion->tipo) }}
                        </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6><i class="fas fa-user-injured"></i> Paciente</h6>
                            <p class="mb-2">
                                <strong>{{ $asignacion->paciente->nombre }} {{ $asignacion->paciente->apellido }}</strong>
                            </p>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <small class="text-muted">Expediente</small><br>
                                    {{ $asignacion->paciente->numero_expediente }}
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Teléfono</small><br>
                                    {{ $asignacion->paciente->telefono }}
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
                                    <span class="badge bg-primary">{{ $asignacion->fecha_asignacion->diffInDays(now()) }} días</span>
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
