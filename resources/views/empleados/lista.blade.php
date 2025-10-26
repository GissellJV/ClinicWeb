@extends('layouts.plantilla')

@section('titulo', 'Lista de Empleados')

@section('contenido')
    <div class="container mt-5 pt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Lista de Empleados</h4>
                        <a href="{{ route('empleados.crear') }}" class="btn btn-light btn-sm">
                            + Nuevo Empleado
                        </a>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($empleados->isEmpty())
                            <div class="alert alert-info">
                                No hay empleados registrados.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre Completo</th>
                                        <th>Identidad</th>
                                        <th>Cargo</th>
                                        <th>Departamento</th>
                                        <th>Fecha Ingreso</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($empleados as $empleado)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $empleado->nombre }} {{ $empleado->apellido }}</td>
                                            <td>{{ $empleado->numero_identidad }}</td>
                                            <td>
                                                <span class="badge bg-primary">{{ $empleado->cargo }}</span>
                                            </td>
                                            <td>{{ $empleado->departamento }}</td>
                                            <td>{{ $empleado->fecha_ingreso->format('d/m/Y') }}</td>
                                            <td>
                                                <a href="#" class="btn btn-info btn-sm">Ver</a>
                                                <a href="#" class="btn btn-warning btn-sm">Editar</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
