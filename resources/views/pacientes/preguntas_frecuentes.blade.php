@php
    //Determinar plantilla según tipo de usuario
    if (session('tipo_usuario') === 'paciente') {
    $layout = 'layouts.plantilla';
    } elseif (session('tipo_usuario') === 'empleado') {
    switch (session('cargo')) {
    case 'Recepcionista':
    $layout = 'layouts.plantillaRecepcion';
    break;
    case 'Doctor':
    $layout = 'layouts.plantillaDoctor';
    break;
    case 'Enfermero':
    $layout = 'layouts.plantillaEnfermeria';
    break;
    case 'Administrador':
    $layout = 'layouts.plantillaAdmin';
    break;
    default:
    $layout = 'layouts.plantilla';
    }
    } else {
    $layout = 'layouts.plantilla';
    }
@endphp

@extends($layout)
@section('contenido')

    <style>
        body {
            background: whitesmoke;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        .btn-add {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration-line: none;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 205, 196, 0.3);
            color: white;
        }

        .faq-public-container {
            padding: 3rem 1rem;
            max-width: 1110px;
            margin: 0 auto;
        }

        .faq-public-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-top: 4rem;
            margin-bottom: 2rem;
        }

        .faq-public-header h1 {
            color: #333;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .faq-public-header p {
            color: #666;
            font-size: 1.1rem;
        }

        .faq-accordion {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .faq-item-wrapper {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .faq-accordion-item {
            flex: 1;
            border-radius: 10px;
            overflow: hidden;
            border: 2px solid #e0e0e0;
            transition: all 0.3s ease;
        }

        .faq-accordion-item:hover {
            border-color: #4ecdc4;
        }

        .faq-accordion-header {
            background: #f8f9fa;
            padding: 1.5rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        .faq-accordion-header:hover {
            background: #e8f8f7;
        }

        .faq-accordion-header.active {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            color: white;
        }

        .faq-question-text {
            font-size: 1.1rem;
            font-weight: 600;
            flex: 1;
            padding-right: 1rem;
        }

        .faq-icon {
            font-size: 1.5rem;
            transition: transform 0.3s ease;
        }

        .faq-icon.rotate {
            transform: rotate(180deg);
        }

        .faq-accordion-body {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .faq-accordion-body.show {
            max-height: 500px;
        }

        .faq-answer-content {
            padding: 1.5rem;
            color: #555;
            line-height: 1.8;
            background: white;
        }

        .faq-actions {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .btn-edit, .btn-delete {
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            text-align: center;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        .btn-edit {
            background: #4ecdc4;
            color: white;
        }

        .btn-edit:hover {
            background: #44a08d;
            color: white;
        }
        .btn-delete {
            padding: 8px 16px;
            background: white;
            border: 2px solid #dc3545;
            border-radius: 8px;
            color: #dc3545;
            font-weight: 600;
            transition: all 0.3s;
            cursor: pointer;
            text-decoration: none;
            width: 110px;        }

        .btn-delete:hover {
            background: #dc3545;
            color: white;
        }

        .empty-faq {
            text-align: center;
            padding: 4rem 2rem;
            color: #999;
        }

        .empty-faq i {
            font-size: 5rem;
            color: #ddd;
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .faq-public-header h1 {
                font-size: 2rem;
            }

            .faq-accordion {
                padding: 1rem;
            }

            .faq-accordion-header {
                padding: 1rem;
            }

            .faq-question-text {
                font-size: 1rem;
            }
        }

        .text-info-emphasis {
            font-weight: bold;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        /* ================= DARK MODE - PREGUNTAS FRECUENTES ================= */

        .dark-mode body {
            background: #121212 !important;
            color: #e4e4e4 !important;
        }

        /* CONTENEDOR */
        .dark-mode .faq-public-container {
            background: transparent !important;
        }

        /* HEADER */
        .dark-mode .faq-public-header h1 {
            color: #4ecdc4 !important;
        }

        .dark-mode .faq-public-header p {
            color: #9ca3af !important;
        }

        /* BOTÓN AGREGAR */
        .dark-mode .btn-add {
            background: linear-gradient(135deg, #2c5364, #203a43) !important;
            color: #e4e4e4 !important;
            border: none !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.5);
        }

        .dark-mode .btn-add:hover {
            background: linear-gradient(135deg, #4ecdc4, #00ffe7) !important;
            color: #000 !important;
            box-shadow: 0 0 15px #00ffe7, 0 0 25px rgba(0,255,231,0.4);
            transform: translateY(-2px);
        }

        /* ACORDEÓN */
        .dark-mode .faq-accordion {
            background: #1e1e1e !important;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.45);
        }

        .dark-mode .faq-accordion-item {
            border: 2px solid #333 !important;
            background: #1e1e1e !important;
        }

        .dark-mode .faq-accordion-item:hover {
            border-color: #4ecdc4 !important;
        }

        /* CABECERA DE PREGUNTA */
        .dark-mode .faq-accordion-header {
            background: #2a2a2a !important;
            color: #e4e4e4 !important;
        }

        .dark-mode .faq-accordion-header:hover {
            background: #333 !important;
        }

        .dark-mode .faq-accordion-header.active {
            background: linear-gradient(135deg, #2c5364, #203a43) !important;
            color: #fff !important;
        }

        /* TEXTO E ÍCONO */
        .dark-mode .faq-question-text {
            color: inherit !important;
        }

        .dark-mode .faq-icon {
            color: #4ecdc4 !important;
        }

        .dark-mode .faq-accordion-header.active .faq-icon {
            color: #fff !important;
        }

        /* RESPUESTA */
        .dark-mode .faq-answer-content {
            background: #1e1e1e !important;
            color: #d1d5db !important;
            border-top: 1px solid #333;
        }

        /* BOTONES DE ACCIÓN SI LUEGO LOS USAS */
        .dark-mode .btn-edit {
            background: linear-gradient(135deg, #2c5364, #203a43) !important;
            color: #e4e4e4 !important;
            border: none !important;
        }

        .dark-mode .btn-edit:hover {
            background: linear-gradient(135deg, #4ecdc4, #00ffe7) !important;
            color: #000 !important;
        }

        .dark-mode .btn-delete {
            background: #2a2a2a !important;
            color: #dc3545 !important;
            border: 2px solid #dc3545 !important;
        }

        .dark-mode .btn-delete:hover {
            background: #dc3545 !important;
            color: #fff !important;
        }

        /* VACÍO */
        .dark-mode .empty-faq {
            color: #9ca3af !important;
        }

        .dark-mode .empty-faq i {
            color: #4b5563 !important;
        }

        .dark-mode .empty-faq h3 {
            color: #d1d5db !important;
        }

        /* BOTÓN SECUNDARIO */
        .dark-mode .btn-secondary {
            background: #2a2a2a !important;
            color: #ccc !important;
            border: 1px solid #555 !important;
        }

        .dark-mode .btn-secondary:hover {
            background: #dc3545 !important;
            color: #fff !important;
            box-shadow: 0 0 10px rgba(220,53,69,0.5);
        }
    </style>

    <div class="faq-public-container">
        <div class="faq-public-header">
            <h1 class="text-info-emphasis">Preguntas Frecuentes</h1>
            @if(session('cargo') === 'Administrador'|| session('cargo') === 'Recepcionista')
                <a href="{{ route('preguntas.create') }}" class="btn-add">
                  + Agregar Pregunta
                </a>
            @endif
        </div>

        <div class="faq-accordion">
            @if($preguntas->count() > 0)
                @foreach($preguntas as $index => $pregunta)
                    <div class="faq-item-wrapper">
                        <div class="faq-accordion-item">
                            <div class="faq-accordion-header" onclick="toggleFAQ({{ $index }})">
                                <div class="faq-question-text">
                                    {{ $pregunta->pregunta }}
                                </div>
                                <div class="faq-icon" id="icon-{{ $index }}">
                                    <i class="bi bi-chevron-down"></i>
                                </div>
                            </div>
                            <div class="faq-accordion-body" id="body-{{ $index }}">
                                <div class="faq-answer-content">
                                    {{ $pregunta->respuesta }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-faq">
                    <h3>No hay preguntas frecuentes disponibles</h3>

                </div>
            @endif
        </div>
    </div>

    <script>
        function toggleFAQ(index) {
            const header = document.querySelector(`#body-${index}`).previousElementSibling;
            const body = document.getElementById(`body-${index}`);
            const icon = document.getElementById(`icon-${index}`);

            // Cerrar todos los demás
            document.querySelectorAll('.faq-accordion-body').forEach((item, i) => {
                if (i !== index) {
                    item.classList.remove('show');
                    item.previousElementSibling.classList.remove('active');
                    document.getElementById(`icon-${i}`).classList.remove('rotate');
                }
            });

            // Toggle el actual
            body.classList.toggle('show');
            header.classList.toggle('active');
            icon.classList.toggle('rotate');
        }


    </script>
@endsection
