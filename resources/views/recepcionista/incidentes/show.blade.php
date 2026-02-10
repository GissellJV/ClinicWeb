@extends('layouts.plantillaRecepcion')

@section('titulo', 'Detalle del Incidente')

@section('contenido')

    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .contenedor-principal {
            max-width: 1000px;
            margin: 80px auto 40px;
            padding: 0 20px;
        }

        .tarjeta-detalle {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
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
        }

        .cuerpo-detalle {
            padding: 40px;
        }

        .seccion-info {
            margin-bottom: 30px;
        }

        .seccion-info h5 {
            color: #4db6ac;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #4db6ac;
        }

        .grid-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .item-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid #4db6ac;
        }

        .etiqueta-info {
            font-weight: 600;
            color: #555;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .valor-info {
            color: #2c3e50;
            font-size: 1.1rem;
        }

        .caja-descripcion {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #4db6ac;
            margin-top: 15px;
        }

        .caja-descripcion p {
            margin: 0;
            line-height: 1.6;
            color: #2c3e50;
        }

        .insignia-detalle {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.95rem;
            display: inline-block;
        }

        .insignia-leve { background-color: #c8e6c9; color: #2e7d32; }
        .insignia-moderado { background-color: #fff9c4; color: #f57f17; }
        .insignia-grave { background-color: #ffccbc; color: #d84315; }
        .insignia-critico { background-color: #ffcdd2; color: #c62828; }
        .insignia-pendiente { background-color: #ffcdd2; color: #c62828; }
        .insignia-revision { background-color: #fff9c4; color: #f57f17; }
        .insignia-resuelto { background-color: #c8e6c9; color: #2e7d32; }

        .boton-volver {
            background-color: #6c757d;
            color: white;
            padding: 12px 30px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .boton-volver:hover {
            background-color: #5a6268;
            color: white;
        }

        .alerta-exito-detalle {
            background-color: #e8f5e9;
            border-left: 4px solid #4caf50;
            color: #2e7d32;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        @media (max-width: 768px) {
            .grid-info {
                grid-template-columns: 1fr;
            }

            .cuerpo-detalle {
                padding: 25px;
            }
        }
    </style>

    <div class="contenedor-principal">
        <div class="tarjeta-detalle">
            <!-- Cabecera -->
            <div class="cabecera-detalle">
                <h1>Detalle del Incidente #{{ str_pad($incidente->id, 4, '0', STR_PAD_LEFT) }}</h1>
                <p style="margin: 0; opacity: 0.9;">
                    Registrado el {{ \Carbon\Carbon::parse($incidente->created_at)->format('d/m/Y \a \l\a\s H:i') }}
                </p>
            </div>

            <!-- Cuerpo -->
            <div class="cuerpo-detalle">
                <!-- Alerta de Éxito -->
                @if(session('success'))
                    <div class="alerta-exito-detalle">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Información General -->
                <div class="seccion-info">
                    <h5>Información General</h5>

                    <div class="grid-info">
                        <div class="item-info">
                            <div class="etiqueta-info">Fecha y Hora del Incidente</div>
                            <div class="valor-info">
                                {{ \Carbon\Carbon::parse($incidente->fecha_hora_incidente)->format('d/m/Y H:i') }}
                            </div>
                        </div>

                        <div class="item-info">
                            <div class="etiqueta-info">Tipo de Incidente</div>
                            <div class="valor-info">{{ $incidente->tipo_incidente }}</div>
                        </div>

                        <div class="item-info">
                            <div class="etiqueta-info">Gravedad</div>
                            <div class="valor-info">
                                @php
                                    $claseGravedad = strtolower($incidente->gravedad);
                                    $claseGravedad = in_array($claseGravedad, ['leve', 'moderado', 'grave', 'critico'])
                                        ? $claseGravedad
                                        : 'leve';
                                @endphp
                                <span class="insignia-detalle insignia-{{ $claseGravedad }}">
                                    {{ $incidente->gravedad }}
                                </span>
                            </div>
                        </div>

                        <div class="item-info">
                            <div class="etiqueta-info">Estado Actual</div>
                            <div class="valor-info">
                                @php
                                    $claseEstado = match($incidente->estado) {
                                        'Pendiente' => 'pendiente',
                                        'En Revisión' => 'revision',
                                        'Resuelto' => 'resuelto',
                                        default => 'pendiente'
                                    };
                                @endphp
                                <span class="insignia-detalle insignia-{{ $claseEstado }}">
                                    {{ $incidente->estado }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Personas Involucradas -->
                <div class="seccion-info">
                    <h5>Personas Involucradas</h5>

                    <div class="grid-info">
                        <div class="item-info">
                            <div class="etiqueta-info">Paciente</div>
                            <div class="valor-info">
                                {{ $incidente->paciente->nombres ?? 'N/A' }} {{ $incidente->paciente->apellidos ?? '' }}
                            </div>
                            @if(isset($incidente->paciente->numero_identidad))
                                <small class="text-muted">ID: {{ $incidente->paciente->numero_identidad }}</small>
                            @endif
                        </div>

                        <div class="item-info">
                            <div class="etiqueta-info">Reportado Por</div>
                            <div class="valor-info">{{ $incidente->empleado_nombre }}</div>
                            <small class="text-muted">Enfermero(a)</small>
                        </div>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="seccion-info">
                    <h5>Descripción del Incidente</h5>
                    <div class="caja-descripcion">
                        <p>{{ $incidente->descripcion }}</p>
                    </div>
                </div>

                <!-- Acciones Tomadas -->
                @if($incidente->acciones_tomadas)
                    <div class="seccion-info">
                        <h5>Acciones Tomadas</h5>
                        <div class="caja-descripcion">
                            <p>{{ $incidente->acciones_tomadas }}</p>
                        </div>
                    </div>
                @endif

                <!-- Cambiar Estado -->
                <div class="seccion-info">
                    <div style="background: #e7f9f7; padding: 25px; border-radius: 15px; border: 2px solid #4db6ac; margin-top: 20px;">
                        <h6 style="color: #4db6ac; font-weight: 700; margin-bottom: 15px;">Actualizar Estado del Incidente</h6>
                        <form action="{{ route('recepcionista.incidentes.actualizar-estado', $incidente->id) }}" method="POST" class="row g-3">
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
                                <button type="submit" style="background: linear-gradient(135deg, #4db6ac 0%, #00796b 100%); color: white; padding: 12px 30px; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; width: 100%;">
                                    Actualizar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Botón Volver -->
                <div class="text-end mt-4">
                    <a href="{{ route('recepcionista.incidentes.index') }}" class="boton-volver">Volver al Listado</a>
                </div>
            </div>
        </div>
    </div>

@endsection
