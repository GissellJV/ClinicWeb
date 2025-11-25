@extends('layouts.plantillaRecepcion')

@section('contenido')

    <style>
        body{
            background: #f4f6f9;
            font-family: 'Poppins', sans-serif;
            padding-top: 100px;
        }
        .card{
            border-radius: 15px;
        }
        .table thead{
            background:#44A08DFF;
            color: white;
        }

        .text-info-emphasis{
            font-weight: bold;
        }
    </style>
    <br> <br>
    <h1 class="text-center text-info-emphasis">Historial Diario de Pacientes</h1>
    <div class="container mt-5">

        <div class="row justify-content-center">

            <div class="col-md-10">

                <div class="card shadow">
                    <div class="card-body">

                        <table class="table table-hover text-center">
                            <thead>
                            <tr>
                                <th>Nombre del Paciente</th>
                                <th>Doctor que lo atendió</th>
                            </tr>
                            </thead>

                            <tbody>
                            @forelse($historial as $item)
                                <tr>
                                    <td>{{ $item->nombre_paciente }}</td>
                                    <td>{{ $item->doctor }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-muted">No hay pacientes atendidos hoy.</td>
                                </tr>
                            @endforelse
                            </tbody>

                        </table>

                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection
