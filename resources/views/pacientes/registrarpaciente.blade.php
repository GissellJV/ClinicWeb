@extends('layouts.plantilla')
@section('contenido')
    <style>
        small.text-danger {
            font-size: 0.875em;
        }
    </style>
    <br><br><br>
    <div class="container">
        <h1 class="text-center " >Regístrate para Agendar tu Cita</h1>


        <div class="d-flex justify-content-center align-items-center">
            @csrf
            <!--NOMBRE COMPLETO-->
            <div class="row">
                <label for="exampleInputEmail1">Nombre Completo</label>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombres" value="{{old('nombres')}}">
                        @error('nombres')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" value="{{old('apellidos')}}">
                        @error('apellidos')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <!--FECHA-->
            <div class="mb-3">
                <div class="row">
                    <div class="col">
                        <label for="fecha" class="form-label">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="{{old('fecha_nacimiento')}}" >
                        @error('fecha_nacimiento')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <!--GENERO-->
            <div class="mb-3">
                <label for="exampleInputEmail1">Genero</label>
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="genero" id="femenino" value="Femenino" {{ old('genero') == 'Femenino' ? 'checked' : '' }}  >
                            <label class="form-check-label" for="femenino">
                                Femenino
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
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
            <div class="form-group mb-3" style="width: 100%; ">
                <label for="exampleInputPassword1">Número de identidad</label>
                <input type="text" class="form-control" id="numero_identidad" name="numero_identidad" >
                @error('numero_identidad')
                <small class="text-danger">{{ $message }}</small>
                @enderror
                <div class="invalid-feedback">Ingresa un número de identidad válido (13 dígitos)</div>

                <!--Numero de Telefono con codigo de pais-->
                <div data-mdb-input-init class="form-outline mb-3" style="width: 100%;" >

                    <label class="form-label" for="phone">Número de Telefono</label>
                    <div class="input-group">
                        <span class="input-group-text">+504</span>
                        <input type="text" id="telefono" name="telefono" class="form-control" data-mdb-input-mask-init data-mdb-input-mask="+48 999-999-999" value="{{old('telefono')}}" />
                    </div>
                    @error('telefono')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <!-- CONTRASEÑA -->
                <div class="form-group mb-3" style="width: 100%; ">
                    <label for="exampleInputPassword1">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password">
                    @error('password')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <!-- CONFIRMAR CONTRASEÑA -->
                <div class="form-group mb-3" style="width: 100%; ">
                    <label for="confirmarPassword" class="form-label">Confirmar Contraseña </label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    @error('password_confirmation')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Registrar</button>
                <a class="btn btn-danger" href="{{route('/')}}">Cancelar</a>
            </div>
    </div>
@endsection
