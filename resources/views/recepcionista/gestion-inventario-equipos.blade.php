@extends('layouts.plantillaRecepcion')
@section('contenido')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <style>
        .main-container { max-width: 1400px; margin: 0 auto; padding: 100px 15px 20px; }
        h1 { color: #0f766e; font-weight: 700; font-size: 2.2rem; margin-bottom: 30px; }
        .table-container-card { background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); padding: 25px; }

        /* Encabezado ClinicWeb Centrado */
        table.dataTable thead th {
            background: #4ecdc4 !important;
            color: white;
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
        }

        .badge-status { padding: 8px 16px; border-radius: 20px; font-weight: 600; font-size: 13px; min-width: 120px; display: inline-flex; justify-content: center; }

        /* --- BOTONES UNIFORMES --- */
        .btn-nuevo-equipo {
            background-color: #4ecdc4;
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 15px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }
        .btn-nuevo-equipo:hover { background-color: #3dbbb2; color: white; transform: scale(1.02); }

        .btn-action-custom {
            color: white;
            border: none;
            padding: 8px 25px;
            border-radius: 10px;
            font-weight: 600;
            min-width: 100px;
            transition: opacity 0.2s;
        }
        .btn-action-custom:hover { opacity: 0.9; color: white; }

        .bg-editar { background-color: #f39c12; }
        .bg-eliminar { background-color: #e74c3c; }

        /* Estilos para inputs de modales */
        .modal-content { border-radius: 20px; border: none; }
        .form-control, .form-select { border-radius: 10px; padding: 10px; border: 1px solid #e0e0e0; }

        /* Estilo personalizado para la Alerta (Captura de pantalla) */
        .custom-alert-success {
            background-color: #e6f9f7;
            border: 1.5px solid #4ecdc4;
            border-radius: 12px;
            padding: 15px 25px;
        }
        .icon-circle-check {
            background-color: white;
            border: 2px solid #4ecdc4;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            min-width: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
    </style>

    <div class="main-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-info-emphasis m-0">Gestión de Inventario de Equipos</h1>
            <button class="btn-nuevo-equipo shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCrear">+ Nuevo Equipo</button>
        </div>

        {{-- Alertas de Éxito Estilo Captura --}}
        @if(session('success'))
            <div class="alert custom-alert-success d-flex align-items-center shadow-sm fade show mb-4" role="alert">
                <div class="icon-circle-check me-3">
                    <i class="fas fa-check" style="color: #4ecdc4; font-size: 20px;"></i>
                </div>
                <div class="flex-grow-1">
                    <strong class="d-block" style="color: #0f766e; font-size: 1.1rem; margin-bottom: 2px;">
                        ¡Operación Exitosa!
                    </strong>
                    <span style="color: #2d6a4f; font-size: 1rem; font-weight: 500;">
                        {{ session('success') }}
                    </span>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-container-card">
            <table id="inventarioTable" class="table table-hover display nowrap" style="width:100%">
                <thead>
                <tr>
                    <th>IDENTIFICADOR</th>
                    <th>EQUIPO</th>
                    <th>ESTADO</th>
                    <th>STOCK</th>
                    <th>ACCIONES</th>
                </tr>
                </thead>
                <tbody>
                @foreach($equipos as $equipo)
                    <tr>
                        <td>{{ $equipo->identificador_unico }}</td>
                        <td>{{ $equipo->nombre_equipo }}</td>
                        <td>
                            <span class="badge-status {{ $equipo->estado == 'Disponible' ? 'bg-success' : 'bg-danger' }}" style="color:white">
                                {{ $equipo->estado }}
                            </span>
                        </td>
                        <td>{{ $equipo->stock_actual }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn-action-custom bg-editar" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $equipo->id }}">Editar</button>
                                <button class="btn-action-custom bg-eliminar" data-bs-toggle="modal" data-bs-target="#modalEliminar{{ $equipo->id }}">Eliminar</button>
                            </div>
                        </td>
                    </tr>

                    {{-- MODAL EDITAR --}}
                    <div class="modal fade" id="modalEditar{{ $equipo->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content shadow">
                                <form action="{{ route('inventario.actualizar', $equipo->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" style="color: #0f766e;">Modificar Equipo</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Nombre del Equipo</label>
                                            <input type="text" name="nombre_equipo" class="form-control" value="{{ $equipo->nombre_equipo }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Estado</label>
                                            <select name="estado" class="form-select">
                                                <option value="Disponible" {{ $equipo->estado == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                                                <option value="No Disponible" {{ $equipo->estado == 'No Disponible' ? 'selected' : '' }}>No Disponible</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Stock Actual</label>
                                            <input type="number" name="stock_actual" class="form-control" value="{{ $equipo->stock_actual }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="submit" class="btn-action-custom bg-editar w-100">Actualizar Datos</button>
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
                                    <h4 class="mb-3" style="color: #e74c3c;">¿Eliminar?</h4>
                                    <p>¿Estás seguro de eliminar el equipo <strong>{{ $equipo->nombre_equipo }}</strong>?</p>
                                    <form action="{{ route('inventario.eliminar', $equipo->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <div class="d-flex justify-content-center gap-2 mt-4">
                                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">No</button>
                                            <button type="submit" class="btn-action-custom bg-eliminar">Sí, Eliminar</button>
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
                    <div class="modal-header">
                        <h5 class="modal-title" style="color: #0f766e;">Registrar Nuevo Equipo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Identificador (ID)</label>
                            <input type="text" name="identificador_unico" class="form-control" placeholder="Ej: EQ-100" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nombre del Equipo</label>
                            <input type="text" name="nombre_equipo" class="form-control" placeholder="Nombre descriptivo" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Stock Inicial</label>
                            <input type="number" name="stock_actual" class="form-control" value="1" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
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
                language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
                columnDefs: [
                    { className: "dt-center", "targets": "_all" }
                ]
            });
        });
    </script>
@endsection
