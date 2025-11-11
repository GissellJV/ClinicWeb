@extends('layouts.plantilla')

@section('contenido')

    <style>
        body{
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:whitesmoke;
            display: flex;
        }
    </style>
    <div class="row mt-5 pt-5">
        @forelse($doctores as $doctor)
            <div class="col-md-6 mb-4">
                <div class="card mb-3 shadow-sm" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="{{ $doctor->foto_url }}" class="img-fluid rounded-start" alt="{{ $doctor->nombre }}">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ $doctor->nombre }}</h5>
                                <p class="card-text"><strong>Especialidad:</strong> {{ $doctor->especialidad }}</p>
                                <p class="card-text"><strong>Horario:</strong> {{ $doctor->horario }}</p>
                                <p class="card-text">
                                    <small class="text-body-secondary">Disponible ahora</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-warning text-center mt-4">
                <h5>No hay doctores disponibles en este momento.</h5>
                <p>Por favor, vuelve más tarde o contacta al administrador del sistema.</p>
            </div>
        @endforelse
    </div>
@endsection
