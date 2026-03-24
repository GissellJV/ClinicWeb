@extends('layouts.plantilla')
<link rel="stylesheet" href="{{ asset('css/formulario.css') }}">

@section('contenido')
    <style>
        body { background: whitesmoke; }
        .form-header-icon { display: none; }

        /* Estilo para los mensajes de error debajo del input */
        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* Notificación Personalizada Premium */
        .custom-alert {
            background: #ffffff;
            border: none;
            border-left: 5px solid #4ecdc4;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            animation: slideIn 0.5s ease-out;
        }

        .custom-alert i {
            font-size: 1.8rem;
            color: #4ecdc4;
            margin-right: 15px;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* --- ESTILOS PARA IGUALAR BOTONES SEGÚN CAPTURA --- */
        .btn-container-left {
            display: flex;
            gap: 15px;
            justify-content: flex-start; /* Alineado a la izquierda */
            margin-top: 2rem;
        }

        .btn-custom {
            width: 180px; /* Tamaño idéntico para ambos */
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

        /* Estilo Cancelar: Borde rojo */
        .btn-custom-cancel {
            background: white;
            border: 2px solid #dc3545;
            color: #dc3545;
        }

        .btn-custom-cancel:hover {
            background: #fff5f5;
            color: #c82333;
        }

        /* Estilo Confirmar: Fondo Verde/Teal */
        .btn-custom-confirm {
            background: #4ecdc4;
            color: white;
            border: none;
            cursor: pointer;
        }

        .btn-custom-confirm:hover {
            background: #3ebfb6;
            box-shadow: 0 4px 10px rgba(78, 205, 196, 0.3);
        }

        /* ================= DARK MODE - GESTIÓN DE TRASLADOS ================= */

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

        .dark-mode .formulario .form-container {
            background: #1e1e1e !important;
            color: #e4e4e4 !important;
            border-top: 5px solid #4ecdc4;
            box-shadow: 0 10px 40px rgba(0,0,0,0.5);
        }

        /* LABELS */
        .dark-mode .detail-label {
            color: #e0e0e0 !important;
            font-weight: 600;
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

        /* MENSAJES DE ERROR */
        .dark-mode .invalid-feedback {
            color: #ff6b6b !important;
        }

        /* ALERTA PERSONALIZADA DE ÉXITO */
        .dark-mode .custom-alert {
            background: #1e1e1e !important;
            border-left: 5px solid #4ecdc4 !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.45);
        }

        .dark-mode .custom-alert i {
            color: #4ecdc4 !important;
        }

        .dark-mode .custom-alert .msg-content span:first-child {
            color: #e5e7eb !important;
        }

        .dark-mode .custom-alert .msg-content span:last-child {
            color: #9ca3af !important;
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

        /* BOTÓN CERRAR ALERTA */
        .dark-mode .btn-close {
            filter: invert(1) grayscale(100%);
        }
    </style>

    <br><br>
    <h1 class="text-center text-info-emphasis">Gestion de Traslados</h1>

    <div class="formulario">
        <div class="register-section">
            <div class="form-container">

                @if(session('success'))
                    <div class="custom-alert">
                        <i class="bi bi-check2-circle"></i>
                        <div class="msg-content">
                            <span style="font-weight: bold; color: #2c3e50; display: block;">¡Operacion Exitosa!</span>
                            <span style="color: #7f8c8d; font-size: 0.95rem;">{{ session('success') }}</span>
                        </div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif


                <form action="{{ route('ambulancia.store') }}" method="POST" novalidate>
                    @csrf

                    <div class="detail-item mb-4">
                        <div class="detail-label">Dirección exacta de destino</div>
                        <div class="input-group has-validation">
                            <span class="input-group-text @error('direccion_destino') border-danger text-danger @enderror">
                                <i class="bi bi-geo-alt-fill"></i>
                            </span>
                            <input type="text" name="direccion_destino"
                                   class="form-control @error('direccion_destino') is-invalid @enderror"
                                   placeholder="Ingrese la dirección de destino"
                                   value="{{ old('direccion_destino') }}" required>

                            @error('direccion_destino')
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle"></i> La dirección de destino es requerida.
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="detail-item mb-4">
                        <div class="detail-label">Fecha programada</div>
                        <div class="input-group has-validation">
                            <span class="input-group-text @error('fecha') border-danger text-danger @enderror">
                                <i class="bi bi-calendar-event"></i>
                            </span>
                            <input type="date" name="fecha"
                                   class="form-control @error('fecha') is-invalid @enderror"
                                   value="{{ old('fecha') }}" required>
                            @error('fecha')
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle"></i> Seleccione una fecha válida.
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="detail-item mb-4">
                        <div class="detail-label">Hora programada</div>
                        <div class="input-group has-validation">
                            <span class="input-group-text @error('hora') border-danger text-danger @enderror">
                                <i class="bi bi-clock"></i>
                            </span>
                            <input type="time" name="hora"
                                   class="form-control @error('hora') is-invalid @enderror"
                                   value="{{ old('hora') }}" required>
                            @error('hora')
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle"></i> La hora es requerida.
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="detail-item mb-4">
                        <div class="detail-label">Unidad de ambulancia disponible</div>
                        <div class="input-group has-validation">
                            <span class="input-group-text @error('unidad_id') border-danger text-danger @enderror">
                                <i class="bi bi-truck"></i>
                            </span>
                            <select name="unidad_id" id="unidad_id"
                                    class="form-control @error('unidad_id') is-invalid @enderror"
                                    required onchange="actualizarCosto()">
                                <option value="">Seleccionar unidad...</option>
                                <option value="1" data-precio="1200" {{ old('unidad_id') == '1' ? 'selected' : '' }}>Ambulancia A-101 (Básica)</option>
                                <option value="2" data-precio="2500" {{ old('unidad_id') == '2' ? 'selected' : '' }}>Ambulancia B-202 (UCI Móvil)</option>
                            </select>
                            @error('unidad_id')
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle"></i> Debe seleccionar una unidad.
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="alert alert-success" style="background: #e8f8f7; border: 1px dashed #4ecdc4; padding: 15px;">
                        <div>
                            <strong>Costo del servicio:</strong>
                            <span id="display-costo">Seleccione una unidad</span>
                            <input type="hidden" name="costo_estimado" id="input-costo" value="{{ old('costo_estimado', 0) }}">
                        </div>
                    </div>

                    <div class="btn-container-left">
                        <a href="{{ route('perfil') }}" class="btn-custom btn-custom-cancel">
                            Cancelar
                        </a>
                        <button type="submit" class="btn-custom btn-custom-confirm">
                            Confirmar Traslado
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function actualizarCosto() {
            const select = document.getElementById('unidad_id');
            const display = document.getElementById('display-costo');
            const inputOculto = document.getElementById('input-costo');
            const optionSeleccionada = select.options[select.selectedIndex];
            const precio = optionSeleccionada.getAttribute('data-precio');

            if (precio) {
                display.innerHTML = `<b>L. ${precio}.00</b>`;
                inputOculto.value = precio;
            } else {
                display.innerText = "Seleccione una unidad";
                inputOculto.value = 0;
            }
        }

        window.onload = actualizarCosto;
    </script>
@endsection

