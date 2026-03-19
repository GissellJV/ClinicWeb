@extends('layouts.plantilla')

@section('titulo','Citas Archivadas')

@section('contenido')

    <style>

        body{
            font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;
            background:whitesmoke;
            min-height:100vh;
            padding:20px;
        }

        .citas-container{
            max-width:1450px;
            margin:40px auto;
        }

        .header{
            text-align:center;
            margin-bottom:40px;
        }

        .header h1{
            color:#0f766e;
            font-size:2.5rem;
            font-weight:700;
        }

        .alert-custom{
            padding:18px 25px;
            border-radius:12px;
            margin-bottom:25px;
            display:flex;
            align-items:center;
            gap:12px;
        }

        .alert-info-custom{
            background:#ffffff;
            text-align:center;
        }

        .alert-info-custom i{
            font-size:3rem;
            display:block;
            margin-bottom:15px;
        }

        /* GRID DE CITAS */

        .citas-grid{
            display:grid;
            grid-template-columns:repeat(auto-fill,minmax(400px,1fr));
            gap:25px;
        }

        .cita-card{
            background:white;
            border-radius:20px;
            overflow:hidden;
            box-shadow:0 4px 20px rgba(0,0,0,0.08);
            border-left:6px solid #4ECDC4;
            transition:all .3s ease;
        }

        .cita-card:hover{
            transform:translateY(-8px);
            box-shadow:0 8px 30px rgba(0,0,0,0.15);
        }

        .cita-header-card{
            background:linear-gradient(135deg,#4ECDC4 0%,#44A08D 100%);
            padding:25px;
            color:white;
        }

        .doctor-name{
            font-size:1.4rem;
            font-weight:700;
            display:flex;
            align-items:center;
            gap:10px;
        }

        .especialidad-badge{
            display:inline-block;
            background:rgba(255,255,255,0.3);
            padding:6px 14px;
            border-radius:20px;
            font-size:.85rem;
        }

        .cita-body{
            padding:25px;
        }

        .estado-badge{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:10px 18px;
            border-radius:25px;
            font-size:.9rem;
            font-weight:600;
            margin-bottom:15px;
            background:#d4edda;
            color:#155724;
        }

        .cita-info-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:15px;
        }

        .cita-info-item{
            display:flex;
            gap:12px;
        }

        .cita-info-item i{
            color:#4ECDC4;
        }

        .info-label{
            font-size:.75rem;
            color:#7f8c8d;
            text-transform:uppercase;
        }

        .info-value{
            font-size:1rem;
            color:#2c3e50;
            font-weight:600;
        }

        /* PAGINACION */

        .pagination{
            margin-top:10px;
        }

        /* RESPONSIVE */

        @media (max-width:768px){

            .citas-grid{
                grid-template-columns:1fr;
            }

            .cita-info-grid{
                grid-template-columns:1fr;
            }

        }
        .filters-card{
            background:white;
            border-radius:16px;
            padding:25px;
            margin-bottom:30px;
            box-shadow:0 4px 15px rgba(0,0,0,0.08);
        }

        .filters-row{
            display:flex;
            gap:15px;
            flex-wrap:wrap;
            align-items:flex-end;
        }

        .filter-group{
            display:flex;
            flex-direction:column;
            flex:1;
            min-width:200px;
        }

        .filter-group label{
            font-weight:600;
            margin-bottom:8px;
        }

        .filter-group select,
        .filter-group input{
            padding:10px;
            border:1px solid #ddd;
            border-radius:8px;
        }

        .btn-filter{
            padding:12px 30px;
            background:linear-gradient(135deg,#4ECDC4 0%,#44A08D 100%);
            color:white;
            border:none;
            border-radius:10px;
            font-weight:600;
            cursor:pointer;
        }

    </style>

    <div class="citas-container">

        <div class="header">
            <h1>Citas Archivadas</h1>
        </div>


        {{-- ALERTAS BOOTSTRAP --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Filtros -->
        <div class="filters-card">
            <form method="GET" action="{{ route('citas.citasArchivadas') }}">
                <div class="filters-row">

                    <div class="filter-group">
                        <label><i class="fas fa-stethoscope"></i> Filtrar por Especialidad</label>
                        <select name="especialidad">
                            <option value="">Todas</option>
                            <option value="Pediatría" {{ request('especialidad') == 'Pediatría' ? 'selected' : '' }}>Pediatría</option>
                            <option value="Medicina General" {{ request('especialidad') == 'Medicina General' ? 'selected' : '' }}>Medicina General</option>
                            <option value="Dermatología" {{ request('especialidad') == 'Dermatología' ? 'selected' : '' }}>Dermatología</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label><i class="fas fa-calendar"></i> Filtrar por Fecha</label>
                        <input type="date"
                               name="fecha"
                               class="form-control"
                               value="{{ request('fecha') }}">
                    </div>

                    <div class="filter-group">
                        <button type="submit" class="btn-filter">
                            <i class="fas fa-search"></i> Filtrar
                        </button>
                    </div>

                </div>
            </form>
        </div>



        @if($citas->count() > 0)

            <div class="citas-grid">

                @foreach($citas as $cita)

                    <div class="cita-card archivada">

                        <div class="cita-header-card">

                            <div class="doctor-name">

                                @if($cita->doctor && $cita->doctor->foto)

                                    <img src="data:image/jpeg;base64,{{ base64_encode($cita->doctor->foto) }}"
                                         style="width:45px;height:45px;border-radius:50%;object-fit:cover;">

                                @else
                                    <i class="fas fa-user-md"></i>
                                @endif

                                @if($cita->doctor)
                                    {{ $cita->doctor->genero == 'Femenino' ? 'Dra.' : 'Dr.' }}
                                    {{ $cita->doctor->nombre }}
                                    {{ $cita->doctor->apellido }}
                                @endif

                            </div>
                            <span class="especialidad-badge">
                                    {{ $cita->especialidad ?? 'No definida' }}
                                </span>
                        </div>


                        <div class="cita-body">

                            <div class="estado-badge estado-programada">
                                <i class="fas fa-box-archive"></i>
                                Archivada
                            </div>


                            <div class="cita-info-grid">

                                <div class="cita-info-item">
                                    <i class="fas fa-user"></i>

                                    <div class="info-content">
                                        <div class="info-label">Paciente</div>
                                        <div class="info-value">
                                            {{ session('paciente_nombre') }}
                                        </div>
                                    </div>
                                </div>



                                <div class="cita-info-item">
                                    <i class="fas fa-calendar"></i>

                                    <div class="info-content">
                                        <div class="info-label">Fecha</div>
                                        <div class="info-value">
                                            {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}
                                        </div>
                                    </div>
                                </div>



                                <div class="cita-info-item">
                                    <i class="fas fa-clock"></i>

                                    <div class="info-content">
                                        <div class="info-label">Hora</div>
                                        <div class="info-value">
                                            {{ $cita->hora }}
                                        </div>
                                    </div>
                                </div>



                                <div class="cita-info-item">
                                    <i class="fas fa-hospital"></i>

                                    <div class="info-content">
                                        <div class="info-label">Clínica</div>
                                        <div class="info-value">
                                            ClinicWeb
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>
            <div class="pagination d-flex justify-content-end mt-3">

                <nav>
                    <ul class="pagination">

                        {{-- Botón anterior --}}
                        <li class="page-item {{ $citas->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $citas->previousPageUrl() ?? '#' }}">
                                Anterior
                            </a>
                        </li>

                        {{-- Página actual --}}
                        <li class="page-item active">
                <span class="page-link">
                    {{ $citas->currentPage() }}
                </span>
                        </li>

                        {{-- Botón siguiente --}}
                        <li class="page-item {{ !$citas->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $citas->nextPageUrl() ?? '#' }}">
                                Siguiente
                            </a>
                        </li>

                    </ul>
                </nav>

            </div>

        @else

            <div class="alert-custom alert-info-custom">
                <i class="fas fa-box-open"></i>
                <div>
                    <h5>No tienes citas archivadas</h5>
                </div>
            </div>

        @endif

    </div>

@endsection
