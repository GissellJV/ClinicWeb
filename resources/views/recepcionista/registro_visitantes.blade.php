@extends('layouts.plantillaRecepcion')
<link rel="stylesheet" href="{{ asset('css/formulario.css') }}">

@section('contenido')
    <style>
        body { padding-top: 100px; }
        .text-info-emphasis { font-weight: bold; color: #2C5F5D; }

        .form-group { margin-bottom: 20px; }

        /* Estilo para los mensajes de error en letras rojas */
        .text-danger {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 5px;
            display: block;
            font-weight: 600;
        }

        .button-group {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .btn-primary {
            padding: 0.875rem 2rem;
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
        }

        .btn-secondary {
            padding: 0.875rem 2rem;
            background: white;
            border: 2px solid #dc3545;
            border-radius: 8px;
            color: #dc3545;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
        }
    </style>

    <div class="formulario">
        <div class="register-section">
            <h1 class="text-center text-info-emphasis">Registro de Visitantes</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger shadow-sm border-0" style="border-radius: 10px;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <div class="form-container">
            {{-- Quitamos 'required' de los inputs para que Laravel tome el control de la validación roja --}}
            <form method="POST" action="{{ route('visitantes.store') }}" id="visitanteForm" novalidate>
                @csrf

                <div class="form-group">
                    <label class="form-label" for="nombre_visitante">Nombre Completo del Visitante</label>
                    <input type="text" class="form-control @error('nombre_visitante') is-invalid @enderror" id="nombre_visitante" name="nombre_visitante" placeholder="Ej: Juan Pérez" value="{{ old('nombre_visitante') }}">
                    @error('nombre_visitante')
                    <span class="text-danger"><i class="fas fa-info-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="dni_visitante">Documento de Identidad (DNI)</label>
                    <input type="text" class="form-control @error('dni_visitante') is-invalid @enderror" id="dni_visitante" name="dni_visitante" placeholder="0000-0000-00000" value="{{ old('dni_visitante') }}">
                    @error('dni_visitante')
                    <span class="text-danger"><i class="fas fa-info-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
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
                    <span class="text-danger"><i class="fas fa-info-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-user-check"></i> Crear Registro
                    </button>
                    <a href="{{ url('/') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('visitanteForm').addEventListener('submit', function(e) {
            // Solo mostramos el spinner si los campos básicos están llenos (opcional)
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Implementando...';
        });
    </script>
@endsection
