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
    </style>

    <br><br>
    <h1 class="text-center text-info-emphasis">Gestión de Traslados</h1>

    <div class="formulario">
        <div class="register-section">
            <div class="form-container">

                @if(session('success'))
                    <div class="custom-alert">
                        <i class="bi bi-check2-circle"></i>
                        <div class="msg-content">
                            <span style="font-weight: bold; color: #2c3e50; display: block;">¡Operación Exitosa!</span>
                            <span style="color: #7f8c8d; font-size: 0.95rem;">{{ session('success') }}</span>
                        </div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <h2 class="form-title">Registro de Traslado en Ambulancia</h2>

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

                    <div class="row">
                        <div class="col-md-6">
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
                        </div>

                        <div class="col-md-6">
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

                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" class="btn-register flex-grow-1">
                            <i class="bi bi-check-circle me-2"></i>Confirmar Traslado
                        </button>
                        <a href="{{ route('perfil') }}" class="btn-cancel text-decoration-none text-center d-flex align-items-center justify-content-center">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
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
