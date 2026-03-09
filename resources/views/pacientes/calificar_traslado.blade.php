@extends('layouts.plantilla')
<link rel="stylesheet" href="{{ asset('css/formulario.css') }}">

@section('contenido')
    <style>
        body { background: whitesmoke; }

        /* Diseño de Alerta Técnica "Operación Exitosa" */
        .custom-alert {
            background: #ffffff;
            border-left: 5px solid #4ecdc4;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            animation: fadeIn 0.5s ease-out;
        }

        .icon-circle {
            width: 40px;
            height: 40px;
            border: 2px solid #4ecdc4;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .text-custom { color: #4ecdc4; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Estrellas y botones */
        .btn-container-left { display: flex; gap: 15px; justify-content: flex-start; margin-top: 2rem; }
        .btn-custom { width: 180px; height: 45px; border-radius: 8px; font-weight: bold; display: flex; align-items: center; justify-content: center; text-decoration: none; border: none; }
        .btn-custom-cancel { background: white; border: 2px solid #dc3545; color: #dc3545; }
        .btn-custom-confirm { background: #4ecdc4; color: white; cursor: pointer; }

        .rating { display: flex; flex-direction: row-reverse; justify-content: flex-end; gap: 10px; }
        .rating input { display: none; }
        .rating label { font-size: 2.5rem; color: #ddd; cursor: pointer; transition: color 0.2s; }
        .rating input:checked ~ label, .rating label:hover, .rating label:hover ~ label { color: #ffc107; }
    </style>

    <br><br>
    <h1 class="text-center text-info-emphasis">Calificar Servicio de Traslado</h1>

    <div class="formulario">
        <div class="register-section">
            <div class="form-container" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">

                {{-- Mostrar alerta de éxito idéntica a la captura proporcionada --}}
                @if(session('success'))
                    <div class="custom-alert">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle">
                                <i class="bi bi-check2 text-custom" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold" style="color: #2c3e50;">¡Operación Exitosa!</h6>
                                <small class="text-muted">{{ session('success') }}</small>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('traslado.calificar.guardar') }}" method="POST">
                    @csrf
                    <input type="hidden" name="traslado_id" value="{{ $traslado->id }}">

                    <div class="mb-4">
                        <label class="fw-bold d-block mb-2">¿Cómo calificaría la puntualidad y atención?</label>
                        <div class="rating">
                            @for($i=5; $i>=1; $i--)
                                <input type="radio" id="star{{$i}}" name="puntuacion" value="{{$i}}" required/>
                                <label for="star{{$i}}"><i class="bi bi-star-fill"></i></label>
                            @endfor
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold d-block mb-2">Comentarios opcionales</label>
                        <textarea name="comentario" class="form-control" rows="4" placeholder="Escriba su opinión aquí..." maxlength="255"></textarea>
                    </div>

                    <div class="btn-container-left">
                        <a href="{{ route('perfil') }}" class="btn-custom btn-custom-cancel">Omitir</a>
                        <button type="submit" class="btn-custom btn-custom-confirm">Enviar Calificación</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

