@extends('layouts.app')

@section('title', 'Gestión de Habitaciones - Enfermería')

@section('content')
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-bed"></i> Gestión de Habitaciones</h2>
            <p class="text-muted">Administra las habitaciones de la clínica</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('enfermeria.habitaciones.asignar') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Asignar Habitación
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <div class="card-body text-center">
                    <h3 class="mb-0">{{ $habitaciones->where('estado', 'disponible')->count() }}</h3>
                    <p class="mb-0"><i class="fas fa-check-circle"></i> Disponibles</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white" style="background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);">
                <div class="card-body text-center">
                    <h3 class="mb-0">{{ $habitaciones->where('estado', 'ocupada')->count() }}</h3>
                    <p class="mb-0"><i class="fas fa-user-injured"></i> Ocupadas</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
                <div class="card-body text-center">
                    <h3 class="mb-0">{{ $habitaciones->where('estado', 'mantenimiento')->count() }}</h3>
                    <p class="mb-0"><i class="fas fa-tools"></i> Mantenimiento</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid de Habitaciones -->
    <div class="row">
        @forelse($habitaciones as $habitacion)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100
            @if($habitacion->estado === 'disponible') border-success
            @elseif($habitacion->estado === 'ocupada') border-danger
            @else border-warning
            @endif" style="border-width: 3px;">

                    <div class="card-header
                @if($habitacion->estado === 'disponible') bg-success text-white
                @elseif($habitacion->estado === 'ocupada') bg-danger text-white
                @else bg-warning
                @endif">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-door-open"></i> {{ $habitacion->numero_habitacion }}
                            </h5>
                            <span class="badge bg-light text-dark">
                        {{ ucfirst($habitacion->tipo) }}
                    </span>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <p><strong>Estado:</strong>
                                <span class="badge
                            @if($habitacion->estado === 'disponible') bg-success
                            @elseif($habitacion->estado === 'ocupada') bg-danger
                            @else bg-warning
                            @endif">
                            {{ ucfirst($habitacion->estado) }}
                        </span>
                            </p>

                            @if($habitacion->descripcion)
                                <p class="text-muted small">
                                    <i class="fas fa-info-circle"></i> {{ $habitacion->descripcion }}
                                </p>
                            @endif
                        </div>

                        @if($habitacion->asignacionActiva)
                            <div class="alert alert-light border">
                                <h6 class="alert-heading">Paciente Actual:</h6>
                                <p class="mb-1">
                                    <strong>{{ $habitacion->asignacionActiva->paciente->nombre }}
                                        {{ $habitacion->asignacionActiva->paciente->apellido }}</strong>
                                </p>
                                <small class="text-muted">
                                    <i class="far fa-calendar"></i>
                                    Desde: {{ $habitacion->asignacionActiva->fecha_asignacion->format('d/m/Y H:i') }}
                                </small>
                                @if($habitacion->asignacionActiva->observaciones)
                                    <p class="mb-0 mt-2">
                                        <small><strong>Obs:</strong> {{ $habitacion->asignacionActiva->observaciones }}</small>
                                    </p>
                                @endif

                                <form action="{{ route('enfermeria.habitaciones.liberar', $habitacion->asignacionActiva->id) }}"
                                      method="POST"
                                      class="mt-3"
                                      onsubmit="return confirm('¿Está seguro de liberar esta habitación?')">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-warning w-100">
                                        <i class="fas fa-door-open"></i> Liberar Habitación
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="d-grid">
                                <a href="{{ route('enfermeria.habitaciones.asignar') }}?habitacion={{ $habitacion->id }}"
                                   class="btn btn-primary">
                                    <i class="fas fa-user-plus"></i> Asignar Paciente
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle"></i> No hay habitaciones registradas en el sistema.
                </div>
            </div>
        @endforelse
    </div>
@endsection
