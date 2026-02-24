@extends('layouts.plantillaEnfermeria')
@section('titulo', 'Registrar Incidente')
@section('contenido')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

        .page-wrapper { padding: 80px 20px 40px; }

        .form-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            padding: 2.5rem;
            max-width: 750px;
            margin: 0 auto;
            border-top: 5px solid #4ecdc4;
        }

        .form-title {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 0.3rem;
            text-align: center;
        }

        .form-subtitle {
            text-align: center;
            color: #777;
            margin-bottom: 2rem;
            font-size: 1rem;
        }

        .form-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
            display: block;
        }

        .form-control {
            color: #555;
            padding: 0.75rem 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
            width: 100%;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: #4ecdc4;
            box-shadow: 0 0 0 3px rgba(78,205,196,0.1);
            background: white;
        }

        .form-control[readonly] {
            background: #f0f0f0;
            color: #888;
            cursor: not-allowed;
        }

        textarea.form-control { resize: vertical; min-height: 100px; }

        .form-group { margin-bottom: 1.5rem; }

        .fechas-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        @media (max-width: 600px) { .fechas-grid { grid-template-columns: 1fr; } }

        .fecha-box {
            background: #f0fdfa;
            border: 2px solid #4ecdc4;
            border-radius: 10px;
            padding: 14px;
        }

        .fecha-titulo {
            font-weight: 700;
            color: #00796b;
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .fecha-box .form-control { background: white; border-color: #c8eeeb; }
        .fecha-box .form-control[readonly] { background: #f0f0f0; }

        /* Select2 */
        .select2-container { width: 100% !important; }

        .select2-container--default .select2-selection--single {
            height: 48px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            background: #f8f9fa;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 44px;
            padding-left: 14px;
            color: #555;
            font-size: 1rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow { height: 44px; }

        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: #4ecdc4;
            box-shadow: 0 0 0 3px rgba(78,205,196,0.1);
            background: white;
        }

        .select2-dropdown { border: 2px solid #4ecdc4; border-radius: 8px; }
        .select2-container--default .select2-results__option--highlighted[aria-selected] { background-color: #4ecdc4; }
        .select2-search--dropdown .select2-search__field { border: 2px solid #e0e0e0; border-radius: 6px; padding: 8px; }

        /* Botones */
        .button-group { display: flex; gap: 15px; margin-top: 2rem; justify-content: flex-end; }

        .btn-register {
            padding: 0.875rem 2rem;
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(78,205,196,0.3);
            cursor: pointer;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78,205,196,0.4);
            color: white;
        }

        .btn-cancel {
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

        .btn-cancel:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(220,53,69,0.3);
        }

        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .alert-success { background: #e8f5e9; border-left: 4px solid #4caf50; color: #2e7d32; }
        .alert-danger  { background: #ffebee; border-left: 4px solid #f44336; color: #c62828; }
    </style>

    <div class="page-wrapper">

        @if(session('success'))
            <div class="alert alert-success" style="max-width:750px; margin: 0 auto 20px;">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger" style="max-width:750px; margin: 0 auto 20px;">
                <ul style="margin:0; padding-left:18px;">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <div class="form-container">
            <h1 class="form-title">Registrar Incidente</h1>
            <p class="form-subtitle">Complete el formulario con los detalles del incidente</p>

            <form action="{{ route('incidentes.guardar') }}" method="POST">
                @csrf

                {{-- FECHAS --}}
                <div class="form-group">
                    <div class="fechas-grid">
                        <div class="fecha-box">
                            <div class="fecha-titulo">
                                <i class="bi bi-calendar-event"></i> Fecha del Incidente
                            </div>
                            <input type="datetime-local" class="form-control" name="fecha_hora_incidente"
                                   value="{{ old('fecha_hora_incidente') }}" required>
                            <small class="text-muted">Seleccione la fecha y hora aproximada del incidente</small>
                        </div>
                        <div class="fecha-box">
                            <div class="fecha-titulo">
                                <i class="bi bi-clock"></i> Fecha de Registro
                            </div>
                            <input type="text" class="form-control" value="{{ now()->format('d/m/Y H:i') }}" readonly>
                            <small class="text-muted">Esta se genera automáticamente</small>
                        </div>
                    </div>
                </div>

                {{-- PACIENTE --}}
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-person-fill me-1" style="color:#4ecdc4;"></i> Paciente Involucrado *
                    </label>
                    <select id="paciente_id" name="paciente_id" class="form-control" required style="width:100%; height:48px;">
                        <option value="">-- Seleccione un paciente --</option>
                        @foreach($pacientes as $paciente)
                            <option value="{{ $paciente->id }}" {{ old('paciente_id') == $paciente->id ? 'selected' : '' }}>
                                {{ $paciente->nombres }} {{ $paciente->apellidos }} - {{ $paciente->numero_identidad }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- TIPO --}}
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-tag-fill me-1" style="color:#4ecdc4;"></i> Tipo de Incidente *
                    </label>
                    <select class="form-control" name="tipo_incidente" required>
                        <option value="">Seleccionar tipo</option>
                        <option value="Caída"         {{ old('tipo_incidente') == 'Caída' ? 'selected' : '' }}>Caída</option>
                        <option value="Medicación"    {{ old('tipo_incidente') == 'Medicación' ? 'selected' : '' }}>Medicación</option>
                        <option value="Alergia"       {{ old('tipo_incidente') == 'Alergia' ? 'selected' : '' }}>Alergia</option>
                        <option value="Equipo Médico" {{ old('tipo_incidente') == 'Equipo Médico' ? 'selected' : '' }}>Equipo Médico</option>
                        <option value="Otro"          {{ old('tipo_incidente') == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>

                {{-- GRAVEDAD --}}
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-exclamation-triangle-fill me-1" style="color:#4ecdc4;"></i> Gravedad *
                    </label>
                    <select class="form-control" name="gravedad" required>
                        <option value="">Seleccionar gravedad</option>
                        <option value="Leve"     {{ old('gravedad') == 'Leve' ? 'selected' : '' }}>Leve</option>
                        <option value="Moderado" {{ old('gravedad') == 'Moderado' ? 'selected' : '' }}>Moderado</option>
                        <option value="Grave"    {{ old('gravedad') == 'Grave' ? 'selected' : '' }}>Grave</option>
                        <option value="Crítico"  {{ old('gravedad') == 'Crítico' ? 'selected' : '' }}>Crítico</option>
                    </select>
                </div>

                {{-- DESCRIPCIÓN --}}
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-file-text-fill me-1" style="color:#4ecdc4;"></i> Descripción del Incidente *
                    </label>
                    <textarea class="form-control" name="descripcion" rows="4"
                              placeholder="Describa detalladamente qué ocurrió..." required>{{ old('descripcion') }}</textarea>
                </div>

                {{-- ACCIONES --}}
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-list-check me-1" style="color:#4ecdc4;"></i>
                        Acciones Tomadas <span style="color:#999; font-weight:400;">(Opcional)</span>
                    </label>
                    <textarea class="form-control" name="acciones_tomadas" rows="3"
                              placeholder="Describa las acciones que se tomaron inmediatamente...">{{ old('acciones_tomadas') }}</textarea>
                </div>

                <input type="hidden" name="estado" value="Pendiente">
                <input type="hidden" name="empleado_id" value="{{ session('empleado_id') }}">
                <input type="hidden" name="empleado_nombre" value="{{ session('empleado_nombre') }}">

                <div class="button-group">
                    <a href="{{ route('incidentes.index') }}" class="btn-cancel">Cancelar</a>
                    <button type="submit" class="btn-register">Guardar Incidente</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

@endsection
