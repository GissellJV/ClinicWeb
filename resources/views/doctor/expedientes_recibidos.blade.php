
@extends('layouts.plantillaDoctor')

@section('contenido')

    <div class="container mt-5 pt-5">
        <h2 class="text-center text-info-emphasis mb-4">Expedientes Recibidos</h2>

        @if($expedientes->count() > 0)

            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Paciente</th>
                    <th>Especialidad</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
                </thead>

                <tbody>
                @foreach($expedientes as $exp)
                    <tr>
                        <td>{{ $exp->paciente->nombres }} {{ $exp->paciente->apellidos }}</td>
                        <td>{{ $exp->especialidad }}</td>
                        <td>
                            @if($exp->estado == 'pendiente')
                                <span class="badge bg-warning text-dark">Pendiente</span>
                            @else
                                <span class="badge bg-success">Completado</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('expediente.ver', $exp->paciente_id) }}" class="btn btn-primary btn-sm">
                                Ver expediente
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
            {{ $expedientes->links() }}

        @else
            <div class="text-center mt-5">
                <i class="fas fa-folder-open fa-3x text-secondary"></i>
                <h4 class="mt-3">No tienes expedientes asignados.</h4>
            </div>
        @endif
    </div>

@endsection

