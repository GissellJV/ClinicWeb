@extends('layouts.plantilla')
<link rel="stylesheet" href="{{ asset('css/formulario.css') }}">

@section('contenido')
    <style>

        small.text-danger {
            font-size: 0.875em;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:whitesmoke;
            display: flex;

        }

    </style>
    <br><br><br>
    <div class="formulario">
      <div class="register-section">
          <h1 class="text-center text-info-emphasis" >Regístrate para Agendar tu Cita</h1>
         <div class="form-container">

          <form method="post" action="{{route('pacientes.store')}}">
            @csrf
            <!--NOMBRE COMPLETO-->
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Nombre Completo</label>
                <div class="row g-2">
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombres" value="{{old('nombres')}}">
                        @error('nombres')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                <div class="col-md-6">
                        <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" value="{{old('apellidos')}}">
                        @error('apellidos')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                </div>
             </div>
            </div>
            <!--FECHA-->
            <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="{{old('fecha_nacimiento')}}" >
                        @error('fecha_nacimiento')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
            <!--GENERO-->
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Genero</label>
                <div class="row g-2">

                    <div class="col-6">
                        <div class="form-check" >
                            <input class="form-check-input" type="radio" name="genero" id="femenino" value="Femenino" {{ old('genero') == 'Femenino' ? 'checked' : '' }}  >
                            <label class="form-check-label" for="femenino" >
                                Femenino
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="genero" id="masculino" value="Masculino"  {{ old('genero') == 'Masculino' ? 'checked' : '' }}>
                            <label class="form-check-label" for="masculino">
                                Masculino
                            </label>
                        </div>
                    </div>
                </div>
                @error('genero')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            <!--Numero de identidad-->
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Número de identidad</label>
                <input type="text" class="form-control" id="numero_identidad" name="numero_identidad" placeholder="0000000000000" >
                @error('numero_identidad')
                <small class="text-danger">{{ $message }}</small>
                @enderror
                <div class="invalid-feedback">Ingresa un número de identidad válido (13 dígitos)
                </div>

                <!--Numero de Telefono con codigo de pais-->
                <div data-mdb-input-init class="mb-3" >
                    <label class="form-label" for="phone">Número de Telefono</label>
                    <div class="input-group">
                        <span class="input-group-text">+504</span>
                        <input type="text" id="telefono" name="telefono" class="form-control" placeholder="00000000" value="{{old('telefono')}}" />
                    </div>
                    @error('telefono')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <!-- CONTRASEÑA -->
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password">
                    @error('password')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <!-- CONFIRMAR CONTRASEÑA -->
                <div class="mb-3">
                    <label for="confirmarPassword" class="form-label">Confirmar Contraseña </label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    @error('password_confirmation')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-register">Registrar</button>
                <a class="btn btn-cancel" href="{{route('/')}}">Cancelar</a>
            </div>
              <div class="text-center mt-3">
              <p style="margin-bottom: 0.5rem; color: #666;">¿Tienes una cuenta?
                  <a style="color: #4ecdc4; text-decoration: none; font-weight: 500;" href="{{route('empleados.login')}}">Iniciar Sesión</a>
              </p>
         </div>
          </form>
      </div>
    </div>
    </div>

@endsection
