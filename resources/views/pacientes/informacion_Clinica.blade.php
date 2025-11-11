@extends('layouts.plantilla')
@section('contenido')

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:whitesmoke;
            display: flex;
            color: #2b2b2b;
        }

        /* --- Acordeón --- */
        .accordion-button {
            background-color: #ffffff;
            color: #00695c;
            font-weight: 600;
            font-size: 1.1rem;
            border: 1px solid #4ecdc4 !important;
            box-shadow: none;
            border-radius: 8px !important;
            transition: all 0.3s ease;
        }

        .accordion-button:hover {
            background-color: #e9fbfa;
            color: #00897b;
        }

        .accordion-button:not(.collapsed) {
            background-color: #4ecdc4;
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(78, 205, 196, 0.3);
        }

        .accordion-item {
            border: none;
            background-color: transparent;
        }

        .accordion-body {
            background-color: #ffffff;
            border-left: 3px solid #4ecdc4;
            border-right: 3px solid #4ecdc4;
            border-bottom: 3px solid #4ecdc4;
            border-radius: 0 0 8px 8px;
            padding: 1.5rem;
        }

        .accordion-body h1 {
            color: #00695c;
            font-size: 1.4rem;
            font-weight: 700;
        }

        .accordion-body p, .accordion-body li {
            font-size: 1rem;
            color: #2b2b2b;
            line-height: 1.6;
        }

        /* --- Tarjetas --- */
        .card {
            border: 1px solid #e0f7f5 !important;
            border-radius: 12px;
            background-color: #ffffff;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 18px rgba(78, 205, 196, 0.35);
            border-color: #4ecdc4 !important;
        }

        .card-title {
            color: #00695c;
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        .card-text {
            color: #444;
            font-size: 0.95rem;
            text-align: justify;
        }

        .card img {
            object-fit: cover;
            height: 100%;
            border-right: 3px solid #4ecdc4;
        }

        /* --- Encabezados --- */
        h1 {
            color: #4ecdc4;
            font-weight: 700;
        }

        /* --- Ajuste responsive --- */
        @media (max-width: 768px) {
            .accordion-body h1 {
                font-size: 1.2rem;
            }

            .card img {
                border-right: none;
                border-bottom: 3px solid #4ecdc4;
            }
        }

    </style>

    <div class="container mt-5 pt-5 text-center">

        {{-- Acordeón de información institucional --}}
        <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
                <h1 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        <strong>Visión y Misión</strong>
                    </button>
                </h1>
                <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <div class="row justify-content-center">
                            <div class="col-md-5">
                                <h1>Visión</h1>
                                <p>
                                    Ser una clínica médica reconocida a nivel regional por su excelencia en la atención
                                    al paciente, innovación en los servicios de salud y compromiso con el desarrollo
                                    continuo del personal médico, garantizando una experiencia segura, confiable y de
                                    calidad para toda la comunidad.
                                </p>
                            </div>
                            <div class="col-md-5">
                                <h1>Misión</h1>
                                <p>
                                    Brindar servicios médicos integrales de alta calidad, con un enfoque humano,
                                    ético y profesional, orientados a la prevención, diagnóstico y tratamiento
                                    oportuno de enfermedades, contribuyendo al bienestar y la salud de nuestros
                                    pacientes mediante la atención personalizada y el uso de tecnología moderna.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        <strong>Nuestros Valores</strong>
                    </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body text-start">
                        <ul>
                            <li><strong>Respeto:</strong> Tratamos a cada paciente con dignidad, escuchando sus necesidades y preocupaciones.</li>
                            <li><strong>Empatía:</strong> Nos ponemos en el lugar del paciente para ofrecer un cuidado humano y cercano.</li>
                            <li><strong>Excelencia:</strong> Mantenemos altos estándares en atención médica y servicios.</li>
                            <li><strong>Compromiso:</strong> Trabajamos con responsabilidad y dedicación por la salud de nuestros pacientes.</li>
                            <li><strong>Trabajo en equipo:</strong> Colaboramos entre profesionales para ofrecer un servicio integral y coordinado.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                        <strong>¿Quiénes somos?</strong>
                    </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body text-start">
                        <p>
                            En nuestra clínica nos dedicamos a brindar atención médica de excelencia, con un enfoque integral y
                            humano. Creemos que la salud es un derecho de todos, y por eso trabajamos día a día para ofrecer
                            servicios confiables, innovadores y personalizados para cada paciente. Nuestro compromiso es
                            acompañarte en cada etapa de tu bienestar, asegurándonos de que cada consulta, tratamiento o
                            cuidado sea una experiencia segura y de calidad.
                        </p>
                        <p>
                            En nuestro equipo, la pasión por la medicina se combina con la empatía, la innovación y el compromiso
                            social, creando un espacio donde la salud y el respeto por las personas son nuestra prioridad.
                            Queremos que cada paciente se sienta escuchado, comprendido y valorado,
                            porque cuidarte es nuestra razón de ser.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tarjetas: departamentos de la clínica --}}
        <div class="row row-cols-1 row-cols-md-2 g-3 mt-5 justify-content-center">
            <div class="col">
                <div class="card card-hover mb-3 mx-auto" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="informacion/rayosx.jpg" class="img-fluid rounded-start" alt="Rayos X">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">Rayos X</h5>
                                <p class="card-text">
                                    Departamento de imágenes radiológicas con equipos modernos,
                                    rayos X, tomografías y mamografías especializadas.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card card-hover mb-3 mx-auto" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="informacion/medicinageneral.jpg" class="img-fluid h-100 w-100 rounded-start" alt="Medicina General">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body text-center">
                                <h5 class="card-title">Medicina General</h5>
                                <p class="card-text">
                                    Contamos con los mejores doctores regionales del occidente,
                                    brindando tratamientos confiables y personalizados.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-2 g-3 mt-2 justify-content-center">
            <div class="col">
                <div class="card card-hover mb-3 mx-auto" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="informacion/dermatologia1.jpg" class="img-fluid rounded-start" alt="Dermatología">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">Dermatología</h5>
                                <p class="card-text">
                                    Departamento encargado de tratar todo problema de la piel,
                                    porque cuidarte es la mejor forma de consentirte.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card card-hover mb-3 mx-auto" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="informacion/pedriatia.jpg" class="img-fluid rounded-start" alt="Pediatría">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">Pediatría</h5>
                                <p class="card-text">
                                    Departamento especializado en el cuidado de los niños,
                                    con atención dedicada y servicios del programa Niños Sanos.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
