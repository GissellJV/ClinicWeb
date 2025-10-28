@extends('layouts.plantillaRecepcion')
@section('contenido')
    <br><br><br><br><br>

    <h1 class="text-center mb-4">Pacientes con Citas Programadas</h1>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered table-hover align-middle text-capitalize">
        <thead class="table-primary">
        <tr>
            <th>Paciente</th>
            <th>Doctor</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Especialidad</th>
            <th>Estado</th>
            <th>Acción</th>
        </tr>
        </thead>
        <tbody>
        @forelse($citas as $cita)
            <tr>
                <td>{{ $cita->paciente_nombre ?? 'No definido' }}</td>
                <td>{{ $cita->doctor_nombre ?? 'No definido' }}</td>
                <td>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</td>
                <td>{{ $cita->hora }}</td>
                <td>{{ $cita->especialidad ?? 'No definida' }}</td>
                <td>
                <span class="badge
                    @if($cita->estado == 'pendiente') bg-warning text-dark
                    @elseif($cita->estado == 'programada') bg-success
                    @elseif($cita->estado == 'cancelada') bg-danger
                    @elseif($cita->estado == 'reprogramada') bg-danger
                    @else bg-secondary @endif">
                    {{ ucfirst($cita->estado) }}
                </span>
                </td>
                <td>
                    @if($cita->estado == 'pendiente')
                        <form action="{{ route('citas.confirmar', $cita->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Confirmar</button>
                        </form>
                    @elseif($cita->estado == 'programada')
                        <span class="text-muted">Confirmada</span>
                    @elseif($cita->estado == 'cancelada')
                        <span class="text-muted">Cancelada</span>
                    @elseif($cita->estado == 'reprogramada')
                        <span class="text-muted">reprogramada</span>
                    @else
                        <span class="text-muted">Sin acción</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">No hay citas registradas</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="text-center mt-4">
        <a href="{{route('recepcionista.busquedaexpediente')}}">
            <button type="button" class="btn btn-primary">Volver al Inicio</button>
        </a>
    </div>
@endsection
