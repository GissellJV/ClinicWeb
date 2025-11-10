@extends('layouts.plantillaDoctor')

@section('contenido')
    <style>
        .receta-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(to bottom, #ffffff 0%, #ffffff 100%);
            padding: 40px 20px;
        }

        .receta-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            overflow: hidden;
            width: 100%;
            max-width: 650px;
        }

        .receta-header {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            padding: 30px 40px;
            text-align: center;
        }

        .receta-header h2 {
            color: white;
            font-size: 24px;
            font-weight: 600;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .receta-header p {
            color: rgba(255,255,255,0.95);
            font-size: 14px;
            margin-top: 8px;
            margin-bottom: 0;
        }

        .receta-content {
            padding: 40px;
        }

        .form-label-custom {
            display: block;
            color: #333;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 15px;
        }

        .form-control-custom {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            width: 100%;
            padding: 14px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            color: white;
            margin-top: 10px;
        }

        .btn-generar:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(78, 205, 196, 0.3);
        }

        .mb-3-custom {
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .receta-content {
                padding: 30px 20px;
            }

            .receta-header {
                padding: 25px 20px;
            }

            .receta-header h2 {
                font-size: 20px;
            }
        }
    </style>

    <div class="receta-container">
        <div class="receta-card">
            <div class="receta-header">
                <h2>Receta Médica</h2>
            </div>

            <div class="receta-content">
                <form method="POST" action="{{ route('receta.pdf') }}">
                    @csrf

                    <div class="mb-3-custom">
                        <label for="nombre_paciente" class="form-label-custom">Paciente</label>
                        <input type="text" name="nombre_paciente" id="nombre_paciente" class="form-control-custom" placeholder="Nombre del paciente" value="{{old('nombre_paiente')}}">
                        @error('nombre_paciente')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3-custom">
                        <label for="medicamento" class="form-label-custom">Medicamento</label>
                        <input type="text" name="medicamento" id="medicamento" class="form-control-custom" placeholder="Nombre del medicamento" value="{{old('medicamento')}}">
                        @error('medicamento')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3-custom">
                        <label for="dosis" class="form-label-custom">Dosis</label>
                        <input type="text" name="dosis" id="dosis" class="form-control-custom" placeholder="Ej: 500mg cada 8 horas" value="{{old('dosis')}}">
                        @error('dosis')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3-custom">
                        <label for="duracion" class="form-label-custom">Duración del tratamiento</label>
                        <input type="text" name="duracion" id="duracion" class="form-control-custom" placeholder="Ej: 7 días" value="{{old('duracion')}}">
                        @error('duracion')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3-custom">
                        <label for="observaciones" class="form-label-custom">Observaciones</label>
                        <textarea name="observaciones" id="observaciones" class="form-control-custom" placeholder="Indicaciones adicionales (opcional)"></textarea>
                    </div>

                    <button type="submit" class="btn-generar">Generar Receta</button>
                </form>
            </div>
        </div>
    </div>
@endsection
