@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Mis Citas</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="row">
            @foreach($citas as $cita)
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Dr. {{ $cita->doctor->name }}</h5>
                            <p class="card-text">
                                <strong>Especialidad:</strong> {{ $cita->especialidad }}<br>
                                <strong>Fecha:</strong> {{ $cita->fecha_cita->format('d/m/Y H:i') }}<br>
                                <strong>Estado:</strong>
                                <span class="badge bg-{{ $cita->estado == 'programada' ? 'success' : ($cita->estado == 'cancelada' ? 'danger' : 'warning') }}">
                            {{ ucfirst($cita->estado) }}
                        </span>
                            </p>

                            @if($cita->estado == 'programada')
                                <div class="btn-group">
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#reprogramarModal{{ $cita->id }}">
                                        Reprogramar
                                    </button>
                                    <form action="{{ route('citas.cancelar', $cita->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de cancelar esta cita?')">
                                            Cancelar
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Modal para reprogramar -->
                @if($cita->estado == 'programada')
                    <div class="modal fade" id="reprogramarModal{{ $cita->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Reprogramar Cita</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('citas.reprogramar', $cita->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="nueva_fecha" class="form-label">Nueva Fecha y Hora</label>
                                            <input type="datetime-local" class="form-control" id="nueva_fecha" name="nueva_fecha" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Reprogramar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            @if($citas->isEmpty())
                <div class="col-12">
                    <div class="alert alert-info">
                        No tienes citas programadas.
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
