@extends('layouts.plantillaRecepcion')
<link rel="stylesheet" href="{{ asset('css/formulario.css') }}">

@section('contenido')
    <style>
        body {
            background: whitesmoke;
        }

        .faq-container {
            padding: 2rem 1rem;
            max-width: 1200px;
            margin: 0 auto;
        }



        .page-header h1 {
            color: #333;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            color: #666;
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
            text-decoration: none;

        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
            color: white;
        }

        .faq-list {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .faq-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            background: #e8f8f7;
            transform: translateX(5px);
        }

        .faq-number {
            display: inline-block;
            background: #4ecdc4;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            text-align: center;
            line-height: 35px;
            font-weight: bold;
            margin-right: 1rem;
        }

        .faq-content {
            flex: 1;
        }

        .faq-pregunta {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .faq-respuesta {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .faq-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-edit {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            color: white;
            border: none;
            padding: 15px 16px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            text-align: center;
            width: 110px;
            height: 50px;



        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
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
            width: 110px;
            height: 50px;       }

        .btn-delete:hover {
            background: #dc3545;
            color: white;
        }

        .alert {
            padding: 1rem 1.25rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border: none;
        }

        .alert-success {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
            padding: 15px 45px 15px 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            font-size: 1.05rem;
            position: relative;
            text-align: left;

            border-left: solid #0c5460;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: #999;
        }

        .empty-state i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 1rem;
        }

        .d-flex {
            display: flex;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .align-items-center {
            align-items: center;
        }

        .mb-3 {
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .page-header {
                padding: 1.5rem;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .faq-list {
                padding: 1rem;
            }

            .faq-item {
                padding: 1rem;
            }

            .faq-actions {
                flex-direction: column;
            }

        }

        /* Modal de confirmación */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            padding: 2rem;
            border-radius: 15px;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            margin-bottom: 1rem;
        }

        .modal-header h3 {
            color: #333;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .modal-body {
            color: #666;
            margin-bottom: 1.5rem;
        }

        .modal-footer {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }

        .btn-modal-confirm {
            padding: 0.50rem 1.3rem;
            background: #dc3545;
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            cursor: pointer;
        }
        .text-info-emphasis {

            font-weight: bold;
        }

    </style>
    <br>
    <div class="faq-container">
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="text-center text-info-emphasis">Administración de Preguntas Frecuentes</h1>
                </div>
                <a href="{{ route('preguntas.create') }}" class="btn-add  btn-sm">
                    Agregar Pregunta
                </a>
            </div>
        </div>
        <br><br>
        {{-- Mensajes --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="faq-list">
            @if($preguntas->count() > 0)
                @foreach($preguntas as $index => $pregunta)
                    <div class="faq-item">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex" style="flex: 1;">
                                <span class="faq-number">{{ $index + 1 }}</span>
                                <div class="faq-content">
                                    <div class="faq-pregunta">{{ $pregunta->pregunta }}</div>
                                    <div class="faq-respuesta">{{ Str::limit($pregunta->respuesta, 150) }}</div>
                                </div>
                            </div>
                            <div class="faq-actions">
                                <a href="{{ route('preguntas.edit', $pregunta->id) }}" class="btn-edit">
                                    Editar
                                </a>
                                <button
                                    onclick="confirmarEliminacion({{ $pregunta->id }}, '{{ Str::limit($pregunta->pregunta, 50) }}')"
                                    class="btn-delete"
                                >
                                    Eliminar
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <div style="font-size: 4rem;"></div>
                    <h3>No hay preguntas frecuentes</h3>
                </div>
            @endif
        </div>
    </div>

    {{-- Modal de confirmación --}}
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Confirmar Eliminación</h3>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar esta pregunta?</p>
                <p id="preguntaTexto" style="font-weight: bold;"></p>
            </div>
            <div class="modal-footer">
                <button onclick="cerrarModal()" class="btn btn-secondary">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-modal-confirm">Eliminar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmarEliminacion(id, pregunta) {
            document.getElementById('deleteModal').classList.add('show');
            document.getElementById('preguntaTexto').textContent = pregunta;
            document.getElementById('deleteForm').action = `/preguntas/${id}`;
        }

        function cerrarModal() {
            document.getElementById('deleteModal').classList.remove('show');
        }

        window.onclick = function(event) {
            const modal = document.getElementById('deleteModal');
            if (event.target == modal) {
                cerrarModal();
            }
        }
    </script>
@endsection
