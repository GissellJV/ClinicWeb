@extends('layouts.plantillaDoctor')
@section('titulo', 'Evaluación Guardada')

@section('contenido')
    <style>
        .ver-container {
            max-width: 900px;
            margin: 100px auto 40px auto;
            padding: 0 20px;
        }
        .eval-header {
            background: linear-gradient(135deg, #4ECDC4, #44a08d);
            color: white;
            padding: 25px 30px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        .eval-header h2 { margin: 0; font-size: 1.6rem; }
        .btn-agendar {
            background: white;
            color: #44a08d;
            border: none;
            padding: 12px 28px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn-agendar:hover {
            background: #f0fffe;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
            color: #44a08d;
        }
        .info-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.07);
        }
        .section-title {
            font-size: 1rem;
            font-weight: 700;
            color: #2c3e50;
            border-left: 4px solid #4ECDC4;
            padding-left: 12px;
            margin-bottom: 18px;
        }
        .dato-row { display: flex; flex-wrap: wrap; gap: 12px 30px; margin-bottom: 8px; }
        .dato-item { min-width: 180px; }
        .dato-item span { font-size: 0.8rem; color: #888; display: block; }
        .dato-item strong { color: #2c3e50; }
        .badge-riesgo {
            padding: 5px 16px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.85rem;
        }
        .riesgo-bajo  { background: #d4edda; color: #155724; }
        .riesgo-medio { background: #fff3cd; color: #856404; }
        .riesgo-alto  { background: #f8d7da; color: #721c24; }
    </style>

    <div class="ver-container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="eval-header">
            <div>
                <h2><i class="bi bi-clipboard2-check me-2"></i>Evaluación Prequirúrgica</h2>
                <small style="opacity:0.85">ID #{{ $evaluacion->id }} &nbsp;|&nbsp;
                    {{ \Carbon\Carbon::parse($evaluacion->created_at)->format('d/m/Y H:i') }}</small>
            </div>

            {{-- BOTÓN AGENDAR CIRUGÍA - Criterio de aceptación H71 --}}
            @if(!$evaluacion->cirugia)
                <a href="{{ route('recepcionista.cirugia.programar', $evaluacion->id) }}" class="btn-agendar">
                    <i class="bi bi-scissors"></i> Agendar Cirugía
                </a>
            @else
                <span class="badge bg-success fs-6 px-3 py-2">
                <i class="bi bi-check-circle me-1"></i>Cirugía ya programada
            </span>
            @endif
        </div>

        {{-- Datos del paciente --}}
        <div class="info-card">
            <div class="section-title"><i class="bi bi-person-fill me-2"></i>Datos del Paciente</div>
            <div class="dato-row">
                <div class="dato-item">
                    <span>Nombre completo</span>
                    <strong>{{ $evaluacion->paciente->nombres ?? '' }} {{ $evaluacion->paciente->apellidos ?? '' }}</strong>
                </div>
                <div class="dato-item">
                    <span>No. Identidad</span>
                    <strong>{{ $evaluacion->paciente->numero_identidad ?? 'N/A' }}</strong>
                </div>
                <div class="dato-item">
                    <span>Teléfono</span>
                    <strong>{{ $evaluacion->paciente->telefono ?? 'N/A' }}</strong>
                </div>
                <div class="dato-item">
                    <span>Doctor evaluador</span>
                    <strong>Dr. {{ $evaluacion->doctor->nombre ?? '' }} {{ $evaluacion->doctor->apellido ?? '' }}</strong>
                </div>
            </div>
        </div>

        {{-- Diagnóstico --}}
        <div class="info-card">
            <div class="section-title"><i class="bi bi-stethoscope me-2"></i>Diagnóstico y Procedimiento</div>
            <div class="dato-row">
                <div class="dato-item">
                    <span>Tipo de Cirugía</span>
                    <strong>{{ $evaluacion->tipo_cirugia }}</strong>
                </div>
                <div class="dato-item">
                    <span>Diagnóstico</span>
                    <strong>{{ $evaluacion->diagnostico }}</strong>
                </div>
                <div class="dato-item">
                    <span>Nivel de Riesgo</span>
                    <strong><span class="badge-riesgo riesgo-{{ $evaluacion->nivel_riesgo }}">
                    {{ ucfirst($evaluacion->nivel_riesgo) }}
                </span></strong>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-muted" style="font-size:0.85rem">Descripción del procedimiento</span>
                <p class="mt-1">{{ $evaluacion->descripcion_procedimiento }}</p>
            </div>
            @if($evaluacion->observaciones)
                <div>
                    <span class="text-muted" style="font-size:0.85rem">Observaciones</span>
                    <p class="mt-1">{{ $evaluacion->observaciones }}</p>
                </div>
            @endif
        </div>

        {{-- Signos vitales --}}
        <div class="info-card">
            <div class="section-title"><i class="bi bi-heart-pulse me-2"></i>Signos Vitales</div>
            <div class="dato-row">
                @if($evaluacion->presion_arterial)
                    <div class="dato-item">
                        <span>Presión Arterial</span>
                        <strong>{{ $evaluacion->presion_arterial }}</strong>
                    </div>
                @endif
                @if($evaluacion->temperatura)
                    <div class="dato-item">
                        <span>Temperatura</span>
                        <strong>{{ $evaluacion->temperatura }} °C</strong>
                    </div>
                @endif
                @if($evaluacion->frecuencia_cardiaca)
                    <div class="dato-item">
                        <span>Frec. Cardíaca</span>
                        <strong>{{ $evaluacion->frecuencia_cardiaca }} bpm</strong>
                    </div>
                @endif
                @if($evaluacion->peso)
                    <div class="dato-item">
                        <span>Peso</span>
                        <strong>{{ $evaluacion->peso }} kg</strong>
                    </div>
                @endif
                @if($evaluacion->talla)
                    <div class="dato-item">
                        <span>Talla</span>
                        <strong>{{ $evaluacion->talla }} m</strong>
                    </div>
                @endif
            </div>
        </div>

        <div class="d-flex justify-content-start mt-2 mb-5">
            <a href="{{ route('doctor.citas') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver a Mis Citas
            </a>
        </div>
    </div>
@endsection
