@extends('layouts.plantillaRecepcion')

@section('titulo', 'Reportes de Incidentes')

@section('contenido')
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .contenedor-principal {
            max-width: 1400px;
            margin: 80px auto 40px;
            padding: 0 20px;
        }

        .cabecera-seccion {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .titulo-principal {
            color: #00796b;
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
        }

        .alerta-exito {
            background-color: #e8f5e9;
            border-left: 4px solid #4caf50;
            color: #2e7d32;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .grid-estadisticas {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .tarjeta-estadistica {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
            border-left: 5px solid;
            transition: all 0.3s ease;
        }

        .tarjeta-estadistica:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .tarjeta-estadistica.total { border-left-color: #2196f3; }
        .tarjeta-estadistica.pendientes { border-left-color: #f44336; }
        .tarjeta-estadistica.criticos { border-left-color: #ff9800; }
        .tarjeta-estadistica.mes { border-left-color: #4caf50; }

        .numero-estadistica {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .tarjeta-estadistica.total .numero-estadistica { color: #2196f3; }
        .tarjeta-estadistica.pendientes .numero-estadistica { color: #f44336; }
        .tarjeta-estadistica.criticos .numero-estadistica { color: #ff9800; }
        .tarjeta-estadistica.mes .numero-estadistica { color: #4caf50; }

        .etiqueta-estadistica {
            color: #546e7a;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .tarjeta-tabla {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        }

        .tabla-custom {
            width: 100%;
            border-collapse: collapse;
        }

        .tabla-custom thead th {
            background-color: #f5f5f5;
            color: #37474f;
            font-weight: 600;
            padding: 15px;
            border-bottom: 2px solid #b0bec5;
            text-align: left;
        }

        .tabla-custom tbody td {
            padding: 15px;
            vertical-align: middle;
            color: #37474f;
            border-bottom: 1px solid #e0e0e0;
        }

        .tabla-custom tbody tr:hover {
            background-color: #f5f5f5;
        }

        .insignia {
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-block;
        }

        .insignia-leve { background-color: #c8e6c9; color: #2e7d32; }
        .insignia-moderado { background-color: #fff9c4; color: #f57f17; }
        .insignia-grave { background-color: #ffccbc; color: #d84315; }
        .insignia-critico { background-color: #ffcdd2; color: #c62828; }
        .insignia-pendiente { background-color: #ffcdd2; color: #c62828; }
        .insignia-revision { background-color: #fff9c4; color: #f57f17; }
        .insignia-resuelto { background-color: #c8e6c9; color: #2e7d32; }

        .boton-ver {
            background-color: #2196f3;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .boton-ver:hover {
            background-color: #1976d2;
            color: white;
            transform: translateY(-2px);
        }

        .paginacion-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            padding: 15px 0;
            border-top: 1px solid #e0e0e0;
        }

        .info-paginacion {
            color: #546e7a;
            font-size: 0.9rem;
        }

        .paginacion-links {
            display: flex;
            gap: 5px;
        }

        .paginacion-links a,
        .paginacion-links span {
            padding: 8px 12px;
            border-radius: 4px;
            text-decoration: none;
            color: #2196f3;
            border: 1px solid #ddd;
        }

        .paginacion-links a:hover {
            background-color: #f5f5f5;
        }

        .paginacion-links .active {
            background-color: #2196f3;
            color: white;
            border-color: #2196f3;
        }

        .paginacion-links .disabled {
            color: #9e9e9e;
            pointer-events: none;
        }

        .mostrar-selector {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            color: #546e7a;
        }

        .mostrar-selector select {
            width: auto;
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        @media (max-width: 768px) {
            .cabecera-seccion {
                flex-direction: column;
                align-items: flex-start;
            }

            .grid-estadisticas {
                grid-template-columns: 1fr;
            }

            .paginacion-container {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
        }
    </style>

    <div class="contenedor-principal">
        <div class="cabecera-seccion">
            <h1 class="titulo-principal">Reportes de Incidentes</h1>
        </div>

        @if(session('success'))
            <div class="alerta-exito">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid-estadisticas">
            <div class="tarjeta-estadistica total">
                <div class="numero-estadistica">{{ $estadisticas['total'] }}</div>
                <div class="etiqueta-estadistica">Total de Incidentes</div>
            </div>
            <div class="tarjeta-estadistica pendientes">
                <div class="numero-estadistica">{{ $estadisticas['pendientes'] }}</div>
                <div class="etiqueta-estadistica">Pendientes</div>
            </div>
            <div class="tarjeta-estadistica criticos">
                <div class="numero-estadistica">{{ $estadisticas['criticos'] }}</div>
                <div class="etiqueta-estadistica">Críticos</div>
            </div>
            <div class="tarjeta-estadistica mes">
                <div class="numero-estadistica">{{ $estadisticas['este_mes'] }}</div>
                <div class="etiqueta-estadistica">Este Mes</div>
            </div>
        </div>

        <div class="tarjeta-tabla">
            <!-- Selector de registros -->
            <div class="mostrar-selector">
                <span>Mostrar</span>
                <select class="form-select" id="mostrarRegistros" style="width: auto; display: inline-block;">
                    <option value="10">10 registros</option>
                    <option value="25">25 registros</option>
                    <option value="50">50 registros</option>
                    <option value="100">100 registros</option>
                </select>
            </div>

            <table class="tabla-custom">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha/Hora</th>
                    <th>Paciente</th>
                    <th>Tipo</th>
                    <th>Gravedad</th>
                    <th>Estado</th>
                    <th>Reportado Por</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @forelse($incidentes as $incidente)
                    <tr>
                        <td><strong>#{{ str_pad($incidente->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($incidente->fecha_hora_incidente)->format('d/m/Y H:i') }}</td>
                        <td>{{ $incidente->paciente->nombres ?? 'N/A' }} {{ $incidente->paciente->apellidos ?? '' }}</td>
                        <td>{{ $incidente->tipo_incidente }}</td>
                        <td>
                            @php
                                $claseGravedad = strtolower($incidente->gravedad);
                                $claseGravedad = in_array($claseGravedad, ['leve', 'moderado', 'grave', 'critico'])
                                    ? $claseGravedad
                                    : 'leve';
                            @endphp
                            <span class="insignia insignia-{{ $claseGravedad }}">
                                {{ $incidente->gravedad }}
                            </span>
                        </td>
                        <td>
                            @php
                                $claseEstado = match($incidente->estado) {
                                    'Pendiente' => 'pendiente',
                                    'En Revisión' => 'revision',
                                    'Resuelto' => 'resuelto',
                                    default => 'pendiente'
                                };
                            @endphp
                            <span class="insignia insignia-{{ $claseEstado }}">
                                {{ $incidente->estado }}
                            </span>
                        </td>
                        <td>{{ $incidente->empleado_nombre }}</td>
                        <td>
                            <a href="{{ route('recepcionista.incidentes.show', $incidente->id) }}" class="boton-ver">Ver</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center" style="padding: 40px; color: #9e9e9e;">
                            No hay incidentes registrados
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            {{-- PAGINACIÓN LARAVEL --}}
            @if($incidentes->hasPages())
                <div class="paginacion-container">
                    <div class="info-paginacion">
                        Mostrando {{ $incidentes->firstItem() }} a {{ $incidentes->lastItem() }} de {{ $incidentes->total() }} incidentes
                    </div>
                    <div class="paginacion-links">
                        @if(!$incidentes->onFirstPage())
                            <a href="{{ $incidentes->previousPageUrl() }}">Anterior</a>
                        @else
                            <span class="disabled">Anterior</span>
                        @endif

                        @for($i = 1; $i <= $incidentes->lastPage(); $i++)
                            @if($i == $incidentes->currentPage())
                                <span class="active">{{ $i }}</span>
                            @else
                                <a href="{{ $incidentes->url($i) }}">{{ $i }}</a>
                            @endif
                        @endfor

                        @if($incidentes->hasMorePages())
                            <a href="{{ $incidentes->nextPageUrl() }}">Siguiente</a>
                        @else
                            <span class="disabled">Siguiente</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Script para cambiar número de registros por página
        document.getElementById('mostrarRegistros').addEventListener('change', function() {
            const perPage = this.value;
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', perPage);
            window.location.href = url.toString();
        });

        // Establecer el valor actual en el selector
        const urlParams = new URLSearchParams(window.location.search);
        const currentPerPage = urlParams.get('per_page') || '10';
        document.getElementById('mostrarRegistros').value = currentPerPage;
    </script>

@endsection
