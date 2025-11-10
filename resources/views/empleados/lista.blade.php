@extends('layouts.plantillaRecepcion')

@section('titulo', 'Lista de Empleados')

@section('contenido')
    <style>
        .empleados-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .empleados-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .empleados-header h1 {
            color: #2c3e50;
            font-size: 2.2rem;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .empleados-header p {
            color: #7f8c8d;
            font-size: 1.1rem;
        }

        .card-empleados {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header-empleados {
            background: linear-gradient(135deg, #4ECDC4 0%, #44A08D 100%);
            padding: 25px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header-empleados h4 {
            color: white;
            font-size: 1.6rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-nuevo {
            background: white;
            color: #4ECDC4;
            padding: 12px 25px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-nuevo:hover {
            background: #f8f9fa;
            color: #45b8b0;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .card-body-empleados {
            padding: 40px;
        }

        .alert-success-custom {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 18px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-size: 1.05rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-info-custom {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
            padding: 40px;
            border-radius: 12px;
            text-align: center;
            font-size: 1.1rem;
        }

        .alert-info-custom i {
            font-size: 3rem;
            color: #17a2b8;
            margin-bottom: 15px;
        }

        .table-container {
            overflow-x: auto;
            border-radius: 12px;
            border: 1px solid #e8f4f3;
        }

        .table-custom {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .table-custom thead {
            background: #f8fffe;
        }

        .table-custom thead th {
            padding: 18px 20px;
            text-align: left;
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #4ECDC4;
        }

        .table-custom tbody tr {
            border-bottom: 1px solid #e8f4f3;
            transition: all 0.3s ease;
        }

        .table-custom tbody tr:hover {
            background: #f8fffe;
            transform: scale(1.01);
        }

        .table-custom tbody td {
            padding: 20px;
            color: #555;
            font-size: 1rem;
        }

        .badge-custom {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .badge-doctor {
            background: #d4edda;
            color: #155724;
        }

        .badge-recepcionista {
            background: #cce5ff;
            color: #004085;
        }

        .badge-enfermero {
            background: #fff3cd;
            color: #856404;
        }

        .badge-default {
            background: #e2e8f0;
            color: #475569;
        }

        .btn-acciones {
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-right: 8px;
        }

        .btn-ver {
            background: #4ECDC4;
            color: white;
        }

        .btn-ver:hover {
            background: #45b8b0;
            color: white;
        }

        .btn-editar {
            background: #f59e0b;
            color: white;
        }

        .btn-editar:hover {
            background: #d97706;
            color: white;
        }

        .numero-empleado {
            background: #4ECDC4;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .nombre-empleado {
            font-weight: 600;
            color: #2c3e50;
        }

        .stats-mini {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .stat-mini {
            background: #f8fffe;
            padding: 15px 25px;
            border-radius: 12px;
            border: 2px solid #e8f4f3;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .stat-mini i {
            font-size: 1.8rem;
            color: #4ECDC4;
        }

        .stat-mini-text span {
            display: block;
            font-size: 0.8rem;
            color: #7f8c8d;
        }

        .stat-mini-text strong {
            font-size: 1.4rem;
            color: #2c3e50;
        }

        @media (max-width: 768px) {
            .card-header-empleados {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .card-body-empleados {
                padding: 25px 20px;
            }

            .table-custom {
                font-size: 0.9rem;
            }

            .table-custom thead th,
            .table-custom tbody td {
                padding: 12px;
            }

            .btn-acciones {
                padding: 6px 12px;
                font-size: 0.85rem;
                margin-bottom: 5px;
            }
        }
    </style>

    <div class="empleados-container">
        <div class="empleados-header">
            <h1>Lista de Empleados</h1>
            <p>Gestiona todo el personal de la clínica</p>
        </div>

        <div class="card-empleados">
            <div class="card-header-empleados">
                <h4>
                    <i class="fas fa-users"></i>
                    Empleados Registrados
                </h4>
                <a href="{{ route('empleados.crear') }}" class="btn-nuevo">
                    <i class="fas fa-plus"></i>
                    Nuevo Empleado
                </a>
            </div>

            <div class="card-body-empleados">
                @if(session('success'))
                    <div class="alert-success-custom">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($empleados->isEmpty())
                    <div class="alert-info-custom">
                        <div>
                            <i class="fas fa-users-slash"></i>
                        </div>
                        <h4>No hay empleados registrados</h4>
                        <p>Comienza agregando el primer empleado de la clínica</p>
                        <a href="{{ route('empleados.crear') }}" class="btn-nuevo" style="margin-top: 15px; display: inline-flex;">
                            <i class="fas fa-plus"></i>
                            Registrar Primer Empleado
                        </a>
                    </div>
                @else
                    <!-- Mini Estadísticas -->
                    <div class="stats-mini">
                        <div class="stat-mini">
                            <i class="fas fa-users"></i>
                            <div class="stat-mini-text">
                                <span>Total Empleados</span>
                                <strong>{{ $empleados->count() }}</strong>
                            </div>
                        </div>

                        <div class="stat-mini">
                            <i class="fas fa-user-md"></i>
                            <div class="stat-mini-text">
                                <span>Doctores</span>
                                <strong>{{ $empleados->where('cargo', 'Doctor')->count() }}</strong>
                            </div>
                        </div>

                        <div class="stat-mini">
                            <i class="fas fa-user-nurse"></i>
                            <div class="stat-mini-text">
                                <span>Enfermeros</span>
                                <strong>{{ $empleados->where('cargo', 'Enfermero')->count() }}</strong>
                            </div>
                        </div>

                        <div class="stat-mini">
                            <i class="fas fa-user-tie"></i>
                            <div class="stat-mini-text">
                                <span>Recepcionistas</span>
                                <strong>{{ $empleados->where('cargo', 'Recepcionista')->count() }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="table-container">
                        <table class="table-custom">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><i class="fas fa-user"></i> Nombre Completo</th>
                                <th><i class="fas fa-id-card"></i> Identidad</th>
                                <th><i class="fas fa-briefcase"></i> Cargo</th>
                                <th><i class="fas fa-building"></i> Departamento</th>
                                <th><i class="fas fa-calendar"></i> Fecha Ingreso</th>
                                <th><i class="fas fa-cog"></i> Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($empleados as $empleado)
                                <tr>
                                    <td>
                                        <div class="numero-empleado">{{ $loop->iteration }}</div>
                                    </td>
                                    <td class="nombre-empleado">
                                        {{ $empleado->nombre }} {{ $empleado->apellido }}
                                    </td>
                                    <td>{{ $empleado->numero_identidad }}</td>
                                    <td>
                                        @php
                                            $badgeClass = 'badge-default';
                                            if($empleado->cargo == 'Doctor') {
                                                $badgeClass = 'badge-doctor';
                                            } elseif($empleado->cargo == 'Recepcionista') {
                                                $badgeClass = 'badge-recepcionista';
                                            } elseif($empleado->cargo == 'Enfermero') {
                                                $badgeClass = 'badge-enfermero';
                                            }
                                        @endphp
                                        <span class="badge-custom {{ $badgeClass }}">
                                                {{ $empleado->cargo }}
                                            </span>
                                    </td>
                                    <td>{{ $empleado->departamento }}</td>
                                    <td>{{ $empleado->fecha_ingreso->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="#" class="btn-acciones btn-ver">
                                            <i class="fas fa-eye"></i>
                                            Ver
                                        </a>
                                        <a href="#" class="btn-acciones btn-editar">
                                            <i class="fas fa-edit"></i>
                                            Editar
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
