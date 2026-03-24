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

        /* ================= MODIFICACIÓN MODO OSCURO ================= */
        .dark-mode body {
            background: #121212 !important; /* fondo general */
            color: #e4e4e4 !important;
            display: flex;
        }

        .dark-mode .formulario {
            background: #1e1e1e !important; /* fondo del contenedor principal */

        }

        .dark-mode .form-container {
            background: #1e1e1e !important; /* fondo del formulario */
            border: 1px solid #333;
        }

        /* TÍTULO */
        .dark-mode .register-section h1 {
            color: #4ecdc4 !important; /* mismo color que login */
        }

        /* LABELS */
        .dark-mode label {
            color: #ccc !important;
        }

        /* INPUTS */
        .dark-mode .form-control,
        .dark-mode input,
        .dark-mode select,
        .dark-mode textarea {
            background-color: #2a2a2a !important;
            color: #fff !important;
            border: 1px solid #444 !important;
        }

        .dark-mode .form-control::placeholder {
            color: #888 !important;
        }

        /* ALERTAS / ERRORES */
        .dark-mode .text-danger,
        .dark-mode small.text-danger {
            color: #ff6b6b !important;
        }

        /* BOTONES */
        .dark-mode .btn-register {
            background: linear-gradient(135deg, #2c5364, #203a43);
            color: #e4e4e4;
            border: none;
            transition: all 0.3s ease;
        }

        .dark-mode .btn-register:hover {
            background: linear-gradient(135deg, #4ecdc4, #00ffe7);
            color: #000;
            box-shadow: 0 0 10px #00ffe7;
            transform: translateY(-2px);
        }

        .dark-mode .btn-cancel {
            background: #2a2a2a;
            color: #ccc;
            border: 1px solid #555;
        }

        .dark-mode .btn-cancel:hover {
            background: #dc3545;
            color: white;
            box-shadow: 0 0 10px rgba(220,53,69,0.5);
        }

        /* RADIO BUTTONS */
        .dark-mode .form-check-label {
            color: #ccc !important;
        }

        .dark-mode .form-check-input {
            background-color: #2a2a2a !important;
            border-color: #444 !important;
        }

        /* ENLACES */
        .dark-mode .formulario a {
            color: #4ecdc4 !important;
        }

        .dark-mode .formulario a:hover {
            color: #00ffe7 !important;
        }
        .dark-mode .form-container {
            border-top: 5px solid #4ecdc4 !important;
        }
    </style>
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
                <input type="text" class="form-control" id="numero_identidad" name="numero_identidad" placeholder="0000000000000" value="{{old('numero_identidad')}}" >
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
                <!-- CORREO -->
                <div class="mb-3">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="ejemplo@gmail.com">

                    @error('email')
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
                  <a style="color: #4ecdc4; text-decoration: none; font-weight: 500;" href="{{route('login.sesion')}}">Iniciar Sesión</a>
              </p>
         </div>
          </form>
      </div>
    </div>
    </div>

@endsection
