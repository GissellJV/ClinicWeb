@extends('layouts.plantilla')

@section('contenido')
    <style>
        .agendar-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .header-section {
            text-align: center;
            margin-bottom: 30px;
            background: #82e9de;
            color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .header-section h1 {
            margin: 0;
            font-size: 2rem;
            font-weight: 600;
        }

        .header-section p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }

        .agendar-form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border: 1px solid #e0e0e0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 2px solid #e2e8f0;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #82e9de;
            box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.1);
            outline: none;
        }

        .button-group {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background: #82e9de;
            color: white;
        }

        .btn-primary:hover {
            background: #82e9de;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgb(130, 233, 222);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #545b62;
            transform: translateY(-2px);
        }

        .alert-success {
            background: #d4edda;
            color: #82e9de;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }

        .loading {
            display: none;
            text-align: center;
            padding: 10px;
            color: #82e9de;
        }

        .doctor-options {
            margin-top: 10px;
        }

        .doctor-option {
            padding: 8px 12px;
            margin: 5px 0;
            background: #f8f9fa;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .doctor-option:hover {
            background: #e9ecef;
        }

        .doctor-option.selected {
            background: #82e9de;
            color: white;
        }
        select.form-control {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
        .form-label::before {
            content: "•";
            color: #82e9de;
            font-weight: bold;
            display: inline-block;
            width: 1em;
            margin-right: 5px;
        }
        .form-control:required {
            border-left: 3px solid #82e9de;
        }
    </style>

    <div class="agendar-container">
        <div class="header-section">
            <h1> Agendar Cita - Recepción</h1>
            <p>Registra una nueva cita médica para el paciente</p>
        </div>

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

        <form class="agendar-form" method="POST" action="{{ route('recepcionista.citas.guardar') }}" id="agendarForm">
            @csrf

            <!-- Selección de Paciente -->
            <div class="form-group">
                <label class="form-label" for="paciente_id"> Paciente</label>
                <select class="form-control" id="paciente_id" name="paciente_id" required>
                    <option value="">Seleccionar paciente</option>
                    @foreach($pacientes as $paciente)
                        <option value="{{ $paciente->id }}">
                            {{ $paciente->nombres }} {{ $paciente->apellidos }} - {{ $paciente->numero_identidad }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Especialidad -->
            <div class="form-group">
                <label class="form-label" for="especialidad"> Especialidad</label>
                <select class="form-control" id="especialidad" name="especialidad" required>
                    <option value="">Seleccionar especialidad</option>
                    @foreach($especialidades as $especialidad)
                        <option value="{{ $especialidad }}">{{ $especialidad }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Doctor -->
            <div class="form-group">
                <label class="form-label" for="empleado_id">️ Doctor</label>
                <select class="form-control" id="empleado_id" name="empleado_id" required disabled>
                    <option value="">Primero seleccione una especialidad</option>
                </select>
                <div class="loading" id="loadingDoctores">
                    <i class="fas fa-spinner fa-spin"></i> Cargando doctores...
                </div>
            </div>

            <!-- Fecha de la Cita -->
            <div class="form-group">
                <label class="form-label" for="fecha_cita"> Fecha de la Cita</label>
                <input type="date" class="form-control" id="fecha_cita" name="fecha_cita" min="{{ date('Y-m-d') }}" required>
            </div>

            <!-- Hora de la Cita -->
            <div class="form-group">
                <label class="form-label" for="hora_cita"> Hora de la Cita</label>
                <select class="form-control" id="hora_cita" name="hora_cita" required>
                    <option value="">Seleccionar hora</option>
                    <option value="08:00">08:00 AM</option>
                    <option value="09:00">09:00 AM</option>
                    <option value="10:00">10:00 AM</option>
                    <option value="11:00">11:00 AM</option>
                    <option value="14:00">02:00 PM</option>
                    <option value="15:00">03:00 PM</option>
                    <option value="16:00">04:00 PM</option>
                    <option value="17:00">05:00 PM</option>
                </select>
            </div>

            <!-- Tipo de Consulta -->
            <div class="form-group">
                <label class="form-label" for="tipo_consulta"> Tipo de Consulta</label>
                <select class="form-control" id="tipo_consulta" name="tipo_consulta" required>
                    <option value="">Seleccionar tipo</option>
                    <option value="Primera vez">Primera vez</option>
                    <option value="Control">Control</option>
                    <option value="Emergencia">Emergencia</option>
                    <option value="Examen">Examen</option>
                </select>
            </div>

            <!-- Descripción -->
            <div class="form-group">
                <label class="form-label" for="descripcion"> Descripción (Opcional)</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Descripción breve de la consulta"></textarea>
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-calendar-check"></i> Agendar Cita
                </button>
                <a href="{{ route('listadocitas') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>

    <script>
        // Filtrar doctores por especialidad
        document.getElementById('especialidad').addEventListener('change', function() {
            const especialidad = this.value;
            const doctorSelect = document.getElementById('empleado_id');
            const loading = document.getElementById('loadingDoctores');

            if (especialidad) {
                loading.style.display = 'block';
                doctorSelect.disabled = true;
                doctorSelect.innerHTML = '<option value="">Cargando doctores...</option>';

                fetch(`/recepcionista/doctores-especialidad/${especialidad}`)
                    .then(response => response.json())
                    .then(data => {
                        doctorSelect.innerHTML = '<option value="">Seleccionar doctor</option>';
                        data.forEach(doctor => {
                            const option = document.createElement('option');
                            option.value = doctor.id;
                            option.textContent = `${doctor.nombre} ${doctor.apellido}`;
                            doctorSelect.appendChild(option);
                        });
                        doctorSelect.disabled = false;
                        loading.style.display = 'none';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        doctorSelect.innerHTML = '<option value="">Error al cargar doctores</option>';
                        loading.style.display = 'none';
                    });
            } else {
                doctorSelect.innerHTML = '<option value="">Primero seleccione una especialidad</option>';
                doctorSelect.disabled = true;
            }
        });

        // Validación de fecha mínima (hoy)
        document.getElementById('fecha_cita').min = new Date().toISOString().split('T')[0];

        // Validación del formulario
        document.getElementById('agendarForm').addEventListener('submit', function(e) {
            const fechaCita = document.getElementById('fecha_cita').value;
            const hoy = new Date().toISOString().split('T')[0];

            if (fechaCita < hoy) {
                e.preventDefault();
                alert('La fecha de la cita no puede ser anterior a hoy.');
                return false;
            }

            // Mostrar loading al enviar
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Agendando...';
            submitBtn.disabled = true;
        });
    </script>
@endsection
