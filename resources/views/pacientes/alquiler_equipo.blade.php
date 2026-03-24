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

        /* ================= DARK MODE - ALQUILER DE EQUIPO DE MOVILIDAD ================= */

        .dark-mode body {
            background: #121212 !important;
            color: #e4e4e4 !important;
        }

        /* TÍTULO */
        .dark-mode h1.text-center {
            color: #4ecdc4 !important;
        }

        /* CONTENEDOR PRINCIPAL */
        .dark-mode .formulario,
        .dark-mode .register-section {
            background: transparent !important;
        }

        .dark-mode .form-container {
            background: #1e1e1e !important;
            color: #e4e4e4 !important;
            border-top: 5px solid #4ecdc4 !important;
            box-shadow: 0 10px 40px rgba(0,0,0,0.5) !important;
        }

        /* LABELS */
        .dark-mode .detail-label {
            color: #e0e0e0 !important;
        }

        /* INPUT GROUP */
        .dark-mode .input-group-text {
            background: #1e1e1e !important;
            color: #4ecdc4 !important;
            border: 1px solid #444 !important;
        }

        .dark-mode .input-group .form-control {
            border-left: none !important;
        }

        .dark-mode .input-group:focus-within .input-group-text,
        .dark-mode .input-group:focus-within .form-control {
            border-color: #4ecdc4 !important;
        }

        /* INPUTS Y SELECT */
        .dark-mode .form-control,
        .dark-mode input,
        .dark-mode select,
        .dark-mode textarea {
            background: #2a2a2a !important;
            color: #fff !important;
            border: 1px solid #444 !important;
        }

        .dark-mode .form-control:focus,
        .dark-mode input:focus,
        .dark-mode select:focus,
        .dark-mode textarea:focus {
            border-color: #4ecdc4 !important;
            box-shadow: 0 0 0 3px rgba(78,205,196,0.2) !important;
        }

        .dark-mode .form-control::placeholder,
        .dark-mode input::placeholder,
        .dark-mode textarea::placeholder {
            color: #888 !important;
        }

        .dark-mode select option {
            background: #2a2a2a;
            color: #fff;
        }

        /* ERRORES */
        .dark-mode .invalid-feedback {
            color: #ff6b6b !important;
        }

        /* ALERTA DE ÉXITO PERSONALIZADA */
        .dark-mode .custom-alert-clinic {
            background: #1e1e1e !important;
            border: 1px solid #4ecdc4 !important;
            color: #e4e4e4 !important;
        }

        .dark-mode .alert-icon-circle {
            background: #4ecdc4 !important;
            color: #111827 !important;
        }

        .dark-mode .custom-alert-clinic strong {
            color: #e5e7eb !important;
        }

        .dark-mode .custom-alert-clinic .msg-content span {
            color: #9ca3af !important;
        }

        /* ALERTA DE ERROR */
        .dark-mode .alert-danger {
            background: #3a1e1e !important;
            color: #ff6b6b !important;
            border-color: #5f2f2f !important;
        }

        /* ALERTA DE COSTO */
        .dark-mode .alert.alert-success {
            background: #1e1e1e !important;
            color: #d1d5db !important;
            border: 1px dashed #4ecdc4 !important;
        }

        .dark-mode #display-costo {
            color: #4ecdc4 !important;
        }

        /* BOTONES */
        .dark-mode .btn-custom-cancel {
            background: #2a2a2a !important;
            color: #dc3545 !important;
            border: 2px solid #dc3545 !important;
        }

        .dark-mode .btn-custom-cancel:hover {
            background: #dc3545 !important;
            color: #fff !important;
            box-shadow: 0 4px 10px rgba(220,53,69,0.5);
        }

        .dark-mode .btn-custom-confirm {
            background: linear-gradient(135deg, #2c5364, #203a43) !important;
            color: #e4e4e4 !important;
            border: none !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.5);
        }

        .dark-mode .btn-custom-confirm:hover {
            background: linear-gradient(135deg, #4ecdc4, #00ffe7) !important;
            color: #000 !important;
            box-shadow: 0 0 15px #00ffe7, 0 0 25px rgba(0,255,231,0.4);
            transform: translateY(-2px);
        }

        /* BOTÓN CERRAR ALERTAS */
        .dark-mode .btn-close {
            filter: invert(1) grayscale(100%);
        }
    </style>

    <br><br>
    <h1 class="text-center text-info-emphasis">Alquiler de Equipo de Movilidad</h1>

    <div class="formulario">
        <div class="register-section">
            <div class="form-container" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">

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
