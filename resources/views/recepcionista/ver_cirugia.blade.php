@extends('layouts.plantillaRecepcion')
@section('titulo', 'Cirugía Programada')

@section('contenido')
    <style>
        body { padding-top: 100px; }
        .ver-container { max-width: 850px; margin: 0 auto 50px auto; padding: 0 20px; }
        .success-banner {
            background: linear-gradient(135deg, #4ECDC4, #44a08d);
            color: white;
            padding: 25px 30px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 18px;
        }
        .success-banner i { font-size: 2.5rem; }
        .success-banner h2 { margin: 0; font-size: 1.5rem; }
        .success-banner p { margin: 4px 0 0 0; opacity: 0.9; }
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
        .dato-grid { display: flex; flex-wrap: wrap; gap: 16px 30px; }
        .dato-item { min-width: 160px; }
        .dato-item span { font-size: 0.78rem; color: #999; display: block; }
        .dato-item strong { color: #2c3e50; font-size: 0.97rem; }
        .badge-estado {
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 700;
            background: #e8f8f6;
            color: #44a08d;
        }
    </style>

    <div class="ver-container">
        @if(session('success'))
            <div class="success-banner">
                <i class="bi bi-check-circle-fill"></i>
                <div>
                    <h2>¡Cirugía Programada Exitosamente!</h2>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="info-card">
            <div class="section-title"><i class="bi bi-person-fill me-2"></i>Paciente y Cirujano</div>
            <div class="dato-grid">
                <div class="dato-item">
                    <span>Paciente</span>
                    <strong>{{ $cirugia->paciente->nombres }} {{ $cirugia->paciente->apellidos }}</strong>
                </div>
                <div class="dato-item">
                    <span>Cirujano</span>
                    <strong>Dr. {{ $cirugia->doctor->nombre }} {{ $cirugia->doctor->apellido }}</strong>
                </div>
                <div class="dato-item">
                    <span>Tipo de Cirugía</span>
                    <strong>{{ $cirugia->tipo_cirugia }}</strong>
                </div>
                <div class="dato-item">
                    <span>Estado</span>
                    <strong><span class="badge-estado">{{ ucfirst($cirugia->estado) }}</span></strong>
                </div>
            </div>
        </div>

        <div class="info-card">
            <div class="section-title"><i class="bi bi-calendar-event me-2"></i>Programación</div>
            <div class="dato-grid">
                <div class="dato-item">
                    <span>Fecha</span>
                    <strong>{{ \Carbon\Carbon::parse($cirugia->fecha_cirugia)->format('d/m/Y') }}</strong>
                </div>
                <div class="dato-item">
                    <span>Hora Inicio</span>
                    <strong>{{ $cirugia->hora_inicio }}</strong>
                </div>
                <div class="dato-item">
                    <span>Hora Fin</span>
                    <strong>{{ $cirugia->hora_fin }}</strong>
                </div>
                <div class="dato-item">
                    <span>Duración</span>
                    <strong>{{ $cirugia->duracion_estimada_min }} minutos</strong>
                </div>
                <div class="dato-item">
                    <span>Quirófano</span>
                    <strong>{{ $cirugia->quirofano }}</strong>
                </div>
                @if($cirugia->anestesiologo)
                    <div class="dato-item">
                        <span>Anestesiólogo</span>
                        <strong>{{ $cirugia->anestesiologo }}</strong>
                    </div>
                @endif
            </div>
        </div>

        <div class="d-flex gap-3 justify-content-end">
            <a href="{{ route('listadocitas') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Volver a Citas
            </a>
        </div>
    </div>
@endsection
