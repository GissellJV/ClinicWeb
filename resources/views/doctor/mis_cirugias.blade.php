@extends('layouts.plantillaDoctor')
@section('titulo', 'Mis Citas Quirúrgicas')

@section('contenido')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .cirugias-container {
            max-width: 1200px;
            margin: 100px auto 40px auto;
            padding: 0 20px;
        }
        .page-header { text-align: center; margin-bottom: 35px; }
        .page-header h2 { color: #2c3e50; font-size: 2rem; margin-bottom: 8px; }
        .page-header p { color: #7f8c8d; }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 35px;
        }
        .stat-card {
            background: white;
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.07);
            border-left: 5px solid;
            transition: transform 0.3s;
        }
        .stat-card:hover { transform: translateY(-4px); }
        .stat-card.programadas { border-color: #4ECDC4; background: linear-gradient(135deg,#fff,#e5f9f7); }
        .stat-card.hoy         { border-color: #f39c12; background: linear-gradient(135deg,#fff,#fff4e5); }
        .stat-card.total       { border-color: #3498db; background: linear-gradient(135deg,#fff,#e3f2fd); }
        .stat-number { font-size: 2.2rem; font-weight: 800; }
        .stat-card.programadas .stat-number { color: #4ECDC4; }
        .stat-card.hoy         .stat-number { color: #f39c12; }
        .stat-card.total       .stat-number { color: #3498db; }
        .stat-label { font-size: 0.9rem; color: #666; font-weight: 600; }

        .filters-card {
            background: white;
            border-radius: 14px;
            padding: 22px;
            margin-bottom: 25px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.07);
        }
        .filters-row { display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end; }
        .filter-group label { display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 6px; color: #444; }
        .filter-group input, .filter-group select {
            padding: 10px 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 0.9rem;
            min-width: 160px;
        }
        .filter-group input:focus, .filter-group select:focus {
            border-color: #4ECDC4;
            outline: none;
        }
        .btn-filter {
            padding: 10px 25px;
            background: #4ECDC4;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-filter:hover { background: #45b8b0; }

        .list-card {
            background: white;
            border-radius: 14px;
            padding: 28px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.07);
        }
        .list-card h3 { color: #2c3e50; font-size: 1.4rem; margin-bottom: 22px; display: flex; align-items: center; gap: 8px; }
        .list-card h3 i { color: #4ECDC4; }

        .cirugia-card {
            border: 2px solid #e8f4f3;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.3s;
        }
        .cirugia-card:hover { border-color: #4ECDC4; box-shadow: 0 4px 14px rgba(78,205,196,0.12); }
        .cirugia-card-header { display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 12px; margin-bottom: 14px; }
        .paciente-info h4 { color: #2c3e50; font-size: 1.15rem; margin-bottom: 3px; }
        .paciente-info p  { color: #888; font-size: 0.88rem; margin: 0; }

        .cirugia-detalles { display: flex; flex-wrap: wrap; gap: 14px 28px; margin-bottom: 14px; }
        .detalle-item { display: flex; align-items: center; gap: 8px; }
        .detalle-item i { color: #4ECDC4; width: 18px; }
        .detalle-text span { font-size: 0.75rem; color: #999; display: block; }
        .detalle-text strong { color: #2c3e50; font-size: 0.95rem; }

        .badge-estado {
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.82rem;
            font-weight: 700;
        }
        .estado-programada  { background:#e8f8f6; color:#44a08d; }
        .estado-en_proceso  { background:#fff3cd; color:#856404; }
        .estado-completada  { background:#d4edda; color:#155724; }
        .estado-cancelada   { background:#f8d7da; color:#721c24; }
        .riesgo-bajo  { background:#d4edda; color:#155724; border-radius:12px; padding:3px 10px; font-size:0.78rem; font-weight:700; }
        .riesgo-medio { background:#fff3cd; color:#856404; border-radius:12px; padding:3px 10px; font-size:0.78rem; font-weight:700; }
        .riesgo-alto  { background:#f8d7da; color:#721c24; border-radius:12px; padding:3px 10px; font-size:0.78rem; font-weight:700; }

        .empty-state { text-align: center; padding: 60px 20px; color: #aaa; }
        .empty-state i { font-size: 4rem; margin-bottom: 18px; display: block; color: #ccc; }
        .empty-state h3 { color: #555; }
    </style>

    <div class="cirugias-container">
        <div class="page-header">
            <h2><i class="bi bi-scissors me-2"></i>Mis Citas Quirúrgicas</h2>
            <p>Cirugías programadas asignadas a tu servicio</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Estadísticas --}}
        <div class="stats-grid">
            <div class="stat-card total">
                <div class="stat-number">{{ $cirugias->total() }}</div>
                <div class="stat-label">Total Cirugías</div>
                <small style="color:#888">Registradas</small>
            </div>
            <div class="stat-card programadas">
                <div class="stat-number">{{ $cirugiasProgramadas }}</div>
                <div class="stat-label">Programadas</div>
                <small style="color:#888">Pendientes de realizar</small>
            </div>
            <div class="stat-card hoy">
                <div class="stat-number">{{ $cirugiaHoy }}</div>
                <div class="stat-label">Hoy</div>
                <small style="color:#888">Cirugías de hoy</small>
            </div>
        </div>

        {{-- Filtros --}}
        <div class="filters-card">
            <form method="GET" action="{{ route('doctor.mis-cirugias') }}">
                <div class="filters-row">
                    <div class="filter-group">
                        <label><i class="bi bi-calendar me-1"></i>Fecha</label>
                        <input type="date" name="fecha" value="{{ request('fecha') }}">
                    </div>
                    <div class="filter-group">
                        <label><i class="bi bi-funnel me-1"></i>Estado</label>
                        <select name="estado">
                            <option value="">Todos</option>
                            <option value="programada"  {{ request('estado') == 'programada'  ? 'selected':'' }}>Programada</option>
                            <option value="en_proceso"  {{ request('estado') == 'en_proceso'  ? 'selected':'' }}>En Proceso</option>
                            <option value="completada"  {{ request('estado') == 'completada'  ? 'selected':'' }}>Completada</option>
                            <option value="cancelada"   {{ request('estado') == 'cancelada'   ? 'selected':'' }}>Cancelada</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <button type="submit" class="btn-filter"><i class="bi bi-search me-1"></i>Filtrar</button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Lista --}}
        <div class="list-card">
            <h3><i class="bi bi-list-ul"></i>Cirugías Asignadas</h3>

            @if($cirugias->count() > 0)
                @foreach($cirugias as $cirugia)
                    <div class="cirugia-card">
                        <div class="cirugia-card-header">
                            <div class="paciente-info">
                                <h4>
                                    {{ $cirugia->paciente->nombres ?? '' }} {{ $cirugia->paciente->apellidos ?? '' }}
                                </h4>
                                <p>
                                    {{ $cirugia->tipo_cirugia }}
                                    &nbsp;|&nbsp;
                                    <span class="riesgo-{{ $cirugia->evaluacion->nivel_riesgo ?? 'bajo' }}">
                                    Riesgo {{ ucfirst($cirugia->evaluacion->nivel_riesgo ?? 'N/A') }}
                                </span>
                                </p>
                            </div>
                            <span class="badge-estado estado-{{ $cirugia->estado }}">
                            {{ ucfirst(str_replace('_', ' ', $cirugia->estado)) }}
                        </span>
                        </div>

                        <div class="cirugia-detalles">
                            <div class="detalle-item">
                                <i class="bi bi-calendar-event"></i>
                                <div class="detalle-text">
                                    <span>Fecha</span>
                                    <strong>{{ \Carbon\Carbon::parse($cirugia->fecha_cirugia)->format('d/m/Y') }}</strong>
                                </div>
                            </div>
                            <div class="detalle-item">
                                <i class="bi bi-clock"></i>
                                <div class="detalle-text">
                                    <span>Horario</span>
                                    <strong>{{ $cirugia->hora_inicio }} – {{ $cirugia->hora_fin }}</strong>
                                </div>
                            </div>
                            <div class="detalle-item">
                                <i class="bi bi-hospital"></i>
                                <div class="detalle-text">
                                    <span>Quirófano</span>
                                    <strong>{{ $cirugia->quirofano }}</strong>
                                </div>
                            </div>
                            <div class="detalle-item">
                                <i class="bi bi-stopwatch"></i>
                                <div class="detalle-text">
                                    <span>Duración estimada</span>
                                    <strong>{{ $cirugia->duracion_estimada_min }} min</strong>
                                </div>
                            </div>
                            @if($cirugia->anestesiologo)
                                <div class="detalle-item">
                                    <i class="bi bi-person-badge"></i>
                                    <div class="detalle-text">
                                        <span>Anestesiólogo</span>
                                        <strong>{{ $cirugia->anestesiologo }}</strong>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if($cirugia->notas_adicionales)
                            <p class="text-muted" style="font-size:0.88rem; margin:0">
                                <i class="bi bi-sticky me-1"></i><strong>Notas:</strong> {{ $cirugia->notas_adicionales }}
                            </p>
                        @endif
                    </div>
                @endforeach

                <div class="mt-4">{{ $cirugias->links() }}</div>
            @else
                <div class="empty-state">
                    <i class="bi bi-scissors"></i>
                    <h3>No hay cirugías asignadas</h3>
                    <p>No tienes cirugías programadas en este momento</p>
                </div>
            @endif
        </div>
    </div>
@endsection
