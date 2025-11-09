<style>
    /* Botones */
    .btn-actualizar {
        background-color: white;
        color: #4ecdc4;
        border: 2px solid #4ecdc4;
        transition: 0.3s;
    }
    .btn-actualizar:hover {
        background-color: #4ecdc4;
        color: white;
    }

    .btn-guardar {
        background-color: #4ecdc4;
        color: white;
        border: 2px solid #4ecdc4;
        transition: 0.3s;
    }
    .btn-guardar:hover {
        background-color: #3eb2aa;
        color: white;
    }

    /* Alinear botones a la derecha */
    .text-end {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    /* Inputs y textarea deshabilitados con estilo claro */
    input:disabled, textarea:disabled {
        background-color: #f8f9fa;
    }

    /* Inputs y textarea habilitados */
    input, textarea {
        transition: 0.3s;
    }
    input:enabled, textarea:enabled {
        background-color: #ffffff;
        border: 1px solid #4ecdc4;
    }
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --primary-color: #4ecdc4;
        --secondary-color: #44a08d;
        --primary-light: #e8f8f7;
        --primary-lighter: #d4f4f1;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #ffffff;
        min-height: 100vh;
    }

    .navbar-brand-top i {
        font-size: 1.75rem;
    }


    .welcome-banner strong {
        color: #44a08d;
        font-weight: 600;
    }

    .welcome-banner span {
        color: #333;
    }

    .menu-divider select {
        width: 100%;
        padding: 0.625rem;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        color: #555;
        background: white;
    }

    .btn-logout:hover {
        background: #dc3545;
        color: white;
    }


    .search-box input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        margin-bottom: 0.75rem;
    }

    .search-box .btn-search {
        width: 100%;
        padding: 0.75rem;
        background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        border: none;
        color: white;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .search-box .btn-search:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(78, 205, 196, 0.3);
    }

    h1 {
        font-size: 2rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 2rem;
    }

    /* Tabs */
    .tabs {
        display: flex;
        background-color: #f8f9fa;
        border-bottom: 2px solid #e0e0e0;
        margin-bottom: 0;
        border-radius: 12px 12px 0 0;
        overflow: hidden;
    }

    .tab {
        padding: 15px 25px;
        cursor: pointer;
        color: #666;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
        flex: 1;
        text-align: center;
    }

    .tab:hover {
        background-color: #e9ecef;
    }

    .tab.active {
        color: #4ecdc4;
        border-bottom-color: #4ecdc4;
        background-color: white;
    }

    /* Card Body */
    .card-body {
        background: white;
        border-radius: 0 0 12px 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        padding: 2rem;
    }

    /* Tab Content */
    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    /* Card Header Custom */
    .card-header-custom {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e0e0e0;
    }

    .card-header-custom i {
        font-size: 1.5rem;
        color: #4ecdc4;
    }

    .card-header-custom h5 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
    }

    /* Table Styling */
    .info-table {
        width: 100%;
    }

    .info-table tr {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 1.5rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .info-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #555;
    }

    .info-value {
        padding: 0.875rem 1rem;
        background: #f8f9fa;
        border-radius: 8px;
        color: #333;
        border: 1px solid #e0e0e0;
        min-height: 48px;
        display: flex;
        align-items: center;
    }

    .info-value:empty::before {
        content: '\00a0';
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .sidebar {
            width: 320px;
        }

        .main-content {
            margin-left: 320px;
            width: calc(100% - 320px);
        }
    }

    @media (max-width: 992px) {
        .info-table tr {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
    }

    @media (max-width: 768px) {
        .tabs {
            overflow-x: auto;
            flex-wrap: nowrap;
        }

        .tab {
            white-space: nowrap;
            padding: 12px 20px;
            font-size: 12px;
            flex: 0 0 auto;
        }

        h1 {
            font-size: 1.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }
    }
</style>
<div class="container-fluid p-0" style="margin-top: 100px;">
    <h1>Visualización de Expediente</h1>
    <br>
    <div class="tabs d-flex border-bottom">
        <div class="tab active" data-tab="Paciente">Paciente</div>
        <div class="tab" data-tab="signos">Signos Vitales</div>
        <div class="tab" data-tab="informacion">Información Médica</div>
        <div class="tab" data-tab="antecedentes">Historial Clínico</div>
    </div>

    <div class="card-body p-4 bg-white">

        <!-- INFORMACION DEL PCIENTE -->
        <div class="tab-content active" id="Paciente" >

            <div class="card-header-custom">
                <img src="{{ asset('imagenes/usuario.png') }}" alt="usuario" style="height: 25px; width: 25px; filter: grayscale(1) brightness(0.5);">
                <h5 class="mb-0">Información general del paciente</h5>
            </div>

            <table class="info-table">
                <tbody>
                <tr>
                    <td class="info-item" style="grid-column: 1 / -1;">
                        <span class="info-label">Nombre:</span>
                        <div class="info-value">{{ $expediente->paciente->nombres }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="info-item" style="grid-column: 1 / -1;">
                        <span class="info-label">Apellido:</span>
                        <div class="info-value">{{ $expediente->paciente->apellidos }}</div>
                    </td>
                </tr>
                <tr>
                    <td class=" info-item" style="grid-column: 1 / -1;">
                        <span class="info-label">Género:</span>
                        <div class="info-value">{{ $expediente->paciente->genero }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="info-item" style="grid-column: 1 / -1;">
                        <span class="info-label">Fecha de Nacimiento:</span>
                        <div class="info-value">{{ $expediente->paciente->fecha_nacimiento }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="info-item" style="grid-column: 1 / -1;">
                        <span class="info-label">Número de identidad:</span>
                        <div class="info-value">{{ $expediente->paciente->numero_identidad }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="info-item" style="grid-column: 1 / -1;">
                        <span class="info-label">Teléfono:</span>
                        <div class="info-value">{{ $expediente->paciente->telefono }}</div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- SIGNOS VITALES -->
        <div class="tab-content" id="signos">
            <div class="card-header-custom" style="display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <img src="{{ asset('imagenes/signosVi.png') }}" alt="signos"
                         style="height: 27px; width: 26px; filter: grayscale(1) brightness(0.5);">
                    <h5 class="mb-0">Parámetros Vitales del Paciente</h5>
                </div>
                <button type="button" id="btnEditarSignos" class="btn btn-actualizar">
                    Actualizar
                </button>
            </div>


            <form id="formSignos" method="POST" action="{{ route('expedientes.actualizarSignos', $expediente->id) }}">
                @csrf
                <table class="info-table">
                    <tbody>
                    <tr>
                        <td class="info-item" style="grid-column: 1 / -1;">
                            <span class="info-label">Peso:</span>
                            <input type="number" class="form-control" name="peso" value="{{ $expediente->peso }}" disabled step="any" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-item" style="grid-column: 1 / -1;">
                            <span class="info-label">Altura:</span>
                            <input type="number" class="form-control" name="altura" value="{{ $expediente->altura }}" disabled step="any" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-item" style="grid-column: 1 / -1;">
                            <span class="info-label">Presión Arterial:</span>
                            <input type="text" class="form-control" name="presion_arterial" value="{{ $expediente->presion_arterial }}" disabled required>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-item" style="grid-column: 1 / -1;">
                            <span class="info-label">Frecuencia Cardíaca:</span>
                            <input type="text" class="form-control" name="frecuencia_cardiaca" value="{{ $expediente->frecuencia_cardiaca }}" disabled required>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-item" style="grid-column: 1 / -1;">
                            <span class="info-label">Temperatura:</span>
                            <input type="number" class="form-control" name="temperatura" value="{{ $expediente->temperatura }}" disabled step="any" required>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <!-- Botón guardar alineado a la derecha -->
                <div class="text-end mt-3">
                    <button type="submit" id="btnGuardarSignos" class="btn btn-guardar d-none">Guardar</button>
                </div>
            </form>
        </div>

        <div class="tab-content" id="informacion">
            <div class="card-header-custom" style="display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 10px;">
                <img src="{{ asset('imagenes/registroC.png') }}" alt="usuario" style="height: 25px; width: 25px; filter: grayscale(1) brightness(0.5);">
                <h5 class="mb-0">Registro de Consulta Médica</h5>
                </div>
                <button type="button" id="btnEditarConsulta" class="btn btn-actualizar">Actualizar</button>
            </div>

            <form id="formConsulta" method="POST" action="{{ route('expedientes.actualizarConsulta', $expediente->id) }}">
                @csrf
                <table class="info-table">
                    <tbody>
                    <tr>
                        <td class="info-item" style="grid-column: 1 / -1;">
                            <span class="info-label">Síntomas Actuales:</span>
                            <textarea  class="form-control" name="sintomas_actuales" rows="3" disabled>{{ $expediente->sintomas_actuales }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-item" style="grid-column: 1 / -1;">
                            <span class="info-label">Diagnóstico:</span>
                            <textarea class="form-control" name="diagnostico" rows="3" disabled>{{ $expediente->diagnostico }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-item" style="grid-column: 1 / -1;">
                            <span class="info-label">Tratamiento:</span>
                            <textarea class="form-control" name="tratamiento" rows="3" disabled>{{ $expediente->tratamiento }}</textarea>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>

        <div class="tab-content" id="antecedentes">
            <div class="card-header-custom">
                <img src="{{ asset('imagenes/ante.png') }}" alt="antecedentes" style="height: 25px; width: 24px; filter: grayscale(1) brightness(0.5);">
                <h5 class="mb-0">Antecedentes</h5>
            </div>


            <table class="info-table">
            <tbody>

            <tr>
                <td class="info-item" style="grid-column: 1 / -1;">
                    <span class="info-label">Alergias:</span>
                    <div class="info-value">{{$expediente->alergias}}</div>
                </td>
            </tr>
            <tr>
                <td class="info-item" style="grid-column: 1 / -1;">
                    <span class="info-label">Medicamentos Actuales:</span>
                    <div class="info-value">{{$expediente->medicamentos_actuales}}</div>
                </td>

            </tr>
            <tr>
                <td class="info-item" style="grid-column: 1 / -1;">
                    <span class="info-label">Antecedentes Familiares:</span>
                    <div class="info-value">{{$expediente->antecedentes_familiares}}</div>
                </td>
            </tr>
            <tr>
                <td class="info-item" style="grid-column: 1 / -1;">
                    <span class="info-label">Antecedentes Personales:</span>
                    <div class="info-value">{{$expediente->antecedentes_personales}}</div>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="card-header-custom mt-4">
            <img src="{{ asset('imagenes/notas.png') }}" alt="notas" style="height: 25px; width: 24px; filter: grayscale(1) brightness(0.5);">
            <h5 class="mb-0">Notas Adicionales</h5>
        </div>

        <table class="info-table">
            <tbody>
            <tr>
                <td class="info-item" style="grid-column: 1 / -1;">
                    <span class="info-label">Observaciones Generales:</span>
                    <div class="info-value">{{$expediente->observaciones}}</div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<br><br>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                function habilitarEdicion(btnEditarId, formId, btnGuardarId) {
                    const btnEditar = document.getElementById(btnEditarId);
                    const form = document.getElementById(formId);
                    const btnGuardar = document.getElementById(btnGuardarId);
                    const inputs = form.querySelectorAll('input, textarea');
                    let modoEdicion = false;

                    btnEditar.addEventListener('click', function() {
                        if (!modoEdicion) {
                            inputs.forEach(i => i.disabled = false);
                            btnEditar.textContent = 'Guardar';
                            btnEditar.classList.remove('btn-actualizar');
                            btnEditar.classList.add('btn-guardar');
                            btnGuardar.classList.remove('d-none');
                            modoEdicion = true;
                        } else {
                            form.submit();
                        }
                    });
                }

                habilitarEdicion('btnEditarSignos', 'formSignos', 'btnGuardarSignos');
                habilitarEdicion('btnEditarConsulta', 'formConsulta', 'btnGuardarConsulta');
            });
        </script>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.tab');
        const contents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-tab');

                tabs.forEach(t => t.classList.remove('active'));
                contents.forEach(c => c.classList.remove('active'));

                this.classList.add('active');
                document.getElementById(targetTab).classList.add('active');
            });
        });
    });
</script>

