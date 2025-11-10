@extends('layouts.plantillaRecepcion')
<link rel="stylesheet" href="{{ asset('css/formulario.css') }}">
    @section('contenido')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Expediente Médico</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f0f4f8;
            min-height: 100vh;
            padding: 20px;
        }

        /* Botón de navegación navbar-toggler */
        .navbar-toggler {
            padding: 0.25rem 0.75rem;
            font-size: 1.25rem;
            line-height: 1;
            background-color: transparent;
            border: 1px solid transparent;
            border-radius: 0.375rem;
            transition: box-shadow 0.15s ease-in-out;
            margin-bottom: 20px;
            background: #4ECDC4;
            border-color: #4ECDC4;
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .navbar-toggler:hover {
            background: #45b8b0;
            border-color: #45b8b0;
            text-decoration: none;
            color: white;
        }

        .navbar-toggler-icon {
            display: inline-block;
            width: 1.5em;
            height: 1.5em;
            vertical-align: middle;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='white' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 100%;
        }

        .expediente-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .expediente-header {
            background: linear-gradient(135deg, #4ECDC4, #2b8c84);
            padding: 30px 40px;
            text-align: center;
            color: white;
        }

        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            backdrop-filter: blur(10px);
        }

        .logo::before {
            content: '+';
            color: white;
            font-size: 2rem;
            font-weight: bold;
        }

        .logo-text {
            font-size: 1.8rem;
            font-weight: bold;
            color: white;
        }

        .expediente-header h1 {
            font-size: 1.6rem;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .expediente-header p {
            font-size: 0.95rem;
            opacity: 0.9;
        }

        .expediente-form {
            padding: 30px 40px 40px 40px;
        }

        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-weight: 500;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .section-title {
            color: #2c3e50;
            font-size: 1.3rem;
            font-weight: 600;
            margin: 30px 0 20px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #4ECDC4;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper input,
        .input-wrapper select,
        .input-wrapper textarea {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e8f4f3;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8fffe;
        }

        .input-wrapper input:focus,
        .input-wrapper select:focus,
        .input-wrapper textarea:focus {
            outline: none;
            border-color: #4ECDC4;
            background: white;
            box-shadow: 0 0 0 4px rgba(78, 205, 196, 0.1);
        }

        .input-wrapper input:hover,
        .input-wrapper select:hover,
        .input-wrapper textarea:hover {
            border-color: #4ECDC4;
        }

        .input-wrapper input[readonly] {
            background-color: #f8f9fa;
            color: #6c757d;
            cursor: not-allowed;
        }

        .form-text {
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 5px;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            margin-top: 25px;
        }

        .checkbox-group input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            cursor: pointer;
        }

        .checkbox-group label {
            margin: 0;
            cursor: pointer;
            font-weight: 500;
            color: #2c3e50;
        }

        /* BOTONES ORIGINALES */
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
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            background: #007bff;
            color: white;
            border: 1px solid #007bff;
        }

        .btn-primary:hover {
            background: #0056b3;
            border-color: #0056b3;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
            border: 1px solid #6c757d;
        }

        .btn-secondary:hover {
            background: #545b62;
            border-color: #545b62;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        @media (max-width: 768px) {
            .expediente-form {
                padding: 20px;
            }

            .expediente-header {
                padding: 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .button-group {
                flex-direction: column;
            }

            .logo-text {
                font-size: 1.4rem;
            }

            .expediente-header h1 {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            .expediente-container {
                margin: 10px auto;
            }
        }
    </style>
</head>
<body>
<!-- Botón de navegación navbar-toggler -->
<div style="max-width: 1200px; margin: 0 auto 20px auto;">
    <a href="{{ route('recepcionista.busquedaexpediente') }}" class="navbar-toggler">
        <span class="navbar-toggler-icon"></span>
        Menú Principal
    </a>
</div>

<div class="expediente-container">
    <div class="expediente-header">
        <div class="logo-container">
            <div class="logo"></div>
            <div class="logo-text">ClinicWeb</div>
        </div>
        <h1>Crear Nuevo Expediente Médico</h1>
        <p>Complete la información médica del paciente</p>
    </div>

    <div class="expediente-form">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('expedientes.guardar') }}" method="POST" id="expedienteForm">
            @csrf

            <!-- Información del Expediente -->
            <h3 class="section-title">Información del Expediente</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="numero_expediente">Número de Expediente</label>
                    <div class="input-wrapper">
                        <input type="text" class="form-control" id="numero_expediente" value="{{ $numero_expediente }}" readonly>
                    </div>
                    <small class="form-text text-muted">Generado automáticamente</small>
                </div>

                <div class="form-group">
                    <label for="paciente_id">Seleccionar Paciente *</label>
                    <div class="input-wrapper">
                        @if($pacienteSeleccionado)
                            {{-- SI YA EXISTE UN PACIENTE SELECCIONADO, DESDE EL BOTON CREAR EXPEDIENTE--}}

                            <input type="text" class="form-control"
                                   value="{{ $pacienteSeleccionado->nombres }} - {{ $pacienteSeleccionado->numero_identidad }}"
                                   readonly>
                            <input type="hidden" name="paciente_id" value="{{ $pacienteSeleccionado->id }}">
                        @else
                        <select class="form-select" id="paciente_id" name="paciente_id" required>
                            <option value="">Seleccione un paciente</option>
                            @foreach($pacientes as $paciente)
                                <option value="{{ $paciente->id }}" {{ $paciente_id == $paciente->id ? 'selected' : '' }}>
                                    {{ $paciente->nombres }} - {{ $paciente->numero_identidad }}
                                </option>
                            @endforeach
                        </select>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Signos Vitales -->
            <h3 class="section-title">Signos Vitales</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="peso">Peso (kg)</label>
                    <div class="input-wrapper">
                        <input type="number" step="0.1" class="form-control" id="peso" name="peso" placeholder="Ej: 70.5">
                    </div>
                </div>

                <div class="form-group">
                    <label for="altura">Altura (m)</label>
                    <div class="input-wrapper">
                        <input type="number" step="0.01" class="form-control" id="altura" name="altura" placeholder="Ej: 1.75">
                    </div>
                </div>

                <div class="form-group">
                    <label for="temperatura">Temperatura (°C)</label>
                    <div class="input-wrapper">
                        <input type="text" class="form-control" id="temperatura" name="temperatura" placeholder="Ej: 36.5">
                    </div>
                </div>

                <div class="form-group">
                    <label for="presion_arterial">Presión Arterial</label>
                    <div class="input-wrapper">
                        <input type="text" class="form-control" id="presion_arterial" name="presion_arterial" placeholder="Ej: 120/80">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="frecuencia_cardiaca">Frecuencia Cardíaca</label>
                    <div class="input-wrapper">
                        <input type="text" class="form-control" id="frecuencia_cardiaca" name="frecuencia_cardiaca" placeholder="Ej: 72 lpm">
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <input class="form-check-input" type="checkbox" id="tiene_fiebre" name="tiene_fiebre" value="1">
                        <label class="form-check-label" for="tiene_fiebre">¿Tiene fiebre?</label>
                    </div>
                </div>
            </div>

            <!-- Síntomas y Diagnóstico -->
            <h3 class="section-title">Información Médica</h3>
            <div class="form-group full-width">
                <label for="sintomas_actuales">Síntomas Actuales</label>
                <div class="input-wrapper">
                    <textarea class="form-control" id="sintomas_actuales" name="sintomas_actuales" rows="3" placeholder="Describa los síntomas que presenta el paciente"></textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="diagnostico">Diagnóstico</label>
                    <div class="input-wrapper">
                        <textarea class="form-control" id="diagnostico" name="diagnostico" rows="3" placeholder="Diagnóstico médico"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="tratamiento">Tratamiento</label>
                    <div class="input-wrapper">
                        <textarea class="form-control" id="tratamiento" name="tratamiento" rows="3" placeholder="Tratamiento prescrito"></textarea>
                    </div>
                </div>
            </div>

            <!-- Antecedentes -->
            <h3 class="section-title">Antecedentes</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="alergias">Alergias</label>
                    <div class="input-wrapper">
                        <textarea class="form-control" id="alergias" name="alergias" rows="2" placeholder="Lista de alergias conocidas"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="medicamentos_actuales">Medicamentos Actuales</label>
                    <div class="input-wrapper">
                        <textarea class="form-control" id="medicamentos_actuales" name="medicamentos_actuales" rows="2" placeholder="Medicamentos que toma actualmente"></textarea>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="antecedentes_familiares">Antecedentes Familiares</label>
                    <div class="input-wrapper">
                        <textarea class="form-control" id="antecedentes_familiares" name="antecedentes_familiares" rows="3" placeholder="Enfermedades hereditarias o familiares"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="antecedentes_personales">Antecedentes Personales</label>
                    <div class="input-wrapper">
                        <textarea class="form-control" id="antecedentes_personales" name="antecedentes_personales" rows="3" placeholder="Enfermedades previas, cirugías, etc."></textarea>
                    </div>
                </div>
            </div>

            <!-- Observaciones -->
            <div class="form-group full-width">
                <label for="observaciones">Observaciones Generales</label>
                <div class="input-wrapper">
                    <textarea class="form-control" id="observaciones" name="observaciones" rows="3" placeholder="Observaciones adicionales"></textarea>
                </div>
            </div>

            <!-- BOTONES ORIGINALES -->
            <div class="button-group">
                <a href="{{ route('recepcionista.busquedaexpediente') }}" class="btn btn-secondary">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    Guardar Expediente
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Validación del formulario
    const formulario = document.getElementById('expedienteForm');
    const pacienteSelect = document.getElementById('paciente_id');

    formulario.addEventListener('submit', function(e) {
        if (!pacienteSelect.value) {
            e.preventDefault();
            alert('Por favor, seleccione un paciente');
            pacienteSelect.focus();
            return false;
        }
    });
</script>
</body>
</html>
@endsection
