@extends('layouts.plantillaEnfermeria')
@section('contenido')

    <style>
        /* ── ESTADÍSTICAS ── */
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

        /* ── TABLA ── */

        .dt-wrap{
            overflow-x:visible;
            width:100%;
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
            font-size:.71rem;
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
            font-size:.78rem;
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
            min-height: 40px;
            min-width: 80px;
            text-align: center;
        }
        .btn-nueva:hover{
            background:linear-gradient(135deg,#009e8e,#007a6e);
            color:#fff;
            transform:translateY(-1px);
        }
        .modal-inc .modal-content{
            border-radius:20px;
        }
        .modal-inc .modal-body{
            border-radius:20px;
            padding:2.5rem;
            border-top:5px solid #4ecdc4;
            max-width:600px;
            position:relative;
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
        .modal-inc .modal-footer{
            border:none;
            padding:.75rem 1.4rem 1.2rem;
            gap:.5rem;
        }
        .btn-cerrar-modal{
            background: white;
            color: #dc3545;
            border: 2px solid #dc3545;
            font-family:inherit;
            font-size:.8rem;
            font-weight:600;
            padding:.45rem 1.1rem;
            border-radius:8px;
            cursor:pointer;
            transition:background .15s;
            flex: 1;
            text-align: center;
            min-height: 40px;
        }
        .btn-cerrar-modal:hover{
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }
        .btn-pdf{
            background:linear-gradient(135deg,#00bfa6,#009e8e);
            color:#fff;
            border:none;
            font-family:inherit;
            font-size:.8rem;
            font-weight:600;
            padding:.45rem 1.1rem;
            border-radius:8px;
            cursor:pointer;
            display:inline-flex;
            align-items:center;
            gap:.4rem;
            transition:all .15s;
            box-shadow:0 4px 12px rgba(0,191,166,.25);
            flex: 1;
            text-align: center;
            justify-content: center;
            min-height: 40px;
        }
        .btn-pdf:hover{
            background:linear-gradient(135deg,#009e8e,#007a6e);
            transform:translateY(-1px);
        }
        .text-info-emphasis {

            font-weight: bold;

        }

        .num-cell {
            text-align:center;
            font-weight:700;
        }


    </style>


    <div class="container mt-4">

        <div class="page-header mb-4 d-flex align-items-center justify-content-between" style="margin-top:100px;">
            <h2 class="text-info-emphasis mb-0">
                Informe Mensual
            </h2>
        </div>

        {{-- ESTADÍSTICAS --}}
        <div class="stock-alerts">
            <div class="stat-card sc-blue">
                <div class="stat-num">{{ $totalPacientes }}</div>
                <div class="stat-l1">Pacientes Atendidos</div>
                <small style="color:#7f8c8d;">Total hasta el mes actual</small>
            </div>
            <div class="stat-card sc-green">
                <div class="stat-num">{{ $totalMedicamentos }}</div>
                <div class="stat-l1">Medicamentos Aplicados</div>
                <small style="color:#7f8c8d;">Total hasta el mes actual</small>
            </div>
            <div class="stat-card sc-red">
                <div class="stat-num">{{ $totalIncidentes }}</div>
                <div class="stat-l1">Incidentes Reportados</div>
                <small style="color:#7f8c8d;">Total hasta el mes actual</small>
            </div>
        </div>

        {{-- TABLA DEL INFORME --}}
        <div class="inventory-card">
            <div class="dt-wrap">
                <table id="tablaInforme" class="table table-hover w-100">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Mes</th>
                        <th>Pacientes Atendidos</th>
                        <th>Incidentes Reportados</th>
                        <th>Medicamentos Aplicados</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($meses as $i => $m)
                        <tr>
                            <td class="num-cell"></td>
                            <td>{{ $m['mes'] }}</td>
                            <td><strong style="color:#00bfa6;">{{ $m['pacientes'] }}</strong></td>
                            <td><strong style="color:#e74c3c;">{{ $m['incidentes'] }}</strong></td>
                            <td><strong style="color:#27ae60;">{{ $m['medicamentos'] }}</strong></td>
                            <td>
                                <button class="btn-pdf" disabled>
                                    <i class="bi bi-file-earmark-pdf"></i> PDF
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            var table = $('#tablaInforme').DataTable({
                language: {
                    search: 'Buscar:',
                    lengthMenu: 'Mostrar _MENU_ registros',
                    info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
                    infoEmpty: 'Sin registros',
                    zeroRecords: 'No se encontraron resultados',
                    paginate: {
                        previous: '<i class="bi bi-chevron-left"></i>',
                        next: '<i class="bi bi-chevron-right"></i>'
                    }
                },
                pageLength: 5,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                ordering: false,
                drawCallback: function () {
                    var api = this.api();
                    var info = api.page.info();
                    api.column(0, { search: 'applied', order: 'applied', page: 'current' })
                        .nodes()
                        .each(function (cell, i) {
                            cell.innerHTML = info.start + i + 1;
                        });
                }
            });
        });
    </script>



@endsection
