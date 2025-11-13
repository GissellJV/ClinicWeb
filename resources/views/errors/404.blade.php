
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
            flex-direction: column;
        }
        .btn:hover{
            ransform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        }
        html, body {
            height: 100%;
            margin: 0;
        }
        .footer {
            width: 100%;
            height: 2%;
            background-color: #ffffff;
            color: #333;
            border-top: 3px solid #4ecdc4;
            box-shadow: 0 -4px 15px rgba(0,0,0,0.05);
            padding: 1rem 0;
        }


        .footer h5, .footer h4 {
            margin-bottom: 1rem;
        }

        .footer .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background-color: #4ecdc4;
            color: white;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .footer .social-link:hover {
            background-color: #34b5ad;
            transform: translateY(-3px);
        }
        .navbar-brand img {
            height: 3rem;
            width: auto;
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
    <footer class="footer mt-5">

        <div class="row text-center text-md-start mx-0">
            <!-- Logo y descripción -->
            <div class="col-md-4 mb-4">
                <h4 class="fw-bold text-uppercase" style="color:#4ecdc4;">ClinicWeb</h4>
                <p class="text-muted">
                    Brindamos atención médica profesional con tecnología moderna y un equipo humano comprometido con tu salud.
                </p>
            </div>

            <!-- Información de contacto -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-semibold" style="color:#4ecdc4;">Contáctanos</h5>
                <ul class="list-unstyled text-muted">
                    <li><i class="bi bi-geo-alt-fill" style="color:#4ecdc4;"></i> Barrio centro, Danlí, El Paraíso, Honduras</li>
                    <li><i class="bi bi-telephone-fill" style="color:#4ecdc4;"></i> +504 2234-5678</li>
                    <li><i class="bi bi-envelope-fill" style="color:#4ecdc4;"></i> contacto@clinicweb.hn</li>
                </ul>
            </div>

            <!-- Redes sociales -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-semibold" style="color:#4ecdc4;">Síguenos</h5>
                <div class="d-flex justify-content-center justify-content-md-start gap-3">
                    <a href="#" class="social-link"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-link"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="social-link"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="social-link"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>
        </div>

        <hr class="my-0" style="border-color: rgba(78, 205, 196, 0.3);">

        <div class="text-center text-muted small">
            © {{ date('Y') }} ClinicWeb. Todos los derechos reservados.
        </div>

    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>


