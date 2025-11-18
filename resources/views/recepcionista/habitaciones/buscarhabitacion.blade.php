@extends('layouts.app')

@section('title', 'Buscar Habitación de Paciente')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-4">
                <h2>Búsqueda de pasiente en Habitaciones</h2>
                <p class="text-muted">Busca en qué habitación se encuentra un paciente</p>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('recepcionista.habitaciones.buscar') }}" method="GET">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text text-white" style="background-color: #4ECDC4;">
                                Buscar
                            </span>
                            <input type="text"
                                   name="busqueda"
                                   class="form-control"
                                   placeholder="Buscar por nombre, apellido o número de expediente..."
                                   value="{{ request('busqueda') }}"
                                   required
                                   minlength="3"
                                   autofocus>
                            <button class="btn text-white px-4" type="submit" style="background-color: #4ECDC4;">
                                Buscar
                            </button>
                        </div>
                        <small class="text-muted">Ingrese al menos 3 caracteres para buscar</small>
                    </form>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('recepcionista.habitaciones.ocupadas') }}" class="btn btn-outline-secondary btn-lg">
                    Ver Todas las Habitaciones Ocupadas
                </a>
            </div>

            <!-- Ayuda visual -->
            <div class="row mt-5">
                <div class="col-md-4 text-center mb-3">
                    <div class="p-3 border rounded">
                        <h6 class="fw-bold">Por Nombre</h6>
                        <small class="text-muted">Busca por nombre del paciente</small>
                    </div>
                </div>
                <div class="col-md-4 text-center mb-3">
                    <div class="p-3 border rounded">
                        <h6 class="fw-bold">Por Expediente</h6>
                        <small class="text-muted">Busca por número de expediente</small>
                    </div>
                </div>
                <div class="col-md-4 text-center mb-3">
                    <div class="p-3 border rounded">
                        <h6 class="fw-bold">Habitación</h6>
                        <small class="text-muted">Encuentra la ubicación exacta</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
