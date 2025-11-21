@extends('layouts.plantillaRecepcion')

@section('contenido')

    <style>
        body {
            background: #f4f6f9;
            font-family: 'Poppins', sans-serif;
        }

        .doctor-card {
            transition: 0.3s;
            border-radius: 15px;
        }
        .doctor-card:hover {
            transform: translateY(-3px);
            box-shadow: 0px 4px 12px rgba(0,0,0,0.15);
        }


        .text-info-emphasis{
            font-weight: bold;
        }
    </style>

    <div class="container ">
        <h1 class="text-center text-info-emphasis">Lista de Doctores</h1>

        <!-- LISTA DE DOCTORES -->
        <br>
        <div class="row">
            @forelse ($doctores as $doctor)
                <div class="col-md-4 mb-4">
                    <div class="card doctor-card p-3">
                        <h5 class="fw-bold">{{ $doctor->nombre }}  {{ $doctor->apellido }}</h5>
                        <p><strong>Especialidad:</strong> {{ $doctor->departamento }}</p>
                    </div>
                </div>
                <div class="d-flex justify-content-left">
                    {{ $doctores->links('pagination::bootstrap-5') }}
                </div>
            @empty
                <p class="text-center">No se encontraron doctores.</p>
            @endforelse
        </div>


    </div>

@endsection
