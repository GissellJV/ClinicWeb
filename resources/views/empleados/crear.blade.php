@extends('layouts.plantilla')

@section('titulo', 'Registrar Empleado')

@section('contenido')
    <style>
        small.text-danger {
            font-size: 0.875em;
        }
    </style>
    <div class="container mt-5 pt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Registrar Nuevo Empleado</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif


                        <form action="{{ route('empleados.guardar') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nombre" class="form-label">Nombre *</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre"
                                               value="{{ old('nombre') }}">
                                        @error('nombre')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="apellido" class="form-label">Apellido *</label>
                                        <input type="text" class="form-control" id="apellido" name="apellido"
                                               value="{{ old('apellido') }}">
                                        @error('apellido')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="numero_identidad" class="form-label">Número de Identidad *</label>
                                        <input type="text" class="form-control" id="numero_identidad" name="numero_identidad"
                                               value="{{ old('numero_identidad') }}">
                                        @error('numero_identidad')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fecha_ingreso" class="form-label">Fecha de Ingreso</label>
                                        <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso"
                                               value="{{ old('fecha_ingreso') }}" >
                                        @error('fecha_ingreso')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="telefono" class="form-label">Número de Telefono </label>
                                        <div class="input-group">
                                            <span class="input-group-text">+504</span>
                                            <input type="text" class="form-control" id="telefono" name="telefono"
                                               value="{{ old('telefono') }}" >
                                        </div>
                                        @error('telefono')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Contraseña </label>
                                        <input type="password" class="form-control" id="password" name="password"
                                               value="{{ old('password') }}" >
                                        @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>




                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="cargo" class="form-label">Cargo </label>
                                        <select class="form-select" id="cargo" name="cargo" >
                                            <option value="">Seleccione un cargo</option>
                                            @foreach($cargos as $cargo)
                                                <option value="{{ $cargo }}" {{ old('cargo') == $cargo ? 'selected' : '' }}>
                                                    {{ $cargo }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cargo')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="departamento" class="form-label">Departamento </label>
                                        <select class="form-select" id="departamento" name="departamento" >
                                            <option value="">Seleccione un departamento</option>
                                            @foreach($departamentos as $depto)
                                                <option value="{{ $depto }}" {{ old('departamento') == $depto ? 'selected' : '' }}>
                                                    {{ $depto }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('departamento')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('empleados.lista') }}" class="btn btn-secondary me-md-2">
                                    Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Registrar Empleado
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
