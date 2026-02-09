@extends('layouts.plantillaEnfermeria')

@section('titulo', 'Detalle del Incidente')

@section('contenido')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background: #f0f4f8;
            min-height: 100vh;
            padding: 20px;
        }

        .detalle-container {
            max-width: 1000px;
            margin: 40px auto;
        }

        .detalle-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .detalle-header {
            background: linear-gradient(135deg, #4ECDC4 0%, #44A08D 100%);
            padding: 30px;
            color: white;
        }

        .detalle-header h1 {
            font-size: 1.8rem;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .detalle-body {
            padding: 40px;
        }

        .info-section {
            margin-bottom: 30px;
        }

        .info-section h5 {
            color: #4ECDC4;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #4ECDC4;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .info-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid #4ECDC4;
        }

        .info-label {
            font-weight: 600;
            color: #555;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .info-value {
            color: #2c3e50;
            font-size: 1.1rem;
        }

        .descripcion-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #4ECDC4;
            margin-top: 15px;
        }

        .descripcion-box p {
            margin: 0;
            line-height: 1.6;
            color: #2c3e50;
        }

        .badge-detalle {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.95rem;
            display: inline-block;
        }

        .badge-leve {
            background: #d4edda;
            color: #155724;
        }

        .badge-moderado {
            background: #fff3cd;
            color: #856404;
        }

        .badge-grave {
            background: #ffeaa7;
            color: #b8650b;
        }

        .badge-critico {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-pendiente {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-revision {
            background: #fff3cd;
            color: #856404;
        }

        .badge-resuelto {
            background: #d4edda;
            color: #155724;
        }

        .estado-form {
            background: #e7f9f7;
            padding: 25px;
            border-radius: 15px;
            border: 2px solid #4ECDC4;
            margin-top: 20px;
        }

        .estado-form h6 {
            color: #4ECDC4;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .btn-actualizar {
            background: linear-gradient(135deg, #4ECDC4 0%, #44A08D 100%);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-actualizar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
        }

        .btn-volver {
            background: #6c757d;
            color: white;
            padding: 12px 30px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-volver:hover {
            background: #5a6268;
            color: white;
        }

        .alert-success-detalle {
            background: #d4edda;
            border-left: 4px solid #28a745;
            color: #155724;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }

            .detalle-body {
                padding: 25px;
            }
        }
    </style>

    <div class="detalle-container">
        <div class="detalle-card">
            <!-- Header -->
            <div class="detalle-header">
                <h1>
                    <i class="fas fa-file-medical"></i>
                    Detalle del Incidente #{{ str_pad($incidente->id, 4, '0', STR_PAD_LEFT) }}
                </h1>
                <p style="margin: 0; opacity: 0.9;">
                    Registrado el {{ $incidente->created_at->format('d/m/Y \a \l\a\s H:i') }}
                </p>
            </div>

            <!-- Body -->
            <div class="detalle-body">
                <!-- Alerta de Éxito -->
                @if(session('success'))
                    <div class="alert-success-detalle">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                <!-- Información General -->
                <div class="info-section">
                    <h5><i class="fas fa-info-circle"></i> Información General</h5>

                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Fecha y Hora del Incidente</div>
                            <div class="info-value">
                                {{ \Carbon\Carbon::parse($incidente->fecha_hora_incidente)->format('d/m/Y H:i') }}
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Tipo de Incidente</div>
                            <div class="info-value">{{ $incidente->tipo_incidente }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Gravedad</div>
                            <div class="info-value">
                            <span class="badge-detalle badge-{{ strtolower($incidente->gravedad) }}">
                                {{ $incidente->gravedad }}
                            </span>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Estado Actual</div>
                            <div class="info-value">
                            <span class="badge-detalle badge-{{ $incidente->estado == 'Pendiente' ? 'pendiente' : ($incidente->estado == 'En Revisión' ? 'revision' : 'resuelto') }}">
                                {{ $incidente->estado }}
                            </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Personas Involucradas -->
                <div class="info-section">
                    <h5><i class="fas fa-users"></i> Personas Involucradas</h5>

                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Paciente</div>
                            <div class="info-value">
                                {{ $incidente->paciente->nombres }} {{ $incidente->paciente->apellidos }}
                            </div>
                            <small class="text-muted">ID: {{ $incidente->paciente->numero_identidad }}</small>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Reportado Por</div>
                            <div class="info-value">{{ $incidente->empleado_nombre }}</div>
                            <small class="text-muted">Enfermero(a)</small>
                        </div>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="info-section">
                    <h5><i class="fas fa-file-alt"></i> Descripción del Incidente</h5>
                    <div class="descripcion-box">
                        <p>{{ $incidente->descripcion }}</p>
                    </div>
                </div>

                <!-- Acciones Tomadas -->
                @if($incidente->acciones_tomadas)
                    <div class="info-section">
                        <h5><i class="fas fa-tasks"></i> Acciones Tomadas</h5>
                        <div class="descripcion-box">
                            <p>{{ $incidente->acciones_tomadas }}</p>
                        </div>
                    </div>
                @endif

                <!-- Cambiar Estado -->
                <div class="info-section">
                    <div class="estado-form">
                        <h6><i class="fas fa-sync-alt"></i> Actualizar Estado del Incidente</h6>
                        <form action="{{ route('incidentes.actualizar-estado', $incidente->id) }}" method="POST" class="row g-3">
                            @csrf
                            @method('PUT')
                            <div class="col-md-8">
                                <select name="estado" class="form-select" required>
                                    <option value="Pendiente" {{ $incidente->estado == 'Pendiente' ? 'selected' : '' }}>
                                        Pendiente
                                    </option>
                                    <option value="En Revisión" {{ $incidente->estado == 'En Revisión' ? 'selected' : '' }}>
                                        En Revisión
                                    </option>
                                    <option value="Resuelto" {{ $incidente->estado == 'Resuelto' ? 'selected' : '' }}>
                                        Resuelto
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn-actualizar w-100">
                                    <i class="fas fa-check-circle"></i> Actualizar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Botón Volver -->
                <div class="text-end mt-4">
                    <a href="{{ route('incidentes.index') }}" class="btn-volver">
                        <i class="fas fa-arrow-left"></i> Volver al Listado
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
