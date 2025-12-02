@extends('layouts.plantilla')

@section('titulo', 'Mis Citas')

@section('contenido')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .citas-container {
            max-width: 1400px;
            margin: 40px auto;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            color: #0f766e;
            font-size: 2.5rem;
            margin-bottom: 30px;
            font-weight: 700;




        }

        .header p {
            color: #7f8c8d;
            font-size: 1.1rem;
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
            text-align: left;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
            border-left: 5px solid;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
        }

        .stat-card.total {
            border-left-color: #2c3e50;
            background: linear-gradient(135deg, #fff 0%, #e8eaf0 100%);
        }
        .stat-card.programadas {border-left-color: #4ECDC4;
            background: linear-gradient(135deg, #fff 0%, #e5f9f7 100%);
        }
        .stat-card.canceladas { border-left-color: #e74c3c;
            background: linear-gradient(135deg, #fff 0%, #ffe5e5 100%);}
        .stat-card.reprogramadas { border-left-color: #f39c12;
            background: linear-gradient(135deg, #fff 0%, #fff4e5 100%);
        }

        .stat-card i {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .stat-card.total i { color: #2c3e50; }
        .stat-card.programadas i { color: #4ECDC4; }
        .stat-card.canceladas i { color: #e74c3c; }
        .stat-card.reprogramadas i { color: #f39c12; }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-card.total .stat-number { color: #2c3e50;}
        .stat-card.programadas .stat-number { color: #4ECDC4; }
        .stat-card.canceladas .stat-number { color: #e74c3c; }
        .stat-card.reprogramadas .stat-number { color: #f39c12; }

        .stat-label {
            color: #7f8c8d;
            font-size: 0.95rem;
        }

        /* Filtros */
        .filters-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .filters-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            align-items: end;
        }

        .filter-group label {
            display: block;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .filter-group select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e8f4f3;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #f8fffe;
        }

        .filter-group select:focus {
            outline: none;
            border-color: #4ECDC4;
            box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.1);
        }

        .btn-filter {
            padding: 12px 30px;
            background: linear-gradient(135deg, #4ECDC4 0%, #44A08D 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.4);
        }

        /* Alertas */
        .alert-custom {
            padding: 18px 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .alert-success-custom {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-left: 5px solid #28a745;
            color: #155724;
        }

        .alert-danger-custom {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            border-left: 5px solid #dc3545;
            color: #721c24;
        }

        .alert-info-custom {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            border-left: 5px solid #17a2b8;
            color: #0c5460;
            text-align: center;
            padding: 40px;
        }

        .alert-info-custom i {
            font-size: 3rem;
            display: block;
            margin-bottom: 15px;
        }

        /* Tarjetas de Citas */
        .citas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .cita-card {
            background: white;
            border-radius: 20px;
            padding: 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            overflow: hidden;
            border-left: 6px solid;
        }

        .cita-card.programada { border-left-color: #2ecc71; }
        .cita-card.cancelada { border-left-color: #e74c3c; }
        .cita-card.reprogramada { border-left-color: #f39c12; }
        .cita-card.pendiente { border-left-color: #3498db; }

        .cita-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        .cita-header-card {
            background: linear-gradient(135deg, #4ECDC4 0%, #44A08D 100%);
            padding: 25px;
            color: white;
        }

        .doctor-name {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .doctor-name i {
            font-size: 1.8rem;
        }

        .especialidad-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.3);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .cita-body {
            padding: 25px;
        }

        .cita-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .cita-info-item {
            display: flex;
            align-items: start;
            gap: 12px;
        }

        .cita-info-item i {
            color: #4ECDC4;
            font-size: 1.3rem;
            margin-top: 3px;
        }

        .cita-info-item .info-content {
            flex: 1;
        }

        .cita-info-item .info-label {
            font-size: 0.75rem;
            color: #7f8c8d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
        }

        .cita-info-item .info-value {
            font-size: 1rem;
            color: #2c3e50;
            font-weight: 600;
        }

        .estado-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .estado-badge i {
            font-size: 1rem;
        }

        .estado-programada {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
        }

        .estado-cancelada {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
        }

        .estado-reprogramada {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            color: #856404;
        }

        .estado-pendiente {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            color: #0c5460;
        }

        .mensaje-info {
            background: #e8f4f3;
            border-left: 4px solid #4ECDC4;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            color: #2c3e50;
            font-size: 0.95rem;
        }

        .cita-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-action {
            flex: 1;
            padding: 14px 20px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 0.95rem;
        }

        .btn-reprogramar {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            color: white;
        }

        .btn-reprogramar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(243, 156, 18, 0.4);
        }

        .btn-cancelar {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
        }

        .btn-cancelar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(231, 76, 60, 0.4);
        }

        /* Modales Mejorados */
        .modal-content {
            border-radius: 20px;
            border: none;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            border: none;
            padding: 35px 35px 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .modal-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 40px;
        }

        .modal-icon-danger {
            background: linear-gradient(135deg, #fee 0%, #fdd 100%);
            color: #dc3545;
        }

        .modal-icon-warning {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            color: #f39c12;
        }

        .modal-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            color: #2c3e50;
        }

        .modal-body {
            padding: 25px 35px 35px;
            text-align: center;
        }

        .modal-body p {
            color: #666;
            margin-bottom: 20px;
            font-size: 1.05rem;
        }

        .cita-info-box {
            background: linear-gradient(135deg, #f8fffe 0%, #e8f4f3 100%);
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            text-align: left;
            border-left: 4px solid #4ECDC4;
        }

        .cita-info-box strong {
            color: #2c3e50;
            display: inline-block;
            width: 100px;
            font-weight: 600;
        }

        .modal-footer {
            border: none;
            padding: 0 35px 35px;
            justify-content: center;
            gap: 15px;
        }

        .modal-footer .btn {
            min-width: 140px;
            padding: 14px 30px;
            border-radius: 12px;
            font-weight: 600;
            border: none;
            font-size: 1rem;
        }

        .btn-modal-cancel {
            background: #e9ecef;
            color: #666;
        }

        .btn-modal-cancel:hover {
            background: #d3d6d9;
        }

        .btn-modal-danger {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
        }

        .btn-modal-danger:hover {
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.4);
        }

        .btn-modal-warning {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            color: white;
        }

        .btn-modal-warning:hover {
            box-shadow: 0 4px 15px rgba(243, 156, 18, 0.4);
        }

        .form-control-modal {
            border-radius: 10px;
            border: 2px solid #e8f4f3;
            padding: 12px 16px;
            font-size: 1rem;
        }

        .form-control-modal:focus {
            border-color: #4ECDC4;
            box-shadow: 0 0 0 0.2rem rgba(78, 205, 196, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
            text-align: left;
            display: block;
        }

        .btn-close {
            position: absolute;
            right: 20px;
            top: 20px;
        }

        /* Paginación */
        .pagination {
            justify-content: center;
            margin-top: 30px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .citas-grid {
                grid-template-columns: 1fr;
            }

            .cita-info-grid {
                grid-template-columns: 1fr;
            }

            .filters-row {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>

    <div class="citas-container">
        <!-- Header -->
        <div class="header">
            <h1> Mis Citas Médicas</h1>
        </div>

        <!-- Alertas -->
        @if(session('success'))
            <div class="alert-custom alert-success-custom">
                <i class="fas fa-check-circle" style="font-size: 1.5rem;"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert-custom alert-danger-custom">
                <i class="fas fa-exclamation-circle" style="font-size: 1.5rem;"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @php
            $total = $citas->total();
            $programadas = \App\Models\Cita::where('paciente_id', session('paciente_id'))->where('estado', 'programada')->count();
            $canceladas = \App\Models\Cita::where('paciente_id', session('paciente_id'))->where('estado', 'cancelada')->count();
            $reprogramadas = \App\Models\Cita::where('paciente_id', session('paciente_id'))->where('estado', 'reprogramada')->count();
        @endphp

            <!-- Estadísticas -->
        <div class="stats-grid">
            <div class="stat-card total">
                <div class="stat-number">{{ $total }}</div>
                <div class="stat-label">Total de Citas</div>
            </div>

            <div class="stat-card programadas">

                <div class="stat-number">{{ $programadas }}</div>
                <div class="stat-label">Programadas</div>
            </div>

            <div class="stat-card reprogramadas">

                <div class="stat-number">{{ $reprogramadas }}</div>
                <div class="stat-label">Reprogramadas</div>
            </div>

            <div class="stat-card canceladas">

                <div class="stat-number">{{ $canceladas }}</div>
                <div class="stat-label">Canceladas</div>
            </div>


        </div>

        <!-- Filtros -->
        <div class="filters-card">
            <form method="GET" action="{{ route('citas.mis-citas') }}">
                <div class="filters-row">
                    <div class="filter-group">
                        <label><i class="fas fa-filter"></i> Filtrar por Estado</label>
                        <select name="estado">
                            <option value="">Todos los estados</option>
                            <option value="programada" {{ request('estado') == 'programada' ? 'selected' : '' }}>Programada</option>
                            <option value="cancelada" {{ request('estado') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                            <option value="reprogramada" {{ request('estado') == 'reprogramada' ? 'selected' : '' }}>Reprogramada</option>
                            <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label><i class="fas fa-sort"></i> Ordenar por</label>
                        <select name="orden">
                            <option value="fecha_desc" {{ request('orden') == 'fecha_desc' ? 'selected' : '' }}>Fecha (más reciente)</option>
                            <option value="fecha_asc" {{ request('orden') == 'fecha_asc' ? 'selected' : '' }}>Fecha (más antigua)</option>
                            <option value="doctor" {{ request('orden') == 'doctor' ? 'selected' : '' }}>Doctor</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <button type="submit" class="btn-filter">
                            <i class="fas fa-search"></i> Filtrar
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Grid de Citas -->
        @if($citas->count() > 0)
            <div class="citas-grid">
                @foreach($citas as $cita)
                    <div class="cita-card {{ $cita->estado }}">
                        <!-- Header de la Cita -->
                        <div class="cita-header-card">
                            <div class="doctor-name">
                                <i class="fas fa-user-md"></i>
                                @if($cita->doctor)
                                    {{ $cita->doctor->genero === 'Femenino' ? 'Dra.' : 'Dr.' }} {{ $cita->doctor->nombre }} {{ $cita->doctor->apellido ?? '' }}
                                @else
                                    {{ $cita->doctor_nombre ?? 'Doctor No Definido' }}
                                @endif
                            </div>
                            <span class="especialidad-badge">
                                <i class="fas fa-stethoscope"></i> {{ $cita->especialidad ?? 'No definida' }}
                            </span>
                        </div>

                        <!-- Body de la Cita -->
                        <div class="cita-body">
                            <!-- Estado -->
                            <div class="estado-badge estado-{{ $cita->estado }}">
                                @if($cita->estado == 'programada')
                                    <i class="fas fa-check-circle"></i>
                                @elseif($cita->estado == 'cancelada')
                                    <i class="fas fa-times-circle"></i>
                                @elseif($cita->estado == 'reprogramada')
                                    <i class="fas fa-calendar-alt"></i>
                                @else
                                    <i class="fas fa-clock"></i>
                                @endif
                                {{ ucfirst($cita->estado) }}
                            </div>

                            <!-- Información de la Cita -->
                            <div class="cita-info-grid">
                                <div class="cita-info-item">
                                    <i class="fas fa-user"></i>
                                    <div class="info-content">
                                        <div class="info-label">Paciente</div>
                                        <div class="info-value">{{ session('paciente_nombre') ?? 'No definido' }}</div>
                                    </div>
                                </div>

                                <div class="cita-info-item">
                                    <i class="fas fa-calendar"></i>
                                    <div class="info-content">
                                        <div class="info-label">Fecha</div>
                                        <div class="info-value">{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</div>
                                    </div>
                                </div>

                                <div class="cita-info-item">
                                    <i class="fas fa-clock"></i>
                                    <div class="info-content">
                                        <div class="info-label">Hora</div>
                                        <div class="info-value">{{ $cita->hora }}</div>
                                    </div>
                                </div>

                                <div class="cita-info-item">
                                    <i class="fas fa-hospital"></i>
                                    <div class="info-content">
                                        <div class="info-label">Clínica</div>
                                        <div class="info-value">ClinicWeb</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Mensaje de Confirmación -->
                            @if($cita->mensaje)
                                <div class="mensaje-info">
                                    <i class="fas fa-info-circle"></i> {{ $cita->mensaje }}
                                </div>
                            @endif

                            <!-- Botones de Acción -->
                            @if($cita->estado == 'programada')
                                <div class="cita-actions">
                                    <button type="button" class="btn-action btn-reprogramar"
                                            onclick="confirmarReprogramacion(
                                        {{ $cita->id }},
                                        '{{ $cita->doctor_nombre }}',
                                        '{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}',
                                        '{{ $cita->hora }}'
                                    )">
                                        Reprogramar
                                    </button>

                                    <form action="{{ route('citas.cancelar', $cita->id) }}" method="POST" id="formCancelar{{ $cita->id }}" style="flex: 1; margin: 0;">
                                        @csrf
                                        <button type="button" class="btn-action btn-cancelar" style="width: 100%;"
                                                onclick="confirmarCancelacion(
                                            {{ $cita->id }},
                                            '{{ $cita->doctor_nombre }}',
                                            '{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}',
                                            '{{ $cita->hora }}'
                                        )">
                                            Cancelar
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Formulario Oculto para Reprogramar -->
                    @if($cita->estado == 'programada')
                        <form action="{{ route('citas.reprogramar', $cita->id) }}" method="POST" id="formReprogramar{{ $cita->id }}" style="display: none;">
                            @csrf
                            <input type="hidden" name="nueva_fecha" id="hidden_nueva_fecha_{{ $cita->id }}">
                            <input type="hidden" name="nueva_hora" id="hidden_nueva_hora_{{ $cita->id }}">
                        </form>
                    @endif
                @endforeach
            </div>

            <!-- Paginación -->
            <div class="mt-4">
                {{ $citas->appends(request()->query())->links() }}
            </div>
        @else
            <div class="alert-custom alert-info-custom">
                <i class="fas fa-calendar-times"></i>
                <h3>No tienes citas programadas</h3>
                <p>Agenda tu primera cita médica con nosotros</p>
                <a href="{{ route('agendarcitas') }}" class="btn-filter" style="display: inline-flex; text-decoration: none;">
                    <i class="fas fa-plus"></i> Agendar Cita
                </a>
            </div>
        @endif
    </div>

    <!-- Modal Cancelar -->
    <div class="modal fade" id="modalCancelar" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                <div class="modal-header">
                    <div class="modal-icon modal-icon-danger">
                    </div>
                    <h5 class="modal-title">¿Cancelar Cita?</h5>
                </div>

                <div class="modal-body">
                    <p>¿Estás seguro de que deseas cancelar esta cita médica?</p>
                    <div class="cita-info-box" id="modalCancelarTexto"></div>
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">Esta acción no se puede deshacer</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-modal-cancel" data-bs-dismiss="modal">No, mantener cita</button>
                    <button type="button" class="btn btn-modal-danger" id="btnConfirmarCancelar">
                        <i class="fas fa-check"></i> Sí, cancelar cita
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Reprogramar CORREGIDO -->
    <div class="modal fade" id="modalReprogramar" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-header">
                    <div class="modal-icon modal-icon-warning">
                    </div>
                    <h5 class="modal-title">Reprogramar Cita</h5>
                </div>

                <div class="modal-body" id="modalReprogramarContenido">
                    <!-- El contenido se llenará dinámicamente con JavaScript -->
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-modal-cancel" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-modal-warning" id="btnConfirmarReprogramar">
                        <i class="fas fa-save"></i> Guardar cambios
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmarCancelacion(id, doctor, fecha, hora) {
            document.getElementById('modalCancelarTexto').innerHTML = `
                <strong>Doctor:</strong> ${doctor}<br>
                <strong>Fecha:</strong> ${fecha}<br>
                <strong>Hora:</strong> ${hora}
            `;

            document.getElementById('btnConfirmarCancelar').onclick = function () {
                document.getElementById('formCancelar' + id).submit();
            };

            new bootstrap.Modal(document.getElementById('modalCancelar')).show();
        }

        function confirmarReprogramacion(id, doctor, fecha, hora) {
            document.getElementById('modalReprogramarContenido').innerHTML = `
                <p>Selecciona la nueva fecha y hora para tu cita</p>

                <div class="cita-info-box mb-3">
                    <strong>Doctor:</strong> ${doctor}<br>
                    <strong>Fecha actual:</strong> ${fecha}<br>
                    <strong>Hora actual:</strong> ${hora}
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-calendar"></i> Nueva Fecha</label>
                    <input type="date" class="form-control form-control-modal" id="modal_fecha_${id}" required min="{{ date('Y-m-d') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-clock"></i> Nueva Hora</label>
                    <input type="time" class="form-control form-control-modal" id="modal_hora_${id}" required>
                </div>
            `;

            document.getElementById('btnConfirmarReprogramar').onclick = function () {
                let nuevaFecha = document.getElementById('modal_fecha_' + id).value;
                let nuevaHora = document.getElementById('modal_hora_' + id).value;

                if (!nuevaFecha || !nuevaHora) {
                    alert('Por favor complete todos los campos');
                    return;
                }

                document.getElementById('hidden_nueva_fecha_' + id).value = nuevaFecha;
                document.getElementById('hidden_nueva_hora_' + id).value = nuevaHora;

                document.getElementById('formReprogramar' + id).submit();
            };

            new bootstrap.Modal(document.getElementById('modalReprogramar')).show();
        }
    </script>
@endsection
