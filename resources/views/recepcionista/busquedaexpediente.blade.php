@extends('layouts.plantillaRecepcion')
@section('contenido')
    <div class="container mt-5 pt-5">
        <h2 class="text-primary-emphasis">Búsqueda de Expedientes</h2>
        <br>


        <div class="row justify-content-center mb-4">
            <div class="col-12 col-md-10 col-lg-8">
                <form method="get" action="{{ route('recepcionista.busquedaexpediente') }}">
                    <div class="row g-2">

                        <div class="col-12 col-md-6">
                            <input class="form-control" type="search" name="busqueda"
                                   value="{{ request('busqueda') }}"
                                   placeholder="Ingrese nombre, apellido o identidad"
                                   aria-label="Buscar">
                        </div>


                        <div class="col-6 col-md-3">
                            <select class="form-select" name="filtro" aria-label="filtro de búsqueda">
                                <option selected >Filtrar por: </option>
                                <option value="todos" {{ request('filtro') == 'todos' ? 'selected' : '' }}> Todos </option>
                                <option value="nombre" {{ request('filtro') == 'nombre' ? 'selected' : '' }}> Nombre </option>
                                <option value="apellido" {{ request('filtro') == 'apellido' ? 'selected' : '' }}> Apellido </option>
                                <option value="identidad" {{ request('filtro') == 'identidad' ? 'selected' : '' }}> Identidad </option>
                            </select>
                        </div>


                        <div class="col-6 col-md-3">
                            <button class="btn btn-outline-info w-100" type="submit"> Buscar </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if(request('busqueda'))
            <div class="row justify-content-center mb-3" style="margin-top: 140px;">
                <div class="col-12 col-md-10 col-lg-8">
                    <div class="alert alert-info" role="alert">
                        Se encontraron <strong>{{ $pacientes->total() }}</strong> pacientes
                    </div>
                </div>
            </div>
        @endif


        @if(request('busqueda'))
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                    <tr>
                        <th scope="col">Numero Identidad</th>
                        <th scope="col">Nombre Completo</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="table-group-divider">
                    @forelse($pacientes as $paciente)
                        <tr>
                            <td>{{$paciente->numero_identidad}}</td>
                            <td>{{$paciente->nombres}} {{$paciente->apellidos}}</td>
                            <td>{{$paciente->telefono}}</td>
                            <td>
                                <a class="btn btn-primary btn-sm"
                                   href="#">
                                    <i class="bi bi-eye"></i> Ver Expediente
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">
                                <div class="py-4">
                                    <i class="bi bi-search" style="font-size: 3rem; color: #ccc;"></i>
                                    <p class="mt-3 text-muted">
                                        No se encontraron resultados para "<strong>{{ request('busqueda') }}</strong>"
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>


            <div class="d-flex justify-content-left">
                {{ $pacientes->links('pagination::bootstrap-5') }}
            </div>
        @else

            <div class="text-center py-5" style="margin-top: 100px;">
                <i class="bi bi-search" style="font-size: 4rem; color: #ccc;"></i>
                <h5 class="mt-3 text-muted">Realice una búsqueda para ver los resultados</h5>

            </div>
        @endif

    </div>
@endsection
