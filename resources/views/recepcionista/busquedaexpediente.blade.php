@extends('layouts.plantillaRecepcion')
@section('contenido')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:whitesmoke;
            display: flex;

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
        .table-responsive {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 0;
            margin-bottom: 30px;
        }

        /* Tabla base */
        .table {
            margin-bottom: 0;
        }

        /* Encabezado de la tabla - MÁS OSCURO */
        .table thead.table-light {
            background-color: #2C5F7C !important;
            border-bottom: none;
        }

        .table thead.table-light th {
            color: #224b63 !important;
            font-weight: 600;
            font-size: 14px;
            padding: 16px 20px; /* Más padding */
            border-bottom: none;
            vertical-align: middle;
            text-transform: uppercase; /* Mayúsculas para los encabezados */
            letter-spacing: 0.5px;

        }

        /* Filas del cuerpo */
        .table tbody tr {
            border-bottom: 1px solid #e5e7eb;
            transition: background-color 0.2s ease;
        }

        .table-hover tbody tr:hover {
            background-color: #f0fffe !important;
        }

        .table tbody td {
            padding: 16px 20px; /* Más padding */
            font-size: 14px;
            color: #374151;
            vertical-align: middle;
        }

        /* Última fila sin borde */
        .table tbody tr:last-child {
            border-bottom: none;
        }

        /* Columna de acciones centrada */
        .table tbody td:last-child,
        .table thead th:last-child {
            text-align: center;
        }
        .text-info-emphasis{
            font-weight: bold;
        }

    </style>
    <div class="container mt-5 pt-5">
        <h2 class="text-info-emphasis">Búsqueda de Expedientes
            <a href="{{ route('expedientes.crear') }}" class="btn btn-light btn-sm">
                + Nuevo Expediente
            </a></h2>

        <br>


        <div class="row justify-content-center mb-4">
            <div class="col-12 col-md-10 col-lg-8">
                <form method="get" action="{{ route('recepcionista.busquedaexpediente') }}">
                    <div class="row g-2">

                        <div class="col-12 col-md-6">
                            <input class="form-control" type="search" name="busqueda"
                                   value="{{ request('busqueda') }}"
                                   placeholder="Ingrese nombre, apellido o expediente"
                                   aria-label="Buscar">
                        </div>


                        <div class="col-6 col-md-3">
                            <select class="form-select" name="filtro" aria-label="filtro de búsqueda">
                                <option id="opcion" value="" selected>Filtrar por: </option>
                                <option id="opcion" value="todos" {{ request('filtro') == 'todos' ? 'selected' : '' }}> Todos </option>
                                <option id="opcion" value="nombre" {{ request('filtro') == 'nombre' ? 'selected' : '' }}> Nombre </option>
                                <option id="opcion" value="apellido" {{ request('filtro') == 'apellido' ? 'selected' : '' }}> Apellido </option>
                                <option id="opcion" value="numero_expediente" {{ request('filtro') == 'numero_expediente' ? 'selected' : '' }}> N° Expediente </option>
                            </select>
                        </div>


                        <div class="col-6 col-md-3">
                            <button class="btn-buscar" type="submit"> Buscar </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    @if(request('busqueda'))
           @if($expedientes->total() > 0)

                {{-- Mostrar alerta de resultados encontrados --}}
             <div class="row justify-content-center mb-3" style="margin-top: 140px;">
                <div class="col-12 col-md-10 col-lg-8">
                    <div class="alerta-resultados" role="alert">
                        Se encontraron <strong>{{ $expedientes->total() }}</strong> pacientes
                    </div>
                </div>
             </div>


         {{-- Mostrar tabla con resultados --}}

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                    <tr>
                        <th scope="col">N° Expediente</th>
                        <th scope="col">Nombre Completo</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Fecha Creación</th>
                        <th scope="col">Acciones</th>
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

                {{-- Paginación --}}
            <div class="d-flex justify-content-left">
                {{ $expedientes->links('pagination::bootstrap-5') }}
            </div>
           @else
            {{-- No se encontraron resultados --}}
             <div class="text-center py-5" style="margin-top: 100px;">
                <i class="bi bi-search" style="font-size: 4rem; color: #ccc;"></i>
                <h5 class="mt-3 text-muted">No se encontraron resultados para "<strong>{{ request('busqueda') }}</strong>"</h5>
                <p class="text-muted">Intente con otros términos de búsqueda</p>
             </div>
           @endif
    @else
            {{-- Mensaje inicial antes de buscar --}}
            <div class="text-center py-5" style="margin-top: 100px;">
                <i class="bi bi-search" style="font-size: 4rem; color: #ccc;"></i>
                <h5 class="mt-3 text-muted">Realice una búsqueda para ver los resultados</h5>

            </div>
    @endif

    </div>

@endsection
