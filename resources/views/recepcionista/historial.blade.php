@extends('layouts.plantillaRecepcion')

@section('contenido')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .main-container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 40px 15px;
        }

        h2 {
            color: #0f766e;
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 25px;
        }

        /* Tabla Container */
        .table-container-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            overflow: visible;
            padding: 25px;
        }

        .table-container {
            overflow-x: visible;
            width: 100%;
            margin: 0 auto;
        }

        table.dataTable {
            width: 100% !important;
            border-collapse: collapse;
            table-layout: auto;
        }

        table.dataTable thead th {
            padding: 16px;
            text-align: center;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border-bottom: 2px solid #e0e0e0;
            background: #14b8a6;
            color: white;
            white-space: nowrap;
        }

        table.dataTable tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s;
        }

        table.dataTable tbody tr:hover {
            background: #f0fdfa;
        }

        table.dataTable tbody td {
            padding: 16px;
            color: #555;
            text-align: center;
            vertical-align: middle;
        }

        .patient-name {
            font-weight: 600;
            color: #333;
            font-size: 15px;
        }

        .doctor-name {
            color: #555;
            font-size: 15px;
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
            border-color: #14b8a6;
        }

        .dataTables_wrapper .dataTables_length select {
            height: 32px !important;
            padding: 4px 8px !important;
            font-size: 14px !important;
            border-radius: 6px !important;
            min-width: 60px; /* ancho mínimo para que no quede muy angosto */
            box-sizing: border-box;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 8px 12px !important;
            border-radius: 8px !important;
            transition: all 0.3s !important;
            box-shadow: none !important;
            font-weight: 600 !important;
            border: none !important;
            background: transparent !important;
            color: #6c757d !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            color: #6c757d !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            transform: none !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #007bff !important;
            color: white !important;
            border: none !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #0056b3 !important;
            border: none !important;
        }

        .dataTables_wrapper .dataTables_info {
            font-size: 14px;
            padding-top: 15px;
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 20px 10px;
            }

            .table-container-card {
                padding: 15px;
            }

            table.dataTable thead th,
            table.dataTable tbody td {
                padding: 12px 8px;
            }

            h2 {
                font-size: 1.5rem;
            }
        }
        .text-info-emphasis {

            font-weight: bold;
        }

        table.dataTable thead th {
            padding: 20px;
            text-align: center;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border-bottom: 2px solid #e0e0e0;
            background:  #4ecdc4 !important;
            color: white;
            white-space: nowrap;
        }
    </style>

    <div class="main-container">
        <br><br>
        <h2 class="text-info-emphasis">Historial Diario de Pacientes</h2>
        <br>
        <div class="table-container-card">
            <div class="table-container">
                <table id="historialTable" class="table table-hover">
                    <thead>

                    <tr>

                        <th>Nombre del Paciente</th>
                        <th>Doctor que lo atendió</th>

                    </tr>

                    </thead>
                    <tbody>


                    @forelse($historial as $item)

                        <tr>
                            <td>
                                <span class="patient-name">{{ $item->nombre_paciente }}</span>
                            </td>
                            <td>
                                <span class="doctor-name">{{ $item->doctor }}</span>
                            </td>
                        </tr>
                    @empty
                    @endforelse

                    </tbody>
                </table>
            </div>
        </div>


    </div>

    <!-- jQuery (necesario para DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inicializar DataTable
            $('#historialTable').DataTable({
                responsive: true,
                autoWidth: false,
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                language: {
                    processing: "Procesando...",
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ registros",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty: "Mostrando 0 a 0 de 0 registros",
                    infoFiltered: "(filtrado de _MAX_ registros totales)",
                    loadingRecords: "Cargando...",
                    zeroRecords: "No hay pacientes atendidos hoy",
                    emptyTable: "No hay pacientes atendidos hoy",
                    paginate: {
                        first: "Primero",
                        previous: "Anterior",
                        next: "Siguiente",
                        last: "Último"
                    }
                },
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]],
                order: [[0, 'asc']], // Ordenar por nombre de paciente
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip'
            });
        });
    </script>

@endsection
