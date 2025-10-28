@extends('layouts.plantilla')

@section('contenido')
    <style>
        body {
            background-color: #f0f8ff;
            margin: 0;
            padding: 0;
        }
    </style>



    <div class=" d-flex justify-content-center align-items-center vh-100">
        <div class="bg-white p-5 rounded-4 shadow " style="width: 25rem; border-top: 4px solid #00bcd4;">
            <div class="d-flex justify-content-center">
                <!--LOGO DE LA CLINICA-->
                <img src="/imagenes/login-icono.png" alt="login-icono" style="height: 8rem">

            </div>
            @if(session('mensaje'))
                <div class=" alert alert-primary alert-dismissible fade show">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    {{session('mensaje')}}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{session('error')}}
                </div>
            @endif


            <div class="text-center fs-3 fw-bold mb-4" style="color: #00bcd4;" >Iniciar sesión</div>
            <form action="{{route('empleados.login')}}" method="POST">
                @csrf
                <div class="mt-4">
                    <div class="input-group ">
            <span class="input-group-text bg-info bg-opacity-25 border-0"> <!--Fondo del logo-->
                <img src="/imagenes/username-icon.svg" alt="usuario" style="height: 1rem">
            </span>
                        <input class="form-control border-start-0 bg-light "
                               placeholder="Nombre de usuario"  name="telefono" type="text" value="{{old('telefono')}}">
                    </div>
                    @error('telefono')
                    <div class="text-danger mt-1" style="font-size: 0.875rem;">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mt-1">
        <span class="input-group ">
            <span class="input-group-text bg-info bg-opacity-25 border-0">
                <img src="imagenes\password-icon.svg" alt="contraseña" style="height: 1rem">
            </span>
            <input class="form-control border-start-0 bg-light" type="password" name="password"
                   placeholder="Contraseña" >
        </span>
                </div>

                @error('contraseña')
                <div class="text-danger mt-1" style="font-size: 0.875rem;">
                    {{ $message }}
                </div>
                @enderror

                <br>
                <button type="submit" class="btn text-white w-100 fw-semibold shadow-sm pt-2 mb-3" style="background-color: #00bcd4; border: none;">Iniciar Sesión</button>
            </form>

        </div>


@endsection



