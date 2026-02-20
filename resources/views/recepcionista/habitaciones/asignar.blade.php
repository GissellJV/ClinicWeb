@extends('layouts.plantillaRecepcion')
<link rel="stylesheet" href="{{ asset('css/formulario.css') }}">
@section('contenido')

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .main-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        h1 {
            color: #0f766e;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 30px;
            text-align: center;
        }

        .info-banner {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            color: white;
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            text-align: center;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            color: #555;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .form-label .required {
            color: #ef4444;
            margin-left: 4px;
        }

        .form-control, .form-select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s;
            background: white;
        }

        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: #4ecdc4;
            box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.1);
        }

        .form-select option {
            padding: 10px;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .helper-text {
            color: #666;
            font-size: 13px;
            margin-top: 5px;
        }

        .habitacion-info {
            background: #f0f9ff;
            padding: 10px 15px;
            border-radius: 8px;
            margin-top: 10px;
            color: #0369a1;
            font-size: 13px;
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 14px 20px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-asignar {
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

        .btn-asignar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        }

        .btn-cancel {
            padding: 0.875rem 2rem;
            background: white;
            border: 2px solid #dc3545;
            border-radius: 8px;
            color: #dc3545;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }

        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            border: none;
        }

        .alert-success {
            background: #d4f4f0;
            color: #0d5550;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .alert-info {
            background: #fff4e5;
            color: #856404;
            border-left: 4px solid #f39c12;
        }

        .text-info-emphasis {

            font-weight: bold;
        }
    </style>

    <br> <br>
    <h1 class="text-info-emphasis"> Asignar Habitación a Paciente</h1>
    <div class="formulario">


    <div class="form-container">


        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif


        @if(count($habitacionesDisponibles) == 0)
            <div class="info-banner" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                <i class="fas fa-exclamation-triangle"></i>
                Todos los pacientes ya tienen habitación asignada.
            </div>
        @endif

        <form action="{{ route('recepcionista.habitaciones.store') }}" method="POST">
            @csrf

            <!-- Seleccionar Paciente -->
            <div class="form-group">
                <label class="form-label">
                    @if($pacienteSeleccionado)
                        {{-- SI YA EXISTE UN PACIENTE SELECCIONADO--}}
                  Paciente
                    @else

                    Seleccionar Paciente <span class="required">*</span>
                    @endif
                </label>
                @if($pacienteSeleccionado)
                    {{-- SI YA EXISTE UN PACIENTE SELECCIONADO--}}

                    <input type="text" class="form-control"
                           value="{{ $pacienteSeleccionado->nombres }} - {{ $pacienteSeleccionado->numero_identidad }}"
                           readonly>
                    <input type="hidden" name="paciente_id" value="{{ $pacienteSeleccionado->id }}">
                @else
                <select name="paciente_id" id="paciente_id" class="form-select" required>
                    <option value="">-- Seleccione un paciente --</option>
                    @foreach($pacientes as $paciente)
                        <option value="{{ $paciente->id }}"
                            {{ $pacienteSeleccionado && $pacienteSeleccionado->id == $paciente->id ? 'selected' : '' }}>
                            {{ $paciente->nombres }} {{ $paciente->apellidos }}
                            @if($paciente->numero_identidad)
                                - ID: {{ $paciente->numero_identidad }}
                            @endif
                        </option>
                    @endforeach
                </select>
                @endif
                @if(count($pacientes) == 0)
                    <p class="helper-text" style="color: #ef4444;">
                        <i class="fas fa-exclamation-triangle"></i>
                        No hay pacientes disponibles para asignar
                    </p>
                @endif
            </div>

            <!-- Habitación Disponible -->
            <div class="form-group">
                <label class="form-label">
                    Habitación Disponible <span class="required">*</span>
                </label>
                <select name="habitacion_id" id="habitacion_id" class="form-select" required>
                    <option value="">-- Seleccione una habitación --</option>
                    @foreach($habitacionesDisponibles as $habitacion)
                        <option value="{{ $habitacion->id }}">
                            Habitación {{ $habitacion->numero_habitacion }}
                            - {{ ucfirst($habitacion->tipo) }}
                            @if($habitacion->descripcion)
                                ({{ $habitacion->descripcion }})
                            @endif
                        </option>
                    @endforeach
                </select>
                <div class="habitacion-info" id="habitacionInfo" style="display: none;">
                    <i class="fas fa-info-circle"></i>
                    <span id="habitacionDetalle"></span>
                </div>
            </div>

            <!-- Observaciones -->
            <div class="form-group">
                <label class="form-label">
                    Observaciones <span style="color: #999;">(opcional)</span>
                </label>
                <textarea
                    name="observaciones"
                    class="form-control"
                    placeholder="Ingrese observaciones adicionales sobre la asignación (opcional)"
                    maxlength="500"></textarea>
                <p class="helper-text">Máximo 500 caracteres</p>
            </div>

            <!-- Botones -->
            <div class="button-group">
                <button type="submit" class="btn btn-asignar"
                    {{ count($habitacionesDisponibles) == 0 || count($pacientes) == 0 ? 'disabled' : '' }}>
                    <i class="fas fa-save"></i> Asignar Habitación
                </button>
                <a href="{{ route('listadocitas') }}" class="btn btn-cancel">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
    </div>

    <script>
        // Mostrar información de la habitación seleccionada
        document.getElementById('habitacion_id').addEventListener('change', function() {
            const select = this;
            const selectedOption = select.options[select.selectedIndex];
            const habitacionInfo = document.getElementById('habitacionInfo');
            const habitacionDetalle = document.getElementById('habitacionDetalle');

            if (select.value) {
                habitacionDetalle.textContent = selectedOption.text;
                habitacionInfo.style.display = 'block';
            } else {
                habitacionInfo.style.display = 'none';
            }
        });

        // Validación antes de enviar
        document.querySelector('form').addEventListener('submit', function(e) {
            const paciente = document.getElementById('paciente_id').value;
            const habitacion = document.getElementById('habitacion_id').value;

            if (!paciente || !habitacion) {
                e.preventDefault();
                alert('Por favor seleccione un paciente y una habitación');
            }
        });
    </script>

@endsection
