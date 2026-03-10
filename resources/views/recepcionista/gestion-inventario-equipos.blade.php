@extends('layouts.plantillaRecepcion')
@section('contenido')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <style>
        .main-container { max-width: 1400px; margin: 0 auto; padding: 100px 15px 20px; }
        h1 { color: #0f766e; font-weight: 700; font-size: 2.2rem; margin-bottom: 0; }
        .table-container-card { background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); padding: 25px; }

        /* Encabezados de Tabla Centrados y en Color Turquesa */
        table.dataTable thead th {
            background: #4ecdc4 !important;
            color: white !important;
            padding: 15px;
            text-transform: uppercase;
            font-size: 13px;
            border: none;
            text-align: center !important;
        }

        /* Centrado de celdas del cuerpo */
        table.dataTable tbody td {
            vertical-align: middle !important;
            text-align: center !important;
            padding: 12px !important;
        }

        .badge-status {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
            min-width: 130px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Botón de Registro a la Derecha */
        .btn-nuevo-equipo {
            background-color: #4ecdc4;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-nuevo-equipo:hover { background-color: #3dbbb2; color: white; transform: scale(1.02); }

        /* Botones de Acción Uniformes */
        .btn-action-custom {
            color: white;
            border: none;
            padding: 7px 10px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 12px;
            width: 95px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
            transition: opacity 0.2s;
        }
        .btn-action-custom:hover { opacity: 0.9; color: white; }

        .bg-editar { background-color: #f39c12; }
        .bg-baja { background-color: #34495e; }
        .bg-eliminar { background-color: #e74c3c; }

        /* Alertas Personalizadas */
        .custom-alert-success {
            background-color: #e6f9f7;
            border: 1.5px solid #4ecdc4;
            border-radius: 12px;
            padding: 15px 25px;
            margin-bottom: 25px;
        }
        .icon-circle-check {
            background-color: white;
            border: 2px solid #4ecdc4;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    <div class="main-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-info-emphasis m-0">Inventario de Equipos de Movilidad</h1>
            <button class="btn-nuevo-equipo shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCrear">
                <i class="fas fa-plus me-2"></i> Registrar Equipo
            </button>
        </div>

        {{-- Alertas de Éxito --}}
        @if(session('success'))
            <div class="alert custom-alert-success d-flex align-items-center shadow-sm fade show" role="alert">
                <div class="icon-circle-check me-3">
                    <i class="fas fa-check" style="color: #4ecdc4;"></i>
                </div>
                <div class="flex-grow-1">
                    <strong class="d-block" style="color: #0f766e; font-size: 1.1rem;">¡Operación Exitosa!</strong>
                    <span style="color: #2d6a4f;">{{ session('success') }}</span>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        {{-- Alertas de Error --}}
        @if(session('error'))
            <div class="alert alert-danger d-flex align-items-center shadow-sm fade show mb-4" role="alert">
                <i class="fas fa-exclamation-circle me-3" style="font-size: 20px;"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        <div class="table-container-card">
            <table id="inventarioTable" class="table table-hover display nowrap" style="width:100%">
                <thead>
                <tr>
                    <th>Identificador</th>
                    <th>Nombre del Equipo</th>
                    <th>Estado</th>
                    <th>Cantidad</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($equipos as $equipo)
                    <tr>
                        <td class="fw-bold">{{ $equipo->identificador_unico }}</td>
                        <td>{{ $equipo->nombre_equipo }}</td>
                        <td>
                            @if($equipo->estado == 'Retirado')
                                <span class="badge-status bg-secondary text-white">
                                    <i class="fas fa-exclamation-triangle me-2"></i> Retirado
                                </span>
                            @else
                                <span class="badge-status {{ $equipo->estado == 'Disponible' ? 'bg-success' : 'bg-danger' }} text-white">
                                    {{ $equipo->estado }}
                                </span>
                            @endif
                        </td>
                        <td>
                            <span class="badge rounded-pill bg-light text-dark border px-3">
                                {{ $equipo->stock_actual }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                @if($equipo->estado != 'Retirado')
                                    <button class="btn-action-custom bg-editar" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $equipo->id }}">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                    <button class="btn-action-custom bg-baja" data-bs-toggle="modal" data-bs-target="#modalBaja{{ $equipo->id }}">
                                        <i class="fas fa-ban"></i> Baja
                                    </button>
                                    <button class="btn-action-custom bg-eliminar" data-bs-toggle="modal" data-bs-target="#modalEliminar{{ $equipo->id }}">
                                        <i class="fas fa-trash"></i> Borrar
                                    </button>
                                @else
                                    <span class="text-muted small">Sin acciones</span>
                                @endif
                            </div>
                        </td>
                    </tr>

                    {{-- MODAL BAJA (H108) --}}
                    <div class="modal fade" id="modalBaja{{ $equipo->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content shadow">
                                <div class="modal-body text-center p-4">
                                    <i class="fas fa-exclamation-circle fa-3x mb-3 text-secondary"></i>
                                    <h4 class="mb-3">¿Confirmar Baja?</h4>
                                    <p>¿Está seguro de retirar el equipo: <strong>{{ $equipo->nombre_equipo }}</strong>? Esta acción lo marcará como inactivo permanentemente.</p>
                                    <form action="{{ route('inventario.baja', $equipo->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <div class="d-flex justify-content-center gap-2 mt-4">
                                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn-action-custom bg-baja w-auto px-4 rounded-pill">Confirmar Retiro</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- MODAL EDITAR --}}
                    <div class="modal fade" id="modalEditar{{ $equipo->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content shadow">
                                <form action="{{ route('inventario.actualizar', $equipo->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-header border-0 pb-0">
                                        <h5 class="modal-title fw-bold" style="color: #0f766e;">Modificar Datos</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>
                                    <div class="modal-body py-4 text-start">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold small text-uppercase">Nombre del Equipo</label>
                                            <input type="text" name="nombre_equipo" class="form-control" value="{{ $equipo->nombre_equipo }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold small text-uppercase">Estado Actual</label>
                                            <select name="estado" class="form-select">
                                                <option value="Disponible" {{ $equipo->estado == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                                                <option value="No Disponible" {{ $equipo->estado == 'No Disponible' ? 'selected' : '' }}>No Disponible</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold small text-uppercase">Cantidad en Stock</label>
                                            <input type="number" name="stock_actual" class="form-control" value="{{ $equipo->stock_actual }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 pt-0">
                                        <button type="submit" class="btn-nuevo-equipo w-100">Actualizar Registro</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- MODAL ELIMINAR --}}
                    <div class="modal fade" id="modalEliminar{{ $equipo->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-sm">
                            <div class="modal-content">
                                <div class="modal-body text-center p-4">
                                    <i class="fas fa-trash-alt fa-3x mb-3 text-danger"></i>
                                    <h5 class="fw-bold">¿Eliminar registro?</h5>
                                    <p class="small text-muted">Esta acción no se puede deshacer.</p>
                                    <form action="{{ route('inventario.eliminar', $equipo->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <div class="d-flex justify-content-center gap-2 mt-4">
                                            <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">No</button>
                                            <button type="submit" class="btn-action-custom bg-eliminar">Sí, Borrar</button>
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

    {{-- MODAL CREAR --}}
    <div class="modal fade" id="modalCrear" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow">
                <form action="{{ route('inventario.guardar') }}" method="POST">
                    @csrf
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold" style="color: #0f766e;">Nuevo Registro de Equipo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body py-4 text-start">
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">Identificador Interno (ID)</label>
                            <input type="text" name="identificador_unico" class="form-control" placeholder="Ej: EQ-101" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">Nombre del Equipo</label>
                            <input type="text" name="nombre_equipo" class="form-control" placeholder="Ej: Silla de Ruedas Eléctrica" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">Cantidad Inicial</label>
                            <input type="number" name="stock_actual" class="form-control" value="1" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="submit" class="btn-nuevo-equipo w-100">Guardar Equipo</button>
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
            $('#inventarioTable').DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay datos disponibles en la tabla",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                    "infoFiltered": "(Filtrado de _MAX_ registros totales)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "No se encontraron resultados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                columnDefs: [
                    { className: "dt-center", "targets": "_all" }
                ],
                responsive: true
            });
        });
    </script>
@endsection
