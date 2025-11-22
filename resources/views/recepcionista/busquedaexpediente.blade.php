@extends('layouts.plantillaRecepcion')
@section('contenido')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:whitesmoke;


        }
         .form-control {
            color: #555;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;


        }
         #opcion{

             color: #555;
         }

         .form-select{
             color: #555;
             border: 2px solid #e0e0e0;
             border-radius: 8px;
             font-size: 1rem;
             transition: all 0.3s ease;
         }
        .form-select:focus {
            border-color: #4ecdc4;
            box-shadow: 0 0 0 0.25rem rgba(78, 205, 196, 0.25);
        }

        .form-control:focus {
            border-color: #4ecdc4;
            box-shadow: 0 0 0 0.25rem rgba(78, 205, 196, 0.25);
        }
        .btn-buscar {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.3);
            padding: 0.5rem 1.5rem; /* Ajusta el padding */
            height: 38px; /* Altura igual al input/select */
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
        }

        .btn-buscar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
        }

        .btn-ver-expediente,
        .btn-crear-expediente {
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1); /* Transición suave */
            font-size: 13px;
            font-weight: 500;
            text-align: center;
            width: 140px;
            height: 40px;
            line-height: 20px;
            cursor: pointer;
            white-space: nowrap;
        }

        .btn-ver-expediente {
            background: linear-gradient(135deg, #4ecdc4 0%, #44b8af 100%); /* Gradiente sutil */
            color: white;
            border: none;
        }

        .btn-ver-expediente:hover {
            background: linear-gradient(135deg, #44b8af 0%, #3aa39a 100%);
            box-shadow: 0 3px 10px rgba(78, 205, 196, 0.25);
        }

        .btn-crear-expediente {
            background-color: transparent;
            color: #4ecdc4;
            border: 2px solid #4ecdc4;
        }

        .btn-crear-expediente:hover {
            background-color: rgba(78, 205, 196, 0.08);
            border-color: #3db8af;
        }
        .alerta-resultados {
            background-color: #d1f2ef; /* Turquesa muy claro */
            color: #2c7a7b; /* Texto oscuro turquesa */
            border-left: 4px solid #4ecdc4; /* Borde izquierdo para énfasis */
            padding: 12px 20px;
            margin-top: 20px;
            margin-bottom: 30px;
            border-radius: 6px;
        }
        /* Contenedor de la tabla */
        .table-container {
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 25px;
            margin-bottom: 30px;
        }

        /* DataTables Styling */
        table.dataTable {
            width: 100% !important;
            border-collapse: collapse;
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
            vertical-align: middle;
        }

        /* DataTables Controls */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 20px;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 8px 15px;
            margin-left: 10px;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            outline: none;
            border-color: #4ecdc4;
        }

        .dataTables_wrapper .dataTables_length select {
            border: 2px solid #e0e0e0;
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
        }

        .text-info-emphasis {

            font-weight: bold;
        }

        /* Botón + Nuevo Expediente */
        .btn-light {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-light:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 205, 196, 0.3);
            color: white;
        }

        @media (max-width: 1200px) {
            .table-container {
                padding: 15px;
            }

            table.dataTable thead th,
            table.dataTable tbody td {
                padding: 15px 10px;
            }
        }


    </style>
    <div class="container mt-5 pt-5">
        @if (session('success'))
            <div id="mensaje-exito" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <script>
            setTimeout(function() {
                let mensaje = document.getElementById('mensaje-exito');
                if (mensaje) {
                    mensaje.style.transition = "opacity 0.5s";
                    mensaje.style.opacity = "0";

                    setTimeout(() => mensaje.remove(), 500);
                }
            }, 10000);
        </script>
            <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-info-emphasis">Búsqueda de Expedientes</h2>
            <a href="{{ route('expedientes.crear') }}" class="btn btn-light btn-sm">
                + Nuevo Expediente
            </a>
            </div>

        <br>



         {{-- Mostrar tabla con resultados --}}

            <div class="table-container">
                <table id="expedientesTable" class="table table-hover">
                    <thead>
                    <tr>
                        <th>N° Expediente</th>
                        <th>Nombre Completo</th>
                        <th>Teléfono</th>
                        <th>Fecha Creación</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="table-group-divider">
                    @foreach($expedientes as $paciente)
                        <tr>
                            <td >{{ $paciente->expediente->numero_expediente  ?? 'Sin expediente' }}</td>
                            <td>{{ $paciente->nombres}} {{ $paciente->apellidos }}</td>
                            <td>{{$paciente->telefono}}</td>
                            <td>
                                @if($paciente->expediente && $paciente->expediente->created_at)
                                {{ $paciente->expediente->created_at->format('d/m/Y') }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                @if($paciente->expediente)
                                <a  class="btn-ver-expediente btn-sm"
                                   href="{{route('expedientes.visualizar', $paciente->expediente->id)}}">
                                    <i class=""></i> Ver Expediente
                                </a>
                                @else
                                    <a class="btn-crear-expediente btn-sm"
                                       href="{{ route('expedientes.crear.paciente', ['paciente_id' => $paciente->id]) }}">
                                        <i ></i>Crear Expediente
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    </div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#expedientesTable').DataTable({
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
                    emptyTable: "No hay expedientes disponibles",
                    paginate: {
                        first: "Primero",
                        previous: "Anterior",
                        next: "Siguiente",
                        last: "Último"
                    }
                },
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                order: [[0, 'desc']], // Ordenar por N° Expediente descendente
                columnDefs: [
                    {
                        targets: 4, // Columna de Acciones
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>

@endsection
