@extends('layouts.plantillaEnfermeria')

@section('titulo', 'Listado de Incidentes')

@section('contenido')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background: #f0f4f8;
            min-height: 100vh;
            padding: 20px;
        }

        .incidentes-container {
            max-width: 1400px;
            margin: 40px auto;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .header-section h1 {
            color: #2c3e50;
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .btn-nuevo {
            background: linear-gradient(135deg, #4ECDC4 0%, #44A08D 100%);
            color: white;
            padding: 14px 30px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.3);
        }

        .btn-nuevo:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
            color: white;
        }

        .alert-success-custom {
            background: #d4edda;
            border-left: 4px solid #28a745;
            color: #155724;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border-left: 5px solid;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .stat-card.total {
            border-left-color: #3498db;
        }

        .stat-card.pendientes {
            border-left-color: #e74c3c;
        }

        .stat-card.criticos {
            border-left-color: #f39c12;
        }

        .stat-card.mes {
            border-left-color: #27ae60;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-card.total .stat-number { color: #3498db; }
        .stat-card.pendientes .stat-number { color: #e74c3c; }
        .stat-card.criticos .stat-number { color: #f39c12; }
        .stat-card.mes .stat-number { color: #27ae60; }

        .stat-label {
            color: #666;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .table-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        table.dataTable {
            width: 100% !important;
        }

        table.dataTable thead th {
            font-weight: 700;
            padding: 15px;
            border-bottom: 2px solid #e0e0e0;
            color: white !important;
            background: #4ecdc4 !important;
        }

        table.dataTable tbody td {
            padding: 15px;
            vertical-align: middle;
        }

        table.dataTable tbody tr:hover {
            background: #f8f9fa;
        }

        .badge-custom {
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-block;
        }

        .badge-leve {
            background: #d4edda;
            color: #155724;
        }

        .badge-moderado {
            background: #fff3cd;
            color: #856404;
        }

        .badge-grave {
            background: #ffeaa7;
            color: #b8650b;
        }

        .badge-critico {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-pendiente {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-revision {
            background: #fff3cd;
            color: #856404;
        }

        .badge-resuelto {
            background: #d4edda;
            color: #155724;
        }

        .btn-ver {
            background: #3498db;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }

        .btn-ver:hover {
            background: #2980b9;
            color: white;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .header-section {
                flex-direction: column;
                align-items: flex-start;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <br> <br>

    <div class="incidentes-container">
        <!-- Header -->
        <div class="header-section">
            <h1>
                Reportes de Incidentes
            </h1>
            <a href="{{ route('incidentes.crear') }}" class="btn-nuevo">
                <i class="fas fa-plus-circle"></i> Nuevo Incidente
            </a>
        </div>

        <!-- Alerta de Éxito -->
        @if(session('success'))
            <div class="alert-success-custom">
                <i class="fas fa-check-circle" style="font-size: 1.5rem;"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Estadísticas -->
        <div class="stats-grid">
            <div class="stat-card total">
                <div class="stat-number">{{ $incidentes->total() }}</div>
                <div class="stat-label">Total de Incidentes</div>
            </div>
            <div class="stat-card pendientes">
                <div class="stat-number">{{ $incidentes->where('estado', 'Pendiente')->count() }}</div>
                <div class="stat-label">Pendientes</div>
            </div>
            <div class="stat-card criticos">
                <div class="stat-number">{{ $incidentes->where('gravedad', 'Crítico')->count() }}</div>
                <div class="stat-label">Críticos</div>
            </div>
            <div class="stat-card mes">
                <div class="stat-number">{{ $incidentes->where('created_at', '>=', now()->startOfMonth())->count() }}</div>
                <div class="stat-label">Este Mes</div>
            </div>
        </div>

        <!-- Tabla de Incidentes -->
        <div class="table-card">
            <table id="incidentesTable" class="table table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha/Hora</th>
                    <th>Paciente</th>
                    <th>Tipo</th>
                    <th>Gravedad</th>
                    <th>Estado</th>
                    <th>Reportado Por</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($incidentes as $incidente)
                    <tr>
                        <td><strong>#{{ str_pad($incidente->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($incidente->fecha_hora_incidente)->format('d/m/Y H:i') }}</td>
                        <td>{{ $incidente->paciente->nombres }} {{ $incidente->paciente->apellidos }}</td>
                        <td>{{ $incidente->tipo_incidente }}</td>
                        <td>
                            <span class="badge-custom badge-{{ strtolower($incidente->gravedad) }}">
                                {{ $incidente->gravedad }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-custom badge-{{ $incidente->estado == 'Pendiente' ? 'pendiente' : ($incidente->estado == 'En Revisión' ? 'revision' : 'resuelto') }}">
                                {{ $incidente->estado }}
                            </span>
                        </td>
                        <td>{{ $incidente->empleado_nombre }}</td>
                        <td>
                            <a href="{{ route('incidentes.show', $incidente->id) }}" class="btn-ver">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#incidentesTable').DataTable({
                language: {
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ registros",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ incidentes",
                    infoEmpty: "Mostrando 0 a 0 de 0 incidentes",
                    zeroRecords: "No se encontraron incidentes",
                    emptyTable: "No hay incidentes registrados",
                    paginate: {
                        first: "Primero",
                        previous: "Anterior",
                        next: "Siguiente",
                        last: "Último"
                    }
                },
                pageLength: 10,
                order: [[1, 'desc']]
            });
        });
    </script>

@endsection
