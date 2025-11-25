
@extends('layouts.plantillaDoctor')

@section('contenido')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Reset básico */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: whitesmoke;
            min-height: 100vh;
        }

        .container {
            margin-top: 100px;
            max-width: 1200px;
        }

        .text-info-emphasis {
            font-weight: bold;
        }

        /* Cabecera */
        h2.text-center {
            margin-bottom: 40px;
            color: #2c3e50;
        }

        /* Estadísticas */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card i {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .stat-card.total i { color: #3498db; }
        .stat-card.pendientes i { color: #f39c12; }
        .stat-card.completadas i { color: #2ecc71; }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-card.total .stat-number { color: #3498db; }
        .stat-card.pendientes .stat-number { color: #f39c12; }
        .stat-card.completadas .stat-number { color: #2ecc71; }

        .stat-label {
            color: #7f8c8d;
            font-size: 0.95rem;
        }

        /* Botones */
        .btn-sm.btn-edit {
            padding: 6px 12px;
            font-size: 13px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #4ECDC4;
            color: white;
            transition: all 0.3s;
        }

        .btn-sm.btn-edit:hover {
            background: #45b8b0;
        }

        /* Tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: white;
            border-radius: 12px;
            overflow: hidden;
        }

        table thead {
            background: #4ECDC4;
            color: white;
        }

        table thead th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }

        table tbody td {
            padding: 15px;
            color: #2c3e50;
        }

        table tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        table tbody tr:hover {
            background: #e0f7f5;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .bg-warning { background: #fff3cd; color: #856404; }
        .bg-success { background: #d4edda; color: #131212; }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #7f8c8d;
        }

        .empty-state i {
            font-size: 4rem;
            color: #bdc3c7;
            margin-bottom: 20px;
        }

        .empty-state h4 {
            color: #2c3e50;
            margin-top: 15px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            table thead {
                display: none;
            }
            table tbody td {
                display: block;
                width: 100%;
                padding: 10px 5px;
            }
            table tbody tr {
                margin-bottom: 15px;
                display: block;
                border: 1px solid #ddd;
                border-radius: 12px;
                background: white;
            }
        }
    </style>

    <div class="container mt-5 pt-5">
        <h2 class="text-center text-info-emphasis mb-4">Expedientes Recibidos</h2>

        <!-- Estadísticas de Expedientes Recibidos -->
        <div class="stats-grid mb-4">
            <div class="stat-card total">
                <i class="fas fa-folder-open"></i>
                <div class="stat-number">{{ $expedientes->total() }}</div>
                <div class="stat-label">Total de Expedientes</div>
            </div>

            <div class="stat-card pendientes">
                <i class="fas fa-clock"></i>
                <div class="stat-number">
                    {{ $expedientes->where('estado', 'pendiente')->count() }}
                </div>
                <div class="stat-label">Pendientes</div>
            </div>

            <div class="stat-card completadas">
                <i class="fas fa-check-circle"></i>
                <div class="stat-number">
                    {{ $expedientes->where('estado', 'completado')->count() }}
                </div>
                <div class="stat-label">Completados</div>
            </div>
        </div>



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
                            <a href="{{ route('expediente.ver', $exp->paciente_id) }}" class="btn-sm btn-edit">
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

