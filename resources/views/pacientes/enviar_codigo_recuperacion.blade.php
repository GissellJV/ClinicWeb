@extends('layouts.plantilla')
    @section('contenido')
    <style>
        #recuperar-password-page {
            padding-top: 0 !important;
            min-height: calc(100vh - 200px);
            display: flex;
            align-items: center;
        }


        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:whitesmoke;


        }
        .btn-enviar{
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
        .btn-enviar:hover{
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        }
        small.text-danger {
            font-size: 0.875em;
        }
    </style>




    <div id="recuperar-password-page">
<div class="container d-flex justify-content-center align-items-center vh-80">
    <div class="card shadow p-4" style="width: 400px;">
        <h3 class="text-center mb-3 text-info-emphasis">Recuperar Contraseña</h3>
        <p class="text-muted text-center">Ingresa tu número de WhastsApp para restablecer tu contraseña.</p>

        <form action="{{route('pacientes.enviar_codigo_recuperacion')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="telefono" class="form-label">Número de WhatsApp</label>
                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="00000000" >
                @error('telefono')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn-enviar">Enviar enlace</button>
        </form>

        <div class="mt-3 text-center">
            <a href="{{route('inicioSesion')}}" style="color: #4ecdc4; text-decoration: none; font-weight: 500;">Volver al inicio de sesión</a>
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
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: '{{ session('status') }}',
            confirmButtonColor: '#4ecdc4'
        });
    </script>
@endif

@endsection
