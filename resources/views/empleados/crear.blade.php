@extends('layouts.plantillaRecepcion')
<link rel="stylesheet" href="{{ asset('css/formulario.css') }}">

@section('titulo', 'Registrar Empleado')

@section('contenido')
    <style>
        small.text-danger {
            font-size: 0.875em;
        }

        .container-empleado {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .card-empleado {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header-empleado {
            background: linear-gradient(135deg, #4ECDC4 0%, #44A08D 100%);
            padding: 30px 40px;
            color: white;
        }

        .card-header-empleado h4 {
            font-size: 1.8rem;
            font-weight: 600;
            margin: 0;
        }

        .card-body-empleado {
            padding: 50px 60px;
        }

        .form-row-custom {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .form-group-custom {
            margin-bottom: 30px;
        }

        .form-group-custom label {
            display: block;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 12px;
            font-size: 1.05rem;
        }

        .form-control-custom,
        .form-select-custom {
            width: 100%;
            background: rgba(248, 250, 255, 0.6);
            color: #555;
            padding: 16px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control-custom:focus,
        .form-select-custom:focus {
            outline: none;
            border-color: #4ECDC4;
            background: white;
            box-shadow: 0 0 0 4px rgba(78, 205, 196, 0.1);
        }

        /* Ocultar el ícono de calendario en inputs tipo date */
        input[type="date"]::-webkit-calendar-picker-indicator {
            display: none;
            -webkit-appearance: none;
        }

        input[type="date"]::-webkit-inner-spin-button,
        input[type="date"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .input-group-custom {
            display: flex;
        }

        .input-group-text {
            background: #4ECDC4;
            color: white;
            padding: 16px 20px;
            border: 2px solid #4ECDC4;
            border-radius: 12px 0 0 12px;
            font-weight: 600;
            font-size: 0.7rem;
        }

        .input-group-custom .form-control {
            border-radius: 0 12px 12px 0;
            border-left: none;
        }

        .btn-group-custom {
            display: flex;
            gap: 20px;
            justify-content: flex-end;
            margin-top: 40px;
        }

        .btn-custom {
            padding: 16px 40px;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary-custom {
            background: #4ECDC4;
            color: white;
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.3);
        }

        .btn-primary-custom:hover {
            background: #45b8b0;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
        }

        .btn-secondary-custom {
            background: #f8f9fa;
            color: #6c757d;
            border: 2px solid #e9ecef;
        }

        .btn-secondary-custom:hover {
            background: #e9ecef;
        }

        .alert-success-custom {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            font-size: 1.05rem;
        }
        .gender-options {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        form-check {
            display: inline-flex;
            align-items: center;
            padding: 0;
            margin: 0;
        }

        .form-check-input {
            margin: 0 8px 0 0 !important;
            cursor: pointer;
            vertical-align: middle;
        }

        .form-check-label {
            cursor: pointer;
            margin: 0 !important;
            padding: 0 !important;
            vertical-align: middle;
        }

        .form-check-input:checked ~ .form-check-label {
            color: #4ECDC4;
            font-weight: 600;
        }

        .form-check-input:checked {
            background-color: #4ECDC4;
            border-color: #4ECDC4;
        }

        @media (max-width: 768px) {
            .form-row-custom {
                grid-template-columns: 1fr;
            }

            .card-body-empleado {
                padding: 30px 25px;
            }

            .card-header-empleado {
                padding: 25px 25px;
            }

            .card-header-empleado h4 {
                font-size: 1.4rem;
            }
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:whitesmoke;
            padding-top: 100px;

        }

        .text-info-emphasis{
            font-weight: bold;
        }

        .foto-preview {
            margin-top: 15px;
            max-width: 200px;
        }

        .foto-preview img {
            width: 100%;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
        }


    </style>
    <div class="formulario">
            <h1 class="text-center text-info-emphasis">Registrar Nuevo Empleado</h1>
    <div class="form-container" style="margin: 10px auto; max-width: 900px">

            <div class="card-body-empleado">
                @if(session('success'))
                    <div class="alert-success-custom">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('empleados.guardar') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Nombre y Apellido -->
                    <div class="form-row-custom">
                        <div class="form-group-custom">
                            <label for="nombre">Nombre *</label>
                            <input type="text" class="form-control" id="nombre" name="nombre"
                                   value="{{ old('nombre') }}" placeholder="Ingrese el nombre">
                            @error('nombre')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group-custom">
                            <label for="apellido">Apellido *</label>
                            <input type="text" class="form-control" id="apellido" name="apellido"
                                   value="{{ old('apellido') }}" placeholder="Ingrese el apellido">
                            @error('apellido')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <!-- Genero y Numero de identidad -->
                    <div class="form-row-custom">
                        <div class="form-group-custom">
                        <label for="genero">Género *</label>
                        <div style="display: flex; gap: 50px; align-items: center;">
                            <label class="form-check" style="display: inline-flex; align-items: center;">
                                <input class="form-check-input" type="radio" name="genero" id="femenino"
                                       value="Femenino" {{ old('genero') == 'Femenino' ? 'checked' : '' }}>
                                <span>Femenino</span>
                            </label>
                            <label class="form-check" style="display: inline-flex; align-items: center;">
                                <input class="form-check-input" type="radio" name="genero" id="masculino"
                                       value="Masculino" {{ old('genero') == 'Masculino' ? 'checked' : '' }}>
                                <span>Masculino</span>
                            </label>
                        </div>
                        @error('genero')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                        <div class="form-group-custom">
                            <label for="numero_identidad">Número de Identidad *</label>
                            <input type="text" class="form-control" id="numero_identidad" name="numero_identidad"
                                   value="{{ old('numero_identidad') }}" placeholder="0000-0000-00000">
                            @error('numero_identidad')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                    <!-- Número de Telefono y Fecha de Ingreso -->
                    <div class="form-row-custom">
                        <div class="form-group-custom">
                            <label for="telefono">Número de Teléfono</label>
                            <div class="input-group-custom">
                                <span class="input-group-text">+504</span>
                                <input type="text" class="form-control" id="telefono" name="telefono"
                                       value="{{ old('telefono') }}" placeholder="00000000">
                            </div>
                            @error('telefono')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group-custom">
                            <label for="fecha_ingreso">Fecha de Ingreso</label>
                            <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso"
                                   value="{{ old('fecha_ingreso') }}">
                            @error('fecha_ingreso')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>



                    </div>
                    <!-- Cargo y Departamento -->
                    <div class="form-row-custom">
                        <div class="form-group-custom">
                            <label for="cargo">Cargo</label>
                            <select class="form-select-custom" id="cargo" name="cargo">
                                <option value="">Seleccione un cargo</option>
                                @foreach($cargos as $cargo)
                                    <option value="{{ $cargo }}" {{ old('cargo') == $cargo ? 'selected' : '' }}>
                                        {{ $cargo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cargo')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group-custom">
                            <label for="departamento">Departamento</label>
                            <select class="form-select-custom" id="departamento" name="departamento">
                                <option value="">Seleccione un departamento</option>
                                @foreach($departamentos as $depto)
                                    <option value="{{ $depto }}" {{ old('departamento') == $depto ? 'selected' : '' }}>
                                        {{ $depto }}
                                    </option>
                                @endforeach
                            </select>
                            @error('departamento')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>



                    <!-- Foto y Contraseña -->
                    <div class="form-row-custom">


                        <div class="form-group-custom">
                            <label for="password">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="Mínimo 8 caracteres">
                            @error('password')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group-custom">
                            <label for="foto">Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*" >
                            @error('foto')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>



                    <!-- Botones -->
                    <div class="btn-group-custom">
                        <a href="{{ route('empleados.lista') }}" class="btn-cancel" style="text-decoration-line: none">
                            Cancelar
                        </a>
                        <button type="submit" class="btn-register">
                            Registrar Empleado
                        </button>
                    </div>

                </form>

            </div>

    </div>
    </div>
@endsection
