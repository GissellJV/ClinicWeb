@extends('layouts.plantillaRecepcion')
<link rel="stylesheet" href="{{ asset('css/formulario.css') }}">

@section('contenido')

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:whitesmoke;
        }
        .text-info-emphasis {

            font-weight: bold;
        }

        .btn-guardar {
            padding: 0.875rem 2rem;
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.3);
        }

        .btn-guardar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        }

    </style>

    <br> <br> <br> <br>
    <h1 class="text-center text-info-emphasis">Promociones</h1>
    <div class="formulario">

        <div class="form-container">

            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div style="background:#d4edda; padding:10px; border-radius:5px; margin-bottom:15px;">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Formulario --}}
            <form action="{{ route('publicidad.store') }}" method="POST">
                @csrf

                <label>Título</label>
                <input type="text" name="titulo" class="form-control" required>

                <label>Subtitulo</label>
                <input type="text" name="subtitulo" class="form-control" required>

                <label class="mt-3">Descripción</label>
                <textarea name="descripcion" class="form-control" required></textarea>

                <div style="margin-top: 20px">
                    <button class="btn-guardar">Guardar</button>
                </div>

            </form>
        </div>

    </div>

@endsection
