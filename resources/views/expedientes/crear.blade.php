@extends('layouts.plantilla')

@section('titulo', 'Crear Expediente Médico')

@section('contenido')
    <div class="container mt-5 pt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Crear Nuevo Expediente Médico</h4>
                    </div>
                    <div class="card-body">
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

                        <form action="{{ route('expedientes.guardar') }}" method="POST">
                            @csrf

                            <!-- Información del Expediente -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="numero_expediente" class="form-label">Número de Expediente</label>
                                        <input type="text" class="form-control" id="numero_expediente"
                                               value="{{ $numero_expediente }}" readonly>
                                        <small class="form-text text-muted">Generado automáticamente</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="paciente_id" class="form-label">Seleccionar Paciente *</label>
                                        <select class="form-select" id="paciente_id" name="paciente_id" required>
                                            <option value="">Seleccione un paciente</option>
                                            @foreach($pacientes as $paciente)
                                                <option value="{{ $paciente->id }}"
                                                    {{ $paciente_id == $paciente->id ? 'selected' : '' }}>
                                                    {{ $paciente->nombre }} - {{ $paciente->numero_identidad }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Signos Vitales -->
                            <h5 class="border-bottom pb-2 mb-3">Signos Vitales</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="peso" class="form-label">Peso (kg)</label>
                                        <input type="number" step="0.1" class="form-control" id="peso" name="peso"
                                               placeholder="Ej: 70.5">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="altura" class="form-label">Altura (m)</label>
                                        <input type="number" step="0.01" class="form-control" id="altura" name="altura"
                                               placeholder="Ej: 1.75">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="temperatura" class="form-label">Temperatura (°C)</label>
                                        <input type="text" class="form-control" id="temperatura" name="temperatura"
                                               placeholder="Ej: 36.5">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="presion_arterial" class="form-label">Presión Arterial</label>
                                        <input type="text" class="form-control" id="presion_arterial" name="presion_arterial"
                                               placeholder="Ej: 120/80">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="frecuencia_cardiaca" class="form-label">Frecuencia Cardíaca</label>
                                        <input type="text" class="form-control" id="frecuencia_cardiaca" name="frecuencia_cardiaca"
                                               placeholder="Ej: 72 lpm">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <div class="form-check mt-4">
                                            <input class="form-check-input" type="checkbox" id="tiene_fiebre" name="tiene_fiebre" value="1">
                                            <label class="form-check-label" for="tiene_fiebre">
                                                ¿Tiene fiebre?
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Síntomas y Diagnóstico -->
                            <h5 class="border-bottom pb-2 mb-3">Información Médica</h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="sintomas_actuales" class="form-label">Síntomas Actuales</label>
                                        <textarea class="form-control" id="sintomas_actuales" name="sintomas_actuales"
                                                  rows="3" placeholder="Describa los síntomas que presenta el paciente"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="diagnostico" class="form-label">Diagnóstico</label>
                                        <textarea class="form-control" id="diagnostico" name="diagnostico"
                                                  rows="3" placeholder="Diagnóstico médico"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tratamiento" class="form-label">Tratamiento</label>
                                        <textarea class="form-control" id="tratamiento" name="tratamiento"
                                                  rows="3" placeholder="Tratamiento prescrito"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Antecedentes -->
                            <h5 class="border-bottom pb-2 mb-3">Antecedentes</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="alergias" class="form-label">Alergias</label>
                                        <textarea class="form-control" id="alergias" name="alergias"
                                                  rows="2" placeholder="Lista de alergias conocidas"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="medicamentos_actuales" class="form-label">Medicamentos Actuales</label>
                                        <textarea class="form-control" id="medicamentos_actuales" name="medicamentos_actuales"
                                                  rows="2" placeholder="Medicamentos que toma actualmente"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="antecedentes_familiares" class="form-label">Antecedentes Familiares</label>
                                        <textarea class="form-control" id="antecedentes_familiares" name="antecedentes_familiares"
                                                  rows="3" placeholder="Enfermedades hereditarias o familiares"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="antecedentes_personales" class="form-label">Antecedentes Personales</label>
                                        <textarea class="form-control" id="antecedentes_personales" name="antecedentes_personales"
                                                  rows="3" placeholder="Enfermedades previas, cirugías, etc."></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Observaciones -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="observaciones" class="form-label">Observaciones Generales</label>
                                        <textarea class="form-control" id="observaciones" name="observaciones"
                                                  rows="3" placeholder="Observaciones adicionales"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a href="{{ route('expedientes.lista') }}" class="btn btn-secondary me-md-2">
                                            Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            Guardar Expediente
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
