@extends('layouts.plantillaRecepcion')
<link rel="stylesheet" href="{{ asset('css/formulario.css') }}">
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
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
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
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
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

        small.text-danger {
            font-size: 0.875em;
        }
    </style>
<div class="formulario">

        <div class="register-section">
            <h1 class=" text-center text-info-emphasis"> Agendar Cita - Recepción</h1>

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
    <div class="form-container">
        <form class="" method="POST" action="{{ route('recepcionista.citas.guardar') }}" id="agendarForm">
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
            <label for="especialidad" class="form-label">Especialidad</label>
            <select id="especialidad" name="especialidad" class="form-control" required>
                <option value="">Seleccionar especialidad</option>
                @foreach($especialidades as $especialidad)
                    <option value="{{ $especialidad }}">{{ $especialidad }}</option>
                @endforeach
            </select>
            </div>

            <!-- Doctor -->
            <div class="form-group">
            <label for="empleado_id" class="form-label" >Doctor</label>
            <select id="empleado_id" name="empleado_id" class="form-control" required>
                <option value="">Seleccionar doctor</option>
                @foreach($doctores as $doctor)
                    <option value="{{ $doctor->id }}">{{ $doctor->nombre }}</option>
                @endforeach
            </select>
            <div id="loadingDoctores" class="loading" style="display:none;">Cargando doctores...</div>
            </div>

            <!-- Fecha de la Cita -->
                <div class="form-group">
            <div class="form-group">
                <label class="form-label" for="fecha_cita"> Fecha de la Cita</label>
                <input type="date" class="form-control" id="fecha_cita" name="fecha_cita" min="{{ date('Y-m-d') }}" required>
            </div>
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
</div>
    <script>
        // Filtrar doctores por especialidad
        document.getElementById('especialidad').addEventListener('change', function() {
            const especialidad = this.value;
            const doctorSelect = document.getElementById('empleado_id');
            const loading = document.getElementById('loadingDoctores');

            doctorSelect.innerHTML = '<option value="">Seleccionar doctor</option>';

            if (especialidad) {
                loading.style.display = 'block';
                fetch(`/recepcionista/doctores-especialidad/${especialidad}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(doctor => {
                            const option = document.createElement('option');
                            option.value = doctor.id;
                            option.textContent = doctor.nombre;
                            doctorSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error:', error))
                    .finally(() => {
                        loading.style.display = 'none';
                    });
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
