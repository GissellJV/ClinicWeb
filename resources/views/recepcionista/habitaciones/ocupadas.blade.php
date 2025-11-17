@extends('layouts.app')

@section('title', 'Habitaciones Ocupadas')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="fas fa-bed"></i> Habitaciones Ocupadas</h2>
            <p class="text-muted mb-0">Listado completo de habitaciones con pacientes</p>
        </div>
        <a href="{{ route('recepcionista.habitaciones.index') }}" class="btn btn-secondary">
            <i class="fas fa-search"></i> Búsqueda de Pacientes
        </a>
    </div>

    @if($asignaciones->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-bed fa-3x text-success mb-3"></i>
                <h5>No hay habitaciones ocupadas</h5>
                <p class="text-muted">Actualmente todas las habitaciones están disponibles</p>
            </div>
        </div>
    @else
        <div class="alert alert-success mb-4">
            <i class="fas fa-info-circle"></i>
            Total de habitaciones ocupadas: <strong>{{ $asignaciones->count() }}</strong>
        </div>

        <!-- Tabla de Habitaciones -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                        <tr>
                            <th><i class="fas fa-door-open"></i> Habitación</th>
                            <th><i class="fas fa-tag"></i> Tipo</th>
                            <th><i class="fas fa-user"></i> Paciente</th>
                            <th><i class="fas fa-file-medical"></i> Expediente</th>
                            <th><i class="fas fa-phone"></i> Teléfono</th>
                            <th><i class="far fa-calendar"></i> Ingreso</th>
                            <th><i class="far fa-clock"></i> Días</th>
                            <th><i class="fas fa-notes-medical"></i> Observaciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($asignaciones as $asignacion)
                            <tr>
                                <td>
                                <span class="badge bg-danger fs-6">
                                    {{ $asignacion->habitacion->numero_habitacion }}
                                </span>
                                </td>
                                <td>
                                <span class="badge bg-info">
                                    {{ ucfirst($asignacion->habitacion->tipo) }}
                                </span>
                                </td>
                                <td>
                                    <strong>
                                        {{ $asignacion->paciente->nombre }}
                                        {{ $asignacion->paciente->apellido }}
                                    </strong>
                                </td>
                                <td>{{ $asignacion->paciente->numero_expediente }}</td>
                                <td>{{ $asignacion->paciente->telefono }}</td>
                                <td>{{ $asignacion->fecha_asignacion->format('d/m/Y H:i') }}</td>
                                <td>
                                <span class="badge bg-primary">
                                    {{ $asignacion->fecha_asignacion->diffInDays(now()) }}
                                </span>
                                </td>
                                <td>
                                    @if($asignacion->observaciones)
                                        <small>{{ Str::limit($asignacion->observaciones, 30) }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Estadísticas por Tipo -->
        <div class="row mt-4">
            <div class="col-12 mb-3">
                <h4><i class="fas fa-chart-pie"></i> Estadísticas por Tipo</h4>
            </div>

            @php
                $porTipo = $asignaciones->groupBy(function($item) {
                    return $item->habitacion->tipo;
                });
            @endphp

            @foreach($porTipo as $tipo => $items)
                <div class="col-md-3 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-bed fa-2x text-primary mb-2"></i>
                            <h5 class="card-title">{{ ucfirst($tipo) }}</h5>
                            <p class="display-6 mb-0">{{ $items->count() }}</p>
                            <small class="text-muted">ocupadas</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
