
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina no encontrada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: white;
        }
        .btn:hover{
            ransform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        }
    </style>

</head>
<body >
    <div class="container text-center">
        <img src="{{ asset('imagenes/login-icon.png') }}" alt="Error 404" style="width: 200px; height: auto;">
        <h1 class="mt-4 text-danger fw-bold">
            ¡Ups! Página no encontrada</h1>
        <p class="text-muted mb-4">
            La página que buscas no existe.
        </p>

        {{-- Este botón redirige al panel o ruta principal según el rol --}}
        @if(session('cargo') === 'Recepcionista')
            <a href="{{ route('recepcionista.dashboard') }}" class="btn btn-primary" style="background-color: #4ecdc4;">
                <i class="bi bi-house-door"></i> Ir al inicio
            </a>
        @elseif(session('cargo') === 'Doctor')
            <a href="{{ route('doctor.dashboard') }}" class="btn btn-success">
                <i class="bi bi-house-door"></i> Ir al panel del doctor
            </a>
        @else
            <a href="{{ url('/') }}" class="btn btn-secondary" style="background-color: #4ecdc4; border-color: #00bfa6">
                <i class="bi bi-arrow-left"></i> Regresar al inicio
            </a>
        @endif
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>


