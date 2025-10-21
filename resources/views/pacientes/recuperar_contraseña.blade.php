@extends('layouts.plantilla')
@section('contenido')
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="width: 400px;">
        <h3 class="text-center mb-3">Recuperar Contraseña</h3>
        <p class="text-muted text-center">Ingresa tu correo electrónico para restablecer tu contraseña.</p>

        <form action="{{route('pacientes.recuperar_contra')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="correo" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" placeholder="ejemplo@correo.com" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Enviar enlace</button>
        </form>

        <div class="mt-3 text-center">
            <a href="{{route('pacientes.loginp')}}">Volver al inicio de sesión</a>
        </div>
    </div>
</div>
@endsection
