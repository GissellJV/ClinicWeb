@extends('layouts.plantillaEnfermeria')
@section('contenido')

    <link rel="stylesheet" href="{{ asset('css/formulario.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">


    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:whitesmoke;
            min-height: 100vh;
        }

        .administracion .btn {
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .administracion .btn-primary {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            color: white;
        }

        .administracion .btn-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(78, 205, 196, 0.3);
        }

        /* Alertas de Stock */
        .stock-alerts {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .alert-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border-left: 5px solid;
            transition: all 0.3s;
        }

        .alert-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        }

        .alert-card.critical {
            border-left-color: #e74c3c;
            background: linear-gradient(135deg, #fff 0%, #ffe5e5 100%);
        }

        .alert-card.warning {
            border-left-color: #f39c12;
            background: linear-gradient(135deg, #fff 0%, #fff4e5 100%);
        }

        .alert-card.success {
            border-left-color: #27ae60;
            background: linear-gradient(135deg, #fff 0%, #e8f8f0 100%);
        }

        .alert-number {
            font-size: 32px;
            font-weight: 700;
        }

        .alert-card.critical .alert-number {
            color: #e74c3c;
        }

        .alert-card.warning .alert-number {
            color: #f39c12;
        }

        .alert-card.success .alert-number {
            color: #27ae60;
        }

        .alert-label {
            font-size: 14px;
            color: #666;
            font-weight: 600;
        }

        .administracion .inventory-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            overflow: visible;
            padding: 25px;
        }

        .administracion .table-container {
            overflow-x: visible;
            width: 100%;
            margin: 0 auto;
        }

        table.dataTable {
            width: 100% !important;
            border-collapse: collapse;
            table-layout: auto;
            white-space: nowrap;
        }

        table.dataTable thead th {
            padding: 20px;
            text-align: left;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border-bottom: 2px solid #e0e0e0;
            color: #2c3e50;
            background: white;
            white-space: nowrap;
        }

        table.dataTable tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s;
        }

        table.dataTable tbody tr:hover {
            background: #f8f9fa;
        }

        table.dataTable tbody td {
            padding: 20px;
            color: #666;
            white-space: nowrap;
        }

        /* Resaltar filas según stock */
        table.dataTable tbody tr.stock-critical {
            background-color: #ffe5e5 !important;
        }

        table.dataTable tbody tr.stock-warning {
            background-color: #fff4e5 !important;
        }

        table.dataTable tbody tr.stock-critical:hover {
            background-color: #ffd1d1 !important;
        }

        table.dataTable tbody tr.stock-warning:hover {
            background-color: #ffe5cc !important;
        }

        .administracion .medication-name {
            font-weight: 600;
            color: #333;
            font-size: 16px;
            white-space: nowrap;
        }

        .administracion .quantity-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
        }

        .quantity-badge.stock-normal {
            background: #d4edda;
            color: #155724;
        }

        .quantity-badge.stock-low {
            background: #fff3cd;
            color: #856404;
        }

        .quantity-badge.stock-critical {
            background: #f8d7da;
            color: #721c24;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: nowrap;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 14px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .btn-edit {
            background: #4ecdc4;
            color: white;
        }

        .btn-edit:hover {
            background: #44a08d;
            transform: translateY(-2px);
        }

        .btn-delete {
            background: #e74c3c;
            color: white;
        }

        .btn-delete:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }

        /* DataTables */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 20px;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 8px 15px;
            margin-left: 10px;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            outline: none;
            border-color: #4ecdc4;
        }

        .dataTables_wrapper .dataTables_length select {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 5px 10px;
            margin: 0 10px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 8px 12px !important;
            border-radius: 8px !important;
            transition: all 0.3s !important;
            box-shadow: none !important;
            font-weight: 600 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            color: white !important;
            box-shadow: none !important;
            transform: translateY(-2px);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%) !important;
            color: white !important;
            border-color: #4ecdc4 !important;
        }

        .dataTables_wrapper .dataTables_info {
            font-size: 14px;
            padding-top: 15px;
        }


        @media (max-width: 1200px) {
            .administracion .inventory-card {
                padding: 15px;
            }

            table.dataTable thead th,
            table.dataTable tbody td {
                padding: 15px 10px;
            }

            .stock-alerts {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <div class="administracion">
        <br>
        <div class="container mt-5 pt-5">
            <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            </div>
            <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                <h2 class="text-info-emphasis" style="margin: 0;">Historial de medicamnetos por habitacion</h2>

            </div>

            <div class="inventory-card">
                <div class="table-container">
                    <table id="pacientesTable" class="table table-hover">
                        <thead>
                        <tr>
                            <th>Nombre del Paciente</th>
                            <th>Número de Habitación</th>
                            <th>Medicamentos Asignados</th>
                            <th>Asignar Medicamento</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pacientes as $paciente)
                            @php
                                $habitacion = $paciente->asignacionesHabitacion->first();
                            @endphp

                            @if($habitacion) {{-- Solo mostrar pacientes con habitación --}}
                            <tr>
                                <td>{{ $paciente->nombres }} {{ $paciente->apellidos }}</td>
                                <td>{{ $habitacion->habitacion->numero_habitacion ?? 'Sin Habitación' }}</td>
                                <td>
                                    <ul>
                                        @foreach($paciente->medicamentos as $med)
                                            <li>{{ $med->nombre }} - Cantidad: {{ $med->pivot->cantidad }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    @if($inventarios->count() > 0)
                                        <form action="{{ route('asignar.medicamento') }}" method="POST" class="d-flex gap-2">
                                            @csrf
                                            <select name="inventario_id" class="form-select form-select-sm" style="flex: 2.5;" required>
                                                <option value="" disabled selected>Selecciona medicamento</option>
                                                @foreach($inventarios as $inv)
                                                    <option value="{{ $inv->id }}">{{ $inv->nombre }}</option>
                                                @endforeach
                                            </select>
                                            <input type="number" name="cantidad" min="1" placeholder="0" class="form-control form-control-sm" style="flex: 0.5;" required data-bs-toggle="tooltip" data-bs-placement="top" title="Cantidad">
                                            <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">
                                            <input type="hidden" name="habitacion_id" value="{{ $habitacion->habitacion->id }}">
                                            <button type="submit" class="btn-sm btn-edit">Asignar</button>
                                        </form>
                                    @else
                                        <span>No hay medicamentos disponibles</span>
                                    @endif
                                </td>
                            </tr>
                            @endif
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
                        emptyTable: "No hay pacientes con habitación asignada",
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
            });
        </script>

@endsection
