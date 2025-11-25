@extends('layouts.plantillaDoctor')

@section('title', 'Buscar Habitación de Paciente')

@section('contenido')
    <style>
        body {
            overflow-x: hidden;
        }
    </style>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-4">
                            <h2><i class="fas fa-search"></i> Buscar Habitación de Paciente</h2>
                            <p class="text-muted">Localiza la habitación donde se encuentra un paciente</p>
                        </div>

                        <div class="card shadow-sm">
                            <div class="card-body p-4">
                                <form action="{{ route('doctor.habitaciones.buscar') }}" method="GET">
                                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-primary text-white">
                            <i class="fas fa-search"></i>
                        </span>
                                        <input type="text"
                                               name="busqueda"
                                               class="form-control"
                                               placeholder="Nombre, expediente o número de identidad..."
                                               value="{{ request('busqueda') }}"
                                               required
                                               minlength="3"
                                               autofocus>
                                        <button class="btn btn-primary px-4" type="submit">
                                            Buscar
                                        </button>
                                    </div>
                                    <small class="text-muted">Ingrese al menos 3 caracteres para buscar</small>
                                </form>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('doctor.habitaciones.mis-pacientes') }}" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-user-md"></i> Ver Pacientes Hospitalizados
                            </a>
                        </div>

                        <!-- Ayuda visual -->
                        <div class="row mt-5">
                            <div class="col-md-4 text-center mb-3">
                                <div class="p-3">
                                    <i class="fas fa-user-injured fa-3x text-primary mb-2"></i>
                                    <h6>Por Nombre</h6>
                                    <small class="text-muted">Busca por nombre del paciente</small>
                                </div>
                            </div>
                            <div class="col-md-4 text-center mb-3">
                                <div class="p-3">
                                    <i class="fas fa-file-medical fa-3x text-primary mb-2"></i>
                                    <h6>Por Expediente</h6>
                                    <small class="text-muted">Busca por número de expediente</small>
                                </div>
                            </div>
                            <div class="col-md-4 text-center mb-3">
                                <div class="p-3">
                                    <i class="fas fa-bed fa-3x text-primary mb-2"></i>
                                    <h6>Ubicación</h6>
                                    <small class="text-muted">Encuentra la habitación exacta</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
