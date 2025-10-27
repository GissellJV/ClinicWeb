@extends('layouts.plantilla')

@section('titulo', 'Registrar Empleado')

@section('contenido')
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

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('empleados.guardar') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nombre" class="form-label">Nombre *</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre"
                                               value="{{ old('nombre') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="apellido" class="form-label">Apellido *</label>
                                        <input type="text" class="form-control" id="apellido" name="apellido"
                                               value="{{ old('apellido') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="numero_identidad" class="form-label">Número de Identidad *</label>
                                        <input type="text" class="form-control" id="numero_identidad" name="numero_identidad"
                                               value="{{ old('numero_identidad') }}" required>
                                        <small class="form-text text-muted">Debe ser único</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fecha_ingreso" class="form-label">Fecha de Ingreso *</label>
                                        <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso"
                                               value="{{ old('fecha_ingreso') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="cargo" class="form-label">Cargo *</label>
                                        <select class="form-select" id="cargo" name="cargo" required>
                                            <option value="">Seleccione un cargo</option>
                                            @foreach($cargos as $cargo)
                                                <option value="{{ $cargo }}" {{ old('cargo') == $cargo ? 'selected' : '' }}>
                                                    {{ $cargo }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="departamento" class="form-label">Departamento *</label>
                                        <select class="form-select" id="departamento" name="departamento" required>
                                            <option value="">Seleccione un departamento</option>
                                            @foreach($departamentos as $depto)
                                                <option value="{{ $depto }}" {{ old('departamento') == $depto ? 'selected' : '' }}>
                                                    {{ $depto }}
                                                </option>
                                            @endforeach
                                        </select>
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
