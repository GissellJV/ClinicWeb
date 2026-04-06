@extends('layouts.plantillaDoctor')
@section('contenido')

    <style>
        /* ESTADÍSTICAS  */
        .stock-alerts{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
            gap:20px;margin-bottom:30px;
        }

        .stat-card{
            background:#fff;
            border-radius:15px;
            padding:20px;box-shadow:0 5px 15px rgba(0,0,0,.08);
            border-left:5px solid;
            transition:all .3s;
        }

        .stat-card:hover{
            transform:translateY(-5px);
            box-shadow:0 10px 25px rgba(0,0,0,.12);
        }
        .sc-blue{
            border-left-color:#3498db;
            background:linear-gradient(135deg,#fff 0%,#eaf4fb 100%);
        }
        .sc-red{
            border-left-color:#f1948a;
            background: linear-gradient(135deg, #fff 0%, #fdedec 100%);
        }

        .sc-green{
            border-left-color:#27ae60;
            background:linear-gradient(135deg,#fff 0%,#eafaf1 100%);
        }

        .stat-num{
            font-size:2rem;
            font-weight:700;
            line-height:1;
            margin-bottom:.2rem;
        }

        .sc-blue .stat-num{
            color:#3498db;
        }

        .sc-red .stat-num{
            color:#e74c3c;
        }

        .sc-green .stat-num{
            color:#27ae60;
        }

        .stat-l1{
            font-size:.84rem;
            font-weight:600;
            color:#2c3e50;
            margin-bottom:.2rem;
        }
        .inventory-card{
            background:#fff;
            border-radius:20px;
            box-shadow:0 10px 30px rgba(0,0,0,.08);
            overflow:visible;
            padding:25px;
        }

        /* TABLA*/

        .dt-wrap {
            width: 100%;
            overflow-x: auto;
        }

        @media (min-width: 992px) {
            .dt-wrap {
                overflow-x: visible;
            }
        }

        table.dataTable{
            width:100%!important;
            border-collapse:collapse;
            table-layout:auto;
            white-space:nowrap;
        }

        table.dataTable thead th{
            padding:20px!important;
            text-align:left;
            font-weight:700;
            font-size:13px;
            letter-spacing:.5px;
            text-transform:uppercase;
            border-bottom:2px solid #e0e0e0;
            background:#00bfa6!important;
            color:#fff!important;
            white-space:nowrap;
        }
        table.dataTable thead th.sorting::after,
        table.dataTable thead th.sorting_asc::after,
        table.dataTable thead th.sorting_desc::after{
            color:rgba(255,255,255,.5)!important;
        }
        table.dataTable tbody tr{
            border-bottom:1px solid #f0f0f0;
            transition:all .2s;
        }
        table.dataTable tbody tr:hover{
            background:#f8f9fa;
        }
        table.dataTable tbody td{
            padding:20px!important;
            color:#666;
            white-space:nowrap;
            vertical-align:middle;
        }
        .num-cell{
            font-weight:700;
            color:#7f8c8d;
            font-size:.73rem;
            text-align:center;
        }
        .dataTables_wrapper .dataTables_length select{
            width:65px!important;
            border:2px solid #e0e0e0;
            border-radius:8px;
            padding:5px 10px;
            margin:0 10px;
            font-family:inherit;
        }
        .dataTables_wrapper .dataTables_filter input{
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 8px 15px;
            margin-left: 10px;

        }
        .dataTables_wrapper .dataTables_length {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .dataTables_wrapper .dataTables_length label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            font-size: 14px;
            color: #555;
        }

        .dataTables_wrapper .dataTables_length select {
            width: 65px !important;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 5px 8px;
            margin: 0 !important;
            font-family: inherit;
        }

        .dataTables_wrapper .dataTables_filter label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            font-size: 14px;
            color: #555;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 6px 12px;
            font-family: inherit;
            width: 200px;
        }
        .dataTables_wrapper .dataTables_filter input:focus{
            outline:none;
            border-color:#00bfa6;
        }
        .dataTables_wrapper .dataTables_filter{
            margin-bottom:20px;
            text-align:right!important;
            float:right!important;
        }
        .dataTables_wrapper .dataTables_length{
            margin-bottom:20px;
        }
        .dataTables_wrapper .dataTables_info{
            font-size:14px;
            padding-top:15px;
            color:#7f8c8d;
            float:left!important;
        }
        .dataTables_wrapper .dataTables_paginate{
            float:right!important;
            text-align:right!important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button{
            padding:8px 12px!important;
            border-radius:8px!important;
            transition:all .3s!important;
            box-shadow:none!important;
            font-weight:600!important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover{
            border-color:#00bfa6!important;
            color:#fff!important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover{
            color:#fff!important;
            transform:translateY(-2px);
            border-color:#00bfa6!important;
        }
        .badge-e{
            display:inline-block;
            padding:.6rem .8rem;
            border-radius:20px;
            font-size:.66rem;
            font-weight:600;
            white-space:nowrap;
            min-width: 80px;
            min-height: 35px;
            text-align: center;
        }
        .badge-vigente{
            background:#eafaf1;
            color:#27ae60;
            border:1px solid #a9dfbf;
        }
        .badge-vencida{
            background:#fdedec;
            color:#e74c3c;
            border:1px solid #f1948a;
        }
        .btn-ver{
            background:#00bfa6;
            color:#fff;
            border:none;
            font-family:inherit;
            font-size:.80rem;
            font-weight:500;
            padding:.2rem .6rem;
            border-radius:6px;
            cursor:pointer;
            transition:background .15s;
            white-space:nowrap;
            min-width: 80px;
            min-height: 35px;
            text-align: center;
        }
        .btn-ver:hover{
            background:#009e8e;
        }
        .btn-nueva{
            background:linear-gradient(135deg,#00bfa6,#009e8e);
            color:#fff;
            border:none;
            font-family:inherit;
            font-size:.85rem;
            font-weight:500;
            padding:.4rem .9rem;
            border-radius:6px;
            cursor:pointer;
            display:inline-flex;
            align-items:center;
            gap:.35rem;
            text-decoration:none;
            transition:all .15s;
            box-shadow:0 4px 12px rgba(0,191,166,.3);
            min-height: 43px;
            min-width: 80px;
            text-align: center;
        }
        .btn-nueva:hover{
            background:linear-gradient(135deg,#009e8e,#007a6e);
            color:#fff;
            transform:translateY(-1px);
        }

        .inc-estado{
            display:flex;
            justify-content:start;
            margin-bottom:1rem;
            padding-bottom:.60rem;
            border-bottom:1px solid #f0f0f0;
        }
        .inc-row{
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:.5rem 0;
            border-bottom:1px solid #f8f8f8;
        }
        .inc-row:last-of-type{
            border-bottom:none;
        }
        .inc-label{
            font-size:.72rem;
            font-weight:500;
            text-transform:uppercase;
            letter-spacing:.5px;
        }
        .inc-value{
            font-size:.88rem;
            font-weight:400;
            color:#2c3e50;
            text-align:right;
        }
        .inc-motivo-box{
            background:#f0fdf9;
            border-left:4px solid #00bfa6;
            border-radius:8px;
            padding:.85rem 1rem;
            margin-top:1rem;
            font-size:.83rem;
            color:#2c3e50;
            line-height:1.55;
            font-style:italic;
        }

        .btn-cerrar-modal{
            background: white;
            color: #dc3545;
            border: 2px solid #dc3545;
            font-family:inherit;
            font-weight:600;
            border-radius:8px;
            cursor:pointer;
            text-align: center;
            min-height: 40px;
            padding: 0.875rem 2rem;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            flex: 1px;
        }
        .btn-cerrar-modal:hover{
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }
        .btn-pdf{
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
        .btn-pdf:hover{
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        }
        .text-info-emphasis {

            font-weight: bold;

        }
        @media (max-width: 768px) {
            .inventory-card {
                padding: 15px;
            }

            .dt-wrap {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            .dataTables_wrapper {
                min-width: 550px;
            }
        }

        /* Modal Incapacidad */
        #modalIncapacidad .modal-content {
            border-radius: 18px;
            border: 3px solid #24f3e2;
            box-shadow: 0 0 20px rgba(36, 243, 226, 0.4);
            overflow: hidden;
            padding: 0;
        }

        #modalIncapacidad .modal-body {
            padding: 2.5rem;
            border-top: none;
        }

        #modalIncapacidad .modal-body::before {
            content: 'Detalle de Incapacidad';
            display: block;
            background: linear-gradient(90deg, #00e1ff, #00ffc8);
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            padding: 18px 24px;
            margin: -2.5rem -2.5rem 1.5rem -2.5rem;
        }


        #modalIncapacidad .modal-footer {
            border-top: 1px solid #e9ecef;
            padding: 0.75rem 1.4rem 1.2rem;
            gap: 0.5rem;
            display: flex;
            justify-content: center;
        }

        #modalIncapacidad .btn-close {
            filter: brightness(0) invert(1);
            position: absolute;
            top: 16px;
            right: 16px;
            z-index: 10;
        }



    </style>


        <div class="container mt-4">

            <div class="page-header mb-4 d-flex align-items-center justify-content-between" style="margin-top:100px;">
                    <h1 class="text-info-emphasis">
                        Incapacidades Emitidas
                    </h1>
                    <a href="{{ route('doctor.emitir.incapacidad') }}" class="btn-nueva">
                        <i class="bi bi-plus-lg"></i> Nueva Incapacidad
                    </a>

            </div>

            {{-- ESTADÍSTICAS --}}
            <div class="stock-alerts">
                <div class="stat-card sc-blue">
                    <div class="stat-num">{{ $stats['total'] }}</div>
                    <div class="stat-l1">Total Incapacidades</div>
                    <small style="color:#7f8c8d;">Emitidas en total</small>
                </div>
                <div class="stat-card sc-green">
                    <div class="stat-num">{{ $stats['vigentes'] }}</div>
                    <div class="stat-l1">Vigentes</div>
                    <small style="color:#7f8c8d;">Activas actualmente</small>
                </div>
                <div class="stat-card sc-red">
                    <div class="stat-num">{{ $stats['vencidas'] }}</div>
                    <div class="stat-l1">Completadas</div>
                    <small style="color:#7f8c8d;">Periodo vencido</small>
                </div>
            </div>

            {{-- TABLA --}}
            <div class="inventory-card">
                <div class="dt-wrap">
                    <table id="tablaInc" class="table table-hover w-100">
                        <thead>
                        <tr>
                            <th style="width:45px;">#</th>
                            <th>Paciente</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Dias</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($incapacidades as $index => $inc)
                            <tr>
                                <td class="num-cell"></td>
                                <td>{{ $inc->paciente->nombres }} {{ $inc->paciente->apellidos }}</td>
                                <td>{{ $inc->fecha_inicio->isoFormat('D MMM YYYY') }}</td>
                                <td>{{ $inc->fecha_fin->isoFormat('D MMM YYYY') }}</td>
                                <td><strong style="color:#00bfa6;">{{ $inc->cantidad_dias }}</strong></td>
                                <td>
                                    <span class="badge-e {{ $inc->estado_clase }}">{{ $inc->estado_calculado }}</span>
                                </td>
                                <td style="white-space:nowrap;">
                                    <button class="btn-ver"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalIncapacidad"
                                            data-id="{{ $inc->id }}"
                                            data-estado="{{ $inc->estado_calculado }}"
                                            data-estado-clase="{{ $inc->estado_clase }}"
                                            data-paciente="{{ $inc->paciente->nombres }} {{ $inc->paciente->apellidos }}"
                                            data-identidad="{{ $inc->paciente->numero_identidad}}"
                                            data-genero="{{ $empleado->genero ?? 'M' }}"
                                            data-telefono="{{ $inc->paciente->telefono}}"
                                            data-inicio="{{ $inc->fecha_inicio->isoFormat('D MMM YYYY') }}"
                                            data-fin="{{ $inc->fecha_fin->isoFormat('D MMM YYYY') }}"
                                            data-dias="{{ $inc->cantidad_dias }}"
                                            data-motivo="{{ $inc->motivo }}">
                                        Ver
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    {{-- MODAL DETALLE INCAPACIDAD --}}
    <div class="modal fade modal-inc" id="modalIncapacidad" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:460px;">
            <div class="modal-content">


                <div class="modal-body">
                    <div class="d-flex justify-content-end" style="margin-top:-0.10rem;margin-bottom:0.5rem;">
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    {{-- Filas de detalle --}}
                    <div class="inc-estado">

                        <span class="badge-e" id="modalEstadoBadge">—</span>
                    </div>

                    <div class="inc-row">
                        <span class="inc-label">Paciente</span>
                        <span class="inc-value" id="modalPaciente">—</span>
                    </div>
                    <div class="inc-row">
                        <span class="inc-label">Identidad</span>
                        <span class="inc-value" id="modalIdentidad">—</span>
                    </div>
                    <div class="inc-row">
                        <span class="inc-label">Telefono</span>
                        <span class="inc-value" id="modalTelefono">—</span>
                    </div>
                    <div class="inc-row">
                        <span class="inc-label">Fecha de inicio</span>
                        <span class="inc-value" id="modalInicio">—</span>
                    </div>
                    <div class="inc-row">
                        <span class="inc-label">Fecha de fin</span>
                        <span class="inc-value" id="modalFin">—</span>
                    </div>
                    <div class="inc-row">
                        <span class="inc-label">Duración</span>
                        <span class="inc-value" id="modalDias">—</span>
                    </div>

                    {{-- Motivo --}}
                    <div class="inc-motivo-box" id="modalMotivo">—</div>

                </div>

                <div class="modal-footer d-flex gap-3">
                    <button type="button" class="btn-cerrar-modal" data-bs-dismiss="modal">Cerrar</button>
                    <a href="#" id="btnDescargarPdf" class="btn-pdf" style="text-decoration-line: none;">
                         Descargar PDF
                    </a>
                </div>

            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {

            // ── DataTable ──
            $('#tablaInc').DataTable({
                responsive: false,
                autoWidth: false,
                language: {
                    search: 'Buscar:',
                    lengthMenu: 'Mostrar _MENU_ registros',
                    info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
                    infoEmpty: 'Sin registros',
                    infoFiltered: '',
                    zeroRecords: 'No se encontraron resultados',
                    paginate: {
                        previous: '<i class="bi bi-chevron-left"></i>',
                        next: '<i class="bi bi-chevron-right"></i>'
                    }
                },
                columnDefs: [
                    { targets: 0, orderable: false, searchable: false },
                    { targets: 6, orderable: false, searchable: false },
                ],
                order: [[3, 'desc']],
                pageLength: 5,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                drawCallback: function () {
                    const info = this.api().page.info();
                    this.api()
                        .column(0, { search: 'applied', order: 'applied', page: 'current' })
                        .nodes()
                        .each(function (cell, i) {
                            cell.innerHTML = '<span class="num-cell">' + (info.start + i + 1) + '</span>';
                        });
                }
            });

            $('#modalIncapacidad').on('show.bs.modal', function (event) {
                const btn    = event.relatedTarget;

                const incId   = btn.getAttribute('data-id');
                const baseUrl = "{{ route('doctor.certificado', ['id' => '__ID__']) }}";
                $('#btnDescargarPdf').attr('href', baseUrl.replace('__ID__', incId));
                const $modal = $(this);

                const estado      = btn.getAttribute('data-estado');
                const estadoClase = btn.getAttribute('data-estado-clase');
                const paciente    = btn.getAttribute('data-paciente');
                const identidad = btn.getAttribute('data-identidad');
                const telefono = btn.getAttribute('data-telefono');
                const inicio      = btn.getAttribute('data-inicio');
                const fin         = btn.getAttribute('data-fin');
                const dias        = btn.getAttribute('data-dias');
                const motivo      = btn.getAttribute('data-motivo');

                $modal.find('#modalIncTitulo').text(paciente);
                $modal.find('#modalEstadoBadge')
                    .text(estado)
                    .attr('class', 'badge-e ' + estadoClase);
                $modal.find('#modalPaciente').text(paciente);
                $modal.find('#modalIdentidad').text(identidad);
                $modal.find('#modalTelefono').text(telefono);
                $modal.find('#modalInicio').text(inicio);
                $modal.find('#modalFin').text(fin);
                $modal.find('#modalDias').text(dias + ' dias de reposo');
                $modal.find('#modalMotivo').text(motivo);
            });

        });
    </script>

@endsection
