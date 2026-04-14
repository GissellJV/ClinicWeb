@php
    /* --- SELECCIÓN DINÁMICA DE PLANTILLA SEGÚN ROL --- */
    if (session('tipo_usuario') === 'empleado') {
        switch (session('cargo')) {
            case 'Recepcionista':
                $layout = 'layouts.plantillaRecepcion';
                break;
            case 'Administrador':
                $layout = 'layouts.plantillaAdmin';
                break;
            default:
                $layout = 'layouts.plantilla';
        }
    } else {
        $layout = 'layouts.plantilla';
    }
@endphp

{{-- Extiende el layout definido en el bloque PHP superior --}}
@extends($layout)

@section('contenido')
    {{-- Estilos específicos para DataTables con Bootstrap 5 --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <style>
        /* --- ESTILOS DE INTERFAZ Y CONTENEDORES --- */
        .main-container { max-width: 1400px; margin: 0 auto; padding: 100px 15px 20px; }
        h1 { color: #0f766e; font-weight: 700; font-size: 2.2rem; margin-bottom: 0; }
        .table-container-card { background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); padding: 25px; }

        /* --- ESTILOS PERSONALIZADOS DE LA TABLA --- */
        table.dataTable thead th {
            background: #4ecdc4 !important;
            color: white !important;
            padding: 15px;
            text-transform: uppercase;
            font-size: 13px;
            border: none;
            text-align: center !important;
        }

        table.dataTable tbody td {
            vertical-align: middle !important;
            text-align: center !important;
            padding: 12px !important;
        }

        /* --- BADGES Y BOTONES DE ACCIÓN --- */
        .badge-status {
            padding: 8px 16px; border-radius: 20px; font-weight: 600; font-size: 12px;
            min-width: 130px; display: inline-flex; align-items: center; justify-content: center;
        }

        .btn-nuevo-equipo {
            background-color: #4ecdc4; color: white; border: none; padding: 10px 25px;
            border-radius: 12px; font-weight: 600; transition: all 0.3s ease;
        }

        .btn-action-custom {
            color: white; border: none; padding: 7px 10px; border-radius: 8px;
            font-weight: 600; font-size: 12px; width: 95px; display: inline-flex;
            justify-content: center; align-items: center; cursor: pointer;
        }

        /* Colores por tipo de acción */
        .bg-editar { background-color: #f39c12; }
        .bg-baja { background-color: #34495e; }
        .bg-eliminar { background-color: #e74c3c; }

        /* --- DISEÑO DE MODALES (ESTILO SELECTOR) --- */
        .modal-selector .modal-content.selector-content {
            background: #fff; border: 3px solid #24f3e2; box-shadow: 0 0 20px rgba(36, 243, 226, 0.4);
            border-radius: 18px; overflow: hidden; animation: popSelector 0.25s ease-out;
        }

        /* Animación de entrada para los modales */
        @keyframes popSelector {
            0% { transform: scale(.7); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        .modal-selector .selector-header { background: linear-gradient(90deg, #00e1ff, #00ffc8); padding: 15px 20px; }
        .modal-selector .modal-title { color: #fff; font-size: 24px; font-weight: 800; }
        .modal-selector .selector-body { padding: 24px; background: #fff; color: #333; }
        .modal-selector .selector-footer { border-top: 1px solid #e5e5e5; padding: 18px 24px; background: #fff; }

        /* --- ALINEACIÓN 50/50 PARA BOTONES EN MODALES --- */
        .button-group-50 {
            display: flex;
            width: 100%;
            gap: 15px;
            justify-content: center;
        }

        .btn-modal-action {
            background: linear-gradient(135deg, #4ecdc4 0%, #44b8af 100%);
            color: white !important; border: none; padding: 12px; border-radius: 8px;
            font-weight: 600; flex: 1; text-align: center; text-decoration: none; transition: all 0.3s ease;
        }

        .btn-cancel {
            background: white !important; border: 2px solid #dc3545 !important; color: #dc3545 !important;
            padding: 12px; border-radius: 8px; font-weight: 600; flex: 1; transition: all 0.3s ease;
        }

        .btn-cancel:hover { background: #dc3545 !important; color: white !important; }

        /* Inputs personalizados con borde turquesa */
        .form-control-custom {
            border: 2px solid #24f3e2; border-radius: 12px; padding: 12px; background: rgba(36, 243, 226, 0.05);
        }
    </style>

    <div class="main-container">
        {{-- Encabezado con título y botón para disparar modal de creación --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-info-emphasis m-0">Inventario de Equipos de Movilidad</h1>
            <button class="btn-nuevo-equipo shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCrear">
                Registrar Equipo
            </button>
        </div>

        {{-- Mensaje de éxito tras acciones en el servidor --}}
        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center shadow-sm fade show mb-4" role="alert">
                <strong>¡Operación Exitosa!</strong> &nbsp; {{ session('success') }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Contenedor de la tabla de inventario --}}
        <div class="table-container-card">
            <table id="inventarioTable" class="table table-hover display nowrap" style="width:100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Identificador</th>
                    <th>Nombre del Equipo</th>
                    <th>Estado</th>
                    <th>Cantidad</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($equipos as $index => $equipo)
                    <tr>
                        <td class="text-muted fw-bold">{{ $index + 1 }}</td>
                        <td class="fw-bold">{{ $equipo->identificador_unico }}</td>
                        <td>{{ $equipo->nombre_equipo }}</td>
                        <td>
                            {{-- Badge de estado dinámico --}}
                            <span class="badge-status {{ $equipo->estado == 'Disponible' ? 'bg-success' : ($equipo->estado == 'Retirado' ? 'bg-secondary' : 'bg-danger') }} text-white">
                                {{ $equipo->estado }}
                            </span>
                        </td>
                        <td><span class="fw-bold">{{ $equipo->stock_actual }}</span></td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                {{-- Solo mostrar acciones si el equipo no ha sido retirado --}}
                                @if($equipo->estado != 'Retirado')
                                    <button class="btn-action-custom bg-editar" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $equipo->id }}">Editar</button>
                                    <button class="btn-action-custom bg-baja" data-bs-toggle="modal" data-bs-target="#modalBaja{{ $equipo->id }}">Baja</button>
                                    <button class="btn-action-custom bg-eliminar" data-bs-toggle="modal" data-bs-target="#modalEliminar{{ $equipo->id }}">Borrar</button>
                                @else
                                    <span class="text-muted small">Sin acciones</span>
                                @endif
                            </div>
                        </td>
                    </tr>

                    {{-- --- MODAL PARA EDITAR EQUIPO --- --}}
                    <div class="modal fade modal-selector" id="modalEditar{{ $equipo->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content selector-content">
                                <div class="selector-header">
                                    <h5 class="modal-title">Actualizar Equipo</h5>
                                </div>
                                <form action="{{ route('inventario.actualizar', $equipo->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="selector-body text-start">
                                        <div class="mb-3">
                                            <label class="fw-bold mb-2 small text-uppercase">Nombre del Equipo</label>
                                            <input type="text" name="nombre_equipo" class="form-control form-control-custom" value="{{ $equipo->nombre_equipo }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold mb-2 small text-uppercase">Cantidad en Stock</label>
                                            <input type="number" name="stock_actual" class="form-control form-control-custom" value="{{ $equipo->stock_actual }}" required>
                                        </div>
                                    </div>
                                    <div class="selector-footer">
                                        <div class="button-group-50">
                                            <button type="submit" class="btn-modal-action">Actualizar</button>
                                            <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancelar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- --- MODAL PARA DAR DE BAJA (RETIRO) --- --}}
                    <div class="modal fade modal-selector" id="modalBaja{{ $equipo->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content selector-content">
                                <div class="selector-header">
                                    <h5 class="modal-title text-center w-100">Confirmar Retiro</h5>
                                </div>
                                <div class="selector-body text-center">
                                    <p>¿Está seguro de marcar como <strong>RETIRADO</strong> el equipo: <br><strong>{{ $equipo->nombre_equipo }}</strong>?</p>
                                </div>
                                <div class="selector-footer">
                                    <form action="{{ route('inventario.baja', $equipo->id) }}" method="POST" class="w-100">
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

                    {{-- --- MODAL PARA ELIMINAR REGISTRO --- --}}
                    <div class="modal fade modal-selector" id="modalEliminar{{ $equipo->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content selector-content">
                                <div class="selector-header">
                                    <h5 class="modal-title text-center w-100">¿Eliminar Registro?</h5>
                                </div>
                                <div class="selector-body text-center">
                                    <p>Esta acción borrará permanentemente a:<br><strong>{{ $equipo->nombre_equipo }}</strong></p>
                                </div>
                                <div class="selector-footer">
                                    <form action="{{ route('inventario.eliminar', $equipo->id) }}" method="POST" class="w-100">
                                        @csrf @method('DELETE')
                                        <div class="button-group-50">
                                            <button type="submit" class="btn-modal-action" style="background: #e74c3c;">Eliminar</button>
                                            <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancelar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- --- MODAL PARA CREAR NUEVO REGISTRO --- --}}
    <div class="modal fade modal-selector" id="modalCrear" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content selector-content">
                <div class="selector-header">
                    <h5 class="modal-title">Registrar Nuevo Equipo</h5>
                </div>
                <form action="{{ route('inventario.guardar') }}" method="POST">
                    @csrf
                    <div class="selector-body text-start">
                        <div class="mb-3">
                            <label class="fw-bold mb-2 small text-uppercase">Identificador ID</label>
                            <input type="text" name="identificador_unico" class="form-control form-control-custom" placeholder="Ej: EQ-101" required>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold mb-2 small text-uppercase">Nombre del Equipo</label>
                            <input type="text" name="nombre_equipo" class="form-control form-control-custom" placeholder="Nombre del equipo" required>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold mb-2 small text-uppercase">Cantidad Inicial</label>
                            <input type="number" name="stock_actual" class="form-control form-control-custom" value="1" required>
                        </div>
                    </div>
                    <div class="selector-footer">
                        <div class="button-group-50">
                            <button type="submit" class="btn-modal-action">Guardar Equipo</button>
                            <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- --- IMPORTACIÓN DE SCRIPTS --- --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            /* Inicialización de DataTables con idioma español y centrado de columnas */
            $('#inventarioTable').DataTable({
                language: { url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json" },
                columnDefs: [{ className: "dt-center", "targets": "_all" }],
                responsive: true
            });
        });
    </script>
@endsection
