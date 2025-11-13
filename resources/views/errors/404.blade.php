
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina no encontrada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    @stack('styles')
    \
</head>
<body>
    <div class="container text-center mt-5">
        <img src="imagenes/login-icon.png" alt="Error 404" style="width: 200px; height: auto;">
        <h1 class="mt-4 text-danger fw-bold">
            <i class="bi bi-house-door"></i>¡Ups! Página no encontrada</h1>
        <p class="text-muted mb-4">
            La página que buscas no existe.
        </p>

        {{-- Este botón redirige al panel o ruta principal según el rol --}}
        @if(session('cargo') === 'Recepcionista')
            <a href="{{ route('recepcionista.dashboard') }}" class="btn btn-primary">
                <i class="bi bi-house-door"></i> Ir al inicio
            </a>
        @elseif(session('cargo') === 'Doctor')
            <a href="{{ route('doctor.dashboard') }}" class="btn btn-success">
                <i class="bi bi-house-door"></i> Ir al panel del doctor
            </a>
        @else
            <a href="{{ url('/') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Regresar al inicio
            </a>
        @endif
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>


