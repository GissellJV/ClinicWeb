@extends('layouts.plantillaRecepcion')
<link rel="stylesheet" href="{{ asset('css/formulario.css') }}">
@section('contenido')
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Crear Expediente Médico</title>

        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
@section('contenido')
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Crear Expediente Médico</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }

            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: whitesmoke;
                min-height: 100vh;
                padding: 20px;
            }
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background:whitesmoke;

                min-height: 100vh;
                padding: 20px;
            }

            /* Botón de navegación navbar-toggler */
            .navbar-toggler {
                padding: 0.25rem 0.75rem;
                font-size: 1.25rem;
                line-height: 1;
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
            .navbar-toggler {
                padding: 0.25rem 0.75rem;
                font-size: 1.25rem;
                line-height: 1;
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

            .expediente-container {
                background: white;
                border-radius: 20px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
                max-width: 1200px;
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

            .expediente-header {
                background: linear-gradient(135deg, #4ECDC4, #2b8c84);
                padding: 30px 40px;
                text-align: center;
                color: white;
            }

            .logo-container {
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 20px;
            }

            .logo {
                width: 50px;
                height: 50px;
                background: rgba(255, 255, 255, 0.2);
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-right: 15px;
                backdrop-filter: blur(10px);
            }

            .logo::before {
                content: '+';
                color: white;
                font-size: 2rem;
                font-weight: bold;
            }

            .logo-text {
                font-size: 1.8rem;
                font-weight: bold;
                color: white;
            }

            .expediente-header h1 {
                font-size: 1.6rem;
                margin-bottom: 8px;
                font-weight: 600;
            }

            .expediente-header p {
                font-size: 0.95rem;
                opacity: 0.9;
            }

            .expediente-form {
                padding: 30px 40px 40px 40px;
            }

            .alert {
                padding: 15px;
                border-radius: 10px;
                margin-bottom: 25px;
                font-weight: 500;
            }

            .alert-success {
                background: #d4edda;
                color: #155724;
                border: 1px solid #c3e6cb;
            }

            .alert-danger {
                background: #f8d7da;
                color: #721c24;
                border: 1px solid #f5c6cb;
            }

            .section-title {
                color: #2c3e50;
                font-size: 1.3rem;
                font-weight: 600;
                margin: 30px 0 20px 0;
                padding-bottom: 10px;
                border-bottom: 2px solid #4ECDC4;
            }

            .form-row {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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

            .input-wrapper input,
            .input-wrapper select,
            .input-wrapper textarea {
                width: 100%;
                padding: 14px 16px;
                border: 2px solid #e8f4f3;
                border-radius: 12px;
                font-size: 1rem;
                transition: all 0.3s ease;
                background: #f8fffe;
            }

            .input-wrapper input:focus,
            .input-wrapper select:focus,
            .input-wrapper textarea:focus {
                outline: none;
                border-color: #4ECDC4;
                background: white;
                box-shadow: 0 0 0 4px rgba(78, 205, 196, 0.1);
            }

            .input-wrapper input:hover,
            .input-wrapper select:hover,
            .input-wrapper textarea:hover {
                border-color: #4ECDC4;
            }

            .input-wrapper input[readonly] {
                background-color: #f8f9fa;
                color: #6c757d;
                cursor: not-allowed;
            }

            .form-text {
                font-size: 0.8rem;
                color: #6c757d;
                margin-top: 5px;
            }

            .checkbox-group {
                display: flex;
                align-items: center;
                margin-top: 25px;
            }

            .checkbox-group input[type="checkbox"] {
                width: 20px;
                height: 20px;
                margin-right: 10px;
                cursor: pointer;
            }

            .checkbox-group label {
                margin: 0;
                cursor: pointer;
                font-weight: 500;
                color: #2c3e50;
            }

            .button-group {
                display: flex;
                gap: 15px;
                margin-top: 40px;
                justify-content: flex-end;
            }
            .full-width {
                grid-column: 1 / -1;
            }

            textarea {
                resize: vertical;
                min-height: 80px;
            }

            /* ESTILOS MEJORADOS PARA LOS BOTONES */
            .button-group {
                display: flex;
                gap: 1rem;
                justify-content: flex-end;
                margin-top: 2rem;
                padding-top: 1rem;
                border-top: 1px solid #e2e8f0;
            }

            .btn {
                padding: 12px 24px;
                border: none;
                border-radius: 8px;
                font-size: 1rem;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.3s ease;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }
            .btn-cancel,
            .btn-register {
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 0;
                height: 56px;
                flex: 0 0 220px;
                box-sizing: border-box;
                font-size: 1rem;
                font-weight: 600;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                border-radius: 10px;
                cursor: pointer;
                transition: all 0.3s ease;
                text-decoration: none;
                white-space: nowrap;
                gap: 0.5rem;
            }

            /* Botón Cancelar */
            .btn-cancel {
                background: white;
                color: #e74c3c;
                border: 2px solid #e74c3c;
            }

            .btn-primary {
                background: #007bff;
                color: white;
                border: 1px solid #007bff;
            }
            .btn-cancel:hover {
                background: #e74c3c;
                color: white;
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
            }

            .btn-primary:hover {
                background: #0056b3;
                border-color: #0056b3;
            }
            .btn-cancel:active {
                transform: translateY(0);
            }

            .btn-secondary {
                background: #6c757d;
                color: white;
                border: 1px solid #6c757d;
            }

            .btn-secondary:hover {
                background: #545b62;
                border-color: #545b62;
            }
            /* Botón Guardar */
            .btn-register {
                background: linear-gradient(135deg, #4ECDC4, #2b8c84);
                color: white;
                box-shadow: 0 2px 8px rgba(78, 205, 196, 0.3);
            }

            .btn-register:hover {
                background: linear-gradient(135deg, #45b8b0, #237a72);
                transform: translateY(-1px);
                box-shadow: 0 6px 16px rgba(78, 205, 196, 0.4);
            }
            .full-width {
                grid-column: 1 / -1;
            }

            textarea {
                resize: vertical;
                min-height: 80px;
            }
            .btn-register:active {
                transform: translateY(0);
            }

            .text-info-emphasis {
                font-weight: bold;
            }

            /* =========================
               MODAL SELECTOR CLINICWEB
            ========================= */

            .modal-selector .modal-content.selector-content {
                background: #fff;
                border: 3px solid #24f3e2;
                box-shadow: 0 0 20px rgba(36, 243, 226, 0.4);
                border-radius: 18px;
                overflow: hidden;
                padding: 0;
                animation: popSelector 0.25s ease-out;
            }

            @keyframes popSelector {
                0% {
                    transform: scale(.7);
                    opacity: 0;
                }
                100% {
                    transform: scale(1);
                    opacity: 1;
                }
            }

            .modal-selector .selector-header {
                background: linear-gradient(90deg, #00e1ff, #00ffc8);
                padding: 15px 20px;
                border-bottom: none;
            }

            .modal-selector .modal-title {
                color: #fff;
                margin: 0;
                font-size: 26px;
                font-weight: 800;
            }

            .modal-selector .selector-close {
                filter: brightness(0) invert(1);
                transition: transform .35s ease, opacity .3s ease;
                opacity: 0.9;
            }

            .modal-selector .selector-close:hover {
                transform: rotate(180deg);
                opacity: 1;
            }

            .modal-selector .selector-body {
                padding: 24px 24px 18px;
                background: #fff;
            }

            .modal-selector .selector-footer {
                border-top: 1px solid #e5e5e5;
                padding: 18px 24px 22px;
                display: flex;
                justify-content: center;
                gap: 14px;
                background: #fff;
            }

            .table-container-modal {
                background-color: white;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
                padding: 20px;
            }

            .modal-selector table.dataTable {
                width: 100% !important;
                border-collapse: collapse;
            }

            .modal-selector table.dataTable thead th {
                padding: 20px;
                text-align: left;
                font-weight: 700;
                font-size: 13px;
                letter-spacing: 0.5px;
                text-transform: uppercase;
                border-bottom: 2px solid #e0e0e0;
                color: white !important;
                background: #4ecdc4 !important;
            }

            .modal-selector table.dataTable tbody tr {
                border-bottom: 1px solid #f0f0f0;
                transition: all 0.2s;
            }

            .modal-selector table.dataTable tbody tr:hover {
                background: #f8f9fa;
            }

            .modal-selector table.dataTable tbody td {
                padding: 18px;
                color: #666;
                vertical-align: middle;
            }

            .modal-selector .dataTables_wrapper .dataTables_length,
            .modal-selector .dataTables_wrapper .dataTables_filter {
                margin-bottom: 20px;
            }

            .modal-selector .dataTables_wrapper .dataTables_filter input {
                border: 2px solid #e0e0e0;
                border-radius: 8px;
                padding: 8px 15px;
                margin-left: 10px;
            }

            .modal-selector .dataTables_wrapper .dataTables_filter input:focus {
                outline: none;
                border-color: #4ecdc4;
                box-shadow: 0 0 0 0.25rem rgba(78, 205, 196, 0.25);
            }

            .modal-selector .dataTables_wrapper .dataTables_length select {
                border: 2px solid #e0e0e0;
                border-radius: 8px;
                padding: 5px 10px;
                margin: 0 10px;
            }

            .modal-selector .dataTables_wrapper .dataTables_paginate .paginate_button {
                padding: 8px 12px !important;
                border-radius: 8px !important;
                transition: all 0.3s !important;
                box-shadow: none !important;
                font-weight: 600 !important;
            }

            .modal-selector .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
                color: white !important;
                box-shadow: none !important;
                transform: translateY(-2px);
            }

            .modal-selector .dataTables_wrapper .dataTables_paginate .paginate_button.current {
                background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%) !important;
                color: white !important;
                border-color: #4ecdc4 !important;
            }

            .modal-selector .dataTables_wrapper .dataTables_info {
                font-size: 14px;
                padding-top: 15px;
            }

            .btn-modal-seleccionar {
                padding: 8px 20px;
                border-radius: 5px;
                text-decoration: none;
                display: inline-block;
                transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
                font-size: 13px;
                font-weight: 500;
                text-align: center;
                min-width: 120px;
                cursor: pointer;
                white-space: nowrap;
                background: linear-gradient(135deg, #4ecdc4 0%, #44b8af 100%);
                color: white;
                border: none;
            }

            .btn-modal-seleccionar:hover {
                background: linear-gradient(135deg, #44b8af 0%, #3aa39a 100%);
                box-shadow: 0 3px 10px rgba(78, 205, 196, 0.25);
                color: white;
            }

            .btn-cancel-modal {
                padding: 0.875rem 2rem;
                background: white;
                border: 2px solid #131212;
                border-radius: 8px;
                color: #221414;
                font-weight: 600;
                font-size: 1.05rem;
                transition: all 0.3s ease;
            }

            .btn-cancel-modal:hover {
                background: #dc3545;
                color: white;
                transform: translateY(-2px);
                box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
            }

            .btn-open-selector {
                padding: 12px 18px;
                background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
                border: none;
                border-radius: 12px;
                color: white;
                font-weight: 600;
                font-size: 1rem;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(78, 205, 196, 0.3);
                white-space: nowrap;
                cursor: pointer;
            }

            .btn-open-selector:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
                color: white;
            }

            #paciente_nombre {
                border: 2px solid #24f3e2 !important;
                border-radius: 14px !important;
                background: white !important;
                padding: 14px 16px !important;
                font-size: 1rem !important;
                box-shadow: 0 0 12px rgba(36, 243, 226, 0.20);
                transition: 0.2s;
                color: #555 !important;
            }

            #paciente_nombre:hover {
                box-shadow: 0 0 18px rgba(36, 243, 226, 0.30);
            }

            .selector-inline {
                display: flex;
                gap: 12px;
                align-items: center;
            }

            @media (max-width: 768px) {
                .expediente-form {
                    padding: 20px;
                }
            @media (max-width: 768px) {
                .expediente-form {
                    padding: 20px;
                }

                .expediente-header {
                    padding: 20px;
                }

                .form-row {
                    grid-template-columns: 1fr;
                }

                .button-group {
                    flex-direction: column;
                }

                .logo-text {
                    font-size: 1.4rem;
                }
                .logo-text {
                    font-size: 1.4rem;
                }

                .expediente-header h1 {
                    font-size: 1.3rem;
                }
            }
                .expediente-header h1 {
                    font-size: 1.3rem;
                }

                .selector-inline {
                    flex-direction: column;
                    align-items: stretch;
                }

                .btn-open-selector {
                    width: 100%;
                }
            }

            /* Responsive para botones en móviles */
            @media (max-width: 640px) {
                .button-group {
                    flex-direction: column-reverse;
                    gap: 0.75rem;
                }

                .btn-cancel,
                .btn-register {
                    width: 100%;
                    min-width: unset;
                    padding: 0.875rem 1.5rem;
                }
            }

            @media (max-width: 480px) {
                body {
                    padding: 10px;
                }
            }

            .text-info-emphasis{
                font-weight: bold;
            }
        </style>
    </head>
    <body>
    <!-- Botón de navegación navbar-toggler -->
    <div class="formulario">
        <br><br><br><br><br>
        <h1 class="text-center text-info-emphasis">Crear Nuevo Expediente Médico</h1>
            @media (max-width: 480px) {
                body {
                    padding: 10px;
                }
            }
        </style>
    </head>
    <body>
    <div class="formulario">
        <br><br><br><br><br>
        <h1 class="text-center text-info-emphasis">Crear Nuevo Expediente Médico</h1>

        <div class="form-container" style="margin: 10px auto; max-width: 900px">
            <div class="expediente-form">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
        <div class="form-container" style="margin: 10px auto; max-width: 900px">

            <div class="expediente-form">
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

                <form action="{{ route('expedientes.guardar') }}" method="POST" id="expedienteForm">
                    @csrf

                    <h3 class="section-title">Información del Expediente</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="numero_expediente">Número de Expediente</label>
                            <div class="input-wrapper">
                                <input type="text" class="form-control" id="numero_expediente" value="{{ $numero_expediente }}" readonly>
                            </div>
                            <small class="form-text text-muted">Generado automáticamente</small>
                        </div>
                    <!-- Información del Expediente -->
                    <h3 class="section-title">Información del Expediente</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="numero_expediente">Número de Expediente</label>
                            <div class="input-wrapper">
                                <input type="text" class="form-control" id="numero_expediente" value="{{ $numero_expediente }}" readonly>
                            </div>
                            <small class="form-text text-muted">Generado automáticamente</small>
                        </div>

                        <div class="form-group">
                            @if($pacienteSeleccionado)
                                <label for="paciente_id">Paciente</label>
                            @else
                                <label for="paciente_id">Seleccionar Paciente *</label>
                            @endif

                            <div class="input-wrapper">
                                @if($pacienteSeleccionado)
                                    <input
                                        type="text"
                                        class="form-control"
                                        value="{{ $pacienteSeleccionado->nombres }} - {{ $pacienteSeleccionado->numero_identidad }}"
                                        readonly
                                    >
                                    <input type="hidden" name="paciente_id" value="{{ $pacienteSeleccionado->id }}">
                                @else
                                    <input type="hidden" id="paciente_id" name="paciente_id" value="{{ $paciente_id }}" required>

                                    <div class="selector-inline">
                                        <input
                                            type="text"
                                            id="paciente_nombre"
                                            class="form-control"
                                            placeholder="Seleccione un paciente"
                                            readonly
                                            required
                                        >

                                        <button
                                            type="button"
                                            class="btn-open-selector"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalPacientes"
                                        >
                                            Buscar
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                        <div class="form-group">
                            @if($pacienteSeleccionado)
                                <label for="paciente_id"> Paciente </label>
                            @else
                                <label for="paciente_id">Seleccionar Paciente *</label>
                            @endif
                            <div class="input-wrapper">
                                @if($pacienteSeleccionado)
                                    {{-- SI YA EXISTE UN PACIENTE SELECCIONADO, DESDE EL BOTON CREAR EXPEDIENTE--}}

                                    <input type="text" class="form-control"
                                           value="{{ $pacienteSeleccionado->nombres }} - {{ $pacienteSeleccionado->numero_identidad }}"
                                           readonly>
                                    <input type="hidden" name="paciente_id" value="{{ $pacienteSeleccionado->id }}">
                                @else
                                    <select class="form-control" id="paciente_id" name="paciente_id" required>
                                        <option value="">Seleccione un paciente</option>
                                        @foreach($pacientes as $paciente)
                                            <option value="{{ $paciente->id }}" {{ $paciente_id == $paciente->id ? 'selected' : '' }}>
                                                {{ $paciente->nombres }} - {{ $paciente->numero_identidad }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Signos Vitales -->
                    <h3 class="section-title">Signos Vitales</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="peso">Peso (kg)</label>
                            <div class="input-wrapper">
                                <input type="number" step="0.1" class="form-control" id="peso" name="peso" placeholder="Ej: 70.5">
                            </div>
                        </div>
                    <h3 class="section-title">Signos Vitales</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="peso">Peso (kg)</label>
                            <div class="input-wrapper">
                                <input type="number" step="0.1" class="form-control" id="peso" name="peso" placeholder="Ej: 70.5">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="altura">Altura (m)</label>
                            <div class="input-wrapper">
                                <input type="number" step="0.01" class="form-control" id="altura" name="altura" placeholder="Ej: 1.75">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="temperatura">Temperatura (°C)</label>
                            <div class="input-wrapper">
                                <input type="text" class="form-control" id="temperatura" name="temperatura" placeholder="Ej: 36.5">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="presion_arterial">Presión Arterial</label>
                            <div class="input-wrapper">
                                <input type="text" class="form-control" id="presion_arterial" name="presion_arterial" placeholder="Ej: 120/80">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="frecuencia_cardiaca">Frecuencia Cardíaca</label>
                            <div class="input-wrapper">
                                <input type="text" class="form-control" id="frecuencia_cardiaca" name="frecuencia_cardiaca" placeholder="Ej: 72 lpm">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="checkbox-group">
                                <input class="form-check-input" type="checkbox" id="tiene_fiebre" name="tiene_fiebre" value="1">
                                <label class="form-check-label" for="tiene_fiebre">¿Tiene fiebre?</label>
                            </div>
                        </div>
                    </div>

                    <h3 class="section-title">Información Médica</h3>
                    <div class="form-group full-width">
                        <label for="sintomas_actuales">Síntomas Actuales</label>
                        <div class="input-wrapper">
                            <textarea class="form-control" id="sintomas_actuales" name="sintomas_actuales" rows="3" placeholder="Describa los síntomas que presenta el paciente"></textarea>
                        </div>
                    </div>
                    <!-- Síntomas y Diagnóstico -->
                    <h3 class="section-title">Información Médica</h3>
                    <div class="form-group full-width">
                        <label for="sintomas_actuales">Síntomas Actuales</label>
                        <div class="input-wrapper">
                            <textarea class="form-control" id="sintomas_actuales" name="sintomas_actuales" rows="3" placeholder="Describa los síntomas que presenta el paciente"></textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="diagnostico">Diagnóstico</label>
                            <div class="input-wrapper">
                                <textarea class="form-control" id="diagnostico" name="diagnostico" rows="3" placeholder="Diagnóstico médico"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tratamiento">Tratamiento</label>
                            <div class="input-wrapper">
                                <textarea class="form-control" id="tratamiento" name="tratamiento" rows="3" placeholder="Tratamiento prescrito"></textarea>
                            </div>
                        </div>
                    </div>

                    <h3 class="section-title">Antecedentes</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="alergias">Alergias</label>
                            <div class="input-wrapper">
                                <textarea class="form-control" id="alergias" name="alergias" rows="2" placeholder="Lista de alergias conocidas"></textarea>
                            </div>
                        </div>
                    <!-- Antecedentes -->
                    <h3 class="section-title">Antecedentes</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="alergias">Alergias</label>
                            <div class="input-wrapper">
                                <textarea class="form-control" id="alergias" name="alergias" rows="2" placeholder="Lista de alergias conocidas"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="medicamentos_actuales">Medicamentos Actuales</label>
                            <div class="input-wrapper">
                                <textarea class="form-control" id="medicamentos_actuales" name="medicamentos_actuales" rows="2" placeholder="Medicamentos que toma actualmente"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="antecedentes_familiares">Antecedentes Familiares</label>
                            <div class="input-wrapper">
                                <textarea class="form-control" id="antecedentes_familiares" name="antecedentes_familiares" rows="3" placeholder="Enfermedades hereditarias o familiares"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="antecedentes_personales">Antecedentes Personales</label>
                            <div class="input-wrapper">
                                <textarea class="form-control" id="antecedentes_personales" name="antecedentes_personales" rows="3" placeholder="Enfermedades previas, cirugías, etc."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label for="observaciones">Observaciones Generales</label>
                        <div class="input-wrapper">
                            <textarea class="form-control" id="observaciones" name="observaciones" rows="3" placeholder="Observaciones adicionales"></textarea>
                        </div>
                    </div>
                    <!-- Observaciones -->
                    <div class="form-group full-width">
                        <label for="observaciones">Observaciones Generales</label>
                        <div class="input-wrapper">
                            <textarea class="form-control" id="observaciones" name="observaciones" rows="3" placeholder="Observaciones adicionales"></textarea>
                        </div>
                    </div>

                    <div class="button-group">
                        <a href="{{ route('recepcionista.busquedaexpediente') }}" class="btn-cancel" style="text-decoration-line: none">
                            Cancelar
                        </a>
                        <button type="submit" class="btn-register">
                            Guardar Expediente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(!$pacienteSeleccionado)
        <div class="modal fade modal-selector" id="modalPacientes" tabindex="-1" aria-labelledby="modalPacientesLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content selector-content">
                    <div class="modal-header selector-header">
                        <h5 class="modal-title" id="modalPacientesLabel">Seleccionar Paciente</h5>
                        <button type="button" class="btn-close selector-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- BOTONES MEJORADOS -->
                    <div class="button-group">
                        <a href="{{ route('recepcionista.busquedaexpediente') }}" class="btn-cancel">
                            Cancelar
                        </a>
                        <button type="submit" class="btn-register">
                            Guardar Expediente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

                    <div class="modal-body selector-body">
                        <div class="table-container-modal">
                            <table id="tablaPacientesModal" class="table table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Identidad</th>
                                    <th>Nombres</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($pacientes as $paciente)
                                    <tr>
                                        <td>{{ $paciente->id }}</td>
                                        <td>{{ $paciente->numero_identidad ?? 'Sin identidad' }}</td>
                                        <td>{{ $paciente->nombres }}</td>
                                        <td>
                                            <button
                                                type="button"
                                                class="btn-modal-seleccionar seleccionar-paciente"
                                                data-id="{{ $paciente->id }}"
                                                data-nombre="{{ $paciente->nombres }} - {{ $paciente->numero_identidad }}"
                                            >
                                                Seleccionar
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="modal-footer selector-footer">
                        <button type="button" class="btn-cancel-modal" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        const formulario = document.getElementById('expedienteForm');

        @if(!$pacienteSeleccionado)
        const pacienteInput = document.getElementById('paciente_id');
        const pacienteNombreInput = document.getElementById('paciente_nombre');

        const tablaPacientes = $('#tablaPacientesModal').DataTable({
            responsive: true,
            autoWidth: false,
            language: {
                processing: "Procesando...",
                search: "Buscar:",
                lengthMenu: "Mostrar _MENU_ registros",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                infoEmpty: "Mostrando 0 a 0 de 0 registros",
                infoFiltered: "(filtrado de _MAX_ registros totales)",
                loadingRecords: "Cargando...",
                zeroRecords: "No se encontraron registros",
                emptyTable: "No hay pacientes disponibles",
                paginate: {
                    first: "Primero",
                    previous: "Anterior",
                    next: "Siguiente",
                    last: "Último"
                }
            },
            pageLength: 10,
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            columnDefs: [
                {
                    targets: 3,
                    orderable: false,
                    searchable: false
                }
            ]
        });

        function enlazarBotonesPaciente() {
            document.querySelectorAll('.seleccionar-paciente').forEach(boton => {
                boton.addEventListener('click', function () {
                    pacienteInput.value = this.dataset.id;
                    pacienteNombreInput.value = this.dataset.nombre;

                    const modalElement = document.getElementById('modalPacientes');
                    const modalInstance = bootstrap.Modal.getOrCreateInstance(modalElement);
                    modalInstance.hide();
                });
            });
        }

        enlazarBotonesPaciente();

        $('#modalPacientes').on('shown.bs.modal', function () {
            tablaPacientes.columns.adjust().responsive.recalc();
        });

        @if($paciente_id)
            @foreach($pacientes as $paciente)
            @if($paciente_id == $paciente->id)
            pacienteNombreInput.value = @json($paciente->nombres . ' - ' . $paciente->numero_identidad);
        @endif
        @endforeach
        @endif
        @endif
    <script>
        // Validación del formulario
        const formulario = document.getElementById('expedienteForm');
        const pacienteSelect = document.getElementById('paciente_id');

        formulario.addEventListener('submit', function(e) {
            if (!pacienteSelect.value) {
                e.preventDefault();
                alert('Por favor, seleccione un paciente');
                pacienteSelect.focus();
                return false;
            }
        });
    </script>
    </body>
    </html>
        formulario.addEventListener('submit', function(e) {
            @if(!$pacienteSeleccionado)
            if (!pacienteInput.value) {
                e.preventDefault();
                alert('Por favor, seleccione un paciente');
                return false;
            }
            @endif
        });
    </script>
    </body>
    </html>
@endsection
