@extends('layouts.plantillaRecepcion')

@section('title', 'Buscar Habitación de Paciente')

@section('contenido')
    <style>
        body{
            padding-top: 100px;
        }
    </style>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-4">
                <h2 class="mb-3" style="color: #4ECDC4;">Búsqueda de paciente en Habitaciones</h2>
                <p class="text-muted">Busca en qué habitación se encuentra un paciente</p>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('recepcionista.habitaciones.buscar') }}" method="GET">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text text-white" style="background: linear-gradient(135deg, #4ecdc4 0%, #4FC3C3 100%);">
                                Buscar
                            </span>
                            <input type="text"
                                   name="busqueda"
                                   class="form-control border-start-0"
                                   placeholder="Buscar por nombre, apellido o número de identidad..."
                                   value="{{ request('busqueda') }}"
                                   required
                                   minlength="3"
                                   autofocus>
                            <button class="btn text-white px-4" type="submit" style="background: linear-gradient(135deg, #4ecdc4 0%, #4FC3C3 100%);">
                                Buscar
                            </button>
                        </div>
                        <small class="text-muted mt-2 d-block">Ingrese al menos 3 caracteres para buscar</small>
                    </form>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('recepcionista.habitaciones.ocupadas') }}" class="btn btn-lg text-white" style="background: linear-gradient(135deg, #4ecdc4 0%, #4FC3C3 100%);">
                    Ver Todas las Habitaciones Ocupadas
                </a>
            </div>

            <!-- Ayuda visual -->
            <div class="row mt-5">
                <div class="col-md-4 text-center mb-3">
                    <div class="p-3 border rounded">
                        <h6 class="fw-bold" style="color: #4ECDC4;">Por Nombre</h6>
                        <small class="text-muted">Busca por nombre del paciente</small>
                    </div>
                </div>
                <div class="col-md-4 text-center mb-3">
                    <div class="p-3 border rounded">
                        <h6 class="fw-bold" style="color: #4ECDC4;">Por Identidad</h6>
                        <small class="text-muted">Busca por número de identidad</small>
                    </div>
                </div>
                <div class="col-md-4 text-center mb-3">
                    <div class="p-3 border rounded">
                        <h6 class="fw-bold" style="color: #4ECDC4;">Habitación</h6>
                        <small class="text-muted">Encuentra la ubicación exacta</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
