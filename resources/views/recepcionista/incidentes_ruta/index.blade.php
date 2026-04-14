@extends('layouts.plantillaRecepcion')

@section('titulo', 'Reportes de Incidentes')

@section('contenido')
    {{-- Estilos para DataTables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <style>
        .traslados-container { max-width: 1400px; margin: 100px auto 50px auto; padding: 0 20px; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px; }
        .header-info h2 { color: #0f766e; font-size: 2.2rem; margin-bottom: 0; font-weight: 700; }

        .btn-registrar {
            background-color: #4ecdc4; color: white; border: none; padding: 10px 25px;
            border-radius: 12px; font-weight: 600; transition: all 0.3s ease;
        }

        /* --- ALERTAS CORREGIDAS: FONDO SUAVE, BORDE INTENSO 3PX, SIN ICONOS --- */
        .selector-alert {
            border: 3px solid;
            border-radius: 18px;
            padding: 15px 25px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        }

        .alert-success-selector {
            background: #d4edda; /* Verde suave */
            border-color: #2ecc71; /* Verde intenso */
        }
        .alert-danger-selector {
            background: #f8d7da; /* Rojo suave */
            border-color: #e74c3c; /* Rojo intenso */
        }

        .alert-content { text-align: left; flex-grow: 1; }
        .alert-title { font-weight: 900; text-transform: uppercase; font-size: 0.95rem; display: block; margin-bottom: 2px; }
        .alert-success-selector .alert-title { color: #155724; }
        .alert-danger-selector .alert-title { color: #721c24; }
        .alert-msg { color: #333; font-weight: 600; font-size: 1rem; }

        .btn-close-custom {
            background: none; border: none; font-size: 1.5rem; font-weight: 900;
            color: #999; cursor: pointer; margin-left: 20px;
        }

        /* --- ESTADÍSTICAS --- */
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; margin-bottom: 30px; }
        .stat-card { background: white; border-radius: 14px; padding: 22px; box-shadow: 0 3px 12px rgba(0,0,0,0.07); border-left: 5px solid; }
        .stat-number { font-size: 2.2rem; font-weight: 800; margin-bottom: 4px; }
        .stat-card.total { border-color: #3498db; }
        .stat-card.pendiente { border-color: #f39c12; }
        .stat-card.completado { border-color: #2ecc71; }
        .stat-card.total .stat-number { color: #3498db; }
        .stat-card.pendiente .stat-number { color: #f39c12; }
        .stat-card.completado .stat-number { color: #2ecc71; }
        .stat-label { font-size: 0.88rem; color: #666; font-weight: 600; text-transform: uppercase; }

        /* --- TABLA --- */
        .table-container { background-color: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); padding: 25px; }
        table.dataTable thead th {
            background: #4ecdc4 !important; color: white !important;
            padding: 15px; text-transform: uppercase; font-size: 13px;
            border: none; text-align: center !important;
        }
        table.dataTable tbody td { vertical-align: middle !important; text-align: center !important; padding: 12px !important; }

        .badge-estado { padding: 8px 16px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; min-width: 110px; display: inline-flex; justify-content: center; }
        .badge-Activo { background: #fff3cd; color: #856404; }
        .badge-Resuelto { background: #d4edda; color: #155724; }

        /* --- MODALES SELECTOR --- */
        .modal-selector .modal-content.selector-content {
            background: #fff; border: 3px solid #24f3e2; box-shadow: 0 0 20px rgba(36, 243, 226, 0.4);
            border-radius: 18px; overflow: hidden;
        }
        .modal-selector .selector-header { background: linear-gradient(90deg, #00e1ff, #00ffc8); padding: 15px 20px; }
        .modal-selector .modal-title { color: #fff; font-size: 24px; font-weight: 800; }
        .modal-selector .selector-body { padding: 24px; background: #fff; color: #333; }
        .modal-selector .selector-footer { border-top: 1px solid #e5e5e5; padding: 18px 24px; background: #fff; }
        .button-group-50 { display: flex; width: 100%; gap: 15px; justify-content: center; }
        .btn-modal-action {
            background: linear-gradient(135deg, #4ecdc4 0%, #44b8af 100%);
            color: white !important; border: none; padding: 12px; border-radius: 8px;
            font-weight: 600; flex: 1; text-align: center; text-decoration: none;
        }
        .btn-cancel {
            background: white !important; border: 2px solid #dc3545 !important; color: #dc3545 !important;
            padding: 12px; border-radius: 8px; font-weight: 600; flex: 1;
        }
        .form-control-custom { border: 2px solid #24f3e2; border-radius: 12px; padding: 12px; background: rgba(36, 243, 226, 0.05); }
    </style>

    <div class="traslados-container">

        @if(session('success'))
            <div class="selector-alert alert-success-selector">
                <div class="alert-content">
                    <span class="alert-title">Operación Exitosa</span>
                    <span class="alert-msg">{{ session('success') }}</span>
                </div>
                <button type="button" class="btn-close-custom" onclick="this.parentElement.style.display='none';">×</button>
            </div>
        @endif

        @if($errors->any())
            <div class="selector-alert alert-danger-selector">
                <div class="alert-content">
                    <span class="alert-title">Atención / Error</span>
                    <span class="alert-msg">Por favor, revisa los datos ingresados.</span>
                </div>
                <button type="button" class="btn-close-custom" onclick="this.parentElement.style.display='none';">×</button>
            </div>
        @endif

        <div class="page-header">
            <div class="header-info">
                <h2>Reportes de Incidentes en ruta</h2>
            </div>
            <button class="btn-registrar shadow-sm" data-bs-toggle="modal" data-bs-target="#modalIncidente">
                Registrar Nuevo
            </button>
        </div>

        <div class="stats-grid">
            <div class="stat-card total"><div class="stat-number">{{ $total }}</div><div class="stat-label">Total</div></div>
            <div class="stat-card pendiente"><div class="stat-number">{{ $pendientes }}</div><div class="stat-label">Pendientes</div></div>
            <div class="stat-card completado"><div class="stat-number">{{ $resueltos }}</div><div class="stat-label">Resueltos</div></div>
        </div>

        <div class="table-container">
            <h4 class="mb-4 text-start">Listado de Incidentes</h4>
            <table id="incidentesTable" class="table table-hover w-100">
                <thead>
                <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>Unidad</th>
                    <th>Paciente</th>
                    <th>Evento</th>
                    <th>Retraso</th>
                    <th>Estado / Tiempo</th>
                    <th>Acción</th>
                </tr>
                </thead>
                <tbody>
                @foreach($incidentes as $index => $inc)
                    <tr>
                        <td class="text-muted fw-bold">{{ $index + 1 }}</td>
                        <td class="fw-bold text-muted">#{{ str_pad($inc->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td class="fw-bold" style="color:#4ecdc4;">{{ $inc->traslado->unidad_asignada }}</td>
                        <td class="fw-bold">{{ $inc->traslado->paciente->nombres }} {{ $inc->traslado->paciente->apellidos }}</td>
                        <td>{{ $inc->tipo_incidente }}</td>
                        <td><strong style="color:#e74c3c;">+{{ $inc->minutos_retraso }} min</strong></td>
                        <td id="status-container-{{ $inc->id }}">
                            @if($inc->estado_incidente == 'Activo')
                                <span class="badge-estado badge-Activo timer-label" data-id="{{ $inc->id }}" data-expire="{{ $inc->fecha_expiracion_js }}">Cargando...</span>
                            @else
                                <span class="badge-estado badge-Resuelto">Resuelto</span>
                            @endif
                        </td>
                        <td id="action-container-{{ $inc->id }}">
                            @if($inc->estado_incidente == 'Activo')
                                <button class="btn btn-sm btn-outline-success fw-bold px-3" data-bs-toggle="modal" data-bs-target="#modalResolver{{ $inc->id }}">Resolver</button>
                            @else
                                <span class="text-success fw-bold small">Finalizado</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL REGISTRO --}}
    <div class="modal fade modal-selector" id="modalIncidente" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content selector-content">
                <div class="selector-header"><h5 class="modal-title">Nuevo Incidente</h5></div>
                <form action="{{ route('incidentes_ruta.store') }}" method="POST">
                    @csrf
                    <div class="selector-body text-start">
                        <div class="mb-3">
                            <label class="fw-bold mb-2 small text-uppercase">Traslado Activo</label>
                            <select name="traslado_id" class="form-control form-control-custom" required>
                                <option value="" disabled selected>Seleccione...</option>
                                @foreach($trasladosActivos as $t)
                                    <option value="{{ $t->id }}">{{ $t->unidad_asignada }} - {{ $t->paciente->nombres }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold mb-2 small text-uppercase">Tipo de Incidente</label>
                            <select name="tipo_incidente" class="form-control form-control-custom" required>
                                <option value="Tráfico">Tráfico Pesado</option>
                                <option value="Falla Mecánica">Falla Mecánica</option>
                                <option value="Desvío">Desvío de Ruta</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold mb-2 small text-uppercase">Retraso (Min)</label>
                            <input type="number" name="minutos_retraso" class="form-control form-control-custom" required min="1">
                        </div>
                    </div>
                    <div class="selector-footer">
                        <div class="button-group-50">
                            <button type="submit" class="btn-modal-action">Guardar</button>
                            <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODALES RESOLVER --}}
    @foreach($incidentes as $inc)
        @if($inc->estado_incidente == 'Activo')
            <div class="modal fade modal-selector" id="modalResolver{{ $inc->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content selector-content">
                        <div class="selector-header"><h5 class="modal-title w-100 text-center">Resolver</h5></div>
                        <div class="selector-body text-center">
                            <p>¿Incidente de la unidad <strong>{{ $inc->traslado->unidad_asignada }}</strong> solucionado?</p>
                        </div>
                        <div class="selector-footer">
                            <form action="{{ route('incidentes_ruta.resolver', $inc->id) }}" method="POST" class="w-100">
                                @csrf @method('PATCH')
                                <div class="button-group-50">
                                    <button type="submit" class="btn-modal-action">Confirmar</button>
                                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#incidentesTable').DataTable({
                language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
                columnDefs: [{ className: "dt-center", "targets": "_all" }],
                order: [[1, 'desc']]
            });

            function updateTimers() {
                $('.timer-label').each(function() {
                    let label = $(this);
                    let expireTime = new Date(label.data('expire')).getTime();
                    let diff = expireTime - new Date().getTime();
                    if (diff <= 0) {
                        location.reload();
                    } else {
                        let mins = Math.floor(diff / 60000);
                        let secs = Math.floor((diff % 60000) / 1000);
                        label.html(`${mins}m ${secs < 10 ? '0' : ''}${secs}s`);
                    }
                });
            }
            setInterval(updateTimers, 1000);
            updateTimers();
        });
    </script>
@endsection
