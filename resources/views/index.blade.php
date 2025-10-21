@extends('layouts.plantilla')
@section('contenido')

    <style>
        .card.card-hover {
            transition: transform 0.28s ease, box-shadow 0.28s ease;
            will-change: transform, box-shadow;
        }

        .card.card-hover:hover,
        .card.card-hover:focus {
            transform: translateY(-10px) scale(1.01);
            box-shadow: 0 14px 30px rgba(0,0,0,0.18);
            cursor: pointer;
        }

    </style>
        <div id="carouselExampleDark" class="carousel carousel-dark slide">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="2000">
                    <img src="promociones/promo1.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>ClinicWeb</h5>
                        <p>Promociones vigentes y actuales</p>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="2000">
                    <img src="promociones/promo3.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Cuidate con clinicweb</h5>
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
                <span class="visually-hidden">siguiente</span>
            </button>
        </div>
        <div class="row mt-5">
            <div class="card card-hover border-success mb-3 mx-3" style="max-width: 18rem;">
                <div class="card-header bg-transparent border-success">Promoción Vigente</div>
                <div class="card-body text-success">
                    <h5 class="card-title">Descuento de Tercera Edad</h5>
                    <p class="card-text">Descuento del 30% en todo gasto como ser:
                    <ul>
                        <li>Consultas generales y con especialista</li>
                        <li>Examenes de laboratorio</li>
                        <li>Rayos X</li>
                    </ul></p>
                </div>
                <div class="card-footer bg-transparent border-success">ClinicWeb</div>
            </div>
            <div class="card card-hover border-success mb-3 mx-3" style="max-width: 18rem;">
                <div class="card-header bg-transparent border-success">Promoción Vigente</div>
                <div class="card-body text-success">
                    <h5 class="card-title">Descuento de Cuarta Edad</h5>
                    <p class="card-text">Descuento del 40% en todo gasto como ser:
                    <ul>
                        <li>Consultas generales y con especialista</li>
                        <li>Examenes de laboratorio</li>
                        <li>Rayos X</li>
                        <li>Medicamentos</li>
                    </ul></p>
                </div>
                <div class="card-footer bg-transparent border-success">ClinicWeb</div>
            </div>
            <div class="card card-hover border-success mb-3 mx-3" style="max-width: 18rem;">
                <div class="card-header bg-transparent border-success">Promoción por mes de octubre</div>
                <div class="card-body text-success">
                    <h5 class="card-title">Control Total</h5>
                    <p class="card-text">Precio 1,000 L. en todo gasto como ser:
                    <ul>
                        <li>Consultas con especialista</li>
                        <li>Examenes de laboratorio</li>
                        <li>Rayos X simples</li>
                    </ul></p>
                </div>
                <div class="card-footer bg-transparent border-success">ClinicWeb</div>
            </div>
            <div class="card card-hover border-success mb-3 mx-3" style="max-width: 18rem;">
                <div class="card-header bg-transparent border-success">Promoción Vigente hasta el 15 de noviembre</div>
                <div class="card-body text-success">
                    <h5 class="card-title">Control Estandar</h5>
                    <p class="card-text">Precio 850 L. en todo gasto como ser:
                    <ul>
                        <li>Examenes de laboratorio</li>
                    </ul></p>
                </div>
                <div class="card-footer bg-transparent border-success">ClinicWeb</div>
            </div>
        </div>
@endsection
