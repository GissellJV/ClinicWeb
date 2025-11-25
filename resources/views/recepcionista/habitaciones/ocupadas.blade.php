@extends('layouts.plantillaRecepcion')

@section('title', 'Habitaciones Ocupadas')

@section('contenido')
    <style>
        body{
            padding-top: 100px;
        }
    </style>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="fas fa-bed"></i> Habitaciones Ocupadas</h2>
            <p class="text-muted mb-0">Listado completo de habitaciones con pacientes</p>
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
                                        {{ $asignacion->fecha_asignacion->diffInDays(now()) }} días
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
                                    <form action="{{ route('recepcionista.habitaciones.liberar', $asignacion->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-warning btn-sm"
                                                onclick="return confirm('¿Estás seguro de que deseas liberar la habitación {{ $asignacion->habitacion->numero_habitacion }}? El paciente {{ $asignacion->paciente->nombres }} será dado de alta.')"
                                                title="Liberar Habitación">
                                            <i class="fas fa-door-open"></i> Liberar
                                        </button>
                                    </form>
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

@section('scripts')
    <script>
        // Confirmación adicional para liberar habitación
        document.addEventListener('DOMContentLoaded', function() {
            const liberarButtons = document.querySelectorAll('form[action*="liberar"] button');

            liberarButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    if (!confirm('⚠️ ¿Está seguro de liberar esta habitación? Esta acción no se puede deshacer.')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
@endsection
