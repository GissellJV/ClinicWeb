@extends('layouts.plantillaRecepcion')
@section('titulo', 'Detalle del Incidente')
@section('contenido')

    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

        .contenedor-principal { max-width: 1000px; margin: 80px auto 40px; padding: 0 20px; }

        .tarjeta-detalle {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            overflow: hidden;
            border-top: 5px solid #4db6ac;
        }

        .cabecera-detalle {
            background: linear-gradient(135deg, #4db6ac 0%, #00796b 100%);
            padding: 30px;
            color: white;
        }

        .cabecera-detalle h1 {
            font-size: 1.8rem;
            margin-bottom: 8px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .cuerpo-detalle { padding: 40px; }

        .seccion-info { margin-bottom: 30px; }

        .seccion-info h5 {
            color: #4db6ac;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #4db6ac;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.05rem;
        }

        .grid-info { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

        @media (max-width: 600px) { .grid-info { grid-template-columns: 1fr; } }

        .item-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid #4db6ac;
        }

        .etiqueta-info {
            font-weight: 600;
            color: #777;
            font-size: 0.82rem;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .valor-info { color: #2c3e50; font-size: 1rem; font-weight: 500; }

        /* Fechas */
        .fechas-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

        @media (max-width: 600px) { .fechas-grid { grid-template-columns: 1fr; } }

        .fecha-card {
            background: #f0fdfa;
            border: 2px solid #4db6ac;
            border-radius: 10px;
            padding: 14px;
        }

        .fecha-titulo {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #00796b;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .fecha-valor { font-size: 1rem; color: #2c3e50; font-weight: 600; }

        .caja-descripcion {
            background: #f8f9fa;
            padding: 18px;
            border-radius: 10px;
            border-left: 4px solid #4db6ac;
        }

        .caja-descripcion p { margin: 0; line-height: 1.6; color: #2c3e50; }

        .insignia-detalle {
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-block;
        }

        .insignia-leve     { background-color: #c8e6c9; color: #2e7d32; }
        .insignia-moderado { background-color: #fff9c4; color: #f57f17; }
        .insignia-grave    { background-color: #ffccbc; color: #d84315; }
        .insignia-critico  { background-color: #ffcdd2; color: #c62828; }
        .insignia-pendiente{ background-color: #ffcdd2; color: #c62828; }
        .insignia-revision { background-color: #fff9c4; color: #f57f17; }
        .insignia-resuelto { background-color: #c8e6c9; color: #2e7d32; }

        .estado-form {
            background: #e7f9f7;
            padding: 25px;
            border-radius: 15px;
            border: 2px solid #4db6ac;
            margin-top: 20px;
        }

        .estado-form h6 {
            color: #4db6ac;
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
            background: linear-gradient(135deg, #4db6ac 0%, #00796b 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(77,182,172,0.3);
            cursor: pointer;
            width: 100%;
        }

        .btn-actualizar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(77,182,172,0.4);
            color: white;
        }

        .boton-volver {
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

        .boton-volver:hover {
            background: #6c757d;
            color: white;
            transform: translateY(-2px);
        }

        .alerta-exito-detalle {
            background-color: #e8f5e9;
            border-left: 4px solid #4caf50;
            color: #2e7d32;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        @media (max-width: 768px) {
            .grid-info { grid-template-columns: 1fr; }
            .cuerpo-detalle { padding: 25px; }
        }
    </style>

    <div class="contenedor-principal">
        <div class="tarjeta-detalle">

            <div class="cabecera-detalle">
                <h1>
                    <i class="bi bi-clipboard2-pulse"></i>
                    Detalle del Incidente #{{ str_pad($incidente->id, 4, '0', STR_PAD_LEFT) }}
                </h1>
                <p style="margin:0; opacity:0.9;">
                    Registrado el {{ \Carbon\Carbon::parse($incidente->created_at)->format('d/m/Y \a \l\a\s H:i') }}
                </p>
            </div>

            <div class="cuerpo-detalle">

                @if(session('success'))
                    <div class="alerta-exito-detalle">
                        <i class="bi bi-check-circle-fill" style="font-size:1.2rem;"></i>
                        {{ session('success') }}
                    </div>
                @endif

                {{-- FECHAS --}}
                <div class="seccion-info">
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
                                {{ \Carbon\Carbon::parse($incidente->created_at)->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- INFORMACIÓN GENERAL --}}
                <div class="seccion-info">
                    <h5><i class="bi bi-info-circle"></i> Información General</h5>
                    <div class="grid-info">
                        <div class="item-info">
                            <div class="etiqueta-info">Tipo de Incidente</div>
                            <div class="valor-info">{{ $incidente->tipo_incidente }}</div>
                        </div>
                        <div class="item-info">
                            <div class="etiqueta-info">Estado Actual</div>
                            <div class="valor-info">
                                @php
                                    $claseEstado = match($incidente->estado) {
                                        'Pendiente'   => 'pendiente',
                                        'En Revisión' => 'revision',
                                        'Resuelto'    => 'resuelto',
                                        default       => 'pendiente'
                                    };
                                @endphp
                                <span class="insignia-detalle insignia-{{ $claseEstado }}">{{ $incidente->estado }}</span>
                            </div>
                        </div>
                        <div class="item-info">
                            <div class="etiqueta-info">Gravedad</div>
                            <div class="valor-info">
                                @php
                                    $claseGravedad = strtolower($incidente->gravedad);
                                    $claseGravedad = in_array($claseGravedad, ['leve','moderado','grave','critico']) ? $claseGravedad : 'leve';
                                @endphp
                                <span class="insignia-detalle insignia-{{ $claseGravedad }}">{{ $incidente->gravedad }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- PERSONAS --}}
                <div class="seccion-info">
                    <h5><i class="bi bi-people"></i> Personas Involucradas</h5>
                    <div class="grid-info">
                        <div class="item-info">
                            <div class="etiqueta-info">Paciente</div>
                            <div class="valor-info">
                                {{ $incidente->paciente->nombres ?? 'N/A' }} {{ $incidente->paciente->apellidos ?? '' }}
                            </div>
                            @if(isset($incidente->paciente->numero_identidad))
                                <small style="color:#888;">ID: {{ $incidente->paciente->numero_identidad }}</small>
                            @endif
                        </div>
                        <div class="item-info">
                            <div class="etiqueta-info">Reportado Por</div>
                            <div class="valor-info">{{ $incidente->empleado_nombre }}</div>
                            <small style="color:#888;">Enfermero(a)</small>
                        </div>
                    </div>
                </div>

                {{-- DESCRIPCIÓN --}}
                <div class="seccion-info">
                    <h5><i class="bi bi-file-text"></i> Descripción del Incidente</h5>
                    <div class="caja-descripcion">
                        <p>{{ $incidente->descripcion }}</p>
                    </div>
                </div>

                {{-- ACCIONES TOMADAS --}}
                @if($incidente->acciones_tomadas)
                    <div class="seccion-info">
                        <h5><i class="bi bi-list-check"></i> Acciones Tomadas</h5>
                        <div class="caja-descripcion">
                            <p>{{ $incidente->acciones_tomadas }}</p>
                        </div>
                    </div>
                @endif

                {{-- ACTUALIZAR ESTADO --}}
                <div class="seccion-info">
                    <div class="estado-form">
                        <h6><i class="bi bi-arrow-repeat"></i> Actualizar Estado del Incidente</h6>
                        <form action="{{ route('recepcionista.incidentes.actualizar-estado', $incidente->id) }}" method="POST" class="row g-3">
                            @csrf
                            @method('PUT')
                            <div class="col-md-8">
                                <select name="estado" class="form-select" required
                                        style="padding:0.75rem 1rem; border:2px solid #b2dfdb; border-radius:8px; font-size:1rem;">
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
                    <a href="{{ route('recepcionista.incidentes.index') }}" class="boton-volver">
                        <i class="bi bi-arrow-left"></i> Volver al Listado
                    </a>
                </div>

            </div>
        </div>
    </div>

@endsection
