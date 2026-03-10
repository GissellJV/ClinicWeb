@extends('layouts.plantillaEnfermeria')
@section('contenido')

    <link rel="stylesheet" href="{{ asset('css/formulario.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: whitesmoke;
            min-height: 100vh;
        }

        .administracion .btn {
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .administracion .btn-primary {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            color: white;
        }

        .administracion .btn-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(78, 205, 196, 0.3);
        }

        .stock-alerts {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .alert-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border-left: 5px solid;
            transition: all 0.3s;
        }

        .alert-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        }

        .alert-card.critical {
            border-left-color: #d9534f;
            background: linear-gradient(135deg, #fff 0%, #fdeeee 100%);
        }

        .alert-card.warning {
            border-left-color: #f0ad4e;
            background: linear-gradient(135deg, #fff 0%, #fff8e8 100%);
        }

        .alert-card.success {
            border-left-color: #44a08d;
            background: linear-gradient(135deg, #fff 0%, #ebf8f5 100%);
        }

        .alert-number {
            font-size: 32px;
            font-weight: 700;
        }

        .alert-card.critical .alert-number {
            color: #d9534f;
        }

        .alert-card.warning .alert-number {
            color: #f0ad4e;
        }

        .alert-card.success .alert-number {
            color: #2d8f7d;
        }

        .alert-label {
            font-size: 14px;
            color: #666;
            font-weight: 600;
        }

        .administracion .inventory-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            overflow: visible;
            padding: 25px;
        }

        .administracion .table-container {
            overflow-x: visible;
            width: 100%;
            margin: 0 auto;
        }

        table.dataTable {
            width: 100% !important;
            border-collapse: collapse;
            table-layout: auto;
            white-space: nowrap;
        }

        table.dataTable thead th {
            padding: 20px;
            text-align: left;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border-bottom: 2px solid #e0e0e0;
            color: white !important;
            background: #4ecdc4 !important;
            white-space: nowrap;
        }

        table.dataTable tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s;
        }

        table.dataTable tbody tr:hover {
            background: #f8f9fa;
        }

        table.dataTable tbody td {
            padding: 20px;
            color: #666;
            white-space: nowrap;
            vertical-align: middle;
        }

        table.dataTable tbody tr.limpieza-pendiente {
            background-color: #fff0f0 !important;
        }

        table.dataTable tbody tr.limpieza-en-proceso {
            background-color: #fff8eb !important;
        }

        table.dataTable tbody tr.limpieza-pendiente:hover {
            background-color: #ffe2e2 !important;
        }

        table.dataTable tbody tr.limpieza-en-proceso:hover {
            background-color: #fff1cf !important;
        }

        .habitacion-numero {
            font-weight: 600;
            color: #2f3a3a;
            font-size: 16px;
            white-space: nowrap;
        }

        .badge-tipo {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
        }

        .tipo-individual {
            background: #ddf7f1;
            color: #1f7a6d;
        }

        .tipo-doble {
            background: #fff4d6;
            color: #946200;
        }

        .tipo-uci {
            background: #eef5f4;
            color: #506463;
        }

        .tipo-emergencia {
            background: #fde7e9;
            color: #a33a45;
        }

        .badge-estado-habitacion,
        .badge-limpieza {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
        }

        .estado-disponible {
            background: #ddf7f1;
            color: #1f7a6d;
        }

        .estado-ocupada {
            background: #fde7e9;
            color: #a33a45;
        }

        .estado-mantenimiento {
            background: #eef5f4;
            color: #506463;
        }

        .limpieza-limpia {
            background: #ddf7f1;
            color: #1f7a6d;
        }

        .limpieza-pendiente-badge {
            background: #fde7e9;
            color: #a33a45;
        }

        .limpieza-en_limpieza {
            background: #fff4d6;
            color: #946200;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: nowrap;
            align-items: center;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 14px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            white-space: nowrap;
        }

        .btn-edit {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            color: white;
        }

        .btn-edit:hover {
            background: linear-gradient(135deg, #45bfb5 0%, #3c8f7f 100%);
            transform: translateY(-2px);
        }

        .form-select {
            border: 2px solid #d9e7e5;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 14px;
            min-width: 170px;
            color: #4b5c5a;
            background-color: #fff;
        }

        .form-select:focus {
            outline: none;
            border-color: #4ecdc4;
            box-shadow: 0 0 0 0.2rem rgba(78, 205, 196, 0.2);
        }

        .text-info-emphasis {
            font-weight: bold;
            color: #2d8f7d;
        }

        .text-fecha {
            color: #666;
            font-size: 14px;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 20px;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 2px solid #d9e7e5;
            border-radius: 8px;
            padding: 8px 15px;
            margin-left: 10px;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            outline: none;
            border-color: #4ecdc4;
        }

        .dataTables_wrapper .dataTables_length select {
            border: 2px solid #d9e7e5;
            border-radius: 8px;
            padding: 5px 10px;
            margin: 0 10px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 8px 12px !important;
            border-radius: 8px !important;
            transition: all 0.3s !important;
            box-shadow: none !important;
            font-weight: 600 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            color: white !important;
            box-shadow: none !important;
            transform: translateY(-2px);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%) !important;
            color: white !important;
            border-color: #4ecdc4 !important;
        }

        .dataTables_wrapper .dataTables_info {
            font-size: 14px;
            padding-top: 15px;
            color: #60706f;
        }

        @media (max-width: 1200px) {
            .administracion .inventory-card {
                padding: 15px;
            }

            table.dataTable thead th,
            table.dataTable tbody td {
                padding: 15px 10px;
            }

            .stock-alerts {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="administracion">
        <br>
        <div class="container mt-5 pt-5">

            @if(session('success'))
                <div class="alert alert-dismissible fade show" role="alert" style="
                    border-radius: 8px;
                    border: none;
                    border-left: 4px solid #4ecdc4;
                    background: #e8f8f5;
                    color: #2d8f7d;
                    padding: 15px 20px;
                    display: flex;
                    align-items: center;
                    gap: 15px;
                    margin-bottom: 25px;
                ">
                    <div style="flex: 1;">
                        <p style="margin: 5px 0 0 0; font-size: 17px;">{{ session('success') }}</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($habitaciones->isEmpty())
                <div class="alert alert-dismissible fade show" role="alert" style="
                    border-radius: 8px;
                    border: none;
                    border-left: 4px solid #f0ad4e;
                    background: #fff8e8;
                    color: #946200;
                    padding: 15px 20px;
                    margin-bottom: 25px;
                ">
                    No hay habitaciones registradas.
                </div>
            @endif

            <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                <h2 class="text-info-emphasis" style="margin: 0;">Estado de limpieza de habitaciones</h2>
            </div>

            @php
                $limpias = $habitaciones->where('estado_limpieza', 'limpia')->count();
                $pendientes = $habitaciones->where('estado_limpieza', 'pendiente')->count();
                $enLimpieza = $habitaciones->where('estado_limpieza', 'en_limpieza')->count();
            @endphp

            <div class="stock-alerts">
                <div class="alert-card success">
                    <div>
                        <div class="alert-number">{{ $limpias }}</div>
                        <div class="alert-label">Habitaciones limpias</div>
                    </div>
                    <small style="color: #666;">Listas para recibir pacientes</small>
                </div>

                <div class="alert-card critical">
                    <div>
                        <div class="alert-number">{{ $pendientes }}</div>
                        <div class="alert-label">Pendientes de limpieza</div>
                    </div>
                    <small style="color: #666;">Requieren atención inmediata</small>
                </div>

                <div class="alert-card warning">
                    <div>
                        <div class="alert-number">{{ $enLimpieza }}</div>
                        <div class="alert-label">En limpieza</div>
                    </div>
                    <small style="color: #666;">Proceso en curso</small>
                </div>
            </div>

            <div class="inventory-card">
                <div class="table-container">
                    <table id="tablaLimpieza" class="table table-hover">
                        <thead>
                        <tr>
                            <th>Número</th>
                            <th>Tipo</th>
                            <th>Estado habitación</th>
                            <th>Estado limpieza</th>
                            <th>Última actualización</th>
                            <th>Descripción</th>
                            <th>Actualizar estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($habitaciones as $habitacion)
                            @php
                                $filaClass = '';

                                if ($habitacion->estado_limpieza === 'pendiente') {
                                    $filaClass = 'limpieza-pendiente';
                                } elseif ($habitacion->estado_limpieza === 'en_limpieza') {
                                    $filaClass = 'limpieza-en-proceso';
                                }
                            @endphp

                            <tr class="{{ $filaClass }}">
                                <td class="habitacion-numero">{{ $habitacion->numero_habitacion }}</td>

                                <td>
                                    <span class="badge-tipo tipo-{{ strtolower($habitacion->tipo) }}">
                                        {{ ucfirst($habitacion->tipo) }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge-estado-habitacion estado-{{ strtolower($habitacion->estado) }}">
                                        {{ ucfirst($habitacion->estado) }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge-limpieza
                                        @if($habitacion->estado_limpieza === 'limpia')
                                            limpieza-limpia
                                        @elseif($habitacion->estado_limpieza === 'pendiente')
                                            limpieza-pendiente-badge
                                        @else
                                            limpieza-en_limpieza
                                        @endif
                                    ">
                                        @if($habitacion->estado_limpieza === 'limpia')
                                            Limpia
                                        @elseif($habitacion->estado_limpieza === 'pendiente')
                                            Pendiente de limpieza
                                        @else
                                            En limpieza
                                        @endif
                                    </span>
                                </td>

                                <td class="text-fecha">
                                    @if($habitacion->fecha_limpieza)
                                        {{ $habitacion->fecha_limpieza->format('d/m/Y H:i') }}
                                    @else
                                        Sin registro
                                    @endif
                                </td>

                                <td>{{ $habitacion->descripcion ?: 'Sin descripción' }}</td>

                                <td>
                                    <form action="{{ route('enfermeria.habitaciones.actualizarLimpieza', $habitacion->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="action-buttons">
                                            <select name="estado_limpieza" class="form-select" required>
                                                <option value="limpia" {{ $habitacion->estado_limpieza === 'limpia' ? 'selected' : '' }}>Limpia</option>
                                                <option value="pendiente" {{ $habitacion->estado_limpieza === 'pendiente' ? 'selected' : '' }}>Pendiente de limpieza</option>
                                                <option value="en_limpieza" {{ $habitacion->estado_limpieza === 'en_limpieza' ? 'selected' : '' }}>En limpieza</option>
                                            </select>

                                            <button type="submit" class="btn-sm btn-edit">
                                                Guardar
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tablaLimpieza').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    processing: "Procesando...",
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ registros",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty: "Mostrando 0 a 0 de 0 registros",
                    infoFiltered: "(filtrado de _MAX_ registros totales)",
                    loadingRecords: "Cargando...",
                    zeroRecords: "No se encontraron registros",
                    emptyTable: "No hay habitaciones disponibles",
                    paginate: {
                        first: "Primero",
                        previous: "Anterior",
                        next: "Siguiente",
                        last: "Último"
                    }
                },
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                order: [[0, 'asc']],
                columnDefs: [
                    {
                        targets: 6,
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>

@endsection
