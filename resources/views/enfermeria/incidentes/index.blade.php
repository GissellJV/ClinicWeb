@extends('layouts.plantillaEnfermeria')
@section('titulo', 'Listado de Incidentes')
@section('contenido')

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <style>
        body { background: #f0f4f8; min-height: 100vh; }

        .incidentes-container { max-width: 1400px; margin: 40px auto; padding: 0 20px; }

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
            gap: 12px;
        }

        .btn-nuevo {
            padding: 0.875rem 2rem;
            background: linear-gradient(135deg, #4ECDC4 0%, #44A08D 100%);
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(78,205,196,0.3);
            border: none;
        }

        .btn-nuevo:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78,205,196,0.4);
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
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 22px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border-left: 5px solid;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s ease;
        }

        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 10px 25px rgba(0,0,0,0.12); }

        .stat-card.total     { border-left-color: #3498db; }
        .stat-card.pendientes{ border-left-color: #e74c3c; }
        .stat-card.criticos  { border-left-color: #f39c12; }
        .stat-card.mes       { border-left-color: #27ae60; }

        .stat-icon { font-size: 2rem; }
        .stat-card.total      .stat-icon { color: #3498db; }
        .stat-card.pendientes .stat-icon { color: #e74c3c; }
        .stat-card.criticos   .stat-icon { color: #f39c12; }
        .stat-card.mes        .stat-icon { color: #27ae60; }

        .stat-number { font-size: 2rem; font-weight: 700; line-height: 1; margin-bottom: 4px; }
        .stat-card.total      .stat-number { color: #3498db; }
        .stat-card.pendientes .stat-number { color: #e74c3c; }
        .stat-card.criticos   .stat-number { color: #f39c12; }
        .stat-card.mes        .stat-number { color: #27ae60; }

        .stat-label { color: #666; font-weight: 600; font-size: 0.9rem; }

        .table-card {
            background: white;
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        table.dataTable { width: 100% !important; }

        table.dataTable thead th {
            font-weight: 700;
            padding: 15px;
            border-bottom: 2px solid #e0e0e0;
            color: white !important;
            background: #4ecdc4 !important;
        }

        table.dataTable tbody td { padding: 14px; vertical-align: middle; }
        table.dataTable tbody tr:hover { background: #f8f9fa; }

        .badge-custom {
            padding: 5px 14px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.82rem;
            display: inline-block;
        }

        .badge-leve     { background: #d4edda; color: #155724; }
        .badge-moderado { background: #fff3cd; color: #856404; }
        .badge-grave    { background: #ffeaa7; color: #b8650b; }
        .badge-crítico,
        .badge-critico  { background: #f8d7da; color: #721c24; }
        .badge-pendiente{ background: #f8d7da; color: #721c24; }
        .badge-revision { background: #fff3cd; color: #856404; }
        .badge-resuelto { background: #d4edda; color: #155724; }

        .btn-ver {
            padding: 0.5rem 1.2rem;
            background: #3498db;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .btn-ver:hover { background: #2980b9; color: white; transform: translateY(-2px); }

        @media (max-width: 768px) {
            .header-section { flex-direction: column; align-items: flex-start; }
            .stats-grid { grid-template-columns: 1fr; }
        }
    </style>

    <br><br>

    <div class="incidentes-container">

        <div class="header-section">
            <h1>
                <i class="bi bi-clipboard2-pulse" style="color:#4ecdc4;"></i> Reportes de Incidentes
            </h1>
            <a href="{{ route('incidentes.crear') }}" class="btn-nuevo">
                <i class="bi bi-plus-circle"></i> Nuevo Incidente
            </a>
        </div>

        @if(session('success'))
            <div class="alert-success-custom">
                <i class="bi bi-check-circle-fill" style="font-size:1.3rem;"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="stats-grid">
            <div class="stat-card total">
                <div class="stat-icon"><i class="bi bi-folder2-open"></i></div>
                <div>
                    <div class="stat-number">{{ $incidentes->total() }}</div>
                    <div class="stat-label">Total de Incidentes</div>
                </div>
            </div>
            <div class="stat-card pendientes">
                <div class="stat-icon"><i class="bi bi-hourglass-split"></i></div>
                <div>
                    <div class="stat-number">{{ $incidentes->where('estado', 'Pendiente')->count() }}</div>
                    <div class="stat-label">Pendientes</div>
                </div>
            </div>
            <div class="stat-card criticos">
                <div class="stat-icon"><i class="bi bi-exclamation-octagon"></i></div>
                <div>
                    <div class="stat-number">{{ $incidentes->where('gravedad', 'Crítico')->count() }}</div>
                    <div class="stat-label">Críticos</div>
                </div>
            </div>
            <div class="stat-card mes">
                <div class="stat-icon"><i class="bi bi-calendar2-check"></i></div>
                <div>
                    <div class="stat-number">{{ $incidentes->where('created_at', '>=', now()->startOfMonth())->count() }}</div>
                    <div class="stat-label">Este Mes</div>
                </div>
            </div>
        </div>

        <div class="table-card">
            <table id="incidentesTable" class="table table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha Incidente</th>
                    <th>Fecha Registro</th>
                    <th>Paciente</th>
                    <th>Tipo</th>
                    <th>Gravedad</th>
                    <th>Estado</th>
                    <th>Reportado Por</th>
                    <th>Acción</th>
                </tr>
                </thead>
                <tbody>
                @foreach($incidentes as $incidente)
                    <tr>
                        <td><strong>#{{ str_pad($incidente->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($incidente->fecha_hora_incidente)->format('d/m/Y H:i') }}</td>
                        <td>{{ $incidente->created_at->format('d/m/Y H:i') }}</td>
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
                                <i class="bi bi-eye"></i> Ver
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

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
                    paginate: { first:"Primero", previous:"Anterior", next:"Siguiente", last:"Último" }
                },
                pageLength: 10,
                order: [[1, 'desc']]
            });
        });
    </script>

@endsection
