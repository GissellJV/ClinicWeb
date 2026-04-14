@extends('layouts.plantilla')
<link rel="stylesheet" href="{{ asset('css/formulario.css') }}">

@section('contenido')
    <style>

        body {
            background:whitesmoke;
        }

        .formulario .register-section {
            padding: 1rem 1rem 3rem 1rem;
        }

        .formulario .form-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            max-width: 800px;
            margin: 0 auto;
            border-top: 5px solid #4ecdc4;
            position: relative;
        }

        .formulario .form-title {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 2rem;
            text-align: center;
        }

        .formulario .form-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .formulario .form-control {
            color: #555;
            padding: 0.75rem 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .formulario .form-control:focus {
            outline: none;
            border-color: #4ecdc4;
            box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.1);
            background: white;
        }

        .formulario .form-control::placeholder {
            color: #999;
        }

        /* RADIO BOTONES */
        .formulario .form-check-input:checked {
            background-color: #4ecdc4;
            border-color: #4ecdc4;
        }

        .formulario .form-check-input:focus {
            box-shadow: 0 0 0 0.25rem rgba(78, 205, 196, 0.25);
            border-color: #4ecdc4;
        }

        /* INPUTS */
        .formulario .input-group-text {
            background: #e8f8f7;
            border: 2px solid #e0e0e0;
            border-right: none;
            color: #4ecdc4;
            font-weight: 600;
        }

        .formulario .input-group .form-control {
            border-left: none;
        }

        .formulario .input-group:focus-within .input-group-text {
            border-color: #4ecdc4;
        }

        .formulario .input-group:focus-within .form-control {
            border-color: #4ecdc4;
        }

        /* MENSAJES DE ERROR */
        .formulario small.text-danger {
            font-size: 0.875rem;
            display: block;
            margin-top: 0.5rem;
        }

        /* BOTONES */
        .btn-register {
            padding: 0.875rem 2rem;
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.3);
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        }

        .btn-cancel {
            padding: 0.875rem 2rem;
            background: white;
            border: 2px solid #dc3545;
            border-radius: 8px;
            color: #dc3545;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            flex: 0.6;
        }

        .btn-cancel:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }


        .profile-card {
            margin-top: 1rem;
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2.5rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .profile-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 48px;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.3);
            overflow: hidden;
            position: relative;
        }

        .profile-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-photo-wrapper {
            position: relative;
            width: 120px;
            height: 120px;
            flex-shrink: 0;
            display: inline-block;
        }

        /* Botón de editar foto */
        .edit-photo-btn {
            position: absolute;
            bottom: 2px;
            right: -2px;
            background: #4ecdc4;
            color: white;
            border: 3px solid white;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .edit-photo-btn:hover {
            background: #44a08d;
            transform: scale(1.1);
        }

        .edit-photo-btn i {
            font-size: 16px;
        }

        /* Input oculto para foto */
        #fotoInput {
            display: none;
        }

        .profile-name h2 {
            color: #333;
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .profile-name p {
            color: #666;
            font-size: 1rem;
            margin: 0;
        }

        .patient-badge {
            display: inline-block;
            background: #e8f8f7;
            color: #4ecdc4;
            padding: 0.35rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .profile-details {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .detail-item {
            background: transparent;
            padding: 0;
            border-radius: 0;
            transition: none;
            position: relative;
            width: 100%;
        }

        /* Quitar efecto hover */
        .detail-item:hover {
            background: transparent;
            transform: none;
        }

        .detail-label {
            color: #333;
            font-size: 0.9rem;
            font-weight: 500;
            text-transform: none;
            margin-bottom: 0.5rem;
            letter-spacing: normal;
            display: block;
        }

        .detail-label i {
            display: none;
        }

        .detail-value {
            color: #666;
            font-size: 1rem;
            font-weight: 400;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            background: #f5f5f5;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            min-height: 48px;
            box-sizing: border-box;
        }

        /* Estilos para edición de teléfono */
        .edit-icon {
            color: #4ecdc4;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            padding: 0.25rem;
            margin-left: auto;
        }

        .edit-icon:hover {
            color: #44a08d;
            transform: scale(1.1);
        }

        .phone-edit-mode {
            display: none;
            width: 100%;
        }

        .phone-edit-mode.active {
            display: block;
            width: 100%;
        }

        .phone-view-mode.hidden {
            display: none;
        }

        /* Input de teléfono sin padding extra */
        .phone-input {
            flex: 1;
            padding: 0;
            margin: 0;
            border: none;
            border-radius: 0;
            font-size: 1rem;
            background: transparent;
            color: #333;
            min-width: 0;
            height: auto;
        }

        .phone-input:focus {
            outline: none;
            background: transparent;
            box-shadow: none;
        }


        .phone-edit-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            background: #e8f8f7;
            border: 2px solid #4ecdc4;
            border-radius: 8px;
            min-height: 48px;
            box-sizing: border-box;
            width: 100%;
        }

        .phone-prefix {
            color: #666;
            font-weight: 500;
            font-size: 1rem;
            flex-shrink: 0;
        }


        .save-phone-btn, .cancel-phone-btn {
            padding: 0;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            flex-shrink: 0;
        }

        .save-phone-btn {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            border: none;
            border-radius: 8px;
            color: white;
        }

        .save-phone-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        }

        .cancel-phone-btn {
            background: white;
            border: 2px solid #dc3545;
            border-radius: 8px;
            color: #dc3545;
        }

        .cancel-phone-btn:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }

        .privacy-notice p {
            color: #333;
            font-size: 0.95rem;
            margin: 0;
        }

        /* ALERTAS */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border: none;
        }

        .alert i {
            font-size: 1.25rem;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        /* ESTILOS PARA EL MODAL DE FOTO */
        .foto-preview-container {
            width: 150px;
            height: 150px;
            margin: 0 auto;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid #4ecdc4;
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.3);
        }

        .foto-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .foto-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 80px;
        }

        .form-group-custom {
            margin-bottom: 1rem;
        }

        .invalid-feedback {
            display: none;
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .invalid-feedback.d-block {
            display: block !important;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
            background-color: #fff5f5;
        }
        small.text-danger {
            font-size: 0.875em;
        }

        @media (max-width: 768px) {
            .formulario .form-container {
                padding: 2rem 1.5rem;
            }

            .formulario .form-title {
                font-size: 1.5rem;
            }

            .profile-header {
                flex-direction: column;
                text-align: center;
            }

            .profile-photo {
                width: 100px;
                height: 100px;
                font-size: 40px;
            }

            .profile-name h2 {
                font-size: 1.5rem;
            }

            .profile-details {
                grid-template-columns: 1fr;
            }
        }

        /* ================= DARK MODE PERFIL Y FORMULARIO ================= */
        .dark-mode body {
            background: #121212 !important;
            color: #e4e4e4;
        }

        .dark-mode .formulario .form-container {
            background: #1e1e1e !important;
            color: #e4e4e4;
            border-top: 5px solid #4ecdc4;
            box-shadow: 0 10px 40px rgba(0,0,0,0.5);
        }

        .dark-mode .formulario .form-title {
            color: #4ecdc4;
        }

        .dark-mode .formulario .form-label {
            color: #ccc !important;
        }

        .dark-mode .formulario .form-control {
            background: #2a2a2a !important;
            color: #fff !important;
            border: 2px solid #444 !important;
        }

        .dark-mode .formulario .form-control:focus {
            border-color: #4ecdc4;
            box-shadow: 0 0 0 3px rgba(78,205,196,0.25);
            background: #1e1e1e;
            color: #fff;
        }

        .dark-mode .formulario .form-control::placeholder {
            color: #888 !important;
        }

        .dark-mode .formulario .input-group-text {
            background: #1e1e1e !important;
            color: #4ecdc4 !important;
            border: 2px solid #444;
        }

        .dark-mode .formulario .input-group:focus-within .input-group-text,
        .dark-mode .formulario .input-group:focus-within .form-control {
            border-color: #4ecdc4 !important;
        }

        .dark-mode .btn-register {
            background: linear-gradient(135deg, #2c5364, #203a43);
            color: #e4e4e4;
            box-shadow: 0 4px 15px rgba(0,0,0,0.5);
            transition: all 0.3s ease;
        }

        .dark-mode .btn-register:hover {
            background: linear-gradient(135deg, #4ecdc4, #00ffe7);
            color: #111827;
            box-shadow: 0 0 15px #00ffe7, 0 0 25px rgba(0,255,231,0.4);
            transform: translateY(-2px);
        }

        .dark-mode .btn-cancel {
            background: #2a2a2a;
            color: #dc3545;
            border: 2px solid #dc3545;
        }

        .dark-mode .btn-cancel:hover {
            background: #dc3545;
            color: #fff;
            box-shadow: 0 4px 10px rgba(220,53,69,0.5);
        }

        /* ALERTAS */
        .dark-mode .alert-success {
            background: #1e3a2f;
            color: #4ade80;
            border-left: 4px solid #28a745;
        }

        .dark-mode .alert-danger {
            background: #3a1e1e;
            color: #ff6b6b;
            border-left: 4px solid #dc3545;
        }

        /* PERFIL */
        .dark-mode .profile-card {
            background: #1e1e1e;
            color: #e4e4e4;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
        }

        .dark-mode .profile-header {
            border-bottom: 2px solid #333;
        }

        .dark-mode .profile-name h2,
        .dark-mode .profile-name p {
            color: #fff;
        }

        .dark-mode .patient-badge {
            background: #064e3b;
            color: #d1fae5;
        }

        /* FOTO */
        .dark-mode .profile-photo {
            background: linear-gradient(135deg, #2c5364, #203a43);
            color: #e4e4e4;
        }

        .dark-mode .edit-photo-btn {
            background: #4ecdc4;
        }

        .dark-mode .edit-photo-btn:hover {
            background: #00ffe7;
        }

        /* DETAIL ITEMS */
        .dark-mode .detail-value {
            background: #2a2a2a;
            color: #e4e4e4;
            border: 1px solid #444;
        }

        .dark-mode .phone-edit-container {
            background: #1e1e1e;
            border: 2px solid #4ecdc4;
        }

        .dark-mode .save-phone-btn {
            background: linear-gradient(135deg, #2c5364, #203a43);
            color: #e4e4e4;
        }

        .dark-mode .save-phone-btn:hover {
            background: linear-gradient(135deg, #4ecdc4, #00ffe7);
            color: #111827;
        }

        .dark-mode .cancel-phone-btn {
            background: #2a2a2a;
            color: #dc3545;
            border: 2px solid #dc3545;
        }

        .dark-mode .cancel-phone-btn:hover {
            background: #dc3545;
            color: #fff;
        }

        /* MODAL FOTO */
        .dark-mode .modal-content {
            background: #1e1e1e !important;
            color: #e4e4e4;
            border: 1px solid #333;
        }

        .dark-mode .modal-header,
        .dark-mode .modal-footer {
            background: #1e1e1e !important;
            color: #e4e4e4;
            border-color: #333;
        }

        .dark-mode .foto-preview-container {
            border: 3px solid #4ecdc4;
            box-shadow: 0 4px 15px rgba(0,0,0,0.5);
        }

        .dark-mode .foto-placeholder {
            background: linear-gradient(135deg, #2c5364, #203a43);
            color: #e4e4e4;
        }

        /* INPUTS INVALIDOS */
        .dark-mode .form-control.is-invalid,
        .dark-mode .phone-input.is-invalid {
            border-color: #dc3545;
            background-color: #3a1e1e;
            color: #ff6b6b;
        }

        .dark-mode .invalid-feedback {
            color: #ff6b6b;
        }

        /* MEDIA QUERIES */
        @media (max-width: 768px) {
            .dark-mode .profile-header {
                flex-direction: column;
                text-align: center;
            }

            .dark-mode .profile-photo {
                width: 100px;
                height: 100px;
            }

            .dark-mode .profile-name h2 {
                font-size: 1.5rem;
            }
        }
        /* ================= DARK MODE AJUSTES ================= */

        /* TITULO PERFIL */
        .dark-mode h1.text-center {
            color: #4ecdc4 !important; /* mismo color que el título del formulario */
        }

        /* ELIMINAR BORDES INTERNOS DEL FORMULARIO */
        .dark-mode .profile-header,
        .dark-mode .profile-details,
        .dark-mode .detail-item {
            border: none !important;
        }

        /* LABELS MÁS VISIBLES */
        .dark-mode .formulario .form-label,
        .dark-mode .detail-label {
            color: #e0e0e0 !important; /* color más brillante para destacar sobre fondo oscuro */
            font-weight: 600;
        }

        /* Quitar cuadro interno dentro del formulario */
        .dark-mode .profile-card {
            background: transparent !important;
            box-shadow: none !important;
            border: none !important;
            border-radius: 0 !important;
        }

        #modalFotoPaciente .modal-content {
            border-radius: 18px;
            border: 3px solid #24f3e2;
            box-shadow: 0 0 20px rgba(36, 243, 226, 0.4);
            overflow: hidden;
            padding: 0;
        }

        #modalFotoPaciente .modal-header {
            background: linear-gradient(90deg, #00e1ff, #00ffc8);
            color: white;
            border-radius: 20px 20px 0 0;
            border-bottom: none;
            padding: 20px 30px;
        }

        #modalFotoPaciente .modal-title {
            font-weight: 700;
            font-size: 1.3rem;
        }

        #modalFotoPaciente .modal-body {
            padding: 30px;
        }

        #modalFotoPaciente .modal-footer {
            border-top: none;
            padding: 20px 30px;
            display: flex;
            justify-content: center;
            gap: 12px;
        }

        #modalFotoPaciente .btn-close {
            filter: brightness(0) invert(1);
        }
        #modalFotoPaciente .form-control {
            border: 2px solid #24f3e2;
            border-radius: 12px;
            background: #fff;
            padding: 10px 14px;
            font-size: 1rem;
            width: 100%;
            box-shadow: 0 0 12px rgba(36, 243, 226, 0.2);
            transition: 0.2s;
            outline: none;
        }

        #modalFotoPaciente .form-control:focus {
            border-color: #00f3ff;
            box-shadow: 0 0 10px rgba(0, 243, 255, 0.42);
        }

    </style>
    <br><br>
    <h1 class="text-center text-info-emphasis" >Mi Perfil</h1>
    <div class="formulario">
        <div class="register-section">
            <div class="form-container">

                {{-- alerta de exito --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- alerta de error --}}
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif


                <div class="profile-card">
                    <div class="profile-header">
                      <div class="profile-photo-wrapper">
                        <div class="profile-photo">
                            @if($paciente->foto)
                                <img src="{{ asset('storage/' . $paciente->foto) }}" alt="Foto de perfil" id="profileImage">
                            @else
                                <span id="profileInitials">{{ strtoupper(substr($paciente->nombres, 0, 1) . substr($paciente->apellidos, 0, 1)) }}</span>
                            @endif
                        </div>

                            <!-- Botón de editar foto que abre el modal -->
                            <button type="button" class="edit-photo-btn" data-bs-toggle="modal" data-bs-target="#modalFotoPaciente" title="Cambiar foto">
                                <i class="bi bi-camera-fill"></i>
                            </button>
                        </div>

                        <div class="profile-name">
                            <h2>{{ session('paciente_nombre') }}</h2>
                            <p class="patient-badge">Paciente</p>
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">
                            Número de Identidad
                        </div>
                        <div class="detail-value">{{ $paciente->numero_identidad }}</div>
                    </div>
                    <br>
                    <div class="profile-details">
                        <div class="detail-item">
                            <div class="detail-label">
                                Fecha de Nacimiento
                            </div>
                            <div class="detail-value">
                                {{ $paciente->fecha_nacimiento}}
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">
                                Edad
                            </div>
                            <div class="detail-value">
                                @if($paciente->fecha_nacimiento)
                                    {{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age }} años
                                @endif
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">
                                Sexo
                            </div>
                            <div class="detail-value">{{ $paciente->genero }}</div>
                        </div>


                        <div class="detail-item">
                            <div class="detail-label">
                                Número de Teléfono
                            </div>

                            <!-- Modo vista -->
                            <div class="detail-value phone-view-mode" id="phoneViewMode">
                                <span>+504 {{ $paciente->telefono }}</span>
                                <i class="bi bi-pencil-fill edit-icon" onclick="activarEdicionTelefono()"></i>
                            </div>

                            <!-- Editar -->
                            <form id="telefonoForm" action="{{ route('perfil.actualizar') }}" method="POST" class="phone-edit-mode" novalidate>
                                @csrf
                                @method('PUT')
                                <div class="phone-edit-container">
                                    <span class="phone-prefix">+504</span>
                                    <input type="text"
                                           name="telefono"
                                           id="telefonoInput"
                                           class="phone-input @error('telefono') is-invalid @enderror"
                                           value="{{ old('telefono', $paciente->telefono) }}"
                                           maxlength="8"
                                           pattern="[389][0-9]{7}">
                                    <button type="submit" class="save-phone-btn">
                                        <i class="bi bi-check-lg"></i>
                                    </button>

                                    <button type="button" class="cancel-phone-btn" onclick="cancelarEdicionTelefono()">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </div>

                                @error('telefono')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </form>

                        </div>
                        <script>
                            // Mostrar formulario de edición si hay errores de validación
                            @if($errors->has('telefono'))
                            document.addEventListener('DOMContentLoaded', function() {
                                document.getElementById('phoneViewMode').style.display = 'none';
                                document.getElementById('telefonoForm').classList.add('active');
                                document.getElementById('telefonoInput').focus();
                            });
                            @endif
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PARA ACTUALIZAR FOTO DE PACIENTE -->
    <div class="modal fade" id="modalFotoPaciente" tabindex="-1" aria-labelledby="modalFotoPacienteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFotoPacienteLabel">
                        <i class="bi bi-camera-fill me-2"></i>Actualizar Foto de Perfil
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('perfil.actualizar') }}" method="POST" enctype="multipart/form-data" id="formFotoPaciente">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">

                        <!-- Vista previa de la foto actual -->
                        <div class="text-center mb-4">
                            <div class="foto-preview-container">
                                @if($paciente->foto)
                                    <img src="{{ asset('storage/' . $paciente->foto) }}"
                                         alt="Foto actual"
                                         class="foto-preview"
                                         id="fotoActualPaciente">
                                @else
                                    <div class="foto-placeholder" id="fotoPlaceholderPaciente">
                                        <i class="bi bi-person-circle"></i>
                                    </div>
                                @endif
                            </div>
                            <small class="text-muted">Foto actual</small>
                        </div>

                        <!-- Input para nueva foto -->
                        <div class="form-group-custom mb-3">
                            <label for="fotoPaciente" class="form-label">Seleccionar nueva foto </label>
                            <input type="file"
                                   class="form-control @error('foto') is-invalid @enderror"
                                   id="fotoPaciente"
                                   name="foto"
                                   accept="image/jpeg,image/jpg,image/png"
                                   onchange="previewImagePaciente(event)"
                            >

                            @error('foto')
                            <div class="invalid-feedback d-block">
                               {{ $message }}
                            </div>
                            @enderror

                            <div class="invalid-feedback" id="errorFotoPaciente">
                              Por favor selecciona una imagen válida
                            </div>

                        </div>

                        <!--Vista previa de la nueva foto -->
                        <div class="text-center mt-3" id="nuevaFotoPreviewPaciente" style="display: none;">
                            <p class="mb-2"><strong>Nueva foto:</strong></p>
                            <div class="foto-preview-container">
                                <img src="" alt="Vista previa" class="foto-preview" id="imagenPreviewPaciente">
                            </div>
                            <small class="text-muted mt-1 d-block">Vista previa</small>
                        </div>

                        <input type="hidden" name="telefono" value="{{ $paciente->telefono }}">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                        <button type="submit" class="btn-register" id="btnSubirFotoPaciente">
                            <i class="bi bi-upload me-1"></i>Subir Foto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        //Funciones para edición de teléfono
        function activarEdicionTelefono() {
            document.getElementById('phoneViewMode').classList.add('hidden');
            document.querySelector('.phone-edit-mode').classList.add('active');
            document.getElementById('telefonoInput').focus();
        }

        function cancelarEdicionTelefono() {
            document.getElementById('phoneViewMode').classList.remove('hidden');
            document.querySelector('.phone-edit-mode').classList.remove('active');
            // Restaurar valor original
            document.getElementById('telefonoInput').value = '{{ $paciente->telefono }}';
        }

        // Validación de entrada para teléfono
        document.getElementById('telefonoInput').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // FUNCIONES PARA EL MODAL DE FOTO
        function previewImagePaciente(event) {
            const input = event.target;
            const preview = document.getElementById('nuevaFotoPreviewPaciente');
            const img = document.getElementById('imagenPreviewPaciente');
            const fotoInput = document.getElementById('fotoPaciente');

            // Limpiar clases de error previas
            fotoInput.classList.remove('is-invalid');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const fileSize = file.size / 1024 / 1024; // MB
                const fileType = file.type;
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

                // Validar tipo de archivo
                if (!allowedTypes.includes(fileType)) {
                    fotoInput.classList.add('is-invalid');
                    document.getElementById('errorFotoPaciente').textContent = 'Solo se permiten archivos JPG, JPEG o PNG';
                    document.getElementById('errorFotoPaciente').classList.add('d-block');
                    input.value = '';
                    preview.style.display = 'none';
                    return;
                }

                // Validar tamaño (máximo 2MB)
                if (fileSize > 2) {
                    fotoInput.classList.add('is-invalid');
                    document.getElementById('errorFotoPaciente').textContent = 'La imagen no debe superar los 2MB';
                    document.getElementById('errorFotoPaciente').classList.add('d-block');
                    input.value = '';
                    preview.style.display = 'none';
                    return;
                }

                //  mostrar preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        }

        // Validar antes de enviar el formulario
        document.getElementById('formFotoPaciente').addEventListener('submit', function(e) {
            const fotoInput = document.getElementById('fotoPaciente');
            const btnSubmit = document.getElementById('btnSubirFotoPaciente');

            // Validar si hay archivo seleccionado
            if (!fotoInput.files || fotoInput.files.length === 0) {
                e.preventDefault();
                fotoInput.classList.add('is-invalid');
                document.getElementById('errorFotoPaciente').textContent = 'Debes seleccionar una foto';
                document.getElementById('errorFotoPaciente').classList.add('d-block');
                fotoInput.focus();
                return false;
            }

            const file = fotoInput.files[0];
            const fileSize = file.size / 1024 / 1024; // MB
            const fileType = file.type;
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

            // Validar tipo
            if (!allowedTypes.includes(fileType)) {
                e.preventDefault();
                fotoInput.classList.add('is-invalid');
                document.getElementById('errorFotoPaciente').textContent = 'Solo se permiten archivos JPG, JPEG o PNG';
                document.getElementById('errorFotoPaciente').classList.add('d-block');
                fotoInput.focus();
                return false;
            }

            // Validar tamaño
            if (fileSize > 2) {
                e.preventDefault();
                fotoInput.classList.add('is-invalid');
                document.getElementById('errorFotoPaciente').textContent = 'La imagen no debe superar los 2MB';
                document.getElementById('errorFotoPaciente').classList.add('d-block');
                fotoInput.focus();
                return false;
            }

            //  deshabilitar botón y mostrar loading
            fotoInput.classList.remove('is-invalid');
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Subiendo...';

            return true;
        });

        // Limpiar validación al cambiar archivo
        document.getElementById('fotoPaciente').addEventListener('change', function() {
            if (this.files.length > 0) {
                this.classList.remove('is-invalid');
                document.getElementById('errorFotoPaciente').classList.remove('d-block');
            }
        });

        // Mantener modal abierto si hay errores de validación
        document.addEventListener('DOMContentLoaded', function() {
            @if($errors->has('foto'))
            var modal = new bootstrap.Modal(document.getElementById('modalFotoPaciente'));
            modal.show();
            @endif
        });

        // Ocultar alertas después de 5 segundos
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.3s ease';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 300);
            });
        }, 5000);
    </script>

    {{-- Modal éxito foto --}}
    @if(session('foto_success'))
        <div class="modal fade" id="modalFotoExito" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 380px;">
                <div class="modal-content" style="border-radius: 18px; border: 3px solid #24f3e2; box-shadow: 0 0 20px rgba(36, 243, 226, 0.4); overflow: hidden; padding: 0;">

                    <div class="modal-header" style="background: linear-gradient(90deg, #00e1ff, #00ffc8); border-bottom: none; padding: 20px 30px;">
                        <h5 class="modal-title fw-bold text-white" style="font-size: 1.1rem;">
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                style="filter: brightness(0) invert(1);"></button>
                    </div>

                    <div class="modal-body text-center px-4 pt-4 pb-2">
                        <div style="width: 60px; height: 60px; background: #e6faf7;
                        border-radius: 50%; display: flex; align-items: center;
                        justify-content: center; margin: 0 auto 1rem;
                        border: 2px solid #00bfa6;">
                            <i class="bi bi-check-lg" style="font-size: 1.8rem; color: #00bfa6;"></i>
                        </div>
                        <h6 class="fw-bold mb-1" style="color: #222;">¡Listo!</h6>
                        <p class="text-muted mb-0" style="font-size: 0.9rem;">
                            {{ session('foto_success') }}
                        </p>
                    </div>

                    <div class="modal-footer border-0 justify-content-center pt-2 pb-4">
                        <button type="button" data-bs-dismiss="modal"
                                style="background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%); color: white; border: none;
                               padding: 0.5rem 2.5rem; border-radius: 8px;
                               font-size: 0.95rem; font-weight: 500; cursor: pointer;">
                            Aceptar
                        </button>
                    </div>

                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                new bootstrap.Modal(document.getElementById('modalFotoExito')).show();
            });
        </script>
    @endif

    {{-- Modal error foto --}}
    @if(session('foto_error'))
        <div class="modal fade" id="modalFotoError" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content border-0 shadow" style="border-radius: 12px; overflow: hidden;">
                    <div style="height: 6px; background: linear-gradient(90deg, #dc3545, #b02a37);"></div>
                    <div class="modal-body text-center px-4 pt-4 pb-2">
                        <div style="width: 60px; height: 60px; background: #fdecea;
                            border-radius: 50%; display: flex; align-items: center;
                            justify-content: center; margin: 0 auto 1rem;
                            border: 2px solid #dc3545;">
                            <i class="bi bi-x-lg" style="font-size: 1.8rem; color: #dc3545;"></i>
                        </div>
                        <h6 class="fw-bold mb-1" style="color: #222;">¡Error!</h6>
                        <p class="text-muted mb-0" style="font-size: 0.9rem;">
                            {{ session('foto_error') }}
                        </p>
                    </div>
                    <div class="modal-footer border-0 justify-content-center pt-2 pb-4">
                        <button type="button" data-bs-dismiss="modal"
                                style="background: #dc3545; color: white; border: none;
                               padding: 0.5rem 2.5rem; border-radius: 8px;
                               font-size: 0.95rem; font-weight: 500; cursor: pointer;">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                new bootstrap.Modal(document.getElementById('modalFotoError')).show();
            });
        </script>
    @endif
@endsection
