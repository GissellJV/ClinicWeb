Plantilla Seguimiento
@extends('layouts.plantillaDoctor')
<link rel="stylesheet" href="{{ asset('css/formulario.css') }}">

@section('contenido')

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:whitesmoke;
        }
        .text-info-emphasis {

            font-weight: bold;
        }

        .campo-info{
            background: #eaf4f4;
            border: 1px solid #cfe2e2;
            border-radius: 12px;
            padding: 12px;
            font-weight: 500;
            color: #1c6b6b;
        }

    </style>

    <br> <br> <br>
    <h1 class="text-center text-info-emphasis">Programar cita de seguimiento</h1>

    <br> <br>
    <div class="formulario">
        <div class="form-container">
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


                <div class="form-group">
                <label class="form-label">Doctor:</label>
                <div class="campo-info">
                    {{ $doctor->nombre }} {{ $doctor->apellido }}
                </div>
            </div>

            <br>

            <div class="form-group">
                <label class="form-label">Especialidad:</label>
                <div class="campo-info">
                    {{ $doctor->departamento }}
                </div>
            </div>
            <br>
                <form method="POST" action="{{ route('doctor.guardarSeguimiento') }}">
                    @csrf

                    <label class="form-label">Paciente</label>
                    <select name="paciente_id" class="form-control">
                        <option value="">Seleccione paciente</option>
                        @foreach($pacientes as $p)
                            <option value="{{ $p->id }}" {{ old('paciente_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->nombres }} {{ $p->apellidos }}
                            </option>
                        @endforeach
                    </select>
                    @error('paciente_id')
                    <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror

                    <br>

                    <div>
                        <label class="form-label">Fecha</label>
                        <input type="date" name="fecha" class="form-control" value="{{ old('fecha') }}">
                        @error('fecha')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <br>

                    <div class="form-group mt-2">
                        <label class="form-label">Hora</label>
                        <input
                            type="text"
                            name="hora"
                            class="form-control"
                            placeholder="Ej: 12:00 PM"
                            value="{{ old('hora') }}"
                        >
                        @error('hora')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <br>

                    <button class="btn-register">
                        Guardar cita de seguimiento
                    </button>
                </form>

        </div>
    </div>

    <script>
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.style.transition = "opacity 0.5s";
                alert.style.opacity = "0";
                setTimeout(()=> alert.remove(), 500);
            });
        }, 2500);
    </script>
@endsection
