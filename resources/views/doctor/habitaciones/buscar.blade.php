@extends('layouts.app')

@section('title', 'Buscar Habitación de Paciente')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-4">
                <h2 class="mb-3" style="color: #4ECDC4;">
                    <i class="fas fa-search me-2"></i>Buscar Habitación de Paciente
                </h2>
                <p class="text-muted">Localiza la habitación donde se encuentra un paciente</p>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('doctor.habitaciones.buscar') }}" method="GET">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text text-white" style="background: linear-gradient(135deg, #4ecdc4 0%, #4FC3C3 100%);">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text"
                                   name="busqueda"
                                   class="form-control border-start-0"
                                   placeholder="Nombre, identidad o número de identidad..."
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
                <a href="{{ route('doctor.habitaciones.mis-pacientes') }}" class="btn btn-lg text-white" style="background: linear-gradient(135deg, #4ecdc4 0%, #4FC3C3 100%);">
                    <i class="fas fa-user-md me-2"></i>Ver Pacientes Hospitalizados
                </a>
            </div>

            <!-- Ayuda visual -->
            <div class="row mt-5">
                <div class="col-md-4 text-center mb-3">
                    <div class="p-3 border rounded">
                        <i class="fas fa-user-injured fa-2x mb-2" style="color: #4ECDC4;"></i>
                        <h6 class="fw-bold">Por Nombre</h6>
                        <small class="text-muted">Busca por nombre del paciente</small>
                    </div>
                </div>
                <div class="col-md-4 text-center mb-3">
                    <div class="p-3 border rounded">
                        <i class="fas fa-id-card fa-2x mb-2" style="color: #4ECDC4;"></i>
                        <h6 class="fw-bold">Por Identidad</h6>
                        <small class="text-muted">Busca por número de identidad</small>
                    </div>
                </div>
                <div class="col-md-4 text-center mb-3">
                    <div class="p-3 border rounded">
                        <i class="fas fa-bed fa-2x mb-2" style="color: #4ECDC4;"></i>
                        <h6 class="fw-bold">Ubicación</h6>
                        <small class="text-muted">Encuentra la habitación exacta</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
