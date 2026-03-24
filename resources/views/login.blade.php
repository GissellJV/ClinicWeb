@extends('layouts.plantilla')

@section('contenido')
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:whitesmoke;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-wrapper {
            min-height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px;
            margin-top:-75px;
            width: 800px;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 460px;
            height: 670px;
            padding: 2rem 1.5rem;
            border-top: 5px solid #4ecdc4;
            position: relative;
            overflow: hidden;
        }

        .logo-text span {
            color: #4ecdc4;
            background: transparent;
        }

        .login-title {
            text-align: center;
            font-size: 1.75rem;
            font-weight: bold;


            color: #4ecdc4;
            margin-bottom: 2rem;
            background: transparent;
        }

        .form-group {
            margin-bottom: 1.5rem;
            background: transparent;
        }

        .input-group {
            position: relative;
            background: transparent;
            display: flex;
            align-items: stretch;
        }

        .input-icon {
            flex-shrink: 0;
            width: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #d6f1ec;
            border-radius: 10px 0 0 10px;
            border: 1px solid #e0e0e0;
            border-right: none;
        }

        .input-icon img {
            height: 1.25rem;
            width: auto;

        }

        .form-control {
            flex: 1;
            padding: 0.875rem 1rem;
            border: 1px solid #e0e0e0;
            border-radius: 0 10px 10px 0;
            border-left: none;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus {
            outline: none;
            border-color: #4ecdc4;
            box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.1);
            background: white;
        }

        .form-control::placeholder {
            color: #999;
        }

        .alert {
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border: none;
        }

        .error-container {
            min-height: 70px;
            margin-bottom: 1rem;
        }


        .alert-danger {
            background: #fee;
            color: #c33;
            padding: 1rem;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .text-danger {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            background: transparent;
        }

        .btn-login {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }
        .footer-links {
            text-align: center;
            margin-top: 1.5rem;
            background: transparent;
        }

        .footer-links p {
            color: #666;
            margin-bottom: 0.5rem;
            background: transparent;
        }

        .footer-links a {
            color: #4ecdc4;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            background: transparent;
        }

        .footer-links a:hover {
            color: #44a08d;
            text-decoration: underline;
        }


        @media (max-width: 576px) {
            .login-container {
                padding: 2rem 1.5rem;
            }

            .login-title {
                font-size: 1.5rem;
            }
        }


        /* ================= DARK MODE - LOGIN ================= */
        .dark-mode body {
            background: #121212 !important;
            color: #e4e4e4;
        }

        .dark-mode .login-container {
            background: #1e1e1e !important;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
            border-top: 5px solid #4ecdc4;
        }

        .dark-mode .login-title {
            color: #4ecdc4 !important;
        }

        .dark-mode .form-control {
            background-color: #2a2a2a !important;
            color: #fff !important;
            border: 1px solid #444 !important;
        }

        .dark-mode .form-control::placeholder {
            color: #888 !important;
        }

        .dark-mode .input-icon {
            background: #333;
            border: 1px solid #555;
        }

        .dark-mode .alert-danger {
            background: #3a1e1e !important;
            color: #ff6b6b !important;
            border-color: #5f2f2f !important;
        }

        .dark-mode .text-danger {
            color: #ff6b6b !important;
        }

        .dark-mode .btn-login {
            background: linear-gradient(135deg, #2c5364, #203a43) !important;
            color: #e4e4e4 !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.5);
        }

        .dark-mode .btn-login:hover {
            background: linear-gradient(135deg, #4ecdc4, #00ffe7) !important;
            color: #000 !important;
            box-shadow: 0 0 15px #00ffe7, 0 0 25px rgba(0,255,231,0.4);
        }

        .dark-mode .footer-links p,
        .dark-mode .footer-links a {
            color: #ccc !important;
        }

        .dark-mode .footer-links a:hover {
            color: #4ecdc4 !important;
        }
        /* ================= DARK MODE - LOGIN ================= */
    </style>
    <div class="login-wrapper" style=" margin-top: -3%">
        <div class="login-container">
            <div class="d-flex justify-content-center">
                <!--LOGO DE LA CLINICA-->
                <img src="/imagenes/login-icon.png" alt="login-icono" style="height: 8rem">
            </div>
                <div class="error-container">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{session('error')}}
                        </div>
                    @endif
                </div>


                <h2 class="login-title" >Iniciar Sesión</h2>
            <form action="{{route('login.sesion')}}" method="POST">
                @csrf
                <input type="hidden" name="redirect_to" value="{{ request('redirect_to') }}">

                <div class="form-group">
                    <div class="input-group">
            <span class="input-icon">
                <img src="/imagenes/username-icon.svg" alt="usuario">
            </span>
                        <input class="form-control"
                               placeholder="Número de Teléfono"  name="telefono" type="text" value="{{old('telefono')}}">
                    </div>
                    @error('telefono')
                    <div class="text-danger mt-1" style="font-size: 0.875rem;">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="input-group ">
            <span class="input-icon">
                <img src="imagenes\password-icon.svg" alt="password">
            </span>
                        <input class="form-control" type="password" name="password"
                               placeholder="Contraseña" >
                    </div>
                </div>


                @error('password')
                <div class="text-danger mt-1">
                    {{ $message }}
                </div>
                @enderror

                <br>
                <button type="submit" class="btn-login">Iniciar Sesión</button>
            </form>
            <div class="footer-links">

                <a href="{{route('pacientes.enviar_codigo_recuperacion')}}" class="forgot-password">¿Olvidaste tu contraseña?</a>

            </div>

        </div>

        </div>

@endsection



