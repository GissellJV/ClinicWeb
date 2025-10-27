@extends('layouts.plantilla')

@section('titulo', 'Lista de Expedientes')

@section('contenido')
    <div class="container mt-5 pt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Lista de Expedientes Médicos</h4>
                        <a href="{{ route('expedientes.crear') }}" class="btn btn-light btn-sm">
                            + Nuevo Expediente
                        </a>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($expedientes->isEmpty())
                            <div class="alert alert-info">
                                No hay expedientes registrados.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>N° Expediente</th>
                                        <th>Paciente</th>
                                        <th>Identidad</th>
                                        <th>Fecha Creación</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($expedientes as $expediente)
                                        <tr>
                                            <td>
                                                <strong>{{ $expediente->numero_expediente }}</strong>
                                            </td>
                                            <td>{{ $expediente->paciente->nombre }}</td>
                                            <td>{{ $expediente->paciente->numero_identidad }}</td>
                                            <td>{{ $expediente->created_at->format('d/m/Y') }}</td>
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
