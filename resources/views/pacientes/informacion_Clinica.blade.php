@extends('layouts.plantilla')
@section('contenido')

    <div class="container mt-5 pt-5 text-center">

{{--Acordion donde esta la informacion de la clinica una de mision y vision, los valores--}}
        <div class="accordion accordion-flush"  id="accordionFlushExample">
            <div class="accordion-item" style="border-color: #007bff;">
                <h1 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
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
            <div class="accordion-item" style="border-color: #007bff;">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        <strong>Nuestros Valores</strong>
                    </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body" style="text-align: justify">
                        <ul>
                            <li><strong>Respeto:</strong> Tratamos a cada paciente con dignidad, escuchando sus necesidades y preocupaciones.</li>
                            <li><strong>Empatía:</strong> Nos ponemos en el lugar del paciente para ofrecer un cuidado humano y cercano.</li>
                            <li><strong>Excelencia:</strong> Nos esforzamos por mantener altos estándares en atención médica y servicios.</li>
                            <li><strong>Compromiso:</strong> Trabajamos con responsabilidad y dedicación para la salud de nuestros pacientes.</li>
                            <li><strong>Trabajo en equipo:</strong> Colaboramos entre profesionales para ofrecer un servicio integral y coordinado.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="accordion-item" style="border-color: #007bff;">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                        <strong>¿Quienes somos?</strong>
                    </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
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
                            Queremos que cada paciente que nos visite se sienta escuchado, comprendido y valorado,
                            porque cuidarte es nuestra razón de ser.
                        </p>
                    </div>
                </div>
            </div>
        </div>

{{-- Tarjetas con la informacion de los departamentos de trabajo de la clinica--}}
        <div class="row row-cols-1 row-cols-md-2 g-1 mt-5">
            <div class="col">
                <div class="card card-hover mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="informacion\rayosx.jpg" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">Rayos X</h5>
                                <p class="card-text">
                                    Departamento de imagenes radiologicas con equipo tecnologico,
                                    imagenes rayosx, tomografias y mamografias especializadas.
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                    <div class="card card-hover mb-3" style=" max-width: 540px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="informacion\medicinageneral.jpg" class="img-fluid h-100 w-100 rounded-start" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Medicina General</h5>
                                    <p class="card-text">
                                        Contamos con los mejores doctores reginales del occidente,
                                        con excelentes tratamientos.
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

            <div class="row row-cols-1 row-cols-md-2 g-1 mt-2">
                <div class="col">
                    <div class="card card-hover mb-3" style="max-width: 540px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="informacion\dermatologia1.jpg" style="height: 250px" class="img-fluid h-140 w-100 rounded-start" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">Dermatología</h5>
                                    <p class="card-text">
                                        Departamento encargado de tratar todo problema del organo mas grande de nuestro cuerpo,
                                        porque cuidarte es la manera en que te consientes.
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-hover mb-3" style="max-width: 540px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="informacion\pedriatia.jpg" style="height: 250px;" class="img-fluid h-150 w-100 rounded-start" alt="..." >
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">Pedriatica</h5>
                                    <p class="card-text">
                                        Departamento encargado de los niños de la casa con los mejores cuidados
                                        y excelentes servicios del programa niños sanos.
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection
