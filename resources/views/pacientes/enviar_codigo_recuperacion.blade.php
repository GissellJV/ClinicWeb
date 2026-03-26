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

        /* ================= DARK MODE - RECUPERAR CONTRASEÑA ================= */

        .dark-mode body {
            background: #121212 !important;
            color: #e4e4e4 !important;
        }

        /* CONTENEDOR GENERAL */
        .dark-mode #recuperar-password-page,
        .dark-mode #recuperar-password-page .container {
            background: transparent !important;
        }

        /* TARJETA */
        .dark-mode .card {
            background: #1e1e1e !important;
            color: #e4e4e4 !important;

            box-shadow: 0 10px 40px rgba(0,0,0,0.5) !important;
        }

        /* TÍTULO */
        .dark-mode h3.text-center {
            color: #4ecdc4 !important;
        }

        /* TEXTO SECUNDARIO */
        .dark-mode .text-muted {
            color: #9ca3af !important;
        }

        /* LABEL */
        .dark-mode .form-label {
            color: #e0e0e0 !important;
        }

        /* INPUT */
        .dark-mode .form-control,
        .dark-mode input {
            background: #2a2a2a !important;
            color: #fff !important;
            border: 1px solid #444 !important;
        }

        .dark-mode .form-control:focus,
        .dark-mode input:focus {
            background: #2a2a2a !important;
            color: #fff !important;
            border-color: #4ecdc4 !important;
            box-shadow: 0 0 0 3px rgba(78,205,196,0.2) !important;
        }

        .dark-mode .form-control::placeholder,
        .dark-mode input::placeholder {
            color: #888 !important;
        }

        /* BOTÓN */
        .dark-mode .btn-enviar {
            background: linear-gradient(135deg, #2c5364, #203a43) !important;
            color: #e4e4e4 !important;
            border: none !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.5) !important;
        }

        .dark-mode .btn-enviar:hover {
            background: linear-gradient(135deg, #4ecdc4, #00ffe7) !important;
            color: #000 !important;
            box-shadow: 0 0 10px #00ffe7 !important;
            transform: translateY(-2px);
        }

        /* LINK */
        .dark-mode .mt-3 a {
            color: #4ecdc4 !important;
        }

        .dark-mode .mt-3 a:hover {
            color: #00ffe7 !important;
        }

        /* ERRORES */
        .dark-mode .text-danger,
        .dark-mode small.text-danger {
            color: #ff6b6b !important;
        }
    </style>




    <div id="recuperar-password-page">
<div class="container d-flex justify-content-center align-items-center vh-80">
    <div class="card shadow p-4" style="width: 400px;">
        <h3 class="text-center mb-3 text-info-emphasis">Recuperar Contraseña</h3>
        <p class="text-muted text-center">Ingresa tu correo electrónico registrado para restablecer tu contraseña..</p>

        <form action="{{route('pacientes.enviar_codigo_recuperacion')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="correo@ejemplo.com"
                       value="{{ old('email') }}"
                       required
                >
                @error('email')
                <small class="text-danger">{{ $message }}</small>
                @enderror
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
