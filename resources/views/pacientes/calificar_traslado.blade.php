@extends('layouts.plantilla')
<link rel="stylesheet" href="{{ asset('css/formulario.css') }}">

@section('contenido')
    <style>
        body { background: whitesmoke; }

        /* Bloqueo de alertas externas */
        body > .alert, .main-content > .alert, header + .alert, .container > .alert {
            display: none !important;
        }

        /* === CORRECCIÓN DE ALERTA: ESTILO BOOTSTRAP ESTÁNDAR (Como la captura 2) === */
        .custom-alert {
            box-shadow: none !important;
            border-left: none !important;
            padding: 1rem 1.25rem !important;
            border-radius: 0.375rem !important;
            position: relative;
            border: 1px solid transparent;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            animation: slideIn 0.5s ease-out;
        }

        /* Colores para Éxito */
        .alert-premium-success {
            color: #0f5132 !important;
            background-color: #d1e7dd !important;
            border-color: #badbcc !important;
        }

        /* Colores para Error */
        .alert-premium-error {
            color: #842029 !important;
            background-color: #f8d7da !important;
            border-color: #f5c2c7 !important;
        }

        .msg-content strong { font-weight: 700 !important; }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Estrellas y botones corregidos a diseño 50/50 y comportamiento hover */
        .btn-container-left {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 2rem;
        }

        .btn-custom {
            width: 50%;
            height: 45px;
            border-radius: 8px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            text-decoration: none;
            border: none;
            font-size: 1rem;
        }

        .btn-custom-cancel {
            background: white;
            border: 2px solid #dc3545;
            color: #dc3545;
        }

        .btn-custom-cancel:hover {
            background: #dc3545 !important;
            color: white !important;
        }

        .btn-custom-confirm {
            background: #4ecdc4;
            color: white;
            cursor: pointer;
        }

        .btn-custom-confirm:hover {
            background: #3ebfb6;
            box-shadow: 0 4px 10px rgba(78, 205, 196, 0.3);
        }

        .rating { display: flex; flex-direction: row-reverse; justify-content: flex-end; gap: 10px; }
        .rating input { display: none; }
        .rating label { font-size: 2.5rem; color: #ddd; cursor: pointer; transition: color 0.2s; }
        .rating input:checked ~ label, .rating label:hover, .rating label:hover ~ label { color: #ffc107; }

        /* Estilo para los SELECT/TEXTAREA: Verde transparente y redondeado */
        .form-control {
            border-radius: 10px !important;
            border: 1px solid #4ecdc4 !important;
            background-color: rgba(78, 205, 196, 0.1) !important;
        }
    </style>

    <br><br>
    <h1 class="text-center text-info-emphasis">Calificar Servicio de Traslado</h1>

    <div class="formulario">
        <div class="register-section">
            <div class="form-container" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">

                {{-- Notificación Blindada Estilo Bootstrap --}}
                @if(session('success'))
                    <div class="custom-alert alert-premium-success alert alert-dismissible fade show" role="alert">
                        <div class="msg-content">
                            <strong>¡Operación Exitosa!</strong> <span>{{ session('success') }}</span>
                        </div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif(session('error'))
                    <div class="custom-alert alert-premium-error alert alert-dismissible fade show" role="alert">
                        <div class="msg-content">
                            <strong>Atención:</strong> <span>{{ session('error') }}</span>
                        </div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
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
                        <button type="submit" class="btn-custom btn-custom-confirm">Enviar Calificación</button>
                        <a href="{{ route('perfil') }}" class="btn-custom btn-custom-cancel">Omitir</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
