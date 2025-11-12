@php
//Determinar plantilla según tipo de usuario logueado

if (session('tipo_usuario') === 'paciente') {
    $layout = 'layouts.plantilla';
} elseif (session('tipo_usuario') === 'empleado') {
    switch (session('cargo')) {
    case 'Recepcionista':
    $layout = 'layouts.plantillaRecepcion';
    break;
    case 'Doctor':
    $layout = 'layouts.plantillaDoctor';
    break;
    case 'Enfermero':
    $layout = 'layouts.plantillaEnfermero';
    break;
    default:
    $layout = 'layouts.plantilla'; // fallback
    }
    } else {
    $layout = 'layouts.plantilla'; // visitante
    }
@endphp

@extends($layout)

@section('contenido')

    <style>
        /* --- Estilos generales --- */
        body {
            background-color: #f9fafa;
            font-family: 'Segoe UI', sans-serif;
        }

        /* --- Carrusel --- */
        #carouselExampleDark {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        .carousel-caption h5 {
            color: #ffffff;
            background: rgba(78, 205, 196, 0.85);
            display: inline-block;
            padding: 6px 16px;
            border-radius: 10px;
            font-weight: 600;
        }

        .carousel-caption p {
            color: #ffffff;
            background: rgba(0, 0, 0, 0.4);
            display: inline-block;
            padding: 4px 10px;
            border-radius: 8px;
            margin-top: 8px;
            font-size: 0.95rem;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(78, 205, 196, 0.8);
            border-radius: 50%;
            padding: 15px;
        }

        /* --- Tarjetas de promociones --- */
        .card {
            border-radius: 12px;
            transition: transform 0.2s ease, box-shadow 0.3s ease;
            border: 1px solid #4ecdc4 !important;
            background-color: #ffffff;
        }

        .card-header {
            background-color: #e7f8f7 !important;
            color: #00897b;
            font-weight: 600;
            text-align: center;
            border-bottom: 1px solid #4ecdc4;
        }

        .card-body {
            text-align: center;
            color: #333;
        }

        .card-footer {
            background-color: #f8fdfd !important;
            color: #4ecdc4;
            font-weight: 500;
            text-align: center;
            border-top: 1px solid #4ecdc4;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(78, 205, 196, 0.35);
        }

        /* --- Texto vacío --- */
        p.text-center.mt-4 {
            color: #6c757d;
            font-style: italic;
        }
    </style>

    <div id="carouselExampleDark" class="carousel carousel-dark slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="2000">
                <a href="{{ route('promociones.index') }}">
                    <img src="{{ asset('promociones/promo1.jpg') }}" class="d-block w-100" alt="Todas las promociones">
                </a>
                <div class="carousel-caption d-none d-md-block">
                    <h5>ClinicWeb</h5>
                    <p>Promociones vigentes y actuales</p>
                </div>
            </div>

            <div class="carousel-item" data-bs-interval="2000">
                <a href="{{ route('promociones.index', ['mes' => 'octubre']) }}">
                    <img src="{{ asset('promociones/promo3.jpg') }}" class="d-block w-100" alt="Promociones de octubre">
                </a>
                <div class="carousel-caption d-none d-md-block">
                    <h5>Cuidate con ClinicWeb</h5>
                    <p>Promociones del mes de octubre</p>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previo</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>

    {{-- Tarjetas dinámicas desde PHP --}}
    <div class="row mt-5 justify-content-center">
        @forelse ($promociones as $promo)
            <div class="card card-hover mb-4 mx-3" style="max-width: 18rem;">
                <div class="card-header">
                    {{ $promo['mes'] === 'octubre' ? 'Promoción por mes de octubre' : 'Promoción Vigente' }}
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $promo['titulo'] }}</h5>
                    <p class="card-text">{{ $promo['descripcion'] }}</p>
                </div>
                <div class="card-footer">ClinicWeb</div>
            </div>
        @empty
            <p class="text-center mt-4">No hay promociones disponibles.</p>
        @endforelse
    </div>

@endsection
