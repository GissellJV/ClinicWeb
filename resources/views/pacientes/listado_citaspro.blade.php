@extends('layouts.plantillaRecepcion')
@section('contenido')

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:whitesmoke;
            display: flex;
        }

        .container-fluid {
            max-width: 1400px;
            margin: 0 auto;
        }

        h1 {
            color: #0f766e;
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 30px;
        }

        .alert {
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .table-container {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow-x: auto;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 16px 12px;
            border: none;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 14px 12px;
            vertical-align: middle;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table.table-hover tbody tr:hover {
            background: #f0fdfa;
            transform: scale(1.01);
            box-shadow: 0 2px 8px rgba(20, 184, 166, 0.1);
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: capitalize;
        }

        .bg-warning {
            background: #fbbf24 !important;
            color: #78350f !important;
        }

        .bg-success {
            background: #10b981 !important;
        }

        .bg-danger {
            background: #ef4444 !important;
        }

        .bg-info {
            background: #3b82f6 !important;
        }

        .bg-secondary {
            background: #6b7280 !important;
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border: none;
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }

        .btn-inicio {
            padding: 14px 32px;
            background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(20, 184, 166, 0.3);
            text-decoration: none;
            display: inline-block;
        }

        .btn-inicio:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(20, 184, 166, 0.4);
            color: white;
        }

        .text-muted {
            color: #9ca3af !important;
            font-style: italic;
        }

        .pagination {
            margin-top: 20px;
        }

        .pagination .page-link {
            color: #0d9488;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            margin: 0 4px;
            transition: all 0.3s ease;
        }

        .pagination .page-link:hover {
            background: #f0fdfa;
            border-color: #14b8a6;
            color: #0f766e;
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
            border-color: #14b8a6;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6b7280;
        }

        .empty-state i {
            font-size: 4rem;
            color: #d1d5db;
            margin-bottom: 20px;
        }

        .stats-container {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            flex: 1;
            min-width: 200px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-left: 4px solid #14b8a6;
        }

        .stat-card h3 {
            font-size: 2rem;
            font-weight: 700;
            color: #0f766e;
            margin: 0;
        }

        .stat-card p {
            color: #6b7280;
            margin: 5px 0 0 0;
            font-size: 0.9rem;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        @media (max-width: 768px) {
            .table-container {
                padding: 15px;
            }

            h1 {
                font-size: 1.6rem;
            }

            .btn-inicio {
                width: 100%;
            }

            .action-buttons {
                flex-direction: column;
            }

            .action-buttons button,
            .action-buttons form {
                width: 100%;
            }
        }
    </style>

    <div class="container-fluid">
        <h1 class="text-center">Pacientes con Citas Programadas</h1>

        @if(session('success'))
            <div class="alert alert-success text-center">
                 {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger text-center">
                 {{ session('error') }}
            </div>
        @endif

        <!-- Estadísticas rápidas -->
        <div class="stats-container">
            <div class="stat-card">
                <h3>{{ $citas->total() }}</h3>
                <p>Total de Citas</p>
            </div>
            <div class="stat-card" style="border-left-color: #fbbf24;">
                <h3>{{ $citas->where('estado', 'pendiente')->count() }}</h3>
                <p>Pendientes</p>
            </div>
            <div class="stat-card" style="border-left-color: #10b981;">
                <h3>{{ $citas->where('estado', 'programada')->count() }}</h3>
                <p>Confirmadas</p>
            </div>
            <div class="stat-card" style="border-left-color: #3b82f6;">
                <h3>{{ $citas->where('estado', 'reprogramada')->count() }}</h3>
                <p>Reprogramadas</p>
            </div>
        </div>

        <div class="table-container">
            <table class="table table-hover align-middle text-capitalize">
                <thead>
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
                        <td>
                            <strong>
                                @if($cita->paciente)
                                    {{ $cita->paciente->nombres }} {{ $cita->paciente->apellidos }}
                                @else
                                    {{ $cita->paciente_nombre ?? 'No Definido' }}
                                @endif
                            </strong>
                        </td>
                        <td>
                            @if($cita->doctor)
                                Dr. {{ $cita->doctor->nombre }} {{ $cita->doctor->apellido ?? '' }}
                            @else
                                {{ $cita->doctor_nombre ?? 'No Definido' }}
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</td>
                        <td><strong>{{ $cita->hora }}</strong></td>
                        <td>{{ $cita->especialidad ?? 'No definida' }}</td>
                        <td>
                            <span class="badge
                                @if($cita->estado == 'pendiente') bg-warning
                                @elseif($cita->estado == 'programada') bg-success
                                @elseif($cita->estado == 'cancelada') bg-danger
                                @elseif($cita->estado == 'reprogramada') bg-info
                                @else bg-secondary @endif">
                                {{ ucfirst($cita->estado) }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                @if($cita->estado == 'pendiente')
                                    <form action="{{ route('citas.confirmar', $cita->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                             Confirmar
                                        </button>
                                    </form>
                                @elseif($cita->estado == 'programada')
                                    <span class="text-success fw-bold"> Confirmada</span>
                                @elseif($cita->estado == 'cancelada')
                                    <span class="text-danger fw-bold"> Cancelada</span>
                                @elseif($cita->estado == 'reprogramada')
                                    <span class="text-info fw-bold"> Reprogramada</span>
                                @else
                                    <span class="text-muted">Sin acción</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div style="font-size: 4rem; color: #d1d5db;"></div>
                                <h4>No hay citas registradas</h4>
                                <p>Las citas agendadas aparecerán aquí</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            @if($citas->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $citas->links() }}
                </div>
            @endif
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('recepcionista.busquedaexpediente') }}" class="btn-inicio">
                 Volver al Inicio
            </a>
        </div>
    </div>

@endsection
