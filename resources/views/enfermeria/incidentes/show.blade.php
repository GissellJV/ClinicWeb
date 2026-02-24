@extends('layouts.plantillaEnfermeria')
@section('titulo', 'Detalle del Incidente')
@section('contenido')

    <style>
        body { background: #f0f4f8; min-height: 100vh; padding: 20px; }

        .detalle-container { max-width: 1000px; margin: 40px auto; }

        .detalle-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
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
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .detalle-body { padding: 40px; }

        .info-section { margin-bottom: 30px; }

        .info-section h5 {
            color: #4ECDC4;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #4ECDC4;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.05rem;
        }

        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

        @media (max-width: 600px) { .info-grid { grid-template-columns: 1fr; } }

        .info-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid #4ECDC4;
        }

        .info-label {
            font-weight: 600;
            color: #777;
            font-size: 0.82rem;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .info-value { color: #2c3e50; font-size: 1rem; font-weight: 500; }

        .fechas-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }

        @media (max-width: 600px) { .fechas-grid { grid-template-columns: 1fr; } }

        .fecha-card {
            background: #f0fdfa;
            border: 2px solid #4ecdc4;
            border-radius: 10px;
            padding: 14px;
        }

        .fecha-titulo {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #00796b;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .fecha-valor { font-size: 1rem; color: #2c3e50; font-weight: 600; }

        .descripcion-box {
            background: #f8f9fa;
            padding: 18px;
            border-radius: 10px;
            border-left: 4px solid #4ECDC4;
        }

        .descripcion-box p { margin: 0; line-height: 1.6; color: #2c3e50; }

        .badge-detalle {
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-block;
        }

        .badge-leve     { background: #d4edda; color: #155724; }
        .badge-moderado { background: #fff3cd; color: #856404; }
        .badge-grave    { background: #ffeaa7; color: #b8650b; }
        .badge-critico  { background: #f8d7da; color: #721c24; }
        .badge-pendiente{ background: #f8d7da; color: #721c24; }
        .badge-revision { background: #fff3cd; color: #856404; }
        .badge-resuelto { background: #d4edda; color: #155724; }

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
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Botones simétricos estilo formulario.css */
        .btn-actualizar {
            padding: 0.875rem 2rem;
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(78,205,196,0.3);
            cursor: pointer;
            width: 100%;
        }

        .btn-actualizar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78,205,196,0.4);
            color: white;
        }

        .btn-volver {
            padding: 0.875rem 2rem;
            background: white;
            border: 2px solid #6c757d;
            border-radius: 8px;
            color: #6c757d;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-volver:hover {
            background: #6c757d;
            color: white;
            transform: translateY(-2px);
        }

        .alert-success-detalle {
            background: #d4edda;
            border-left: 4px solid #28a745;
            color: #155724;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>

    <div class="detalle-container">
        <div class="detalle-card">

            <div class="detalle-header">
                <h1>
                    <i class="bi bi-clipboard2-pulse"></i>
                    Detalle del Incidente #{{ str_pad($incidente->id, 4, '0', STR_PAD_LEFT) }}
                </h1>
                <p style="margin:0; opacity:0.9;">
                    Registrado el {{ $incidente->created_at->format('d/m/Y \a \l\a\s H:i') }}
                </p>
            </div>

            <div class="detalle-body">

                @if(session('success'))
                    <div class="alert-success-detalle">
                        <i class="bi bi-check-circle-fill" style="font-size:1.2rem;"></i>
                        {{ session('success') }}
                    </div>
                @endif

                {{-- FECHAS --}}
                <div class="info-section">
                    <h5><i class="bi bi-calendar2-week"></i> Fechas del Incidente</h5>
                    <div class="fechas-grid">
                        <div class="fecha-card">
                            <div class="fecha-titulo">
                                <i class="bi bi-calendar-event"></i> Fecha del Incidente
                            </div>
                            <div class="fecha-valor">
                                {{ \Carbon\Carbon::parse($incidente->fecha_hora_incidente)->format('d/m/Y H:i') }}
                            </div>
                        </div>
                        <div class="fecha-card">
                            <div class="fecha-titulo">
                                <i class="bi bi-clock"></i> Fecha de Registro
                            </div>
                            <div class="fecha-valor">
                                {{ $incidente->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- INFORMACIÓN GENERAL --}}
                <div class="info-section">
                    <h5><i class="bi bi-info-circle"></i> Información General</h5>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Tipo de Incidente</div>
                            <div class="info-value">{{ $incidente->tipo_incidente }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Estado Actual</div>
                            <div class="info-value">
                            <span class="badge-detalle badge-{{ $incidente->estado == 'Pendiente' ? 'pendiente' : ($incidente->estado == 'En Revisión' ? 'revision' : 'resuelto') }}">
                                {{ $incidente->estado }}
                            </span>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Gravedad</div>
                            <div class="info-value">
                            <span class="badge-detalle badge-{{ strtolower($incidente->gravedad) }}">
                                {{ $incidente->gravedad }}
                            </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- PERSONAS --}}
                <div class="info-section">
                    <h5><i class="bi bi-people"></i> Personas Involucradas</h5>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Paciente</div>
                            <div class="info-value">
                                {{ $incidente->paciente->nombres }} {{ $incidente->paciente->apellidos }}
                            </div>
                            <small style="color:#888;">ID: {{ $incidente->paciente->numero_identidad }}</small>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Reportado Por</div>
                            <div class="info-value">{{ $incidente->empleado_nombre }}</div>
                            <small style="color:#888;">Enfermero(a)</small>
                        </div>
                    </div>
                </div>

                {{-- DESCRIPCIÓN --}}
                <div class="info-section">
                    <h5><i class="bi bi-file-text"></i> Descripción del Incidente</h5>
                    <div class="descripcion-box">
                        <p>{{ $incidente->descripcion }}</p>
                    </div>
                </div>

                {{-- ACCIONES TOMADAS --}}
                @if($incidente->acciones_tomadas)
                    <div class="info-section">
                        <h5><i class="bi bi-list-check"></i> Acciones Tomadas</h5>
                        <div class="descripcion-box">
                            <p>{{ $incidente->acciones_tomadas }}</p>
                        </div>
                    </div>
                @endif

                {{-- CAMBIAR ESTADO --}}
                <div class="info-section">
                    <div class="estado-form">
                        <h6><i class="bi bi-arrow-repeat"></i> Actualizar Estado del Incidente</h6>
                        <form action="{{ route('incidentes.actualizar-estado', $incidente->id) }}" method="POST" class="row g-3">
                            @csrf
                            @method('PUT')
                            <div class="col-md-8">
                                <select name="estado" class="form-select" required
                                        style="padding:0.75rem 1rem; border:2px solid #e0e0e0; border-radius:8px; font-size:1rem;">
                                    <option value="Pendiente"   {{ $incidente->estado == 'Pendiente'   ? 'selected' : '' }}>Pendiente</option>
                                    <option value="En Revisión" {{ $incidente->estado == 'En Revisión' ? 'selected' : '' }}>En Revisión</option>
                                    <option value="Resuelto"    {{ $incidente->estado == 'Resuelto'    ? 'selected' : '' }}>Resuelto</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn-actualizar">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- VOLVER --}}
                <div class="text-end mt-4">
                    <a href="{{ route('incidentes.index') }}" class="btn-volver">
                        <i class="bi bi-arrow-left"></i> Volver al Listado
                    </a>
                </div>

            </div>
        </div>
    </div>

@endsection
