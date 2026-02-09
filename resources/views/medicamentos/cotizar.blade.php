@extends('layouts.app')

@section('content')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: whitesmoke;
            min-height: 100vh;
        }

        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 100px 15px 40px;
        }

        .text-info-emphasis {
            color: #2c3e50;
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 30px;
            text-align: center;
        }

        /* Estadísticas Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border-left: 5px solid;
            transition: all 0.3s;
            text-align: left;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        }

        .stat-card.total {
            border-left-color: #3498db;
            background: linear-gradient(135deg, #fff 0%, #e3f2fd 100%);
        }

        .stat-card.pendientes {
            border-left-color: #f39c12;
            background: linear-gradient(135deg, #fff 0%, #fff4e5 100%);
        }

        .stat-card.completadas {
            border-left-color: #2ecc71;
            background: linear-gradient(135deg, #fff 0%, #e8f8f0 100%);
        }

        .stat-card i {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .stat-card.total i {
            color: #3498db;
        }

        .stat-card.pendientes i {
            color: #f39c12;
        }

        .stat-card.completadas i {
            color: #2ecc71;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-card.total .stat-number {
            color: #3498db;
        }

        .stat-card.pendientes .stat-number {
            color: #f39c12;
        }

        .stat-card.completadas .stat-number {
            color: #2ecc71;
        }

        .stat-label {
            font-size: 14px;
            color: #666;
            font-weight: 600;
        }

        /* Tabla Container */
        .table-container-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            overflow: visible;
            padding: 25px;
        }

        .table-container {
            overflow-x: visible;
            width: 100%;
            margin: 0 auto;
        }

        table.dataTable {
            width: 100% !important;
            border-collapse: collapse;
            table-layout: auto;
            white-space: nowrap;
        }

        table.dataTable thead th {
            padding: 20px;
            text-align: left;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border-bottom: 2px solid #e0e0e0;
            background: #4ECDC4;
            color: white;
            white-space: nowrap;
        }

        table.dataTable tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s;
        }

        table.dataTable tbody tr:hover {
            background: #e0f7f5;
        }

        table.dataTable tbody td {
            padding: 20px;
            color: #2c3e50;
            white-space: nowrap;
            vertical-align: middle;
        }

        /* Resaltar filas según estado */
        table.dataTable tbody tr.estado-pendiente {
            background-color: #fff4e5 !important;
        }

        table.dataTable tbody tr.estado-completado {
            background-color: #e8f8f0 !important;
        }

        table.dataTable tbody tr.estado-pendiente:hover {
            background-color: #ffe5cc !important;
        }

        table.dataTable tbody tr.estado-completado:hover {
            background-color: #d4edda !important;
        }

        .patient-name {
            font-weight: 600;
            color: #333;
            font-size: 16px;
        }

        .especialidad-text {
            color: #555;
            font-size: 15px;
        }

        .badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .bg-warning {
            background: #fff3cd;
            color: #856404;
        }

        .bg-success {
            background: #d4edda;
            color: #155724;
        }

        .btn-sm.btn-edit {
            padding: 8px 16px;
            font-size: 14px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
            background: #4ECDC4;
            color: white;
            text-decoration: none;
        }

        .btn-sm.btn-edit:hover {
            background: #45b8b0;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(78, 205, 196, 0.3);
        }

        /* DataTables */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 20px;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 8px 15px;
            margin-left: 10px;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            outline: none;
            border-color: #4ECDC4;
        }

        .dataTables_wrapper .dataTables_length select {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 5px 10px;
            margin: 0 10px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 8px 12px !important;
            border-radius: 8px !important;
            transition: all 0.3s !important;
            box-shadow: none !important;
            font-weight: 600 !important;
            border: none !important;
            background: transparent !important;
            color: #6c757d !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            color: #6c757d !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            transform: none !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #4ECDC4 !important;
            color: white !important;
            border: none !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #45b8b0 !important;
            border: none !important;
        }

        .dataTables_wrapper .dataTables_info {
            font-size: 14px;
            padding-top: 15px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #7f8c8d;
        }

        .empty-state i {
            font-size: 4rem;
            color: #4ECDC4;
            margin-bottom: 20px;
        }

        .empty-state h4 {
            color: #4ECDC4;
            margin-top: 15px;
            font-weight: 600;
        }

        .empty-state p {
            color: #7f8c8d;
            margin-top: 10px;
        }

        @media (max-width: 1200px) {
            .table-container-card {
                padding: 15px;
            }

            table.dataTable thead th,
            table.dataTable tbody td {
                padding: 15px 10px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .main-container {
                padding: 80px 10px 20px;
            }
        }
    </style>

    <div class="main-container mt-4">
        <h4 class="text-info-emphasis">Cotización de Medicamentos</h4>

        <!-- Buscador -->
        <form method="GET" action="{{ route('medicamentos.cotizar') }}" class="mb-3">
            <input
                type="text"
                name="buscar"
                class="form-control"
                placeholder="Buscar medicamento"
                value="{{ request('buscar') }}"
            >
        </form>

        <div class="table-container-card">
            <div class="table-container">
        @if(count($medicamentos) > 0)
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Código</th>
                    <th>Medicamento</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                @foreach($medicamentos as $med)
                    <tr>
                        <td>{{ $med->codigo }}</td>
                        <td>{{ $med->nombre }}</td>
                        <td class="precio">{{ $med->precio_unitario }}</td>
                        <td>{{ $med->cantidad }}</td>
                        <td>
                            <input type="number" class="form-control cantidad" min="1" max="{{ $med->cantidad }}" value="1">
                        </td>
                        <td class="total">L. {{ number_format($med->precio_unitario,2) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>
        </div>
        @endif
    </div>

    <script>
        document.querySelectorAll('.cantidad').forEach(input => {
            input.addEventListener('input', function () {
                let fila = this.closest('tr');
                let precio = parseFloat(fila.querySelector('.precio').innerText);
                let cantidad = parseInt(this.value);
                fila.querySelector('.total').innerText = 'L. ' + (precio * cantidad).toFixed(2);
            });
        });
    </script>
@endsection

