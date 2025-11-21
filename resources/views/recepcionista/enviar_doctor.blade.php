@extends('layouts.plantillaRecepcion')
<link rel="stylesheet" href="{{ asset('css/formulario.css') }}">
@section('contenido')
    <div class="formulario">
        <div class="register-section">
            <h1 class=" text-center text-info-emphasis"> Seleccionar al doctor que desea <br>
                enviar el expediente</h1>

        </div>
        <div class="form-container">
            <form method="POST" action="{{ route('recepcionista.enviarDoctor') }}">
                @csrf
                <input type="hidden" name="paciente_id" value="{{ $expediente->paciente->id }}">

                <div class="mb-3">
                    <label for="especialidad" class="form-label">Seleccionar Especialidad</label>
                    <select name="especialidad" id="especialidad" class="form-control" required>
                        <option value="">Seleccione especialidad</option>
                        @foreach($especialidades as $esp)
                            <option value="{{ $esp->departamento }}">{{ $esp->departamento }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="empleado_id" class="form-label">Seleccionar Doctor</label>
                    <select name="empleado_id" id="empleado_id" class="form-control" required>
                        <option value="">Seleccione Doctor</option>
                    </select>
                    <div id="loadingDoctores" style="display:none; margin-top:5px;">Cargando doctores...</div>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('expedientes.visualizar', ['id' => $expediente->id]) }}" class="btn-cancel">Cancelar</a>
                    <button type="submit" class="btn-register">Enviar</button>
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

            doctorSelect.innerHTML = '<option value="">Seleccione Doctor</option>';

            if (especialidad) {
                loading.style.display = 'block';

                fetch(`/recepcionista/doctores-expediente/${especialidad}`)
                    .then(res => res.json())
                    .then(data => {
                        data.forEach(doctor => {
                            const option = document.createElement('option');
                            option.value = doctor.id;
                            option.textContent = doctor.nombre + ' ' + doctor.apellido + ` (${doctor.departamento})`;
                            doctorSelect.appendChild(option);
                        });
                    })
                    .finally(() => loading.style.display = 'none');
            }
        });

    </script>

@endsection
