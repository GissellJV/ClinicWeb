@extends('layouts.plantillaDoctor')

@section('contenido')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background:whitesmoke;
            display: flex;
            min-height: 100vh;
            padding: 20px;
        }

        .citas-container {
            margin-top: 100px;
            max-width: 1200px;

        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            color: #2c3e50;
            font-size: 2.2rem;
            margin-bottom: 10px;
        }

        .header p {
            color: #7f8c8d;
            font-size: 1.1rem;
        }

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
        .stat-card.hoy i { color: #4ECDC4; }
        .stat-card.pendientes i { color: #f39c12; }
        .stat-card.completadas i { color: #2ecc71; }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-card.total .stat-number { color: #3498db; }
        .stat-card.hoy .stat-number { color: #4ECDC4; }
        .stat-card.pendientes .stat-number { color: #f39c12; }
        .stat-card.completadas .stat-number { color: #2ecc71; }

        .stat-label {
            color: #7f8c8d;
            font-size: 0.95rem;
        }

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

        .filter-group select,
        .filter-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e8f4f3;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .filter-group select:focus,
        .filter-group input:focus {
            outline: none;
            border-color: #4ECDC4;
            box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.1);
        }

        .btn-filter {
            padding: 12px 30px;
            background: #4ECDC4;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-filter:hover {
            background: #45b8b0;
            transform: translateY(-2px);
        }

        .citas-list {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .citas-list h3 {
            color: #2c3e50;
            margin-bottom: 25px;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .citas-list h3 i {
            color: #4ECDC4;
        }

        .cita-card {
            border: 2px solid #e8f4f3;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .cita-card:hover {
            border-color: #4ECDC4;
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.1);
        }

        .cita-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 15px;
        }

        .paciente-info h4 {
            color: #2c3e50;
            font-size: 1.2rem;
            margin-bottom: 5px;
        }

        .paciente-info p {
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        .badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .badge-programada {
            background: #d4edda;
            color: #155724;
        }

        .badge-pendiente {
            background: #fff3cd;
            color: #856404;
        }

        .badge-completada {
            background: #d1ecf1;
            color: #0c5460;
        }

        .badge-cancelada {
            background: #f8d7da;
            color: #721c24;
        }

        .cita-detalles {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            padding: 15px;
            background: #f8fffe;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .detalle-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .detalle-item i {
            color: #4ECDC4;
            font-size: 1.2rem;
        }

        .detalle-text span {
            display: block;
            font-size: 0.75rem;
            color: #7f8c8d;
            margin-bottom: 3px;
        }

        .detalle-text strong {
            color: #2c3e50;
            font-size: 0.95rem;
        }

        .motivo-consulta {
            padding: 15px;
            background: #fff;
            border-left: 4px solid #4ECDC4;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .motivo-consulta h5 {
            color: #2c3e50;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .motivo-consulta p {
            color: #555;
            line-height: 1.6;
        }

        .cita-acciones {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-ver {
            background: #4ECDC4;
            color: white;
        }

        .btn-ver:hover {
            background: #45b8b0;
            color: white;
        }

        .btn-completar {
            background: #2ecc71;
            color: white;
        }

        .btn-completar:hover {
            background: #27ae60;
        }

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

        .empty-state h3 {
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .cita-header {
                flex-direction: column;
                gap: 15px;
            }

            .cita-acciones {
                justify-content: flex-start;
                width: 100%;
            }

            .filters-row {
                grid-template-columns: 1fr;
            }
        }

        .table thead th {
            background: #4ecdc4 ;
        }

        .table.table-hover tbody tr:hover,
        .table.table-hover tbody tr:hover td {
            background: rgb(222, 251, 249);
            color: rgba(28, 27, 27, 0.95);
        }

        .text-info-emphasis{
            font-weight: bold;
        }
    </style>

    <div class="citas-container">
        <!-- Header -->
        <div class="header">
            <h1 class="text-center text-info-emphasis">Mis Citas Programadas</h1>
            <p>Gestiona y revisa tus citas médicas</p>
        </div>

        <!-- Estadísticas -->
        <div class="stats-grid">
            <div class="stat-card total">
                <i class="fas fa-calendar"></i>
                <div class="stat-number">{{ $citas->total() }}</div>
                <div class="stat-label">Total de Citas</div>
            </div>

            <div class="stat-card hoy">
                <i class="fas fa-calendar-day"></i>
                <div class="stat-number">{{ $citasHoy }}</div>
                <div class="stat-label">Citas de Hoy</div>
            </div>

            <div class="stat-card pendientes">
                <i class="fas fa-clock"></i>
                <div class="stat-number">{{ $citas->where('estado', 'programada')->count() + $citas->where('estado', 'pendiente')->count() }}</div>
                <div class="stat-label">Pendientes</div>
            </div>

            <div class="stat-card completadas">
                <i class="fas fa-check-circle"></i>
                <div class="stat-number">{{ $citas->where('estado', 'completada')->count() }}</div>
                <div class="stat-label">Completadas</div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="filters-card">
            <form method="GET" action="{{ route('doctor.citas') }}">
                <div class="filters-row">
                    <div class="filter-group">
                        <label><i class="fas fa-calendar"></i> Fecha</label>
                        <input type="date" name="fecha" value="{{ request('fecha') }}">
                    </div>

                    <div class="filter-group">
                        <label><i class="fas fa-filter"></i> Estado</label>
                        <select name="estado">
                            <option value="">Todos los estados</option>
                            <option value="programada" {{ request('estado') == 'programada' ? 'selected' : '' }}>Programada</option>
                            <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="completada" {{ request('estado') == 'completada' ? 'selected' : '' }}>Completada</option>
                            <option value="cancelada" {{ request('estado') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label><i class="fas fa-sort"></i> Ordenar por</label>
                        <select name="orden">
                            <option value="fecha_asc" {{ request('orden') == 'fecha_asc' ? 'selected' : '' }}>Fecha (más próxima)</option>
                            <option value="fecha_desc" {{ request('orden') == 'fecha_desc' ? 'selected' : '' }}>Fecha (más lejana)</option>
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

        <!-- Lista de Citas -->
        <div class="citas-list">
            <h3>
                <i class="fas fa-list"></i>
                Listado de Citas
            </h3>

            @if(session('success'))
                <div class="alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if($citas->count() > 0)
                @foreach($citas as $cita)
                    <div class="cita-card">
                        <div class="cita-header">
                            <div class="paciente-info">
                                <h4>{{ $cita->paciente_nombre }}</h4>
                                <p>Paciente ID: {{ $cita->paciente_id }}</p>
                            </div>
                            <span class="badge badge-{{ $cita->estado }}">
                        {{ ucfirst($cita->estado) }}
                    </span>
                        </div>

                        <div class="cita-detalles">
                            <div class="detalle-item">
                                <i class="fas fa-calendar"></i>
                                <div class="detalle-text">
                                    <span>Fecha</span>
                                    <strong>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</strong>
                                </div>
                            </div>

                            <div class="detalle-item">
                                <i class="fas fa-clock"></i>
                                <div class="detalle-text">
                                    <span>Hora</span>
                                    <strong>{{ $cita->hora }}</strong>
                                </div>
                            </div>

                            <div class="detalle-item">
                                <i class="fas fa-stethoscope"></i>
                                <div class="detalle-text">
                                    <span>Especialidad</span>
                                    <strong>{{ $cita->especialidad }}</strong>
                                </div>
                            </div>

                            @if($cita->paciente && $cita->paciente->telefono)
                                <div class="detalle-item">
                                    <i class="fas fa-phone"></i>
                                    <div class="detalle-text">
                                        <span>Teléfono</span>
                                        <strong>{{ $cita->paciente->telefono }}</strong>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if($cita->motivo)
                            <div class="motivo-consulta">
                                <h5><i class="fas fa-notes-medical"></i> Motivo de Consulta:</h5>
                                <p>{{ $cita->motivo }}</p>
                            </div>
                        @endif

                        <div class="cita-acciones">
                            <a href="{{ route('expediente.ver', $cita->paciente_id) }}" class="btn btn-ver">
                                <i class="fas fa-file-medical"></i>
                                Ver Expediente
                            </a>

                            @if(in_array($cita->estado, ['programada', 'pendiente']))
                                <form method="POST" action="{{ route('doctor.cita.completar', $cita->id) }}" style="margin: 0;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-completar">
                                        <i class="fas fa-check"></i>
                                        Marcar Completada
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach

                <!-- Paginación -->
                <div style="margin-top: 30px;">
                    {{ $citas->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <h3>No hay citas programadas</h3>
                    <p>No tienes citas médicas en este momento</p>
                </div>
            @endif
        </div>
    </div>

@endsection
