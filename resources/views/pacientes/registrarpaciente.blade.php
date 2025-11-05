<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClinicWeb - Registro</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f0f4f8;
            min-height: 100vh;
            padding: 20px;
        }

        /* Botón de navegación navbar-toggler */
        .navbar-toggler {
            padding: 0.25rem 0.75rem;
            font-size: 1.25rem;
            line-height: 1;
            background-color: transparent;
            border: 1px solid transparent;
            border-radius: 0.375rem;
            transition: box-shadow 0.15s ease-in-out;
            margin-bottom: 20px;
            background: #4ECDC4;
            border-color: #4ECDC4;
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .navbar-toggler:hover {
            background: #45b8b0;
            border-color: #45b8b0;
            text-decoration: none;
            color: white;
        }

        .navbar-toggler-icon {
            display: inline-block;
            width: 1.5em;
            height: 1.5em;
            vertical-align: middle;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='white' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 100%;
        }

        .register-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            margin: 0 auto;
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .register-header {
            background: white;
            padding: 40px 40px 20px 40px;
            text-align: center;
        }

        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
        }

        .logo {
            width: 60px;
            height: 60px;
            background: #4ECDC4;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            position: relative;
        }

        .logo::before {
            content: '+';
            color: white;
            font-size: 2.5rem;
            font-weight: bold;
        }

        .logo-text {
            font-size: 2rem;
            font-weight: bold;
            color: #2c3e50;
        }

        .logo-text span {
            color: #4ECDC4;
        }

        .register-header h1 {
            font-size: 1.8rem;
            margin-bottom: 8px;
            font-weight: 600;
            color: #4ECDC4;
        }

        .register-header p {
            font-size: 0.95rem;
            color: #7f8c8d;
        }

        .register-form {
            padding: 30px 40px 40px 40px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e8f4f3;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8fffe;
        }

        .input-wrapper input:focus {
            outline: none;
            border-color: #4ECDC4;
            background: white;
            box-shadow: 0 0 0 4px rgba(78, 205, 196, 0.1);
        }

        .input-wrapper input:hover {
            border-color: #4ECDC4;
        }

        .radio-group {
            display: flex;
            gap: 30px;
            margin-top: 10px;
        }

        .radio-option {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .radio-option input[type="radio"] {
            appearance: none;
            width: 22px;
            height: 22px;
            border: 2px solid #cbd5e1;
            border-radius: 50%;
            margin-right: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .radio-option input[type="radio"]:checked {
            border-color: #4ECDC4;
            background: #4ECDC4;
        }

        .radio-option input[type="radio"]:checked::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
        }

        .radio-option label {
            margin: 0;
            cursor: pointer;
            font-weight: 500;
            color: #2c3e50;
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 16px;
            border: none;
            border-radius: 12px;
            font-size: 1.05rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-primary {
            background: #4ECDC4;
            color: white;
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.3);
        }

        .btn-primary:hover {
            background: #45b8b0;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
            color: white;
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            background: #f8f9fa;
            color: #6c757d;
            border: 2px solid #e9ecef;
        }

        .btn-secondary:hover {
            background: #e9ecef;
            color: #495057;
        }

        .login-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #e8f4f3;
            color: #7f8c8d;
            font-size: 0.95rem;
        }

        .login-link a {
            color: #4ECDC4;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: #45b8b0;
            text-decoration: underline;
        }

        .strength-meter {
            height: 4px;
            background: #e8f4f3;
            border-radius: 2px;
            margin-top: 8px;
            overflow: hidden;
        }

        .validation-message {
            font-size: 0.85em;
            display: block;
            margin-top: 5px;
            transition: all 0.3s ease;
        }

        .text-danger {
            color: #e74c3c;
        }

        .text-success {
            color: #2ecc71;
        }

        @media (max-width: 640px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .register-form {
                padding: 30px 20px;
            }

            .register-header {
                padding: 30px 20px 20px 20px;
            }

            .logo-text {
                font-size: 1.5rem;
            }

            .register-header h1 {
                font-size: 1.4rem;
            }

            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
<!-- Botón de navegación navbar-toggler -->
<div style="max-width: 600px; margin: 0 auto 20px auto;">
    <a href="{{ route('recepcionista.busquedaexpediente') }}" class="navbar-toggler">
        <span class="navbar-toggler-icon"></span>
        Menú Principal
    </a>
</div>

<div class="register-container">
    <div class="register-header">
        <div class="logo-container">
            <div class="logo"></div>
            <div class="logo-text">
                Clinic<span>Web</span>
            </div>
        </div>
        <h1>Regístrate para Agendar tu Cita</h1>
        <p>Completa el formulario para crear tu cuenta</p>
    </div>

    <form class="register-form" method="POST" action="{{ route('pacientes.store') }}" id="registerForm">
        @csrf

        <!-- NOMBRES Y APELLIDOS -->
        <div class="form-row">
            <div class="form-group">
                <label for="nombres">Nombres</label>
                <div class="input-wrapper">
                    <input type="text" id="nombres" name="nombres" value="{{ old('nombres') }}" placeholder="Ingresa tus nombres" required>
                </div>
                @error('nombres')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="apellidos">Apellidos</label>
                <div class="input-wrapper">
                    <input type="text" id="apellidos" name="apellidos" value="{{ old('apellidos') }}" placeholder="Ingresa tus apellidos" required>
                </div>
                @error('apellidos')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <!-- FECHA DE NACIMIENTO -->
        <div class="form-group">
            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
            <div class="input-wrapper">
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required>
            </div>
            @error('fecha_nacimiento')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- GÉNERO -->
        <div class="form-group">
            <label>Género</label>
            <div class="radio-group">
                <div class="radio-option">
                    <input type="radio" id="femenino" name="genero" value="Femenino" {{ old('genero') == 'Femenino' ? 'checked' : '' }} required>
                    <label for="femenino">Femenino</label>
                </div>
                <div class="radio-option">
                    <input type="radio" id="masculino" name="genero" value="Masculino" {{ old('genero') == 'Masculino' ? 'checked' : '' }} required>
                    <label for="masculino">Masculino</label>
                </div>
            </div>
            @error('genero')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- NÚMERO DE IDENTIDAD -->
        <div class="form-group">
            <label for="numero_identidad">Número de Identidad</label>
            <div class="input-wrapper">
                <input type="text" id="numero_identidad" name="numero_identidad" value="{{ old('numero_identidad') }}" placeholder="0000000000000" required>
            </div>
            <span id="identidad-validation" class="validation-message">El número de identidad debe tener 13 dígitos</span>
            @error('numero_identidad')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- TELÉFONO -->
        <div class="form-group">
            <label for="telefono">Número de Teléfono</label>
            <div class="input-wrapper">
                <input type="tel" id="telefono" name="telefono" value="{{ old('telefono') }}" placeholder="0000-0000" required>
            </div>
            @error('telefono')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- CONTRASEÑA -->
        <div class="form-group">
            <label for="password">Contraseña</label>
            <div class="input-wrapper">
                <input type="password" id="password" name="password" placeholder="Mínimo 8 caracteres" required>
            </div>
            <div class="strength-meter">
                <div class="strength-meter-fill" id="strengthMeter"></div>
            </div>
            @error('password')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- CONFIRMAR CONTRASEÑA -->
        <div class="form-group">
            <label for="password_confirmation">Confirmar Contraseña</label>
            <div class="input-wrapper">
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repite tu contraseña" required>
            </div>
            @error('password_confirmation')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- BOTONES -->
        <div class="button-group">
            <button type="submit" class="btn btn-primary">
                Registrar
            </button>
            <a href="{{ route('/') }}" class="btn btn-secondary">
                Cancelar
            </a>
        </div>

        <div class="login-link">
            ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a>
        </div>
    </form>
</div>

<script>
    // Password strength meter
    const passwordInput = document.getElementById('password');
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strengthMeter = document.getElementById('strengthMeter');
            let strength = 0;

            if (password.length >= 8) strength += 25;
            if (password.match(/[a-z]/)) strength += 25;
            if (password.match(/[A-Z]/)) strength += 25;
            if (password.match(/[0-9]/)) strength += 25;

            if (strengthMeter) {
                strengthMeter.style.width = strength + '%';
            }
        });
    }

    // Format identity number and validate
    const identidadInput = document.getElementById('numero_identidad');
    const identidadValidation = document.getElementById('identidad-validation');

    if (identidadInput) {
        identidadInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');

            // Format with dashes
            if (value.length > 4) {
                value = value.slice(0, 4) + '-' + value.slice(4);
            }
            if (value.length > 9) {
                value = value.slice(0, 9) + '-' + value.slice(9, 14);
            }
            e.target.value = value;

            // Validate - count only digits (excluding dashes)
            const digitCount = value.replace(/\D/g, '').length;

            if (digitCount === 13) {
                identidadValidation.textContent = "✓ Número de identidad válido";
                identidadValidation.className = "validation-message text-success";
            } else {
                identidadValidation.textContent = "El número de identidad debe tener 13 dígitos";
                identidadValidation.className = "validation-message text-danger";
            }
        });

        // Initial validation on page load
        const initialValue = identidadInput.value.replace(/\D/g, '');
        if (initialValue.length === 13) {
            identidadValidation.textContent = "✓ Número de identidad válido";
            identidadValidation.className = "validation-message text-success";
        }
    }

    // Format phone number
    const telefonoInput = document.getElementById('telefono');
    if (telefonoInput) {
        telefonoInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 4) {
                value = value.slice(0, 4) + '-' + value.slice(4, 8);
            }
            e.target.value = value;
        });
    }

    // Form validation
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            const identidadValue = identidadInput.value.replace(/\D/g, '');

            if (identidadValue.length !== 13) {
                e.preventDefault();
                identidadValidation.textContent = "El número de identidad debe tener 13 dígitos";
                identidadValidation.className = "validation-message text-danger";
                identidadInput.focus();
            }
        });
    }
</script>
</body>
</html>
