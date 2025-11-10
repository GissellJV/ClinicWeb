@extends('layouts.plantilla')

@section('contenido')
    <div class="container mt-4 pt-5">
        <style>
            body {
                background-color: #fafafa;
                font-family: 'Poppins', 'Segoe UI', sans-serif;
                color: #2b2b2b;
            }

            h4, h5 {
                color: #00695c;
                font-weight: 700;
            }

            /* --- Campos del formulario --- */
            .form-floating > label {
                color: #666;
            }

            .form-control {
                border: 2px solid #c8f2ee;
                border-radius: 10px;
                transition: all 0.3s ease;
            }

            .form-control:focus {
                border-color: #4ecdc4;
                box-shadow: 0 0 0 0.2rem rgba(78, 205, 196, 0.25);
            }

            .input-group-text {
                background-color: #4ecdc4;
                color: #fff;
                border: none;
                font-weight: bold;
            }

            /* --- Botón principal --- */
            .btn-primary {
                background-color: #4ecdc4;
                border: none;
                border-radius: 10px;
                font-weight: 600;
                transition: all 0.3s ease;
                padding: 10px 20px;
            }

            .btn-primary:hover {
                background-color: #37b8ae;
                box-shadow: 0 4px 10px rgba(78, 205, 196, 0.4);
            }

            /* --- Tarjetas de comentarios --- */
            .card {
                border: 1px solid #e0f7f5 !important;
                border-radius: 12px;
                background-color: #ffffff;
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
                transition: all 0.3s ease;
            }

            .card:hover {
                transform: translateY(-3px);
                box-shadow: 0 6px 15px rgba(78, 205, 196, 0.25);
                border-color: #4ecdc4 !important;
            }

            .card-body strong {
                color: #00695c;
                font-size: 1rem;
            }

            .card-body p {
                color: #333;
                font-size: 0.95rem;
                margin-top: 5px;
            }

            .text-muted {
                color: #888 !important;
                font-size: 0.85rem;
            }

            /* --- Mensaje de éxito --- */
            .alert-success {
                background-color: #e0f8f6;
                border: 1px solid #4ecdc4;
                color: #00796b;
                border-radius: 10px;
                font-weight: 500;
            }

            /* --- Responsive --- */
            @media (max-width: 768px) {
                .form-floating textarea {
                    height: 120px !important;
                }
            }
        </style>

        <h4>Agrega tu comentario</h4>
        <br>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('comentarios.store') }}" method="POST">
            @csrf

            <div class="input-group mb-3 has-validation">
                <span class="input-group-text">@</span>
                <div class="form-floating flex-grow-1">
                    <input type="text" name="usuario" class="form-control" id="floatingInputGroup2" placeholder="Usuario" required>
                    <label for="floatingInputGroup2">Nombre de usuario</label>
                </div>
            </div>

            <div class="form-floating mb-3">
                <textarea name="comentario" class="form-control" placeholder="Escribe tu comentario" id="floatingTextarea2" style="height: 100px" required></textarea>
                <label for="floatingTextarea2">Comentario</label>
            </div>

            <button type="submit" class="btn btn-primary">Enviar comentario</button>
        </form>

        <hr>
        <h5>Comentarios recientes</h5>

        @foreach($comentarios as $comentario)
            <div class="card mb-2">
                <div class="card-body">
                    <strong>{{ $comentario->usuario }}</strong>
                    <p class="mb-0">{{ $comentario->comentario }}</p>
                    <small class="text-muted">{{ $comentario->created_at->diffForHumans() }}</small>
                </div>
            </div>
        @endforeach
    </div>
@endsection
