@extends('layouts.plantillaEnfermeria')
<link rel="stylesheet" href="{{ asset('css/formulario.css') }}">
@section('contenido')
    <style>

        small.text-danger {
            font-size: 0.875em;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:whitesmoke;
            display: flex;
        }
        .formulario .btn-guardar {
            padding: 0.875rem 2rem;
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.3);
        }

        .formulario .btn-guardar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        }

        .formulario .btn-cancel {
            padding: 0.875rem 2rem;
            background: white;
            border: 2px solid #dc3545;
            border-radius: 8px;
            color: #dc3545;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .formulario .btn-cancel:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }


    </style>

    <div class="formulario">
        <div class="register-section" style="margin-top: 120px">
            <h2 class="text-center text-info-emphasis">
                @isset($inventario)
                    Editar
                @else
                    Registrar
                @endisset

                Medicamento</h2>
            <div class="form-container" style="width: 500px;">

                <form
                    @isset($inventario)
                        action="{{route('inventario.update', ['id'=>$inventario->id])}}"
                    @else
                        action="{{ route('inventario.store') }}"
                    @endisset

                    method="post">
                    @isset($inventario)
                        @method('put')
                    @endisset

                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Código:</label>
                        <input type="text" id="codigo" name="codigo"  class="form-control" value="{{ isset($inventario)?$inventario->codigo:  old('codigo') }}">
                        @error('codigo')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nombre:</label>
                        <input type="text" id="nombre" name="nombre"  class="form-control" value="{{ isset($inventario)?$inventario->nombre:  old('nombre') }}">
                        @error('nombre')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Cantidad:</label>
                        <input type="number" id="cantidad" name="cantidad" min="0"  class="form-control" value="{{ isset($inventario)?$inventario->cantidad:  old('cantidad') }}">
                        @error('cantidad')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Fecha de Vencimiento:</label>
                        <input type="date" id="fecha_vencimiento" name="fecha_vencimiento"  class="form-control" value="{{ isset($inventario)?$inventario->fecha_vencimiento:  old('fecha_vencimiento') }}">
                        @error('fecha_vencimiento')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <br>
                    <button type="submit" class="btn-guardar">Guardar</button>
                    <a class="btn-cancel" href="{{ route('inventario.principal') }}" style="text-decoration-line: none">Cancelar</a>
                </form>
            </div>
        </div>
    </div>

@endsection
