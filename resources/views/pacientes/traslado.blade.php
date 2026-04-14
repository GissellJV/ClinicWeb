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

        /* Bloqueo de alertas externas */
        body > .alert, .main-content > .alert, header + .alert, .container > .alert {
            display: none !important;
        }

        /* === CORRECCIÓN DE ALERTA: ESTILO BOOTSTRAP ESTÁNDAR (Como la captura 2) === */
        .custom-alert {
            box-shadow: none !important;
            border-left: none !important;
            padding: 1rem 1.25rem !important;
            border-radius: 0.375rem !important;
            position: relative;
            border: 1px solid transparent;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            animation: slideIn 0.5s ease-out;
        }

        /* Colores para Éxito */
        .alert-premium-success {
            color: #0f5132 !important;
            background-color: #d1e7dd !important;
            border-color: #badbcc !important;
        }

        /* Colores para Error */
        .alert-premium-error {
            color: #842029 !important;
            background-color: #f8d7da !important;
            border-color: #f5c2c7 !important;
        }

        .msg-content strong { font-weight: 700 !important; }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* --- ESTILOS CORREGIDOS: BOTONES 50/50 Y HOVER ROJO --- */
        .btn-container-left {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 2rem;
        }

        .btn-custom {
            width: 50%;
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

        .btn-custom-cancel:hover {
            background: #dc3545 !important;
            color: white !important;
        }

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

        /* --- ESTILO SELECT: Verde transparente y redondeado --- */
        select.form-control {
            border-radius: 10px !important;
            border: 1px solid #4ecdc4 !important;
            background-color: rgba(78, 205, 196, 0.1) !important;
            appearance: none;
        }

        select.form-control option {
            background-color: white;
            color: #2c3e50;
            border-radius: 10px;
        }

        /* ================= DARK MODE ================= */
        .dark-mode body { background: #121212 !important; color: #e4e4e4 !important; }
        .dark-mode h1.text-center { color: #4ecdc4 !important; }
        .dark-mode .formulario .form-container { background: #1e1e1e !important; color: #e4e4e4 !important; border-top: 5px solid #4ecdc4; box-shadow: 0 10px 40px rgba(0,0,0,0.5); }
        .dark-mode .form-control, .dark-mode input, .dark-mode select, .dark-mode textarea { background: rgba(78, 205, 196, 0.05) !important; color: #fff !important; border: 1px solid #4ecdc4 !important; }
        .dark-mode .btn-custom-cancel { background: transparent !important; color: #dc3545 !important; border: 2px solid #dc3545 !important; }
        .dark-mode .btn-custom-confirm { background: linear-gradient(135deg, #2c5364, #203a43) !important; color: #e4e4e4 !important; }
    </style>

    <br><br>
    <h1 class="text-center text-info-emphasis">Gestión de Traslados</h1>

    <div class="formulario">
        <div class="register-section">
            <div class="form-container" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">

                {{-- Notificación Blindada Estilo Bootstrap --}}
                @if(session('success'))
                    <div class="custom-alert alert-premium-success alert alert-dismissible fade show" role="alert">
                        <div class="msg-content">
                            <strong>¡Operación Exitosa!</strong> <span>{{ session('success') }}</span>
                        </div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif(session('error'))
                    <div class="custom-alert alert-premium-error alert alert-dismissible fade show" role="alert">
                        <div class="msg-content">
                            <strong>Atención:</strong> <span>{{ session('error') }}</span>
                        </div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('ambulancia.store') }}" method="POST" novalidate>
                    @csrf

                    <div class="detail-item mb-4">
                        <div class="detail-label">Dirección exacta de destino</div>
                        <input type="text" name="direccion_destino"
                               class="form-control @error('direccion_destino') is-invalid @enderror"
                               placeholder="Ingrese la dirección de destino"
                               value="{{ old('direccion_destino') }}" required>
                        @error('direccion_destino')
                        <div class="invalid-feedback">La dirección de destino es requerida.</div>
                        @enderror
                    </div>

                    <div class="detail-item mb-4">
                        <div class="detail-label">Fecha programada</div>
                        <input type="date" name="fecha"
                               class="form-control @error('fecha') is-invalid @enderror"
                               value="{{ old('fecha') }}" required>
                        @error('fecha')
                        <div class="invalid-feedback">Seleccione una fecha válida.</div>
                        @enderror
                    </div>

                    <div class="detail-item mb-4">
                        <div class="detail-label">Hora programada</div>
                        <input type="time" name="hora"
                               class="form-control @error('hora') is-invalid @enderror"
                               value="{{ old('hora') }}" required>
                        @error('hora')
                        <div class="invalid-feedback">La hora es requerida.</div>
                        @enderror
                    </div>

                    <div class="detail-item mb-4">
                        <div class="detail-label">Unidad de ambulancia disponible</div>
                        <select name="unidad_id" id="unidad_id"
                                class="form-control @error('unidad_id') is-invalid @enderror"
                                required onchange="actualizarCosto()">
                            <option value="">Seleccionar unidad...</option>
                            <option value="1" data-precio="1200" {{ old('unidad_id') == '1' ? 'selected' : '' }}>Ambulancia A-101 (Básica)</option>
                            <option value="2" data-precio="2500" {{ old('unidad_id') == '2' ? 'selected' : '' }}>Ambulancia B-202 (UCI Móvil)</option>
                        </select>
                        @error('unidad_id')
                        <div class="invalid-feedback">Debe seleccionar un unidad.</div>
                        @enderror
                    </div>

                    <div class="alert alert-success" style="background: #e8f8f7; border: 1px dashed #4ecdc4; padding: 15px; border-radius: 8px;">
                        <div>
                            <strong>Costo del servicio:</strong>
                            <span id="display-costo" style="font-weight: bold; color: #38b2ac; margin-left: 5px;">Seleccione una unidad</span>
                            <input type="hidden" name="costo_estimado" id="input-costo" value="{{ old('costo_estimado', 0) }}">
                        </div>
                    </div>

                    <div class="btn-container-left">
                        <button type="submit" class="btn-custom btn-custom-confirm">
                            Confirmar Traslado
                        </button>
                        <a href="{{ route('perfil') }}" class="btn-custom btn-custom-cancel">
                            Cancelar
                        </a>
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
                display.innerHTML = `L. ${precio}.00`;
                inputOculto.value = precio;
            } else {
                display.innerText = "Seleccione una unidad";
                inputOculto.value = 0;
            }
        }
        window.onload = actualizarCosto;
    </script>
@endsection
