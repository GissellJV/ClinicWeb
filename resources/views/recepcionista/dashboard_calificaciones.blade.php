@extends('layouts.plantilaAdmin')

@section('contenido')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <style>
        body { background: whitesmoke; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .main-container { padding-top: 20px; }

        /* Tarjetas de Estadisticas con Efecto de Movimiento */
        .stat-card {
            border: none;
            border-radius: 15px;
            color: white;
            padding: 1.2rem;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            cursor: pointer;
        }

        /* Efecto al pasar el cursor (Hover) */
        .stat-card:hover {
            transform: translateY(-8px); /* Se eleva */
            box-shadow: 0 12px 20px rgba(0,0,0,0.15); /* Sombra mas profunda */
            filter: brightness(1.1); /* Brilla un poco mas */
        }

        .mint { background-color: #00bfa6; }
        .aqua { background-color: #4cd7c6; }
        .turq { background-color: #82e9de; }
        .soft { background-color: #b2f5ea; color: #004b46; }

        .chart-container {
            background: white; border-radius: 15px; padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08); height: 100%;
        }

        .bi-star-fill, .bi-star-half, .bi-star {
            color: #ffc107 !important;
        }

        /* Tablas */
        table.dataTable thead th {
            background: #4ecdc4 !important; color: white !important;
            text-transform: uppercase; font-size: 13px; text-align: center; border: none;
        }
        table.dataTable tbody td { text-align: center; vertical-align: middle; }
    </style>

    <div class="container main-container my-4">
        <h2 class="text-info-emphasis mb-4" style="font-weight: bold;">Estadistica de Calidad de Traslados</h2>

        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stat-card mint">
                    <i class="bi bi-star-fill fs-1 text-white"></i> <h5>Promedio</h5>
                    <h3>{{ number_format($promedioGeneral, 1) }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card aqua">
                    <i class="bi bi-chat-right-text-fill fs-1"></i>
                    <h5>Opiniones</h5>
                    <h3>{{ $totalCalificaciones }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card turq">
                    <i class="bi bi-award-fill fs-1"></i>
                    <h5>Mejor Unidad</h5>
                    <h3>{{ $mejorAmbulancia->unidad_asignada ?? 'N/A' }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card soft">
                    <i class="bi bi-calendar3 fs-1"></i>
                    <h5>Reporte</h5>
                    <h3>{{ now()->format('M Y') }}</h3>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-8">
                <div class="chart-container">
                    <h5 class="mb-4" style="color: #2c3e50; font-weight: 650;">Calificaciones por Ambulancia</h5>
                    <div style="height: 300px;">
                        <canvas id="calidadBarChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="chart-container">
                    <h5 class="mb-4" style="color: #2c3e50; font-weight: 650;">Distribucion de Satisfaccion</h5>
                    <div style="height: 300px;">
                        <canvas id="calidadDoughnutChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="chart-container">
            <h5 class="mb-4" style="color: #2c3e50; font-weight: 650;">Registro Detallado</h5>
            <table id="calidadTable" class="table table-hover w-100">
                <thead>
                <tr>
                    <th>Paciente</th>
                    <th>Unidad</th>
                    <th>Calificacion</th>
                    <th>Comentario</th>
                    <th>Fecha</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($calificaciones as $item)
                    <tr>
                        <td class="fw-bold">{{ $item->traslado->paciente->nombres ?? 'Usuario' }}</td>
                        <td><span class="badge" style="background: #e6f9f7; color: #0d9488;">{{ $item->traslado->unidad_asignada }}</span></td>
                        <td>
                            @for($i=1; $i<=5; $i++)
                                <i class="bi bi-star{{ $i <= $item->puntuacion ? '-fill' : '' }}"></i>
                            @endfor
                        </td>
                        <td class="text-muted small italic">"{{ $item->comentario }}"</td>
                        <td>{{ $item->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {
            $('#calidadTable').DataTable({
                responsive: true,
                language: {
                    "search": "Buscar:",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "zeroRecords": "No se encontraron resultados"
                }
            });

            new Chart(document.getElementById('calidadBarChart'), {
                type: 'bar',
                data: {
                    labels: @json($datosGrafica->pluck('unidad_asignada')),
                    datasets: [{
                        label: 'Promedio',
                        data: @json($datosGrafica->pluck('promedio')),
                        backgroundColor: '#00bfa6',
                        borderRadius: 10,
                        maxBarThickness: 50
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true, max: 5 },
                        x: { grid: { display: false } }
                    }
                }
            });

            new Chart(document.getElementById('calidadDoughnutChart'), {
                type: 'doughnut',
                data: {
                    labels: ['5 Estrellas', '4 Estrellas', '3 Estrellas', '2 Estrellas', '1 Estrella'],
                    datasets: [{
                        data: [
                            {{ $calificaciones->where('puntuacion', 5)->count() }},
                            {{ $calificaciones->where('puntuacion', 4)->count() }},
                            {{ $calificaciones->where('puntuacion', 3)->count() }},
                            {{ $calificaciones->where('puntuacion', 2)->count() }},
                            {{ $calificaciones->where('puntuacion', 1)->count() }}
                        ],
                        backgroundColor: ['#00bfa6', '#4cd7c6', '#82e9de', '#b2f5ea', '#e2e8f0']
                    }]
                },
                options: { cutout: '70%', responsive: true, maintainAspectRatio: false }
            });
        });
    </script>
@endsection
