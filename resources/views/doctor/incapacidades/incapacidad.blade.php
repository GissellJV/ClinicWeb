@extends('layouts.plantillaDoctor')
<link rel="stylesheet" href="{{ asset('css/formulario.css') }}">
@section('contenido')
    <style>
        .formulario .form-container {
            max-width: 650px;
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

        .formulario .btn-register {
            flex: 1;
            text-align: center;
        }

        .formulario .btn-cancel {
            flex: 1;
            text-align: center;
        }

        .alert-info-custom {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
            padding: 15px 45px 15px 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            font-size: 1.05rem;
            position: relative;
            text-align: left;
            border-left: solid #0c5460;
        }
    </style>

    <div class="formulario">
        <section class="register-section" style="margin-top: 35px;">
            <h1 class="text-center text-info-emphasis">Incapacidad Médica</h1>
            <div class="form-container"  style="margin-top: 35px;">



                {{-- Mensaje de exito --}}
                @if(session('success'))
                    <div class="alert alert-info-custom alert-dismissible fade show mb-4" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                @endif


                <form action="{{ route('doctor.guardar-incapacidad') }}" method="POST" novalidate>
                    @csrf

                    <div class="mb-4">
                        <label for="paciente_id" class="form-label">
                            Paciente
                        </label>
                        <div class="input-group">
                            <select
                                id="paciente_id"
                                name="paciente_id"
                                class="form-control @error('paciente_id') @enderror"
                            >
                                <option value="" >Seleccione un paciente</option>
                                @foreach($pacientes as $paciente)
                                    <option value="{{ $paciente->id }}" {{ old('paciente_id') == $paciente->id ? 'selected' : '' }}>
                                        {{ $paciente->nombres }} {{ $paciente->apellidos }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('paciente_id')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="mb-4">
                        <label for="nombre_doctor" class="form-label">
                            Doctor que Emite
                        </label>
                        <div class="campo-info">

                            {{ $empleado->nombre ?? session('nombre') }} {{ $empleado->apellido ?? '' }}
                        </div>
                    </div>

                    {{-- Fecha de Inicio --}}
                    <div class="mb-4">
                        <label for="fecha_inicio" class="form-label">
                            Fecha de Inicio
                        </label>
                        <div class="input-group">
                            <input
                                type="date"
                                id="fecha_inicio"
                                name="fecha_inicio"
                                class="form-control @error('fecha_inicio')  @enderror"
                                value="{{ old('fecha_inicio') }}"

                            >
                        </div>
                        @error('fecha_inicio')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Fecha de Fin --}}
                    <div class="mb-4">
                        <label for="fecha_fin" class="form-label">
                            Fecha de Fin
                        </label>
                        <div class="input-group">
                            <input
                                type="date"
                                id="fecha_fin"
                                name="fecha_fin"
                                class="form-control @error('fecha_fin')  @enderror"
                                value="{{ old('fecha_fin') }}"
                            >
                        </div>
                        @error('fecha_fin')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Motivo --}}
                    <div class="mb-4">
                        <label for="motivo" class="form-label">
                            Motivo de la Incapacidad
                        </label>
                        <textarea
                            id="motivo"
                            name="motivo"
                            class="form-control @error('motivo')  @enderror"
                            rows="4"
                            maxlength="1000"
                        >{{ old('motivo') }}</textarea>
                        @error('motivo')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                    {{-- Botones --}}
                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" class="btn-register">
                            Emitir Incapacidad
                        </button>

                        <a href="{{ route('doctor.listaIncapacidades') }}" class="btn-cancel" style="text-decoration-line: none">
                            Cancelar
                        </a>

                    </div>

                </form>
            </div>
        </section>
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
