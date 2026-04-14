@php
    if (session('tipo_usuario') === 'empleado') {
        switch (session('cargo')) {
            case 'Recepcionista':
                $layout = 'layouts.plantillaRecepcion';
                break;
            case 'Administrador':
                $layout = 'layouts.plantillaAdmin';
                break;
            default:
                $layout = 'layouts.plantilla';
        }
    } else {
        $layout = 'layouts.plantilla';
    }
@endphp

@extends($layout)
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

        /* Bloqueo de alertas externas */
        body > .alert, .main-content > .alert, header + .alert, .container > .alert {
            display: none !important;
        }

        /* Estilo de Alerta Bootstrap (segunda captura) */
        .custom-alert {
            box-shadow: none !important;
            border-left: none !important;
            padding: 1rem 1.25rem !important;
            border-radius: 0.375rem !important;
            position: relative;
            border: 1px solid transparent;
            margin-bottom: 1rem;
            animation: slideIn 0.5s ease-out;
        }

        .alert-premium-success {
            color: #0f5132 !important;
            background-color: #d1e7dd !important;
            border-color: #badbcc !important;
        }

        .alert-premium-error {
            color: #842029 !important;
            background-color: #f8d7da !important;
            border-color: #f5c2c7 !important;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* === CORRECCIÓN DE BOTONES: 50/50 Y HOVER === */
        .btn-container-left {
            display: flex;
            gap: 15px;
            justify-content: center; /* Centrados para ocupar el 50% cada uno */
            margin-top: 35px;
        }

        .btn-custom {
            width: 50%; /* Tamaño 50/50 */
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
            cursor: pointer;
        }

        /* Estilo y Hover: Crear Registro */
        .btn-custom-confirm {
            background: #4ecdc4;
            color: white;
        }

        .btn-custom-confirm:hover {
            background: #3dbbb2; /* Color más oscuro al pasar el cursor */
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(78, 205, 196, 0.3);
        }

        /* Estilo y Hover: Cancelar */
        .btn-custom-cancel {
            background: white;
            border: 2px solid #dc3545;
            color: #dc3545;
        }

        .btn-custom-cancel:hover {
            background: #dc3545; /* Fondo rojo al pasar el cursor */
            color: white;
            transform: translateY(-2px);
        }

        .form-label { font-weight: 600; color: #2c3e50; margin-bottom: 5px; display: block; }
    </style>

    <div class="formulario">
        <div class="register-section">
            <h1 class="text-center text-info-emphasis">Registro de Visitantes</h1>

            <div class="form-container shadow-sm">

                @if(session('success'))
                    <div class="custom-alert alert-premium-success alert alert-dismissible fade show" role="alert">
                        <div class="msg-content">
                            <strong>¡Éxito!</strong> <span>{{ session('success') }}</span>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif(session('error') || session('error_habitacion'))
                    <div class="custom-alert alert-premium-error alert alert-dismissible fade show" role="alert">
                        <div class="msg-content">
                            <strong>Atención:</strong> <span>{{ session('error') ?? session('error_habitacion') }}</span>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                        {{-- Orden corregido: Confirmar primero, Cancelar después --}}
                        <button type="submit" class="btn-custom btn-custom-confirm">Crear Registro</button>
                        <a href="{{ url('/') }}" class="btn-custom btn-custom-cancel">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
