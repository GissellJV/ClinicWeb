@extends('layouts.plantillaRecepcion')
<link rel="stylesheet" href="{{ asset('css/formulario.css') }}">

@section('contenido')
    <style>
        body { padding-top: 100px; }
        .text-info-emphasis { font-weight: bold; color: #2C5F5D; } /* Color turquesa oscuro de la marca */

        /* Mantenemos tus estilos originales para asegurar consistencia visual */
        .form-group { margin-bottom: 20px; }
        .button-group {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
        }

        /* Estilo de botones heredado de tu código de citas */
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

        {{-- Feedback de Validar operaciones --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="form-container">
            <form method="POST" action="{{ route('visitantes.store') }}" id="visitanteForm">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="nombre_visitante">Nombre Completo del Visitante</label>
                    <input type="text" class="form-control" id="nombre_visitante" name="nombre_visitante" placeholder="Ej: Juan Pérez" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="dni_visitante">Documento de Identidad (DNI)</label>
                    <input type="text" class="form-control" id="dni_visitante" name="dni_visitante" placeholder="0000-0000-00000" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="paciente_id">Paciente a Visitar</label>
                    <select class="form-control" id="paciente_id" name="paciente_id" required>
                        <option value="">Seleccionar paciente internado...</option>
                        @foreach($pacientes as $paciente)
                            <option value="{{ $paciente->id }}">
                                {{ $paciente->nombres }} {{ $paciente->apellidos }}
                            </option>
                        @endforeach
                    </select>
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
        // Validar el envío para dar feedback visual al usuario
        document.getElementById('visitanteForm').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Implementando...';
            submitBtn.disabled = true;
        });
    </script>
@endsection
