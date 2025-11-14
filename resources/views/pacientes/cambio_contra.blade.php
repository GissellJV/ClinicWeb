@extends('layouts.plantilla')

    @section('contenido')


    <style>
        #cambiar-password-page {
            padding-top: 0 !important;
            min-height: calc(100vh - 200px);
            display: flex;
            align-items: center;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:whitesmoke;


        }
        .btn-cambiar{
            width: 100%;
            padding: 0.31rem;
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            border: none;
            border-radius: 7px;
            color: white;
            margin-top: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.3);
        }
        .btn-cambiar:hover{
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        }
        small.text-danger {
            font-size: 0.875em;
        }
    </style>

    <div id="cambiar-password-page">
        <div class="container d-flex justify-content-center align-items-center vh-80">
    <div class="card shadow p-4" style="width: 400px;">
        <h3 class="text-center mb-3 text-info-emphasis">Establecer contraseña nueva</h3>
        <p class="text-muted text-center">Establece la nueva contraseña para tu cuenta.</p>

        <form action="{{ route('password.update') }}" method="POST">
            @csrf

            <input type="hidden" class="form-control" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label for="password" class="form-label">Nueva contraseña:</label>
                <input type="password" class="form-control" name="password" id="password" >
                @error('password')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar contraseña:</label>
                <input type="password"  class="form-control" name="password_confirmation" id="password_confirmation">
                @error('password_confirmation')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

        <button type="submit" class="btn-cambiar">Cambiar contraseña</button>
        </form>

        <div class="mt-3 text-center">
            <a href="{{route('inicioSesion')}}" style= "text-decoration-line: none; margin-bottom: 0.5rem; color: #4ecdc4; font-weight: 600" >Volver al inicio de sesión</a>
        </div>
    </div>
        </div>
    </div>

        <script>
            window.addEventListener('DOMContentLoaded', function() {
                window.scrollTo(0, 0);
            });
        </script>

    <!-- Alertas -->
    @if (session('error'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            window.scrollTo(0, 0);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonColor: '#4ecdc4'
            });
        </script>
    @endif

    @if (session('status'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            window.scrollTo(0, 0);
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: '{{ session('status') }}',
                confirmButtonColor: '#4ecdc4'
            });
        </script>
    @endif


@endsection
