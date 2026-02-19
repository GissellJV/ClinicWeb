@extends('layouts.plantillaRecepcion')

@section('contenido')

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: whitesmoke;
            min-height: 100vh;
            padding-top: 100px;
        }


        .btn-register {
            padding: 0.875rem 2rem;
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.3);
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        }

        .btn-cancel {
            padding: 0.875rem 2rem;
            background: white;
            border: 2px solid #dc3545;
            border-radius: 8px;
            color: #dc3545;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }



        /* Estilos para los campos de formulario */
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            width: 100%;
            background: rgba(248, 250, 255, 0.6);
            color: #555;
            padding: 16px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;

        }

        .form-control:focus, .form-select:focus {
            border-color: #4ecdc4;
            box-shadow: 0 0 0 0.2rem rgba(78, 205, 196, 0.25);
            outline: none;
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            max-width: 600px;
            max-height: 700px;
            margin: 0 auto;
            border-top: 5px solid #4ecdc4;
            position: relative;
        }


        .text-info-emphasis {

            font-weight: bold;
        }
    </style>

    <div class="form-container">

        <h1 class=" text-center text-info-emphasis"> Alta de Paciente</h1>

            <div class="card-body">
                <form action="{{ route('recepcionista.habitaciones.liberar', $asignacion->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">

                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>

                        <form action="{{ route('recepcionista.habitaciones.liberar', $asignacion->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Datos de Alta -->
                            <div class="modal-section">


                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="fecha_salida" class="form-label">
                                            Fecha de Salida
                                        </label>
                                        <input
                                                type="date"
                                                class="form-control @error('fecha_salida') is-invalid @enderror"
                                                id="fecha_salida"
                                                name="fecha_salida"
                                                value="{{ old('fecha_salida', date('Y-m-d')) }}"
                                                max="{{ date('Y-m-d') }}"
                                        >
                                        @error('fecha_salida')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="motivo_alta_{{ $asignacion->id }}" class="form-label">
                                            Motivo de Alta
                                        </label>
                                        <select
                                                class="form-select @error('motivo_alta') is-invalid @enderror"
                                                id="motivo_alta"
                                                name="motivo_alta"
                                        >
                                            <option value="" selected disabled > Selecciona un motivo</option>
                                            <option value="Recuperación satisfactoria" {{ old('motivo_alta') == 'Recuperación satisfactoria' ? 'selected' : '' }}>
                                                Recuperación satisfactoria
                                            </option>
                                            <option value="Por solicitud del paciente/familiar" {{ old('motivo_alta') == 'Por solicitud del paciente/familiar' ? 'selected' : '' }}>
                                                Por solicitud del paciente o familiar
                                            </option>
                                            <option value="Traslado a otra clinica" {{ old('motivo_alta') == 'Traslado a otra clinica' ? 'selected' : '' }}>
                                                Traslado a otra clínica
                                            </option>
                                        </select>
                                        @error('motivo_alta')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="observaciones_alta" class="form-label">
                                            Observaciones
                                        </label>
                                        <textarea
                                                class="form-control @error('observaciones_alta') is-invalid @enderror"
                                                id="observaciones_alta"
                                                name="observaciones_alta"
                                                rows="2"
                                        >{{ old('observaciones_alta') }}</textarea>
                                        @error('observaciones_alta')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="modal-footer" style=" gap: 1rem;">
                                <a href="{{ route('recepcionista.habitaciones.ocupadas') }}" class="btn-cancel" style="text-decoration-line: none">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>

                                <button type="submit" class="btn-register">
                                    Confirmar Alta
                                </button>
                            </div>

                        </form>
                    </div>

@endsection
