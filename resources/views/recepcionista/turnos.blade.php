@extends('layouts.plantillaRecepcion')
@section('contenido')

    <style>
        body {
            background: #f7fdfc;
            font-family: 'Segoe UI', sans-serif;
        }

        .stat-card {
            border: none;
            border-radius: 15px;
            color: white;
            padding: 1.2rem;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .mint { background-color: #00bfa6 !important; }
        .aqua { background-color: #4cd7c6 !important; }
        .turq { background-color: #82e9de !important; color: #004b46 !important; }
        .soft { background-color: #b2f5ea !important; color: #004b46 !important; }

        .card-custom {
            border-radius: 18px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.1);
            border: none;
        }

        .btn-primary {
            background-color: #00bfa6 !important;
            border-color: #00bfa6 !important;
        }

        .btn-primary:hover {
            background-color: #009e8e !important;
            border-color: #009e8e !important;
        }

        .btn-outline-primary {
            color: #00bfa6 !important;
            border-color: #00bfa6 !important;
        }

        .btn-outline-primary:hover {
            background-color: #00bfa6 !important;
            color: white !important;
        }

        .btn-outline-info {
            color: #4cd7c6 !important;
            border-color: #4cd7c6 !important;
        }

        .btn-outline-info:hover {
            background-color: #4cd7c6 !important;
            color: white !important;
        }

        .btn-outline-danger {
            color: #e74c3c !important;
            border-color: #e74c3c !important;
        }

        .btn-outline-danger:hover {
            background-color: #e74c3c !important;
            color: white !important;
        }

        table thead {
            background: #b2f5ea !important;
            color: #004b46 !important;
        }
    </style>

    <br><br><br>

    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="fw-bold mint p-2 px-3 text-white rounded">Turnos de Doctores</h2>

            <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalNuevoTurno">
                <i class="bi bi-calendar-plus"></i> Nuevo Turno
            </button>

            <!-- MODAL MODERNO -->
            <div class="modal fade" id="modalNuevoTurno" data-bs-backdrop="static" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content shadow-lg border-0 rounded-4">

                        <!-- Header -->
                        <div class="modal-header bg-primary text-white rounded-top-4">
                            <h5 class="modal-title d-flex align-items-center gap-2">
                                <i class="bi bi-calendar-check"></i>
                                Asignar Nuevo Turno
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>

                        <!-- Form -->
                        <form action="{{ route('recepcionista.store') }}" method="POST">
                            @csrf

                            <div class="modal-body">

                                <!-- Sección: Información del Turno -->
                                <h6 class="fw-bold text-primary mb-3">
                                    <i class="bi bi-person-badge"></i> Información del Turno
                                </h6>

                                <div class="row g-3">

                                    <!-- Doctor -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Doctor</label>
                                        <select name="empleado_id" class="form-select shadow-sm" required>
                                            <option value="">Seleccione un doctor</option>
                                            @foreach ($doctores as $doc)
                                                <option value="{{ $doc->id }}">{{ $doc->nombre }} {{ $doc->apellido }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Cita -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Cita</label>
                                        <select name="cita_id" class="form-select shadow-sm" required>
                                            <option value="">Seleccione una cita</option>
                                            @foreach ($citas as $cita)
                                                <option value="{{ $cita->id }}">
                                                    Cita #{{ $cita->id }} – {{ $cita->paciente->nombre ?? 'Paciente' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <hr class="my-4">

                                <!-- Sección: Fecha y Hora -->
                                <h6 class="fw-bold text-primary mb-3">
                                    <i class="bi bi-clock-history"></i> Fecha y Hora
                                </h6>

                                <div class="row g-3">
                                    <!-- Fecha -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Fecha del turno</label>
                                        <input type="date" name="fecha" class="form-control shadow-sm" required>
                                    </div>

                                    <!-- Hora -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Hora del turno</label>
                                        <input type="time" name="hora_turno" class="form-control shadow-sm" required>
                                    </div>
                                </div>

                            </div>

                            <!-- Footer -->
                            <div class="modal-footer d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle"></i> Cancelar
                                </button>

                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-check-circle"></i> Guardar Turno
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="card card-custom soft mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('recepcionista.index') }}" class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Doctor</label>
                        <input type="text" name="doctor" class="form-control" value="{{ request('doctor') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Especialidad</label>
                        <input type="text" name="especialidad" class="form-control" value="{{ request('especialidad') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Fecha</label>
                        <input type="date" name="fecha" class="form-control" value="{{ request('fecha') }}">
                    </div>

                    <div class="col-md-1 d-flex align-items-end">
                        <button class="btn btn-primary w-100 shadow-sm">Filtrar</button>
                    </div>

                </form>
            </div>
        </div>

        <div class="card card-custom">
            <div class="card-body">

                <table class="table table-hover align-middle">
                    <thead>
                    <tr>
                        <th>Doctor</th>
                        <th>Especialidad</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                    </thead>

                    <tbody id="tablaTurnos">
                    @forelse ($turnos as $turno)
                        <tr>
                            <td>{{ $turno->empleado->nombre }} {{ $turno->empleado->apellido }}</td>
                            <td>{{ $turno->empleado->departamento->nombre}}</td>
                            <td>{{\Carbon\Carbon::parse($turno->fecha)->format('d/m/Y') }}</td>
                            <td>{{ $turno->hora_turno }}</td>
                            <td>{{$turno->cita->estado}}</td>

                            <td class="text-center">
                                <!-- <button class="btn btn-outline-info btn-sm" onclick="verDetalles({{ $turno->id }})">
                                    <i class="bi bi-eye"></i>
                                </button>

                                <button class="btn btn-outline-primary btn-sm" onclick="editarTurno({{ $turno->id }})">
                                    <i class="bi bi-pencil"></i>
                                </button>

                                <button class="btn btn-outline-danger btn-sm" onclick="eliminarTurno({{ $turno->id }})">
                                    <i class="bi bi-trash"></i>
                                </button> -->
                                <button class="btn btn-outline-success btn-sm mt-1" onclick="verMas({{ $turno->id }})">
                                    Ver más
                                </button>

                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No hay turnos registrados</td>
                        </tr>
                    @endforelse
                    </tbody>

                </table>

                <div class="mt-3">
                    {{ $turnos->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: Ver Detalles -->
    <div class="modal fade" id="modalDetalles" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-3 shadow">

                <div class="modal-header mint text-white">
                    <h5 class="modal-title">Detalles del Turno</h5>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" id="contenidoDetalles">
                    <!-- AJAX -->
                </div>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function verDetalles(id) {
            fetch(`/turnos/${id}`)
                .then(r => r.json())
                .then(data => {
                    let html = `
                    <h5 class="fw-bold">${data.doctor.nombre} ${data.doctor.apellido}</h5>
                    <p><strong>Especialidad:</strong> ${data.doctor.especialidad.nombre}</p>
                    <p><strong>Fecha:</strong> ${data.fecha}</p>
                    <p><strong>Hora:</strong> ${data.hora}</p>
                    <hr>
                    <h6 class="fw-bold">Pacientes asignados</h6>
                    <ul>
                        ${data.pacientes.length > 0
                        ? data.pacientes.map(p => `<li>${p.nombre} ${p.apellido}</li>`).join('')
                        : "<p class='text-muted'>Sin pacientes asignados</p>"
                    }
                    </ul>
                `;
                    document.getElementById('contenidoDetalles').innerHTML = html;
                    new bootstrap.Modal('#modalDetalles').show();
                });
        }
    </script>
@endsection

<script>
    function verMas(id) {
        window.location.href = '/turnos/${id}/vermas';
    }
</script>
