@extends('layouts.plantillaRecepcion')
@section('titulo', 'Programar Cirugía')

@section('contenido')
    <style>
        body { padding-top: 100px; }
        .cirugia-container {
            max-width: 900px;
            margin: 0 auto 50px auto;
            padding: 0 20px;
        }
        .cirugia-header {
            background: linear-gradient(135deg, #4ECDC4, #44a08d);
            color: white;
            padding: 25px 30px;
            border-radius: 12px;
            margin-bottom: 25px;
        }
        .cirugia-header h2 { margin: 0 0 5px 0; font-size: 1.7rem; }
        .cirugia-header p  { margin: 0; opacity: 0.85; }
        .section-card {
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
            margin-bottom: 20px;
        }
        .form-label { font-weight: 600; color: #444; font-size: 0.9rem; }
        .form-control:focus, .form-select:focus {
            border-color: #4ECDC4;
            box-shadow: 0 0 0 3px rgba(78,205,196,0.15);
        }
        .datos-precargados {
            background: #e8f8f6;
            border: 1px solid #4ECDC4;
            border-radius: 10px;
            padding: 18px 22px;
            margin-bottom: 22px;
        }
        .datos-precargados .dato-label { font-size: 0.8rem; color: #666; display: block; }
        .datos-precargados .dato-val   { font-weight: 700; color: #2c3e50; }
        .quirofano-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 12px;
            margin-top: 8px;
        }
        .quirofano-option input[type="radio"] { display: none; }
        .quirofano-option label {
            display: block;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.25s;
            font-weight: 600;
        }
        .quirofano-option input:checked + label {
            border-color: #4ECDC4;
            background: #e8f8f6;
            color: #44a08d;
        }
        .quirofano-option label:hover { border-color: #4ECDC4; }
        .disponibilidad-msg {
            font-size: 0.85rem;
            margin-top: 6px;
            display: none;
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
        .btn-cancelar:hover { background: #dc3545; color: white; transform: translateY(-2px); box-shadow: 0 4px 10px rgba(220,53,69,0.3); }
        .badge-riesgo {
            padding: 3px 12px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 700;
        }
        .riesgo-bajo  { background:#d4edda; color:#155724; }
        .riesgo-medio { background:#fff3cd; color:#856404; }
        .riesgo-alto  { background:#f8d7da; color:#721c24; }
    </style>

    <div class="cirugia-container">

        <div class="cirugia-header">
            <h2><i class="bi bi-scissors me-2"></i>Programar Cirugía en Quirófano</h2>
            <p>Asigne espacio, fecha y hora para el procedimiento quirúrgico</p>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle me-2"></i><strong>Corrige los siguientes errores:</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- DATOS PRECARGADOS (paciente + tipo cirugía) --}}
        <div class="datos-precargados">
            <div class="row g-3">
                <div class="col-md-4">
                    <span class="dato-label"><i class="bi bi-person-fill me-1"></i>Paciente</span>
                    <span class="dato-val">{{ $evaluacion->paciente->nombres }} {{ $evaluacion->paciente->apellidos }}</span>
                </div>
                <div class="col-md-4">
                    <span class="dato-label"><i class="bi bi-scissors me-1"></i>Tipo de Cirugía</span>
                    <span class="dato-val">{{ $evaluacion->tipo_cirugia }}</span>
                </div>
                <div class="col-md-4">
                    <span class="dato-label"><i class="bi bi-person-badge me-1"></i>Cirujano</span>
                    <span class="dato-val">Dr. {{ $evaluacion->doctor->nombre }} {{ $evaluacion->doctor->apellido }}</span>
                </div>
                <div class="col-md-4">
                    <span class="dato-label">Diagnóstico</span>
                    <span class="dato-val">{{ $evaluacion->diagnostico }}</span>
                </div>
                <div class="col-md-4">
                    <span class="dato-label">Nivel de Riesgo</span>
                    <span class="dato-val">
                    <span class="badge-riesgo riesgo-{{ $evaluacion->nivel_riesgo }}">{{ ucfirst($evaluacion->nivel_riesgo) }}</span>
                </span>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('recepcionista.cirugia.guardar') }}" id="formCirugia">
            @csrf
            <input type="hidden" name="evaluacion_id" value="{{ $evaluacion->id }}">

            {{-- SECCIÓN 1: Quirófano --}}
            <div class="section-card">
                <div class="section-title"><i class="bi bi-hospital me-2"></i>Selección de Quirófano *</div>
                <div class="quirofano-grid">
                    @foreach($quirofanos as $q)
                        <div class="quirofano-option">
                            <input type="radio" name="quirofano" id="q_{{ $loop->index }}"
                                   value="{{ $q }}" {{ old('quirofano') == $q ? 'checked' : '' }} required>
                            <label for="q_{{ $loop->index }}">
                                <i class="bi bi-hospital-fill d-block mb-1" style="font-size:1.4rem"></i>
                                {{ $q }}
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('quirofano')<small class="text-danger mt-2 d-block">{{ $message }}</small>@enderror
                <div id="disponibilidadMsg" class="disponibilidad-msg"></div>
            </div>

            {{-- SECCIÓN 2: Fecha y hora --}}
            <div class="section-card">
                <div class="section-title"><i class="bi bi-calendar-event me-2"></i>Fecha y Hora de la Cirugía</div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Fecha de la Cirugía *</label>
                        <input type="date" name="fecha_cirugia" id="fecha_cirugia"
                               class="form-control @error('fecha_cirugia') is-invalid @enderror"
                               value="{{ old('fecha_cirugia') }}"
                               min="{{ date('Y-m-d') }}" required>
                        @error('fecha_cirugia')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Hora de Inicio *</label>
                        <input type="time" name="hora_inicio" id="hora_inicio"
                               class="form-control @error('hora_inicio') is-invalid @enderror"
                               value="{{ old('hora_inicio') }}" required>
                        @error('hora_inicio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Hora de Fin *</label>
                        <input type="time" name="hora_fin" id="hora_fin"
                               class="form-control @error('hora_fin') is-invalid @enderror"
                               value="{{ old('hora_fin') }}" required>
                        @error('hora_fin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Duración Estimada (minutos) *</label>
                        <input type="number" name="duracion_estimada_min" id="duracion"
                               class="form-control @error('duracion_estimada_min') is-invalid @enderror"
                               value="{{ old('duracion_estimada_min') }}" min="15" max="720"
                               placeholder="Ej: 90" required>
                        @error('duracion_estimada_min')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- SECCIÓN 3: Equipo --}}
            <div class="section-card">
                <div class="section-title"><i class="bi bi-people me-2"></i>Equipo y Recursos</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Anestesiólogo</label>
                        <input type="text" name="anestesiologo"
                               class="form-control @error('anestesiologo') is-invalid @enderror"
                               value="{{ old('anestesiologo') }}" placeholder="Nombre del anestesiólogo">
                        @error('anestesiologo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Instrumentos Requeridos</label>
                        <textarea name="instrumentos_requeridos" rows="2" class="form-control"
                                  placeholder="Equipos o instrumentos especiales necesarios">{{ old('instrumentos_requeridos') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Notas Adicionales</label>
                        <textarea name="notas_adicionales" rows="2" class="form-control"
                                  placeholder="Cualquier nota especial para la cirugía">{{ old('notas_adicionales') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-3 justify-content-end mt-3">
                <a href="{{ route('listadocitas') }}" class="btn-cancelar">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-guardar" id="btnGuardar">
                    Programar Cirugía
                </button>
            </div>
        </form>
    </div>

    <script>
        // Calcular duración automáticamente
        function calcularDuracion() {
            const inicio = document.getElementById('hora_inicio').value;
            const fin = document.getElementById('hora_fin').value;
            if (inicio && fin) {
                const [hi, mi] = inicio.split(':').map(Number);
                const [hf, mf] = fin.split(':').map(Number);
                const diff = (hf * 60 + mf) - (hi * 60 + mi);
                if (diff > 0) {
                    document.getElementById('duracion').value = diff;
                }
            }
        }
        document.getElementById('hora_inicio').addEventListener('change', calcularDuracion);
        document.getElementById('hora_fin').addEventListener('change', calcularDuracion);

        // Verificar disponibilidad de quirófano via AJAX
        function verificarDisponibilidad() {
            const quirofanoChecked = document.querySelector('input[name="quirofano"]:checked');
            const fecha = document.getElementById('fecha_cirugia').value;
            const horaInicio = document.getElementById('hora_inicio').value;
            const horaFin = document.getElementById('hora_fin').value;
            const msg = document.getElementById('disponibilidadMsg');

            if (!quirofanoChecked || !fecha || !horaInicio || !horaFin) return;

            fetch(`/recepcionista/cirugia/verificar-quirofano?quirofano=${encodeURIComponent(quirofanoChecked.value)}&fecha=${fecha}&hora_inicio=${horaInicio}&hora_fin=${horaFin}`)
                .then(r => r.json())
                .then(data => {
                    msg.style.display = 'block';
                    if (data.disponible) {
                        msg.className = 'disponibilidad-msg text-success fw-bold';
                        msg.innerHTML = '<i class="bi bi-check-circle me-1"></i>Quirófano disponible en ese horario';
                    } else {
                        msg.className = 'disponibilidad-msg text-danger fw-bold';
                        msg.innerHTML = '<i class="bi bi-x-circle me-1"></i>Quirófano ocupado en ese horario. Elige otro.';
                    }
                });
        }

        document.querySelectorAll('input[name="quirofano"]').forEach(r => r.addEventListener('change', verificarDisponibilidad));
        document.getElementById('fecha_cirugia').addEventListener('change', verificarDisponibilidad);
        document.getElementById('hora_inicio').addEventListener('change', verificarDisponibilidad);
        document.getElementById('hora_fin').addEventListener('change', verificarDisponibilidad);

        // Loading al enviar
        document.getElementById('formCirugia').addEventListener('submit', function(e) {
            const fechaVal = document.getElementById('fecha_cirugia').value;
            const hoy = new Date().toISOString().split('T')[0];
            if (fechaVal < hoy) {
                e.preventDefault();
                alert('La fecha de la cirugía no puede ser anterior a hoy.');
                return;
            }
            const btn = document.getElementById('btnGuardar');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Programando...';
        });
    </script>
@endsection
