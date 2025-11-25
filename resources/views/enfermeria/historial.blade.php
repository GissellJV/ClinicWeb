@extends('layouts.plantillaEnfermeria')
@section('contenido')

    <link rel="stylesheet" href="{{ asset('css/formulario.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <div class="administracion">
        <br>
        <div class="container mt-5 pt-5">
            <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                <h2 class="text-info-emphasis">Medicamentos por Paciente</h2>
            </div>


            <div class="inventory-card">
                <div class="table-container">
                    <table id="pacientesTable" class="table table-hover">
                        <thead>
                        <tr>
                            <th>Nombre del Paciente</th>
                            <th>Número de Habitación</th>
                            <th>Medicamento</th>
                            <th>Cantidad</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pacientes as $paciente)
                            @foreach($paciente->medicamentos as $medicamento)
                                <tr>
                                    <td>{{ $paciente->nombres }} {{ $paciente->apellidos }}</td>
                                    <td> {{ $paciente->asignacionesHabitacion()->where('estado','activo')->first()?->habitacion?->numero_habitacion ?? 'Sin Habitación' }}
                                    </td>
                                    <td>{{ $medicamento->nombre }}</td>
                                    <td>{{ $medicamento->pivot->cantidad }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <!-- jQuery y DataTables -->

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#pacientesTable').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ registros",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty: "Mostrando 0 a 0 de 0 registros",
                    zeroRecords: "No se encontraron registros",
                    emptyTable: "No hay pacientes registrados",
                    paginate: {
                        first: "Primero",
                        previous: "Anterior",
                        next: "Siguiente",
                        last: "Último"
                    }
                },
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                order: [[0, 'asc']]
            });
        })

    </script>

@endsection
