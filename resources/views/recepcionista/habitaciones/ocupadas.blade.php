@extends('layouts.plantillaRecepcion')

@section('title', 'Habitaciones Ocupadas')

@section('contenido')
    <style>
        body{
            padding-top: 100px;
        }

        .table thead th{
            background: #44A08D !important;
            color: white !important;
        }

        .btn-register {
            padding: 0.875rem 2rem;
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.3);
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        }

        .btn-cancel {
            padding: 0.875rem 2rem;
            background: white;
            border: 2px solid #dc3545;
            border-radius: 8px;
            color: #dc3545;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }
    </style>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1> Habitaciones Ocupadas</h1>
        </div>
        <div>
            <a href="{{ route('recepcionista.habitaciones.asignar') }}" class="btn text-white me-2" style="background: linear-gradient(135deg, #4ecdc4 0%, #4FC3C3 100%);">
                <i class="fas fa-plus"></i> Asignar Habitación
            </a>
            <a href="{{ route('recepcionista.habitaciones.index') }}" class="btn btn-secondary">
                <i class="fas fa-search"></i> Búsqueda de Pacientes
            </a>
        </div>
    </div>

    @if($asignaciones->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-bed fa-3x text-success mb-3"></i>
                <h5>No hay habitaciones ocupadas</h5>
                <p class="text-muted">Actualmente todas las habitaciones están disponibles</p>
                <a href="{{ route('recepcionista.habitaciones.asignar') }}" class="btn text-white mt-3" style="background: linear-gradient(135deg, #4ecdc4 0%, #4FC3C3 100%);">
                    <i class="fas fa-plus"></i> Asignar Primera Habitación
                </a>
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
                            <th><i class="fas fa-id-card"></i> Identidad</th>
                            <th><i class="fas fa-phone"></i> Teléfono</th>
                            <th><i class="far fa-calendar"></i> Ingreso</th>
                            <th><i class="far fa-clock"></i> Días</th>
                            <th><i class="fas fa-notes-medical"></i> Observaciones</th>
                            <th><i class="fas fa-cog"></i> Acciones</th>
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
                                        {{ $asignacion->paciente->nombres }}
                                        {{ $asignacion->paciente->apellidos }}
                                    </strong>
                                </td>
                                <td>{{ $asignacion->paciente->numero_identidad }}</td>
                                <td>{{ $asignacion->paciente->telefono }}</td>
                                <td>{{ $asignacion->fecha_asignacion->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $asignacion->fecha_asignacion->startOfDay()->diffInDays(now()->startOfDay()) + 1 }} días
                                    </span>
                                </td>
                                <td>
                                    @if($asignacion->observaciones)
                                        <small>{{ Str::limit($asignacion->observaciones, 30) }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalLiberar{{ $asignacion->id }}"
                                            title="Liberar Habitación">
                                        <i class="fas fa-door-open"></i> Liberar
                                    </button>

                                    <!-- Modal de Confirmación -->
                                    <div class="modal fade" id="modalLiberar{{ $asignacion->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header text-white" style="background: linear-gradient(135deg, #4ecdc4 0%, #4FC3C3 100%);">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-exclamation-triangle"></i> Confirmar Liberación
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="mb-2">¿Está seguro de que desea liberar la habitación?</p>
                                                    <div class="alert alert-info mb-0">
                                                        <strong>Habitación:</strong> {{ $asignacion->habitacion->numero_habitacion }}<br>
                                                        <strong>Paciente:</strong> {{ $asignacion->paciente->nombres }} {{ $asignacion->paciente->apellidos }}<br>
                                                        <small class="text-muted">El paciente será dado de alta.</small>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                                                        <i class="fas fa-times"></i> Cancelar
                                                    </button>
                                                    <form action="{{ route('recepcionista.habitaciones.liberar', $asignacion->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-register" >
                                                            <i class="fas fa-door-open"></i> Sí, Liberar
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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


