@extends('layouts.plantillaRecepcion')
@section('contenido')
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Asistencia | ClinicWeb</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:whitesmoke;
        }

        .stat-card {
            border: none;
            border-radius: 15px;
            color: white;
            padding: 1.2rem;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }

        .mint { background-color: #00bfa6; }
        .aqua { background-color: #4cd7c6; }
        .turq { background-color: #82e9de; }
        .soft { background-color: #b2f5ea; color: #004b46; }

        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 0.9rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);

        }

        .filter-tabs .nav-link {
            color: #009e8e;
            border: none;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .filter-tabs .nav-link:hover {
            color: #00bfa6;
        }

        .filter-tabs .nav-link.active {
            border-bottom: 3px solid #00bfa6;
            font-weight: 600;
            color: #00bfa6;
        }

        .text-info-emphasis {
            font-weight: bold;
        }

        /* DataTables Styles */
        table.dataTable {
            width: 100% !important;
            border-collapse: collapse;
            table-layout: auto;
        }

        table.dataTable thead th {
            padding: 16px;
            text-align: left;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border-bottom: 2px solid #e0e0e0;
            background: #4ecdc4 !important;
            color: white !important;
            white-space: nowrap;
        }

        table.dataTable tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s;
        }

        table.dataTable tbody tr:hover {
            background: rgb(222, 251, 249) !important;
        }

        table.dataTable tbody td {
            padding: 16px;
            color: #2c3e50;
            vertical-align: middle;
        }

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
            background: #4ecdc4 !important;
            color: white !important;
            border: none !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #45b8b0 !important;
            border: none !important;
        }

        .dataTables_wrapper .dataTables_info {
            font-size: 14px;
            padding-top: 15px;
        }

        .patient-name {
            font-weight: 600;
            color: #333;
        }

        @media (max-width: 768px) {
            table.dataTable thead th,
            table.dataTable tbody td {
                padding: 12px 8px;
            }
        }
    </style>
</head>
<body>
<br><br><br>
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-info-emphasis">Estadística de Asistencia de Pacientes</h2>
    </div>

    <!-- Estadísticas -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card mint">
                <i class="bi bi-emoji-smile fs-1"></i>
                <h5>Niños</h5>
                <h3>{{$ninos->count()}}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card aqua">
                <i class="bi bi-person-hearts fs-1"></i>
                <h5>Adolescentes</h5>
                <h3>{{$adolescentes->count()}}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card turq">
                <i class="bi bi-person-badge fs-1"></i>
                <h5>Adultos</h5>
                <h3>{{$adultos->count()}}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card soft">
                <i class="bi bi-person-wheelchair fs-1"></i>
                <h5>Tercera edad</h5>
                <h3>{{$terceraEdad->count()}}</h3>
            </div>
        </div>
    </div>

    <!-- Gráficas -->
    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="chart-container">
                <h5 class="mb-3" style="color: #2c3e50;
            font-weight: 650; margin-top: 2% ">Visitas por Semana</h5>
                <canvas id="visitasChart"></canvas>
            </div>
        </div>
        <div class="col-md-4">
            <div class="chart-container">
                <h5 class="mb-3"style="color: #2c3e50;
            font-weight: 650; margin-top: 2% ">Distribución por Edad</h5>
                <canvas id="edadChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Registro y filtros -->
    <div class="chart-container">
        <div class="">
            <h5 class="mb-3" style="color: #2c3e50;
            font-weight: 650; margin-top: 1%">Registro de visitas</h5>
        </div>
        <br>
        <table id="citasTable" class="table table-hover align-middle">
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Edad</th>
                <th>Doctor/Especialista</th>
                <th>Especialidad</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Estado</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($citas as $cita)
                <tr>
                    <td><span class="patient-name">{{ $cita->paciente_nombre }}</span></td>
                    <td>{{ $cita->paciente->edad }} años</td>
                    <td>{{ $cita->doctor_nombre }}</td>
                    <td>{{ $cita->especialidad }}</td>
                    <td>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $cita->hora }}</td>
                    <td>{{ ucfirst($cita->estado) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
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
        $('#citasTable').DataTable({
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
                zeroRecords: "No se encontraron registros",
                emptyTable: "No hay visitas registradas",
                paginate: {
                    first: "Primero",
                    previous: "Anterior",
                    next: "Siguiente",
                    last: "Último"
                }
            },
            pageLength: 10,
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            order: [[4, 'desc']], // Ordenar por fecha descendente
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip'
        });
    });

    // Gráfico de barras
    const ctx1 = document.getElementById('visitasChart');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: @json($labelsVisitas),
            datasets: [{
                label: 'Visitas',
                data: @json($dataVisitas),
                backgroundColor: '#00bfa6'
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });

    // Gráfico circular
    const ctx2 = document.getElementById('edadChart');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Niños', 'Adolescentes', 'Adultos', 'Tercera Edad'],
            datasets: [{
                data: [{{$ninos->count()}}, {{$adolescentes->count()}}, {{$adultos->count()}}, {{$terceraEdad->count()}}],
                backgroundColor: ['#00bfa6', '#4cd7c6', '#82e9de', '#b2f5ea']
            }]
        },
        options: { responsive: true, cutout: '70%' }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection
