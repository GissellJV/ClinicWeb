@extends('layouts.plantilla')

@section('contenido')

@endsection

<div class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="bg-white p-5 rounded-5 text-secondary shadow mt-5 pt-4" style="width: 25rem">
        <div class="d-flex justify-content-center">
            <!--LOGO DE LA CLINICA-->
            <img src="" alt="login-icono" style="height: 8rem">
        </div>
        @if(session('mensaje'))
            <div class=" alert alert-success">
                {{session('mensaje')}}
            </div>
        @endif

        <div class="text-center fs-1 fw-bold">Iniciar sesión</div>
        <div class="input-group mt-4">
            <div class="input-group-text bg-info"> <!--Fondo del logo-->
                <img src="/imagenes/username-icon.svg" alt="usuario" style="height: 1rem">
            </div>
            <input class="form-control bg-light" type="text" placeholder="Nombre de usuario">
        </div>
        <div class="input-group mt-1">
            <div class="input-group-text bg-info">
                <img src="imagenes\password-icon.svg" alt="contraseña" style="height: 1rem">
            </div>
            <input class="form-control bg-light" type="password" placeholder="Contraseña">
        </div>
        <div class="d-flex justify content-around mt-2">
            <div class="d-flex align-items-center gap-1">
                <input class="form-check-input" type="checkbox" ></div>
                <div class="pt-1" style="font-size:0.9rem"> Recordarme</div>
        </div>
        <div class="pt-1 text-center">
            <a href="{{route('pacientes.enviar_codigo_recuperacion')}}" class="text-decoration-none text-dark
             fw-semibold fst-italic" style="font-size: 0.9rem " >¿Olvidaste tu contraseña?</a>
        </div>

    <div class="btn btn-dark text-white w-100 mt-4 fw-semibold
    shadow-sm">Iniciar Sesión</div>

    <div class="d-flex gap-2 justify-content-center mt-3">
        <div>¿No tienes una cuenta?</div>
             <a href="{{route('pacientes.registrarpaciente')}}" class="text-decoration-none text-dark
              fw-semibold" >Registrate</a>
        </div>
    </div>
</div>


