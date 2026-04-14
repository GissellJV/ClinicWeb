@extends('layouts.plantillaDoctor')
<link rel="stylesheet" href="{{ asset('css/formulario.css') }}">
@section('contenido')
    <style>

        body {
            flex-direction: column; /* para que footer esté al final */
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:whitesmoke;
            display: flex;
        }

        .main-container {
            flex: 1; /* ocupa espacio disponible y empuja footer */
        }

        footer {
            width: 100%;
            margin-top: auto; /* asegura que se quede abajo */
            text-align: center;
            padding: 20px 0;
        }

        .receta-header h2 {
            color: rgba(28, 27, 27, 0.95);
            font-size: 24px;
            font-weight: 600;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .receta-header p {
            color: rgba(28, 27, 27, 0.95);
            font-size: 14px;
            margin-top: 8px;
            margin-bottom: 0;
        }

        .form-control-custom:focus {
            outline: none;
            border-color: #4ecdc4;
            box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.1);
        }

        .form-control-custom::placeholder {
            color: #999;
        }

        textarea.form-control-custom {
            min-height: 100px;
            resize: vertical;
        }

        .btn-generar {
            padding: 0.875rem 2rem;
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.3);
            margin-left: 5px;
        }

        .btn-generar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        }

        @media (max-width: 768px) {

            .receta-header h2 {
                font-size: 20px;
            }
        }

        .text-info-emphasis{
            font-weight: bold;
        }

        .botones-container{
            display: flex;
            gap: 10px;
        }

        .botones-container button{
            flex: 1;
        }
    </style>

    <div class="formulario">
        <div class="register-section" style="margin-top: 70px">
            <h1 class="text-center text-info-emphasis">Receta Médica</h1>
            <br>
        <div class="form-container" >

                    <form method="POST" action="{{ route('receta.pdf') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="nombre_paciente" class="form-label">Paciente</label>
                            <input type="text" name="nombre_paciente" id="nombre_paciente" class="form-control" placeholder="Nombre del paciente" value="{{old('nombre_paiente')}}">
                            @error('nombre_paciente')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="medicamento" class="form-label">Medicamento</label>
                            <input type="text" name="medicamento" id="medicamento" class="form-control" placeholder="Nombre del medicamento" value="{{old('medicamento')}}">
                            @error('medicamento')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="dosis" class="form-label">Dosis</label>
                            <input type="text" name="dosis" id="dosis" class="form-control" placeholder="Ej: 500mg cada 8 horas" value="{{old('dosis')}}">
                            @error('dosis')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="duracion" class="form-label">Duración del tratamiento</label>
                            <input type="text" name="duracion" id="duracion" class="form-control" placeholder="Ej: 7 días" value="{{old('duracion')}}">
                            @error('duracion')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <textarea name="observaciones" id="observaciones" class="form-control" placeholder="Indicaciones adicionales "></textarea>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="atendido" id="atendido" value="1">
                            <label class="form-check-label" for="atendido">
                                Paciente atendido
                            </label>
                        </div>

                        <div class="botones-container">
                            <button type="submit" class="btn-generar">Generar Receta</button>

                            <button type="reset" class="btn-cancel">
                                Cancelar
                            </button>
                        </div>

                      </form>


        </div>
        </div>
    </div>

@endsection
