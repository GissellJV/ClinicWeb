@extends('layouts.plantillaRecepcion')
<link rel="stylesheet" href="{{ asset('css/formulario.css') }}">

@section('contenido')
    <style>
        body { background: whitesmoke; padding-top: 100px; }
        .text-info-emphasis { font-weight: bold; color: #2C5F5D; margin-bottom: 20px; }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            font-weight: 600;
        }

        /* Notificación Personalizada Premium */
        .custom-alert {
            background: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            animation: slideIn 0.5s ease-out;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .alert-premium-success { border-left: 5px solid #4ecdc4; }
        .alert-premium-error { border-left: 5px solid #dc3545; }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Botones alineados a la izquierda y del mismo tamaño */
        .btn-container-left {
            display: flex;
            gap: 15px;
            justify-content: flex-start;
            margin-left: -5px;
            margin-top: 35px;
        }

        .btn-custom {
            width: 180px;
            height: 46px;
            border-radius: 8px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 1rem;
            border: none;
        }

        .btn-custom-cancel {
            background: white;
            border: 2px solid #dc3545;
            color: #dc3545;
        }

        .btn-custom-confirm {
            background: #4ecdc4;
            color: white;
            cursor: pointer;
        }

        .form-label { font-weight: 600; color: #2c3e50; margin-bottom: 5px; display: block; }
    </style>

    <div class="formulario">
        <div class="register-section">
            <h1 class="text-center text-info-emphasis">Registro de Visitantes</h1>

            <div class="form-container shadow-sm">

                {{-- Notificación de ÉXITO (Ahora dentro del contenedor y con el mismo estilo del error) --}}
                @if(session('success'))
                    <div class="custom-alert alert-premium-success">
                        <div class="msg-content">
                            <span style="font-weight: bold; color: #2c3e50; display: block;">Operación Exitosa</span>
                            <span style="color: #7f8c8d; font-size: 0.95rem;">{{ session('success') }}</span>
                        </div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Notificación de ERROR --}}
                @if(session('error'))
                    <div class="custom-alert alert-premium-error">
                        <div class="msg-content">
                            <span style="font-weight: bold; color: #2c3e50; display: block;">Error de Proceso</span>
                            <span style="color: #7f8c8d; font-size: 0.95rem;">{{ session('error') }}</span>
                        </div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('visitantes.store') }}" id="visitanteForm" novalidate>
                    @csrf

                    <div class="mb-4">
                        <label class="form-label" for="nombre_visitante">Nombre Completo del Visitante</label>
                        <input type="text" class="form-control @error('nombre_visitante') is-invalid @enderror"
                               id="nombre_visitante" name="nombre_visitante" placeholder="Ej: Juan Pérez"
                               value="{{ old('nombre_visitante') }}">
                        @error('nombre_visitante')
                        <div class="invalid-feedback">El nombre es requerido.</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="dni_visitante">Documento de Identidad (DNI)</label>
                        <input type="text" class="form-control @error('dni_visitante') is-invalid @enderror"
                               id="dni_visitante" name="dni_visitante" placeholder="0000-0000-00000"
                               value="{{ old('dni_visitante') }}">
                        @error('dni_visitante')
                        <div class="invalid-feedback">DNI inválido o requerido.</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="paciente_id">Paciente a Visitar</label>
                        <select class="form-control @error('paciente_id') is-invalid @enderror" id="paciente_id" name="paciente_id">
                            <option value="">Seleccionar paciente internado...</option>
                            @foreach($pacientes as $paciente)
                                <option value="{{ $paciente->id }}" {{ old('paciente_id') == $paciente->id ? 'selected' : '' }}>
                                    {{ $paciente->nombres }} {{ $paciente->apellidos }}
                                </option>
                            @endforeach
                        </select>
                        @error('paciente_id')
                        <div class="invalid-feedback">Debe seleccionar un paciente.</div>
                        @enderror
                    </div>

                    <div class="btn-container-left">
                        <a href="{{ url('/') }}" class="btn-custom btn-custom-cancel">Cancelar</a>
                        <button type="submit" class="btn-custom btn-custom-confirm">Crear Registro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
