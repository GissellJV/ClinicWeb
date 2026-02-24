@extends('layouts.plantilla')
<link rel="stylesheet" href="{{ asset('css/formulario.css') }}">

@section('contenido')
    <style>
        body { background: whitesmoke; }
        .form-header-icon { display: none; }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* Estilo idéntico a tus capturas (image_7a291e.png / image_7a213d.png) */
        .custom-alert-clinic {
            background: #e8f8f7;
            border: 1px solid #4ecdc4;
            color: #2c3e50;
            padding: 15px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            position: relative;
            border-radius: 8px;
            animation: fadeIn 0.4s ease-in-out;
        }

        .alert-icon-circle {
            background: #4ecdc4;
            color: white;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .btn-container-left {
            display: flex;
            gap: 15px;
            justify-content: flex-start;
            margin-top: 2rem;
        }

        .btn-custom {
            width: 180px;
            height: 45px;
            border-radius: 8px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 1rem;
        }

        .btn-custom-cancel {
            background: white;
            border: 2px solid #dc3545;
            color: #dc3545;
        }

        .btn-custom-confirm {
            background: #4ecdc4;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>

    <br><br>
    <h1 class="text-center text-info-emphasis">Alquiler de Equipo de Movilidad</h1>

    <div class="formulario">
        <div class="register-section">
            {{-- El form-container es el cuadro blanco que envuelve todo --}}
            <div class="form-container" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">

                {{-- LA NOTIFICACIÓN SE MUESTRA AQUÍ (DENTRO DEL FORMULARIO) --}}
                @if(session('success'))
                    <div class="custom-alert-clinic alert alert-dismissible fade show" role="alert">
                        <div class="alert-icon-circle">
                            <i class="bi bi-check2" style="font-size: 1.2rem; font-weight: bold;"></i>
                        </div>
                        <div class="msg-content">
                            <strong style="display: block; font-size: 1rem; color: #1a1a1a;">¡Operación Exitosa!</strong>
                            <span style="color: #6c757d; font-size: 0.9rem;">{{ session('success') }}</span>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="top: 15px;"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 8px;">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('paciente.alquiler.store') }}" method="POST" novalidate>
                    @csrf

                    <div class="detail-item mb-4">
                        <div class="detail-label" style="font-weight: 600; color: #444; margin-bottom: 8px;">Equipo de movilidad disponible</div>
                        <div class="input-group">
                            <span class="input-group-text @error('equipo_id') border-danger text-danger @enderror">
                                <i class="bi bi-accessibility"></i>
                            </span>
                            <select name="equipo_id" id="equipo_id"
                                    class="form-control @error('equipo_id') is-invalid @enderror"
                                    required onchange="actualizarCosto()">
                                <option value="">Seleccionar equipo...</option>
                                @foreach($equipos as $equipo)
                                    <option value="{{ $equipo->id }}"
                                            data-precio="150"
                                        {{ old('equipo_id') == $equipo->id ? 'selected' : '' }}>
                                        {{ $equipo->nombre_equipo }} (Disponibles: {{ $equipo->stock_actual }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('equipo_id')
                        <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> Debe seleccionar un equipo.</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-item mb-4">
                                <div class="detail-label" style="font-weight: 600; color: #444; margin-bottom: 8px;">Fecha de inicio</div>
                                <div class="input-group">
                                    <span class="input-group-text @error('fecha_inicio') border-danger text-danger @enderror">
                                        <i class="bi bi-calendar-check"></i>
                                    </span>
                                    <input type="date" name="fecha_inicio"
                                           class="form-control @error('fecha_inicio') is-invalid @enderror"
                                           value="{{ old('fecha_inicio') }}" required>
                                </div>
                                @error('fecha_inicio')
                                <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="detail-item mb-4">
                                <div class="detail-label" style="font-weight: 600; color: #444; margin-bottom: 8px;">Fecha de devolución</div>
                                <div class="input-group">
                                    <span class="input-group-text @error('fecha_fin') border-danger text-danger @enderror">
                                        <i class="bi bi-calendar-x"></i>
                                    </span>
                                    <input type="date" name="fecha_fin"
                                           class="form-control @error('fecha_fin') is-invalid @enderror"
                                           value="{{ old('fecha_fin') }}" required>
                                </div>
                                @error('fecha_fin')
                                <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-success" style="background: #f0fdfa; border: 1px dashed #4ecdc4; padding: 15px; border-radius: 8px;">
                        <div style="color: #2d3748;">
                            <strong>Costo diario del alquiler:</strong>
                            <span id="display-costo" style="font-weight: bold; color: #38b2ac; margin-left: 5px;">Seleccione un equipo</span>
                            <input type="hidden" name="costo_alquiler" id="input-costo" value="{{ old('costo_alquiler', 0) }}">
                        </div>
                    </div>

                    <div class="btn-container-left">
                        <a href="{{ route('perfil') }}" class="btn-custom btn-custom-cancel">
                            Cancelar
                        </a>
                        <button type="submit" class="btn-custom btn-custom-confirm">
                            Confirmar Alquiler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function actualizarCosto() {
            const select = document.getElementById('equipo_id');
            const display = document.getElementById('display-costo');
            const inputOculto = document.getElementById('input-costo');
            const optionSeleccionada = select.options[select.selectedIndex];
            const precio = optionSeleccionada.getAttribute('data-precio');

            if (precio) {
                display.innerHTML = `L. ${precio}.00`;
                inputOculto.value = precio;
            } else {
                display.innerText = "Seleccione un equipo";
                inputOculto.value = 0;
            }
        }
        window.onload = actualizarCosto;
    </script>
@endsection
