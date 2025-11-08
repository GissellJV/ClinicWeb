@extends('layouts.plantilla')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/formulario.css') }}">
@endpush

@section('contenido')
    <style>
        .registro-form small.text-danger {
            font-size: 0.875em;
        }
        .registro-form .footer-links {
            text-align: center;
            margin-top: 1.5rem;
            background: transparent;
        }
        .footer-links a {
            color: #4ecdc4;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            background: transparent;
        }
    </style>


    <div class="formulario">
        <div class="register-section">
            <div class="form-container">
                <h1 class="form-title">Regístrate para Agendar tu Cita</h1>

                <form method="post" action="{{route('pacientes.store')}}">
                    @csrf

                    <!--NOMBRE COMPLETO-->
                    <div class="mb-3">
                        <label class="form-label">Nombre Completo</label>
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
                        <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="{{old('fecha_nacimiento')}}">
                        @error('fecha_nacimiento')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!--GENERO -->
                    <div class="mb-3">
                        <label class="form-label">Género</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="genero" id="femenino" value="Femenino" {{ old('genero') == 'Femenino' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="femenino">
                                        Femenino
                                    </label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="genero" id="masculino" value="Masculino" {{ old('genero') == 'Masculino' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="masculino">
                                        Masculino
                                    </label>
                                </div>
                            </div>
                        </div>
                        @error('genero')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!--Numero de identidad-->
                    <div class="mb-3">
                        <label for="numero_identidad" class="form-label">Número de Identidad</label>
                        <input type="text" class="form-control" id="numero_identidad" name="numero_identidad" value="{{old('numero_identidad')}}" placeholder="0000-0000-00000">
                        @error('numero_identidad')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!--Numero de Telefono-->
                    <div class="mb-3">
                        <label class="form-label" for="telefono">Número de Teléfono</label>
                        <div class="input-group">
                            <span class="input-group-text">+504</span>
                            <input type="text" id="telefono" name="telefono" class="form-control" value="{{old('telefono')}}" placeholder="0000-0000">
                        </div>
                        @error('telefono')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!--Contraseña-->
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Mínimo 8 caracteres">
                        @error('password')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- CONFIRMAR CONTRASEÑA -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Repite tu contraseña">
                        @error('password_confirmation')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- BOTONES -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                        <button type="submit" class="btn btn-register">Registrar</button>
                        <a class="btn btn-cancel" href="{{route('/')}}">Cancelar</a>
                    </div>

                    <!-- Enlaces debajo de los botones -->
                    <div class="text-center mt-3">
                        <p style="margin-bottom: 0.5rem; color: #666;">¿Ya tienes una cuenta?
                            <a href="{{route('pacientes.login')}}" style="color: #4ecdc4; text-decoration: none; font-weight: 500;">Iniciar Sesión</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>



@endsection
