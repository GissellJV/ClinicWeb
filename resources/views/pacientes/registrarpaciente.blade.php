@extends('layouts.plantilla')

@section('contenido')
    <style>
        small.text-danger {
            font-size: 0.875em;
        }
        .validation-feedback {
            margin-top: 0.25rem;
            font-size: 0.875em;
        }
    </style>

    <script>
        // Validación en tiempo real para número de identidad
        function validarIdentidad(input) {
            input.value = input.value.replace(/\D/g, '').substring(0, 13);
            const feedback = document.getElementById('identidad-feedback');
            if (input.value.length === 13) {
                feedback.textContent = '✓ Número de identidad válido';
                feedback.className = 'text-success small validation-feedback';
            } else if (input.value.length > 0) {
                feedback.textContent = `Faltan ${13 - input.value.length} dígitos`;
                feedback.className = 'text-warning small validation-feedback';
            } else {
                feedback.textContent = '';
            }
        }

        // Validación en tiempo real para teléfono
        function validarTelefono(input) {
            // Solo permitir números y máximo 8 dígitos
            input.value = input.value.replace(/\D/g, '').substring(0, 8);

            const feedback = document.getElementById('telefono-feedback');
            const valor = input.value;

            if (valor.length === 0) {
                feedback.textContent = '';
                return;
            }

            // Validar que comience con 2, 3, 8 o 9
            const primerDigito = valor.charAt(0);
            if (!'2389'.includes(primerDigito)) {
                feedback.textContent = 'El número debe comenzar con 2, 3, 8 o 9';
                feedback.className = 'text-danger small validation-feedback';
                return;
            }

            if (valor.length === 8) {
                feedback.textContent = 'Número de teléfono válido';
                feedback.className = 'text-success small validation-feedback';
            } else {
                feedback.textContent = `Faltan ${8 - valor.length} dígitos`;
                feedback.className = 'text-warning small validation-feedback';
            }
        }

        // Validación de contraseña
        function validarPassword(input) {
            const feedback = document.getElementById('password-feedback');
            const valor = input.value;

            if (valor.length === 0) {
                feedback.innerHTML = '';
                return;
            }

            let errores = [];
            if (valor.length < 8) errores.push('Mínimo 8 caracteres');
            if (!/[a-z]/.test(valor)) errores.push('una minúscula');
            if (!/[A-Z]/.test(valor)) errores.push('una mayúscula');
            if (!/\d/.test(valor)) errores.push('un número');

            if (errores.length === 0) {
                feedback.textContent = 'Contraseña válida';
                feedback.className = 'text-success small validation-feedback';
            } else {
                feedback.innerHTML = 'Falta: ' + errores.join(', ');
                feedback.className = 'text-warning small validation-feedback';
            }
        }

        // Validar confirmación de contraseña
        function validarConfirmacion() {
            const password = document.getElementById('password').value;
            const confirmacion = document.getElementById('password_confirmation').value;
            const feedback = document.getElementById('confirmacion-feedback');

            if (confirmacion.length === 0) {
                feedback.textContent = '';
                return;
            }

            if (password === confirmacion) {
                feedback.textContent = 'Las contraseñas coinciden';
                feedback.className = 'text-success small validation-feedback';
            } else {
                feedback.textContent = 'Las contraseñas no coinciden';
                feedback.className = 'text-danger small validation-feedback';
            }
        }
    </script>

    <br><br><br>
    <div class="container">
        <h1 class="text-center">Regístrate para Agendar tu Cita</h1>

        <div class="d-flex justify-content-center align-items-center">
            <form class="p-4 border rounded" style="max-width: 600px; width: 200%;" method="post" action="{{route('pacientes.store')}}">
                @csrf
                <!--NOMBRE COMPLETO-->
                <div class="row">
                    <label for="exampleInputEmail1">Nombre Completo</label>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombres" value="{{old('nombres')}}">
                            @error('nombres')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" value="{{old('apellidos')}}">
                            @error('apellidos')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <!--FECHA-->
                <div class="mb-3">
                    <div class="row">
                        <div class="col">
                            <label for="fecha" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="{{old('fecha_nacimiento')}}">
                            @error('fecha_nacimiento')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <!--GENERO-->
                <div class="mb-3">
                    <label for="exampleInputEmail1">Genero</label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="genero" id="femenino" value="Femenino" {{ old('genero') == 'Femenino' ? 'checked' : '' }}>
                                <label class="form-check-label" for="femenino">
                                    Femenino
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="genero" id="masculino" value="Masculino" {{ old('genero') == 'Masculino' ? 'checked' : '' }}>
                                <label class="form-check-label" for="masculino">
                                    Masculino
                                </label>
                            </div>
                        </div>
                    </div>
                    @error('genero')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!--Numero de identidad-->
                <div class="form-group mb-3" style="width: 100%;">
                    <label for="numero_identidad">Número de identidad</label>
                    <input
                        type="text"
                        class="form-control"
                        id="numero_identidad"
                        name="numero_identidad"
                        placeholder="0000-0000-00000 (13 dígitos)"
                        maxlength="13"
                        oninput="validarIdentidad(this)"
                        value="{{old('numero_identidad')}}">
                    <div id="identidad-feedback"></div>
                    @error('numero_identidad')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!--Numero de Telefono con codigo de pais-->
                <div class="form-outline mb-3" style="width: 100%;">
                    <label class="form-label" for="telefono">Número de Teléfono</label>
                    <div class="input-group">
                        <span class="input-group-text">+504</span>
                        <input
                            type="text"
                            id="telefono"
                            name="telefono"
                            class="form-control"
                            placeholder="00000000 (8 dígitos)"
                            maxlength="8"
                            oninput="validarTelefono(this)"
                            value="{{old('telefono')}}">
                    </div>
                    <div id="telefono-feedback"></div>
                    @error('telefono')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mb-3" style="width: 100%;">
                    <label for="password">Contraseña</label>
                    <input
                        type="password"
                        class="form-control"
                        id="password"
                        name="password"
                        placeholder="Mínimo 8 caracteres"
                        oninput="validarPassword(this); validarConfirmacion();">
                    <div id="password-feedback"></div>
                    @error('password')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- CONFIRMAR CONTRASEÑA -->
                <div class="form-group mb-3" style="width: 100%;">
                    <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                    <input
                        type="password"
                        class="form-control"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Repite la contraseña"
                        oninput="validarConfirmacion();">
                    <div id="confirmacion-feedback"></div>
                    @error('password_confirmation')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Registrar</button>
                <a class="btn btn-danger" href="{{route('/')}}">Cancelar</a>
            </form>
        </div>
    </div>

@endsection
