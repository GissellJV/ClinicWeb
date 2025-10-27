@extends('layouts.plantilla')

@section('contenido')
    <div class="container mt-4 pt-5">
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
