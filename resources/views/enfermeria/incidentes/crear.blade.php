@extends('layouts.plantillaEnfermeria')

@section('titulo', 'Registrar Incidente')

@section('contenido')
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .contenedor-principal {
            max-width: 1000px;
            margin: 80px auto 40px;
            padding: 0 20px;
        }

        .cabecera-seccion {
            text-align: center;
            margin-bottom: 30px;
        }

        .titulo-principal {
            color: #00796b;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .subtitulo {
            color: #546e7a;
            font-size: 1.1rem;
            margin-bottom: 30px;
        }

        .formulario-container {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .alert-success {
            background-color: #e8f5e9;
            border-left: 4px solid #4caf50;
            color: #2e7d32;
        }

        .alert-danger {
            background-color: #ffebee;
            border-left: 4px solid #f44336;
            color: #c62828;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #00796b;
            box-shadow: 0 0 0 3px rgba(0, 121, 107, 0.1);
        }

        .form-control[readonly] {
            background-color: #f5f5f5;
            color: #757575;
            cursor: not-allowed;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23757575' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
            padding-right: 40px;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .info-box {
            background-color: #e8f4f3;
            border-left: 4px solid #4ECDC4;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .info-box strong {
            color: #00796b;
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 40px;
            justify-content: flex-end;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-cancel {
            background-color: #f5f5f5;
            color: #757575;
            border: 2px solid #e0e0e0;
        }

        .btn-cancel:hover {
            background-color: #e0e0e0;
            color: #424242;
        }

        .btn-register {
            background-color: #00796b;
            color: white;
        }

        .btn-register:hover {
            background-color: #00695c;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 121, 107, 0.3);
        }

        @media (max-width: 768px) {
            .contenedor-principal {
                margin: 60px auto 20px;
                padding: 0 15px;
            }

            .formulario-container {
                padding: 25px;
            }

            .button-group {
                flex-direction: column;
            }
        }
    </style>

    <div class="contenedor-principal">
        <div class="cabecera-seccion">
            <h1 class="titulo-principal">Registrar Incidente</h1>
            <p class="subtitulo">Complete el formulario con los detalles del incidente</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="formulario-container">
            <form action="{{ route('incidentes.guardar') }}" method="POST">
                @csrf

                <!-- Descripción del Incidente -->
                <div class="form-group">
                    <label for="descripcion">Descripción del Incidente *</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="4"
                              placeholder="Describa detalladamente qué ocurrió..." required>{{ old('descripcion') }}</textarea>
                </div>

                <!-- Fecha y Hora del Incidente -->
                <div class="info-box">
                    <div class="form-group">
                        <strong>Fecha y Hora del Incidente</strong>
                        <input type="text" class="form-control" value="{{ now()->format('d/m/Y H:i') }}" readonly>
                        <input type="hidden" name="fecha_hora_incidente" value="{{ now()->format('Y-m-d H:i:s') }}">
                    </div>
                </div>

                <!-- Paciente Involucrado -->
                <div class="info-box">
                    <div class="form-group">
                        <label for="paciente_id">Paciente Involucrado</label>
                        <select class="form-control" id="paciente_id" name="paciente_id" required>
                            <option value="">Seleccionar paciente</option>
                            @foreach($pacientes as $paciente)
                                <option value="{{ $paciente->id }}" {{ old('paciente_id') == $paciente->id ? 'selected' : '' }}>
                                    {{ $paciente->nombres }} {{ $paciente->apellidos }} - {{ $paciente->numero_identidad }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Tipo de Incidente -->
                <div class="info-box">
                    <div class="form-group">
                        <label for="tipo_incidente">Tipo de Incidente</label>
                        <select class="form-control" id="tipo_incidente" name="tipo_incidente" required>
                            <option value="">Seleccionar tipo</option>
                            <option value="Caída" {{ old('tipo_incidente') == 'Caída' ? 'selected' : '' }}>Caída</option>
                            <option value="Medicación" {{ old('tipo_incidente') == 'Medicación' ? 'selected' : '' }}>Medicación</option>
                            <option value="Alergia" {{ old('tipo_incidente') == 'Alergia' ? 'selected' : '' }}>Alergia</option>
                            <option value="Equipo Médico" {{ old('tipo_incidente') == 'Equipo Médico' ? 'selected' : '' }}>Equipo Médico</option>
                            <option value="Otro" {{ old('tipo_incidente') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>
                </div>

                <!-- Gravedad -->
                <div class="info-box">
                    <div class="form-group">
                        <label for="gravedad">Gravedad</label>
                        <select class="form-control" id="gravedad" name="gravedad" required>
                            <option value="">Seleccionar gravedad</option>
                            <option value="Leve" {{ old('gravedad') == 'Leve' ? 'selected' : '' }}>Leve</option>
                            <option value="Moderado" {{ old('gravedad') == 'Moderado' ? 'selected' : '' }}>Moderado</option>
                            <option value="Grave" {{ old('gravedad') == 'Grave' ? 'selected' : '' }}>Grave</option>
                            <option value="Crítico" {{ old('gravedad') == 'Crítico' ? 'selected' : '' }}>Crítico</option>
                        </select>
                    </div>
                </div>

                <!-- Acciones Tomadas (Opcional) -->
                <div class="form-group">
                    <label for="acciones_tomadas">Acciones Tomadas (Opcional)</label>
                    <textarea class="form-control" id="acciones_tomadas" name="acciones_tomadas" rows="3"
                              placeholder="Describa las acciones que se tomaron inmediatamente...">{{ old('acciones_tomadas') }}</textarea>
                </div>

                <!-- Estado (oculto, se establece automáticamente) -->
                <input type="hidden" name="estado" value="Pendiente">
                <input type="hidden" name="empleado_id" value="{{ session('empleado_id') }}">
                <input type="hidden" name="empleado_nombre" value="{{ session('empleado_nombre') }}">

                <!-- Botones -->
                <div class="button-group">
                    <a href="{{ route('incidentes.index') }}" class="btn btn-cancel">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-register">
                        Guardar Incidente
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
