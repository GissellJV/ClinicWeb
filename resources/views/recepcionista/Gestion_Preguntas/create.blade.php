@extends('layouts.plantillaRecepcion')
<link rel="stylesheet" href="{{ asset('css/formulario.css') }}">

@section('titulo', isset($pregunta) ? 'Editar Pregunta Frecuente' : 'Nueva Pregunta Frecuente')

@section('contenido')
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: whitesmoke;
        }

        .formulario-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 100px 20px 40px;
        }

        .page-title {
            color: #2c3e50;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 30px;
            text-align: center;
        }

        .formulario .form-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            border-top: 5px solid #4ecdc4;
        }

        .formulario .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
            font-size: 1rem;
            display: block;
        }

        .formulario .form-control {
            color: #555;
            padding: 0.75rem 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
            width: 100%;
        }

        .formulario .form-control:focus {
            outline: none;
            border-color: #4ecdc4;
            box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.1);
            background: white;
        }

        .formulario .form-control.is-invalid {
            border-color: #dc3545;
            background: #fff5f5;
        }

        .formulario .form-control.is-invalid:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }

        .formulario textarea.form-control {
            min-height: 120px;
            resize: vertical;
            font-family: inherit;
        }

        .char-counter {
            font-size: 0.85rem;
            color: #6c757d;
            text-align: right;
            margin-top: 0.25rem;
        }

        .char-counter.warning {
            color: #f39c12;
            font-weight: 600;
        }

        .char-counter.danger {
            color: #dc3545;
            font-weight: 600;
        }

        .mb-3 {
            margin-bottom: 1.5rem;
        }

        .form-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn-register {
            padding: 0.875rem 2.5rem;
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.3);
            cursor: pointer;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
        }

        .btn-cancel {
            padding: 0.875rem 2.5rem;
            background: white;
            border: 2px solid #6c757d;
            border-radius: 8px;
            color: #6c757d;
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #6c757d;
            color: white;
            transform: translateY(-2px);
        }

        .text-danger {
            font-size: 0.875rem;
            display: block;
            margin-top: 0.5rem;
            color: #dc3545;
        }

        .required-field::after {
            content: " *";
            color: #dc3545;
        }

        @media (max-width: 768px) {
            .formulario-container {
                padding: 80px 15px 30px;
            }

            .formulario .form-container {
                padding: 2rem 1.5rem;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .form-buttons {
                flex-direction: column;
            }

            .btn-register, .btn-cancel {
                width: 100%;
            }
        }
        .text-info-emphasis {

            font-weight: bold;
        }

    </style>

    <div class="formulario-container">
        <h2 class="text-center text-info-emphasis">
            @isset($pregunta)
                Editar
            @else
                Registrar
            @endisset

            Pregunta Frecuente</h2>

        <div class="formulario">
            <div class="form-container">
                <form
                    @isset($pregunta)
                        action="{{route('preguntas.update', ['id'=>$pregunta->id])}}"
                    @else
                        action="{{ route('preguntas.store') }}"
                    @endisset

                    method="post">

                    @isset($pregunta)
                        @method('put')
                    @endisset
                    @csrf

                    {{-- Campo Pregunta --}}
                    <div class="mb-3">
                        <label for="pregunta" class="form-label ">Pregunta</label>
                        <textarea
                            class="form-control"
                            id="pregunta"
                            name="pregunta"
                            maxlength="500"
                        >{{ old('pregunta', $pregunta->pregunta ?? '') }}</textarea>
                        <div class="char-counter">
                            <span id="preguntaCount">0</span> / 500 caracteres
                        </div>
                        @error('pregunta')
                        <small class="text-danger"> {{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Campo Respuesta --}}
                    <div class="mb-3">
                        <label for="respuesta" class="form-label">Respuesta</label>
                        <textarea
                            class="form-control"
                            id="respuesta"
                            name="respuesta"
                            maxlength="2000"
                        >{{ old('respuesta', $pregunta->respuesta ?? '') }}</textarea>
                        <div class="char-counter">
                            <span id="respuestaCount">0</span> / 2000 caracteres
                        </div>
                        @error('respuesta')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Botones --}}
                    <div class="form-buttons" >
                        <a href="{{ route('preguntas.index') }}" class="btn-cancel">
                            Cancelar
                        </a>
                        <button type="submit" class="btn-register">
                            {{ isset($pregunta) ? 'Actualizar' : 'Guardar' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Función para actualizar el contador de caracteres
        function updateCharCounter(textarea, counter) {
            const currentLength = textarea.value.length;
            const maxLength = textarea.getAttribute('maxlength');
            counter.textContent = currentLength;

            // Cambiar color según el porcentaje usado
            const percentage = (currentLength / maxLength) * 100;
            counter.parentElement.classList.remove('warning', 'danger');

            if (percentage >= 90) {
                counter.parentElement.classList.add('danger');
            } else if (percentage >= 75) {
                counter.parentElement.classList.add('warning');
            }
        }

        // Contador de caracteres para pregunta
        const preguntaTextarea = document.getElementById('pregunta');
        const preguntaCount = document.getElementById('preguntaCount');

        preguntaTextarea.addEventListener('input', function() {
            updateCharCounter(this, preguntaCount);
        });

        // Contador de caracteres para respuesta
        const respuestaTextarea = document.getElementById('respuesta');
        const respuestaCount = document.getElementById('respuestaCount');

        respuestaTextarea.addEventListener('input', function() {
            updateCharCounter(this, respuestaCount);
        });

        // Inicializar contadores al cargar la página
        window.addEventListener('DOMContentLoaded', function() {
            updateCharCounter(preguntaTextarea, preguntaCount);
            updateCharCounter(respuestaTextarea, respuestaCount);
        });

        // Validación antes de enviar el formulario
        document.querySelector('form').addEventListener('submit', function(e) {
            const pregunta = preguntaTextarea.value.trim();
            const respuesta = respuestaTextarea.value.trim();

            if (!pregunta || !respuesta) {
                e.preventDefault();
                alert('Por favor completa todos los campos requeridos.');

                if (!pregunta) preguntaTextarea.focus();
                else if (!respuesta) respuestaTextarea.focus();
            }
        });
    </script>
@endsection
