@extends('layouts.plantillaDoctor')
@section('titulo', 'Evaluación Prequirúrgica')

@section('contenido')
    <style>
        .eval-container {
            max-width: 900px;
            margin: 100px auto 40px auto;
            padding: 0 20px;
        }
        .eval-header {
            background: linear-gradient(135deg, #4ECDC4, #44a08d);
            color: white;
            padding: 25px 30px;
            border-radius: 12px;
            margin-bottom: 30px;
        }
        .eval-header h2 { margin: 0 0 5px 0; font-size: 1.7rem; }
        .eval-header p  { margin: 0; opacity: 0.85; font-size: 0.95rem; }
        .section-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.07);
        }
        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #2c3e50;
            border-left: 4px solid #4ECDC4;
            padding-left: 12px;
            margin-bottom: 20px;
        }
        .form-label { font-weight: 600; color: #444; font-size: 0.9rem; }
        .form-control:focus {
            border-color: #4ECDC4;
            box-shadow: 0 0 0 3px rgba(78,205,196,0.15);
        }
        .btn-guardar {
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
        .btn-guardar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
            color: white;
        }
        .btn-cancelar {
            padding: 0.875rem 2rem;
            background: white;
            border: 2px solid #dc3545;
            border-radius: 8px;
            color: #dc3545;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        .btn-cancelar:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }
        .paciente-badge {
            background: #e8f8f6;
            border: 1px solid #4ECDC4;
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 20px;
        }
        .riesgo-options { display: flex; gap: 15px; flex-wrap: wrap; }
        .riesgo-option input[type="radio"] { display: none; }
        .riesgo-option label {
            padding: 8px 20px;
            border-radius: 20px;
            border: 2px solid #ddd;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
        }
        .riesgo-option input:checked + label { color: white; border-color: transparent; }
        .riesgo-bajo  input:checked + label { background: #2ecc71; }
        .riesgo-medio input:checked + label { background: #f39c12; }
        .riesgo-alto  input:checked + label { background: #e74c3c; }
    </style>

    <div class="eval-container">
        <div class="eval-header">
            <h2><i class="bi bi-clipboard2-pulse me-2"></i>Evaluación Prequirúrgica</h2>
            <p>Complete el formulario de evaluación para habilitar el agendamiento de cirugía</p>
        </div>

        {{-- Datos del paciente precargados --}}
        <div class="paciente-badge">
            <strong><i class="bi bi-person-fill me-2" style="color:#4ECDC4"></i>Paciente:</strong>
            {{ $cita->paciente_nombre }}
            &nbsp;|&nbsp;
            <strong>Cita #{{ $cita->id }}</strong>
            &nbsp;|&nbsp;
            <strong>Especialidad:</strong> {{ $cita->especialidad }}
            &nbsp;|&nbsp;
            <strong>Fecha cita:</strong> {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle me-2"></i><strong>Corrige los siguientes errores:</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('doctor.evaluacion.guardar') }}" id="formEvaluacion">
            @csrf
            <input type="hidden" name="cita_id" value="{{ $cita->id }}">
            <input type="hidden" name="paciente_id" value="{{ $cita->paciente_id }}">

            {{-- SECCIÓN 1: Diagnóstico --}}
            <div class="section-card">
                <div class="section-title"><i class="bi bi-stethoscope me-2"></i>Diagnóstico y Procedimiento</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Tipo de Cirugía *</label>
                        <input type="text" name="tipo_cirugia" class="form-control @error('tipo_cirugia') is-invalid @enderror"
                               value="{{ old('tipo_cirugia') }}" placeholder="Ej: Apendicectomía" required>
                        @error('tipo_cirugia')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Diagnóstico *</label>
                        <input type="text" name="diagnostico" class="form-control @error('diagnostico') is-invalid @enderror"
                               value="{{ old('diagnostico') }}" placeholder="Diagnóstico principal" required>
                        @error('diagnostico')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Descripción del Procedimiento *</label>
                        <textarea name="descripcion_procedimiento" rows="3"
                                  class="form-control @error('descripcion_procedimiento') is-invalid @enderror"
                                  placeholder="Descripción detallada del procedimiento quirúrgico" required>{{ old('descripcion_procedimiento') }}</textarea>
                        @error('descripcion_procedimiento')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Nivel de Riesgo *</label>
                        <div class="riesgo-options">
                            <div class="riesgo-option riesgo-bajo">
                                <input type="radio" name="nivel_riesgo" id="riesgo_bajo" value="bajo"
                                       {{ old('nivel_riesgo') == 'bajo' ? 'checked' : '' }} required>
                                <label for="riesgo_bajo"><i class="bi bi-shield-check me-1"></i>Bajo</label>
                            </div>
                            <div class="riesgo-option riesgo-medio">
                                <input type="radio" name="nivel_riesgo" id="riesgo_medio" value="medio"
                                    {{ old('nivel_riesgo') == 'medio' ? 'checked' : '' }}>
                                <label for="riesgo_medio"><i class="bi bi-shield-exclamation me-1"></i>Medio</label>
                            </div>
                            <div class="riesgo-option riesgo-alto">
                                <input type="radio" name="nivel_riesgo" id="riesgo_alto" value="alto"
                                    {{ old('nivel_riesgo') == 'alto' ? 'checked' : '' }}>
                                <label for="riesgo_alto"><i class="bi bi-shield-x me-1"></i>Alto</label>
                            </div>
                        </div>
                        @error('nivel_riesgo')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                </div>
            </div>

            {{-- SECCIÓN 2: Signos vitales --}}
            <div class="section-card">
                <div class="section-title"><i class="bi bi-heart-pulse me-2"></i>Signos Vitales</div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Presión Arterial</label>
                        <input type="text" name="presion_arterial" class="form-control"
                               value="{{ old('presion_arterial') }}" placeholder="Ej: 120/80">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Temperatura (°C)</label>
                        <input type="number" step="0.1" name="temperatura" class="form-control"
                               value="{{ old('temperatura') }}" placeholder="36.5">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Frec. Cardíaca (bpm)</label>
                        <input type="number" name="frecuencia_cardiaca" class="form-control"
                               value="{{ old('frecuencia_cardiaca') }}" placeholder="70">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Frec. Respiratoria (rpm)</label>
                        <input type="number" name="frecuencia_respiratoria" class="form-control"
                               value="{{ old('frecuencia_respiratoria') }}" placeholder="16">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Peso (kg)</label>
                        <input type="number" step="0.01" name="peso" class="form-control"
                               value="{{ old('peso') }}" placeholder="70.5">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Talla (m)</label>
                        <input type="number" step="0.01" name="talla" class="form-control"
                               value="{{ old('talla') }}" placeholder="1.70">
                    </div>
                </div>
            </div>

            {{-- SECCIÓN 3: Antecedentes --}}
            <div class="section-card">
                <div class="section-title"><i class="bi bi-journal-medical me-2"></i>Antecedentes del Paciente</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Alergias</label>
                        <textarea name="alergias" rows="2" class="form-control"
                                  placeholder="Especifique alergias conocidas o escriba 'Ninguna'">{{ old('alergias') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Medicamentos Actuales</label>
                        <textarea name="medicamentos_actuales" rows="2" class="form-control"
                                  placeholder="Medicamentos que toma actualmente">{{ old('medicamentos_actuales') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Antecedentes Quirúrgicos</label>
                        <textarea name="antecedentes_quirurgicos" rows="2" class="form-control"
                                  placeholder="Cirugías previas">{{ old('antecedentes_quirurgicos') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Observaciones Adicionales</label>
                        <textarea name="observaciones" rows="2" class="form-control"
                                  placeholder="Cualquier observación relevante">{{ old('observaciones') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-3 justify-content-end mt-3 mb-5">
                <a href="{{ route('doctor.citas') }}" class="btn-cancelar">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-guardar" id="btnGuardar">
                    Guardar Evaluación
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('formEvaluacion').addEventListener('submit', function() {
            const btn = document.getElementById('btnGuardar');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Guardando...';
        });
    </script>
@endsection
