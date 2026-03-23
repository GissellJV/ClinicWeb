@extends('layouts.plantillaRecepcion')

@section('titulo', 'Reportes de Incidentes')

@section('contenido')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .traslados-container {
            max-width: 1200px;
            margin: 100px auto 50px auto;
            padding: 0 20px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
        }
        .header-info h2 { color: #2c3e50; font-size: 2rem; margin-bottom: 8px; font-weight: 800; }
        .header-info p  { color: #7f8c8d; font-size: 1rem; margin: 0; }

        .btn-registrar {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            color: white; border: none; padding: 12px 25px; border-radius: 10px;
            font-weight: 700; box-shadow: 0 4px 15px rgba(78, 205, 196, 0.3);
            transition: 0.3s;
        }
        .btn-registrar:hover { transform: translateY(-2px); color: white; opacity: 0.9; }

        /* --- Estilos de Validación --- */
        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            font-weight: 500;
        }
        .is-invalid { border: 1.5px solid #dc3545 !important; }
        .input-group-text.border-danger { border-color: #dc3545 !important; color: #dc3545 !important; }

        .custom-alert {
            background: #ffffff; border-left: 5px solid #4ecdc4;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 8px;
            padding: 15px; margin-bottom: 25px; display: flex; align-items: center;
        }
        .custom-alert i { font-size: 1.5rem; color: #4ecdc4; margin-right: 12px; }

        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; margin-bottom: 30px; }
        .stat-card { background: white; border-radius: 14px; padding: 22px; box-shadow: 0 3px 12px rgba(0,0,0,0.07); border-left: 5px solid; transition: all 0.3s ease; cursor: pointer; }
        .stat-card:hover { transform: translateY(-5px) scale(1.02); box-shadow: 0 8px 15px rgba(0,0,0,0.1); }
        .stat-card.total { border-color: #3498db; }
        .stat-card.pendiente { border-color: #f39c12; }
        .stat-card.completado { border-color: #2ecc71; }
        .stat-number { font-size: 2.2rem; font-weight: 800; margin-bottom: 4px; }
        .stat-card.total .stat-number { color: #3498db; }
        .stat-card.pendiente .stat-number { color: #f39c12; }
        .stat-card.completado .stat-number { color: #2ecc71; }
        .stat-label { font-size: 0.88rem; color: #666; font-weight: 600; text-transform: uppercase; }

        .table-container { background-color: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 25px; }
        table.dataTable thead th { padding: 20px; color: white !important; background: #4ecdc4 !important; text-transform: uppercase; font-size: 13px; border: none !important; }
        table.dataTable tbody td { padding: 20px; color: #666; vertical-align: middle; }
        .badge-estado { padding: 5px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; }
        .badge-Activo { background: #fff3cd; color: #856404; }
        .badge-Resuelto { background: #d4edda; color: #155724; }
    </style>

    <div class="traslados-container">

        @if(session('success'))
            <div class="custom-alert">
                <i class="bi bi-check2-circle"></i>
                <div class="msg-content">
                    <span style="font-weight: bold; color: #2c3e50; display: block;">¡Operación Exitosa!</span>
                    <span style="color: #7f8c8d; font-size: 0.95rem;">{{ session('success') }}</span>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="page-header">
            <div class="header-info">
                <h2><i class="bi bi-broadcast-pin me-2" style="color:#4ECDC4;"></i>Reportes de Incidentes en ruta</h2>
            </div>
            <button class="btn btn-registrar" data-bs-toggle="modal" data-bs-target="#modalIncidente">
                <i class="bi bi-plus-lg me-2"></i>Registrar Nuevo
            </button>
        </div>

        <div class="stats-grid">
            <div class="stat-card total">
                <div class="stat-number">{{ $total }}</div>
                <div class="stat-label"><i class="bi bi-list-task me-1"></i>Total Reportes</div>
            </div>
            <div class="stat-card pendiente">
                <div class="stat-number">{{ $pendientes }}</div>
                <div class="stat-label"><i class="bi bi-hourglass-split me-1"></i>Pendientes</div>
            </div>
            <div class="stat-card completado">
                <div class="stat-number">{{ $resueltos }}</div>
                <div class="stat-label"><i class="bi bi-check-circle me-1"></i>Resueltos</div>
            </div>
        </div>

        <div class="table-container">
            <h4><i class="bi bi-clock-history me-2" style="color:#4ECDC4;"></i>Listado de Incidentes</h4>
            <table id="incidentesTable" class="table table-hover w-100">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>UNIDAD / AMBULANCIA</th>
                    <th>PACIENTE ASIGNADO</th>
                    <th>TIPO DE EVENTO</th>
                    <th class="text-center">RETRASO</th>
                    <th class="text-center">ESTADO</th>
                    <th class="text-center">ACCIÓN</th>
                </tr>
                </thead>
                <tbody>
                @foreach($incidentes as $inc)
                    <tr>
                        <td class="fw-bold text-muted">#{{ str_pad($inc->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td class="fw-bold" style="color:#4ecdc4;">{{ $inc->traslado->unidad_asignada }}</td>
                        <td class="fw-bold" style="color:#2c3e50;">{{ $inc->traslado->paciente->nombres }} {{ $inc->traslado->paciente->apellidos }}</td>
                        <td>{{ $inc->tipo_incidente }}</td>
                        <td class="text-center"><strong style="color:#e74c3c;">+{{ $inc->minutos_retraso }} min</strong></td>

                        <td class="text-center" id="status-container-{{ $inc->id }}">
                            @if($inc->estado_incidente == 'Activo')
                                <span class="badge-estado badge-Activo timer-label"
                                      data-id="{{ $inc->id }}"
                                      data-expire="{{ $inc->fecha_expiracion_js }}">
                                    <i class="bi bi-clock me-1"></i> Cargando...
                                </span>
                            @else
                                <span class="badge-estado badge-Resuelto">Resuelto</span>
                            @endif
                        </td>

                        <td class="text-center" id="action-container-{{ $inc->id }}">
                            @if($inc->estado_incidente == 'Activo')
                                <form action="{{ route('incidentes_ruta.resolver', $inc->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-outline-success fw-bold px-3">Resolver</button>
                                </form>
                            @else
                                <span class="text-success fw-bold small"><i class="bi bi-check-all"></i> Finalizado</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal con validación funcional --}}
    <div class="modal fade" id="modalIncidente" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <div class="modal-header text-white" style="background: #4ecdc4; border-radius: 20px 20px 0 0;">
                    <h5 class="modal-title fw-bold">Nuevo Reporte de Incidente</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('incidentes_ruta.store') }}" method="POST" novalidate>
                    @csrf
                    <div class="modal-body p-4 text-start">

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">TRASLADO ACTIVO</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text @error('traslado_id') border-danger text-danger @enderror">
                                    <i class="bi bi-truck"></i>
                                </span>
                                <select name="traslado_id" class="form-select bg-light @error('traslado_id') is-invalid @enderror" style="height: 50px;" required>
                                    <option value="" disabled selected>Seleccione la unidad...</option>
                                    @foreach($trasladosActivos as $t)
                                        <option value="{{ $t->id }}" {{ old('traslado_id') == $t->id ? 'selected' : '' }}>{{ $t->unidad_asignada }} - {{ $t->paciente->nombres }}</option>
                                    @endforeach
                                </select>
                                @error('traslado_id')
                                <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> Seleccione un traslado activo.</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">TIPO DE INCIDENTE</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text @error('tipo_incidente') border-danger text-danger @enderror">
                                    <i class="bi bi-exclamation-triangle"></i>
                                </span>
                                <select name="tipo_incidente" class="form-select bg-light @error('tipo_incidente') is-invalid @enderror" style="height: 50px;" required>
                                    <option value="Tráfico" {{ old('tipo_incidente') == 'Tráfico' ? 'selected' : '' }}>Tráfico Pesado</option>
                                    <option value="Falla Mecánica" {{ old('tipo_incidente') == 'Falla Mecánica' ? 'selected' : '' }}>Falla Mecánica</option>
                                    <option value="Desvío" {{ old('tipo_incidente') == 'Desvío' ? 'selected' : '' }}>Desvío de Ruta</option>
                                    <option value="Otro" {{ old('tipo_incidente') == 'Otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                @error('tipo_incidente')
                                <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> Seleccione el tipo de evento.</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">RETRASO ESTIMADO (MIN)</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text @error('minutos_retraso') border-danger text-danger @enderror">
                                    <i class="bi bi-clock-history"></i>
                                </span>
                                <input type="number" name="minutos_retraso" class="form-control bg-light @error('minutos_retraso') is-invalid @enderror" style="height: 50px;" required min="1" value="{{ old('minutos_retraso') }}">
                                @error('minutos_retraso')
                                <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> Ingrese el tiempo de retraso.</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">NOTA DESCRIPTIVA (OPCIONAL)</label>
                            <textarea name="nota_descriptiva" class="form-control bg-light border-0" rows="3" placeholder="Detalle lo sucedido...">{{ old('nota_descriptiva') }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4">
                        <button type="button" class="btn btn-light px-4 fw-bold" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-registrar">Guardar Reporte</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#incidentesTable').DataTable({
                responsive: true,
                autoWidth: false,
                language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
                order: [[0, 'desc']]
            });

            function updateTimers() {
                $('.timer-label').each(function() {
                    let label = $(this);
                    let id = label.data('id');
                    let expireTime = new Date(label.data('expire')).getTime();
                    let now = new Date().getTime();
                    let diff = expireTime - now;

                    if (diff <= 0) {
                        $(`#status-container-${id}`).html('<span class="badge-estado badge-Resuelto">Resuelto</span>');
                        $(`#action-container-${id}`).html('<span class="text-success fw-bold small"><i class="bi bi-check-all"></i> Finalizado</span>');
                        label.removeClass('timer-label');
                    } else {
                        let totalSecs = Math.floor(diff / 1000);
                        let mins = Math.floor(totalSecs / 60);
                        let secs = totalSecs % 60;
                        label.html(`<i class="bi bi-clock me-1"></i> ${mins}m ${secs < 10 ? '0' : ''}${secs}s`);
                    }
                });
            }

            setInterval(updateTimers, 1000);
            updateTimers();

            @if($errors->any())
            var myModal = new bootstrap.Modal(document.getElementById('modalIncidente'));
            myModal.show();
            @endif
        });
    </script>
@endsection
