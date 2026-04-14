@extends('layouts.plantilla')

@section('titulo', 'Mis Citas')

@section('contenido')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:whitesmoke;
            min-height: 100vh;
            padding: 20px;
        }

        .citas-container {
            max-width: 1450px;
            margin: 40px auto;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            color: #0f766e;
            font-size: 2.5rem;
            margin-bottom: 30px;
            font-weight: 700;




        }

        .header p {
            color: #7f8c8d;
            font-size: 1.1rem;
        }

        /* Estadísticas */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            text-align: left;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
            border-left: 5px solid;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
        }

        .stat-card.total {
            border-left-color: #2c3e50;
            background: linear-gradient(135deg, #fff 0%, #e8eaf0 100%);
        }
        .stat-card.programadas {border-left-color: #4ECDC4;
            background: linear-gradient(135deg, #fff 0%, #e5f9f7 100%);
        }
        .stat-card.canceladas { border-left-color: #e74c3c;
            background: linear-gradient(135deg, #fff 0%, #ffe5e5 100%);}
        .stat-card.reprogramadas { border-left-color: #f39c12;
            background: linear-gradient(135deg, #fff 0%, #fff4e5 100%);
        }

        .stat-card i {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .stat-card.total i { color: #2c3e50; }
        .stat-card.programadas i { color: #4ECDC4; }
        .stat-card.canceladas i { color: #e74c3c; }
        .stat-card.reprogramadas i { color: #f39c12; }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-card.total .stat-number { color: #2c3e50;}
        .stat-card.programadas .stat-number { color: #4ECDC4; }
        .stat-card.canceladas .stat-number { color: #e74c3c; }
        .stat-card.reprogramadas .stat-number { color: #f39c12; }

        .stat-label {
            color: #7f8c8d;
            font-size: 0.95rem;
        }

        /* Filtros */
        .filters-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .filters-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            align-items: end;
        }

        .filter-group label {
            display: block;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .filter-group select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e8f4f3;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #f8fffe;
        }

        .filter-group select:focus {
            outline: none;
            border-color: #4ECDC4;
            box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.1);
        }

        .filters-row {
            display: flex;
            align-items: flex-end;
            gap: 15px;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            flex: 1;
            min-width: 200px;
        }

        .filter-group:last-child {
            flex: 0;
            min-width:12%;
            margin-left: auto;
        }

        .filter-group label {
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .filter-group select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }

        .btn-filter {
            padding: 12px 30px;
            background: linear-gradient(135deg, #4ECDC4 0%, #44A08D 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 205, 196, 0.4);
        }

        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.4);
        }

        /* Alertas */
        .alert-custom {
            padding: 18px 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .alert-success-custom {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-left: 5px solid #28a745;
            color: #155724;
        }

        .alert-danger-custom {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            border-left: 5px solid #dc3545;
            color: #721c24;
        }

        .alert-info-custom {
            background: linear-gradient(135deg, #ffffff 0%, #ffffff 100%);

            color: #0c5460;
            text-align: center;

        }

        .alert-info-custom i {
            font-size: 3rem;
            display: block;
            margin-bottom: 15px;
        }

        /* Tarjetas de Citas */
        .citas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .cita-card {
            background: white;
            border-radius: 20px;
            padding: 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            overflow: hidden;
            border-left: 6px solid;
        }

        .cita-card.programada { border-left-color: #2ecc71; }
        .cita-card.cancelada { border-left-color: #e74c3c; }
        .cita-card.reprogramada { border-left-color: #f39c12; }
        .cita-card.pendiente { border-left-color: #3498db; }

        .cita-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        .cita-header-card {
            background: linear-gradient(135deg, #4ECDC4 0%, #44A08D 100%);
            padding: 29px;
            color: white;
        }

        .doctor-name {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .doctor-name i {
            font-size: 1.8rem;
        }

        .especialidad-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.3);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .cita-body {
            padding: 25px;
        }

        .cita-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .cita-info-item {
            display: flex;
            align-items: start;
            gap: 12px;
        }

        .cita-info-item i {
            color: #4ECDC4;
            font-size: 1.3rem;
            margin-top: 3px;
        }

        .cita-info-item .info-content {
            flex: 1;
        }

        .cita-info-item .info-label {
            font-size: 0.75rem;
            color: #7f8c8d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
        }

        .cita-info-item .info-value {
            font-size: 1rem;
            color: #2c3e50;
            font-weight: 600;
        }

        .estado-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .estado-badge i {
            font-size: 1rem;
        }

        .estado-programada {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
        }

        .estado-cancelada {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
        }

        .estado-reprogramada {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            color: #856404;
        }

        .estado-pendiente {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            color: #0c5460;
        }

        .mensaje-info {
            background: #e8f4f3;
            border-left: 4px solid #4ECDC4;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            color: #2c3e50;
            font-size: 0.95rem;
        }

        .cita-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-action {
            flex: 1;
            padding: 14px 20px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 0.95rem;
        }

        .btn-reprogramar {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            color: white;
        }

        .btn-reprogramar:hover {
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            transform: translateY(-2px);
        }

        .btn-cancelar {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
        }

        .btn-cancelar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(231, 76, 60, 0.4);
        }

        /* Modales Mejorados */
        .modal-content {
            border-radius: 20px;
            border: none;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            border: none;
            padding: 35px 35px 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .modal-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 40px;
        }

        .modal-icon-danger {
            background: linear-gradient(135deg, #fee 0%, #fdd 100%);
            color: #dc3545;
        }

        .modal-icon-warning {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            color: white;
        }

        .modal-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            color: #2c3e50;
        }

        .modal-body {
            padding: 25px 35px 35px;
            text-align: center;
        }

        .modal-body p {
            color: #666;
            margin-bottom: 20px;
            font-size: 1.05rem;
        }

        .cita-info-box {
            background: linear-gradient(135deg, #f8fffe 0%, #e8f4f3 100%);
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            text-align: left;
            border-left: 4px solid #4ECDC4;
        }

        .cita-info-box strong {
            color: #2c3e50;
            display: inline-block;
            width: 100px;
            font-weight: 600;
        }

        .modal-footer {
            border: none;
            padding: 0 35px 35px;
            justify-content: center;
            gap: 15px;
        }

        .modal-footer .btn {
            min-width: 140px;
            padding: 14px 30px;
            border-radius: 12px;
            font-weight: 600;
            border: none;
            font-size: 1rem;
        }

        .btn-modal-cancel {
            background: #e9ecef;
            color: #666;
        }

        .btn-modal-cancel:hover {
            background: #d3d6d9;
        }

        .btn-modal-danger {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
        }

        .btn-modal-danger:hover {
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.4);
        }

        .btn-modal-warning {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            color: white;
        }

        .btn-modal-warning:hover {
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
        }

        .form-control-modal {
            border-radius: 10px;
            border: 2px solid #e8f4f3;
            padding: 12px 16px;
            font-size: 1rem;
        }

        .form-control-modal:focus {
            border-color: #4ECDC4;
            box-shadow: 0 0 0 0.2rem rgba(78, 205, 196, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
            text-align: left;
            display: block;
        }

        .btn-close {
            position: absolute;
            right: 20px;
            top: 20px;
        }

        /* Paginación */
        .pagination {
            justify-content: center;
            margin-top: 30px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .citas-grid {
                grid-template-columns: 1fr;
            }

            .cita-info-grid {
                grid-template-columns: 1fr;
            }

            .filters-row {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        .btn-descargar-comprobante {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 15%;
            padding: 12px 20px;
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.6rem;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 0;
            margin-left: auto;

        }

        .btn-descargar-comprobante:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(26, 26, 46, 0.45);
            background: rgba(255, 255, 255, 0.3);
            color: white;
            text-decoration: none;
        }

        .btn-descargar-comprobante:active {
            transform: translateY(0);
        }

        .btn-descargar-comprobante i {
            font-size: 1.1rem;
        }

        .btn-accion {
            padding: 14px 20px;
            border: none;
            border-radius: 12px;
            font-weight: 300;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 0.95rem;
        }

        .btn-archivar {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            color: white;
        }

        .btn-archivar:hover {
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            transform: translateY(-2px);
        }

        /* ================= DARK MODE - MIS CITAS ================= */

        .dark-mode body {
            background: #121212 !important;
            color: #e4e4e4 !important;
        }

        .dark-mode .citas-container {
            background: transparent;
        }

        /* HEADER */
        .dark-mode .header h1 {
            color: #4ecdc4 !important;
        }

        .dark-mode .header p {
            color: #9ca3af !important;
        }

        /* TARJETAS DE ESTADÍSTICAS */
        .dark-mode .stat-card {
            background: #1e1e1e !important;
            color: #e4e4e4 !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.45);
        }

        .dark-mode .stat-card.total {
            background: linear-gradient(135deg, #1e1e1e 0%, #2a2a2a 100%) !important;
            border-left-color: #6b7280;
        }

        .dark-mode .stat-card.programadas {
            background: linear-gradient(135deg, #1e1e1e 0%, #163c38 100%) !important;
            border-left-color: #4ecdc4;
        }

        .dark-mode .stat-card.canceladas {
            background: linear-gradient(135deg, #1e1e1e 0%, #3a1e1e 100%) !important;
            border-left-color: #e74c3c;
        }

        .dark-mode .stat-card.reprogramadas {
            background: linear-gradient(135deg, #1e1e1e 0%, #3f3218 100%) !important;
            border-left-color: #f39c12;
        }

        .dark-mode .stat-card.total i,
        .dark-mode .stat-card.total .stat-number {
            color: #d1d5db !important;
        }

        .dark-mode .stat-card.programadas i,
        .dark-mode .stat-card.programadas .stat-number {
            color: #4ecdc4 !important;
        }

        .dark-mode .stat-card.canceladas i,
        .dark-mode .stat-card.canceladas .stat-number {
            color: #ff6b6b !important;
        }

        .dark-mode .stat-card.reprogramadas i,
        .dark-mode .stat-card.reprogramadas .stat-number {
            color: #fbbf24 !important;
        }

        .dark-mode .stat-label {
            color: #9ca3af !important;
        }

        /* FILTROS */
        .dark-mode .filters-card {
            background: #1e1e1e !important;
            color: #e4e4e4 !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.45);
        }

        .dark-mode .filter-group label,
        .dark-mode .form-label {
            color: #ccc !important;
        }

        .dark-mode .filter-group select,
        .dark-mode .form-control-modal {
            background: #2a2a2a !important;
            color: #fff !important;
            border: 1px solid #444 !important;
        }

        .dark-mode .filter-group select:focus,
        .dark-mode .form-control-modal:focus {
            border-color: #4ecdc4 !important;
            box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.2) !important;
        }

        .dark-mode .filter-group select option {
            background: #2a2a2a;
            color: #fff;
        }

        /* BOTÓN FILTRAR */
        .dark-mode .btn-filter {
            background: linear-gradient(135deg, #2c5364, #203a43) !important;
            color: #e4e4e4 !important;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.5);
        }

        .dark-mode .btn-filter:hover {
            background: linear-gradient(135deg, #4ecdc4, #00ffe7) !important;
            color: #000 !important;
            box-shadow: 0 0 15px #00ffe7, 0 0 25px rgba(0,255,231,0.4);
            transform: translateY(-2px);
        }

        /* ALERTAS */
        .dark-mode .alert-success-custom {
            background: #1e3a2f !important;
            color: #4ade80 !important;
            border-left-color: #2f5f4a !important;
        }

        .dark-mode .alert-danger-custom {
            background: #3a1e1e !important;
            color: #ff6b6b !important;
            border-left-color: #5f2f2f !important;
        }

        .dark-mode .alert-info-custom {
            background: #1e1e1e !important;
            color: #d1d5db !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.45);
        }

        /* GRID DE CITAS */
        .dark-mode .cita-card {
            background: #1e1e1e !important;
            color: #e4e4e4 !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.45);
        }

        .dark-mode .cita-card:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
        }

        .dark-mode .cita-header-card {
            background: linear-gradient(135deg, #203a43 0%, #2c5364 100%) !important;
            color: #fff !important;
        }

        .dark-mode .doctor-name,
        .dark-mode .especialidad-badge {
            color: #fff !important;
        }

        .dark-mode .especialidad-badge {
            background: rgba(255, 255, 255, 0.15) !important;
        }

        .dark-mode .cita-body {
            background: #1e1e1e !important;
        }

        .dark-mode .cita-info-item i {
            color: #4ecdc4 !important;
        }

        .dark-mode .cita-info-item .info-label {
            color: #9ca3af !important;
        }

        .dark-mode .cita-info-item .info-value {
            color: #e5e7eb !important;
        }

        /* BADGES DE ESTADO */
        .dark-mode .estado-programada {
            background: #1e3a2f !important;
            color: #4ade80 !important;
        }

        .dark-mode .estado-cancelada {
            background: #3a1e1e !important;
            color: #ff6b6b !important;
        }

        .dark-mode .estado-reprogramada {
            background: #3f3218 !important;
            color: #fbbf24 !important;
        }

        .dark-mode .estado-pendiente {
            background: #1e3140 !important;
            color: #60a5fa !important;
        }

        /* MENSAJE INFO */
        .dark-mode .mensaje-info {
            background: #2a2a2a !important;
            border-left: 4px solid #4ecdc4 !important;
            color: #d1d5db !important;
        }

        /* BOTONES DE ACCIÓN */
        .dark-mode .btn-reprogramar,
        .dark-mode .btn-archivar {
            background: linear-gradient(135deg, #2c5364, #203a43) !important;
            color: #e4e4e4 !important;
        }

        .dark-mode .btn-reprogramar:hover,
        .dark-mode .btn-archivar:hover {
            background: linear-gradient(135deg, #4ecdc4, #00ffe7) !important;
            color: #000 !important;
            box-shadow: 0 0 15px rgba(0,255,231,0.35) !important;
        }

        .dark-mode .btn-cancelar {
            background: linear-gradient(135deg, #7f1d1d, #b91c1c) !important;
            color: #fff !important;
        }

        .dark-mode .btn-cancelar:hover {
            box-shadow: 0 6px 15px rgba(220, 53, 69, 0.4) !important;
        }

        /* BOTÓN DESCARGAR PDF */
        .dark-mode .btn-descargar-comprobante {
            color: #fff !important;
        }

        .dark-mode .btn-descargar-comprobante:hover {
            background: rgba(255,255,255,0.12) !important;
            color: #fff !important;
        }

        /* MODALES */
        .dark-mode .modal-content {
            background: #1e1e1e !important;
            color: #e4e4e4 !important;
            border: 1px solid #333 !important;
        }

        .dark-mode .modal-header {
            background: linear-gradient(135deg, #203a43, #2c5364) !important;
            color: #fff !important;
            border-bottom: 1px solid #333 !important;
        }

        .dark-mode .modal-title {
            color: #fff !important;
        }

        .dark-mode .modal-body {
            background: #1e1e1e !important;
            color: #d1d5db !important;
        }

        .dark-mode .modal-body p {
            color: #d1d5db !important;
        }

        .dark-mode .modal-footer {
            background: #1e1e1e !important;
            border-top: 1px solid #333 !important;
        }

        .dark-mode .modal-icon-danger {
            background: linear-gradient(135deg, #3a1e1e 0%, #5f2f2f 100%) !important;
            color: #ff6b6b !important;
        }

        .dark-mode .modal-icon-warning {
            background: linear-gradient(135deg, #2c5364 0%, #203a43 100%) !important;
            color: #4ecdc4 !important;
        }

        .dark-mode .cita-info-box {
            background: #2a2a2a !important;
            border-left: 4px solid #4ecdc4 !important;
            color: #d1d5db !important;
        }

        .dark-mode .cita-info-box strong {
            color: #e5e7eb !important;
        }

        /* BOTONES DEL MODAL */
        .dark-mode .btn-modal-cancel,
        .dark-mode .btn-secondary {
            background: #2a2a2a !important;
            color: #ccc !important;
            border: 1px solid #555 !important;
        }

        .dark-mode .btn-modal-cancel:hover,
        .dark-mode .btn-secondary:hover {
            background: #dc3545 !important;
            color: #fff !important;
            box-shadow: 0 0 10px rgba(220,53,69,0.5) !important;
        }

        .dark-mode .btn-modal-danger,
        .dark-mode .btn-danger {
            background: linear-gradient(135deg, #7f1d1d, #b91c1c) !important;
            color: #fff !important;
            border: none !important;
        }

        .dark-mode .btn-modal-warning {
            background: linear-gradient(135deg, #2c5364, #203a43) !important;
            color: #e4e4e4 !important;
            border: none !important;
        }

        .dark-mode .btn-modal-warning:hover {
            background: linear-gradient(135deg, #4ecdc4, #00ffe7) !important;
            color: #000 !important;
        }

        /* CERRAR MODAL */
        .dark-mode .btn-close {
            filter: invert(1) grayscale(100%);
        }

        /* PAGINACIÓN */
        .dark-mode .pagination {
            --bs-pagination-bg: #1f2937;
            --bs-pagination-border-color: #374151;
            --bs-pagination-color: #d1d5db;
            --bs-pagination-hover-bg: #374151;
            --bs-pagination-hover-border-color: #4b5563;
            --bs-pagination-hover-color: #fff;
            --bs-pagination-active-bg: #4ecdc4;
            --bs-pagination-active-border-color: #4ecdc4;
            --bs-pagination-active-color: #111827;
            --bs-pagination-disabled-bg: #111827;
            --bs-pagination-disabled-color: #6b7280;
        }

        /* SI SALE ALGÚN INPUT GENERAL EN MODALES */
        .dark-mode .form-control,
        .dark-mode input,
        .dark-mode select,
        .dark-mode textarea {
            background-color: #2a2a2a !important;
            color: #fff !important;
            border: 1px solid #444 !important;
        }

        .dark-mode .form-control::placeholder,
        .dark-mode input::placeholder,
        .dark-mode textarea::placeholder {
            color: #888 !important;
        }

        /* ===== MODALES - ESTILO INDEX ===== */
        .modal-content {
            border-radius: 18px;
            border: 3px solid #24f3e2;
            box-shadow: 0 0 20px rgba(36, 243, 226, 0.4);
            overflow: hidden;
            padding: 0;
        }

        .modal-header {
            background: linear-gradient(90deg, #00e1ff, #00ffc8);
            padding: 15px 20px;
            border-bottom: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-radius: 0;
        }

        .modal-title {
            color: #fff;
            margin: 0;
            font-size: 1.4rem;
            font-weight: 800;
        }

        .modal-body {
            padding: 25px 30px;
            background: #fff;
        }

        .modal-body p {
            color: #555;
            font-size: 0.95rem;
        }

        .modal-footer {
            background: #fff;
            border-top: 1px solid #e5e5e5;
            padding: 20px 30px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        /* Botón cerrar X */
        .btn-close {
            filter: brightness(0) invert(1);
            transition: transform 0.35s ease;
        }
        .btn-close:hover {
            transform: rotate(180deg);
            filter: brightness(0) invert(1);
        }

        /* Caja info dentro del modal reprogramar */
        .cita-info-box {
            background: #f8fffe;
            border-left: 4px solid #24f3e2;
            border-radius: 10px;
            padding: 15px 18px;
            margin: 15px 0;
            text-align: left;
            font-size: 0.95rem;
            color: #333;
        }
        .cita-info-box strong {
            display: inline-block;
            width: 110px;
            color: #2c3e50;
            font-weight: 700;
        }

        /* Inputs dentro de modales */
        .form-control-modal {
            border: 2px solid #24f3e2;
            border-radius: 12px;
            background: #fff;
            padding: 10px 14px;
            font-size: 1rem;
            width: 100%;
            box-shadow: 0 0 12px rgba(36, 243, 226, 0.2);
            transition: 0.2s;
            outline: none;
        }
        .form-control-modal:hover {
            box-shadow: 0 0 18px rgba(36, 243, 226, 0.35);
        }
        .form-control-modal:focus {
            border-color: #00f3ff;
            box-shadow: 0 0 10px rgba(0, 243, 255, 0.42);
        }

        .form-label {
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 8px;
            text-align: left;
            display: block;
        }

        /* Botón Cancelar (modales) */
        .btn-modal-cancel,
        .modal .btn-secondary {
            padding: 0.875rem 2rem;
            background: white;
            border: 2px solid #dc3545;
            border-radius: 8px;
            color: #dc3545;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .btn-modal-cancel:hover,
        .modal .btn-secondary:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }

        /* Botón Confirmar peligro (Cancelar cita / Eliminar) */
        .btn-modal-danger,
        .modal .btn-danger {
            padding: 0.875rem 2rem;
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.3);
            cursor: pointer;
        }
        .btn-modal-danger:hover,
        .modal .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        }

        /* Botón Confirmar (Reprogramar / Archivar) */
        .btn-modal-warning,
        .btn-accion.btn-archivar {
            padding: 0.875rem 2rem;
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.3);
            cursor: pointer;
        }
        .btn-modal-warning:hover,
        .btn-accion.btn-archivar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        }

        /* DARK MODE - botones modal */
        .dark-mode .btn-modal-cancel,
        .dark-mode .modal .btn-secondary {
            background: #1e293b !important;
            border: 2px solid #dc3545 !important;
            color: #dc3545 !important;
        }
        .dark-mode .btn-modal-cancel:hover,
        .dark-mode .modal .btn-secondary:hover {
            background: #dc3545 !important;
            color: white !important;
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3) !important;
        }

        .dark-mode .btn-modal-danger,
        .dark-mode .modal .btn-danger {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%) !important;
            color: white !important;
            border: none !important;
        }
        .dark-mode .btn-modal-danger:hover,
        .dark-mode .modal .btn-danger:hover {
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4) !important;
        }

        .dark-mode .btn-modal-warning,
        .dark-mode .btn-accion.btn-archivar {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%) !important;
            color: white !important;
            border: none !important;
        }
        .dark-mode .btn-modal-warning:hover,
        .dark-mode .btn-accion.btn-archivar:hover {
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4) !important;
        }
    </style>

    <div class="citas-container">
        <!-- Header -->
        <div class="header">
            <h1> Mis Citas Médicas</h1>
        </div>

        <!-- Alertas -->
        @if(session('success'))
            <div class="alert-custom alert-success-custom">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert-custom alert-danger-custom">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @php
            $total = $citas->total();
            $programadas = \App\Models\Cita::where('paciente_id', session('paciente_id'))->where('estado', 'programada')->count();
            $canceladas = \App\Models\Cita::where('paciente_id', session('paciente_id'))->where('estado', 'cancelada')->count();
            $reprogramadas = \App\Models\Cita::where('paciente_id', session('paciente_id'))->where('estado', 'reprogramada')->count();
        @endphp

            <!-- Estadísticas -->
        <div class="stats-grid">
            <div class="stat-card total">
                <div class="stat-number">{{ $total }}</div>
                <div class="stat-label">Total de Citas</div>
            </div>

            <div class="stat-card programadas">

                <div class="stat-number">{{ $programadas }}</div>
                <div class="stat-label">Programadas</div>
            </div>

            <div class="stat-card reprogramadas">

                <div class="stat-number">{{ $reprogramadas }}</div>
                <div class="stat-label">Reprogramadas</div>
            </div>

            <div class="stat-card canceladas">

                <div class="stat-number">{{ $canceladas }}</div>
                <div class="stat-label">Canceladas</div>
            </div>


        </div>

        <!-- Filtros -->
        <div class="filters-card">
            <form method="GET" action="{{ route('citas.mis-citas') }}">
                <div class="filters-row">
                    <div class="filter-group">
                        <label><i class="fas fa-filter"></i> Filtrar por Estado</label>
                        <select name="estado">
                            <option value="">Todos los estados</option>
                            <option value="programada" {{ request('estado') == 'programada' ? 'selected' : '' }}>Programada</option>
                            <option value="cancelada" {{ request('estado') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                            <option value="reprogramada" {{ request('estado') == 'reprogramada' ? 'selected' : '' }}>Reprogramada</option>
                            <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label><i class="fas fa-sort"></i> Ordenar por</label>
                        <select name="orden">
                            <option value="fecha_desc" {{ request('orden') == 'fecha_desc' ? 'selected' : '' }}>Fecha (más reciente)</option>
                            <option value="fecha_asc" {{ request('orden') == 'fecha_asc' ? 'selected' : '' }}>Fecha (más antigua)</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <button type="submit" class="btn-filter">
                            <i class="fas fa-search"></i> Filtrar
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Grid de Citas -->
        @if($citas->count() > 0)
            <div class="citas-grid">
                @foreach($citas->where('estado','!=','archivada') as $cita)
                    <div class="cita-card {{ $cita->estado }}">
                        <!-- Header de la Cita -->
                        <div class="cita-header-card">
                            <div class="doctor-name">
                                @if($cita->doctor && $cita->doctor->foto)
                                    <img src="data:image/jpeg;base64,{{ base64_encode($cita->doctor->foto) }}"
                                         alt="Foto Doctor"
                                         style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover; border: 2px solid #00ffe0; margin-right: 10px;">
                                @else
                                    <i class="fas fa-user-md" style="margin-right: 10px; font-size: 28px;"></i>
                                @endif
                                @if($cita->doctor)
                                    {{ $cita->doctor->genero === 'Femenino' ? 'Dra.' : 'Dr.' }} {{ $cita->doctor->nombre }} {{ $cita->doctor->apellido ?? '' }}
                                @else
                                    {{ $cita->doctor_nombre ?? 'Doctor No Definido' }}
                                @endif

                                @if(in_array($cita->estado, ['programada', 'reprogramada']))
                                    <a href="{{ route('citas.comprobante', $cita->id) }}"
                                       class="btn-descargar-comprobante">
                                        <i class="bi bi-file-earmark-pdf-fill"></i>

                                    </a>
                                @endif
                            </div>
                            <span class="especialidad-badge">
                                <i class="fas fa-stethoscope"></i> {{ $cita->especialidad ?? 'No definida' }}
                            </span>
                        </div>

                        <!-- Body de la Cita -->
                        <div class="cita-body">
                            <!-- Estado -->
                            <div class="estado-badge estado-{{ $cita->estado }}">
                                @if($cita->estado == 'programada')
                                    <i class="fas fa-check-circle"></i>
                                @elseif($cita->estado == 'cancelada')
                                    <i class="fas fa-times-circle"></i>
                                @elseif($cita->estado == 'reprogramada')
                                    <i class="fas fa-calendar-alt"></i>
                                @else
                                    <i class="fas fa-clock"></i>
                                @endif
                                {{ ucfirst($cita->estado) }}
                            </div>

                            <!-- Información de la Cita -->
                            <div class="cita-info-grid">
                                <div class="cita-info-item">
                                    <i class="fas fa-user"></i>
                                    <div class="info-content">
                                        <div class="info-label">Paciente</div>
                                        <div class="info-value">{{ session('paciente_nombre') ?? 'No definido' }}</div>
                                    </div>
                                </div>

                                <div class="cita-info-item">
                                    <i class="fas fa-calendar"></i>
                                    <div class="info-content">
                                        <div class="info-label">Fecha</div>
                                        <div class="info-value">{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</div>
                                    </div>
                                </div>

                                <div class="cita-info-item">
                                    <i class="fas fa-clock"></i>
                                    <div class="info-content">
                                        <div class="info-label">Hora</div>
                                        <div class="info-value">{{ $cita->hora }}</div>
                                    </div>
                                </div>

                                <div class="cita-info-item">
                                    <i class="fas fa-hospital"></i>
                                    <div class="info-content">
                                        <div class="info-label">Clínica</div>
                                        <div class="info-value">ClinicWeb</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Mensaje de Confirmación -->
                            @if($cita->estado == 'cancelada' && $cita->motivo_cancelacion)
                                <div class="mensaje-info">
                                    <strong>Motivo de cancelación:</strong><br>
                                    {{ $cita->motivo_cancelacion }}
                                </div>
                            @endif

                            <!-- Botones de Acción -->
                            @if($cita->estado == 'programada')
                                <div class="cita-actions">
                                    <button type="button" class="btn-action btn-reprogramar"
                                            onclick="confirmarReprogramacion(
                                        {{ $cita->id }},
                                        '{{ $cita->doctor_nombre }}',
                                        '{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}',
                                        '{{ $cita->hora }}'
                                    )">
                                        Reprogramar
                                    </button>

                                    <form action="{{ route('citas.cancelar', $cita->id) }}" method="POST" id="formCancelar{{ $cita->id }}" style="flex: 1; margin: 0;">
                                        @csrf
                                        <input type="hidden" name="motivo_cancelacion" id="hidden_motivo_{{ $cita->id }}">
                                        <button type="button" class="btn-action btn-cancelar" style="width: 100%;"
                                                onclick="confirmarCancelacion(
                                            {{ $cita->id }},
                                            '{{ $cita->doctor_nombre }}',
                                            '{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}',
                                            '{{ $cita->hora }}'
                                        )">
                                            Cancelar
                                        </button>
                                    </form>
                                </div>
                            @endif

                            @if($cita->estado == 'completada')
                                <div class="cita-actions">
                                    <form id="formArchivar{{ $cita->id }}" action="{{ route('citas.archivar', $cita->id) }}" method="POST" style="flex:1; margin:0;">
                                        @csrf
                                        @method('PUT')

                                        <button type="button" class="btn-action btn-reprogramar" style="width:100%;"
                                                onclick="confirmarArchivar({{ $cita->id }})">
                                            Archivar cita
                                        </button>
                                    </form>

                                    <form id="formEliminar{{ $cita->id }}"
                                          action="{{ route('citas.eliminar.completada', $cita->id) }}" style="flex: 1; margin: 0;"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button" class="btn-action btn-cancelar" onclick="confirmarEliminar({{ $cita->id }})"style="width: 100%;">
                                            Eliminar cita
                                        </button>
                                    </form>

                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Formulario Oculto para Reprogramar -->
                    @if($cita->estado == 'programada')
                        <form action="{{ route('citas.reprogramar', $cita->id) }}" method="POST" id="formReprogramar{{ $cita->id }}" style="display: none;">
                            @csrf
                            <input type="hidden" name="nueva_fecha" id="hidden_nueva_fecha_{{ $cita->id }}">
                            <input type="hidden" name="nueva_hora" id="hidden_nueva_hora_{{ $cita->id }}">
                        </form>
                    @endif
                @endforeach
            </div>

            <!-- Paginación -->
            <div class="mt-4">
                {{ $citas->appends(request()->query())->links() }}
            </div>
        @else
            <div class="alert-custom alert-info-custom">
                <h3>No tienes citas {{request('estado')}}s </h3>
                <div class="filter-group">
                    <a href="{{ route('agendarcitas') }}" class="btn-filter" style="display: inline-flex; text-decoration: none;">
                        Agendar Cita
                    </a>
                </div>
            </div>
        @endif
    </div>


    <!-- Modal Archivar -->
    <div class="modal fade" id="modalArchivar" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Archivar cita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="text-align:center;">
                    <p>¿Estás seguro de que deseas archivar esta cita?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn-accion btn-archivar" id="btnConfirmarArchivar">
                        Sí, archivar
                    </button>
                    <button class="btn-modal-cancel" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Eliminar -->
    <div class="modal fade" id="modalEliminar" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Eliminar cita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="text-align:center;">
                    <p>¿Estás seguro de que deseas eliminar esta cita?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn-modal-danger" id="btnConfirmarEliminar">
                        Sí, eliminar
                    </button>
                    <button class="btn-modal-cancel" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cancelar Cita -->
    <div class="modal fade" id="modalCancelar" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cancelar Cita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="modalCancelarTexto" class="cita-info-box mb-3"></div>
                    <label for="motivo_cancelacion" class="form-label">
                        Motivo de cancelación <span style="color:#e74c3c;">*</span>
                    </label>
                    <textarea id="motivo_cancelacion"
                              class="form-control-modal"
                              rows="3"
                              placeholder="Escribe el motivo de cancelación..."></textarea>
                    <div id="alertaMotivoCancelar" class="alert alert-danger mt-2 d-none">
                        El motivo de cancelación es obligatorio.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnConfirmarCancelar" class="btn-modal-danger">
                        Confirmar cancelación
                    </button>
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Reprogramar -->
    <div class="modal fade" id="modalReprogramar" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reprogramar Cita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalReprogramarContenido">
                    <!-- Se llena dinámicamente por JS -->
                    <div id="alertaReprogramar" class="alert alert-danger mt-3 d-none" role="alert">
                        Debes seleccionar la nueva fecha y hora.
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn-modal-warning" id="btnConfirmarReprogramar">
                        Guardar cambios
                    </button>
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancelar</button>

                </div>
            </div>
        </div>
    </div>




    <script>
        function confirmarCancelacion(id, doctor, fecha, hora) {
            document.getElementById('modalCancelarTexto').innerHTML = `
        <strong>Doctor:</strong> ${doctor}<br>
        <strong>Fecha:</strong> ${fecha}<br>
        <strong>Hora:</strong> ${hora}
    `;

            document.getElementById('btnConfirmarCancelar').onclick = function () {
                let motivo = document.getElementById('motivo_cancelacion').value.trim();
                let alerta = document.getElementById('alertaMotivoCancelar');

                if (!motivo) {
                    alerta.classList.remove('d-none');
                    return;
                }

                alerta.classList.add('d-none');

                document.getElementById('hidden_motivo_' + id).value = motivo;
                document.getElementById('formCancelar' + id).submit();
            };

            document.getElementById('motivo_cancelacion').value = '';
            document.getElementById('alertaMotivoCancelar').classList.add('d-none');

            new bootstrap.Modal(document.getElementById('modalCancelar')).show();
        }

        function confirmarReprogramacion(id, doctor, fecha, hora) {

            document.getElementById('modalReprogramarContenido').innerHTML = `
        <p>Selecciona la nueva fecha y hora para tu cita</p>

        <div class="cita-info-box mb-3">
            <strong>Doctor:</strong> ${doctor}<br>
            <strong>Fecha actual:</strong> ${fecha}<br>
            <strong>Hora actual:</strong> ${hora}
        </div>

        <div class="mb-3">
            <label class="form-label"><i class="fas fa-calendar"></i> Nueva Fecha</label>
            <input type="date" class="form-control form-control-modal" id="modal_fecha_${id}" required min="{{ date('Y-m-d') }}">
        </div>

        <div class="mb-3">
            <label class="form-label"><i class="fas fa-clock"></i> Nueva Hora</label>
            <input type="time" class="form-control form-control-modal" id="modal_hora_${id}" required>
        </div>

        <div id="alertaReprogramar_${id}" class="alert alert-danger d-none">
            Debes seleccionar la nueva fecha y hora.
        </div>
    `;

            document.getElementById('btnConfirmarReprogramar').onclick = function () {

                let nuevaFecha = document.getElementById('modal_fecha_' + id).value;
                let nuevaHora = document.getElementById('modal_hora_' + id).value;
                let alerta = document.getElementById('alertaReprogramar_' + id);

                if (!nuevaFecha || !nuevaHora) {
                    alerta.classList.remove('d-none');
                    return;
                }

                alerta.classList.add('d-none');

                document.getElementById('hidden_nueva_fecha_' + id).value = nuevaFecha;
                document.getElementById('hidden_nueva_hora_' + id).value = nuevaHora;

                document.getElementById('formReprogramar' + id).submit();
            };

            new bootstrap.Modal(document.getElementById('modalReprogramar')).show();
        }

        let citaArchivar = null;

        function confirmarArchivar(id){
            citaArchivar = id;
            let modal = new bootstrap.Modal(document.getElementById('modalArchivar'));
            modal.show();
        }

        document.getElementById('btnConfirmarArchivar').onclick = function(){
            document.getElementById('formArchivar'+citaArchivar).submit();
        };

        let citaEliminar = null;

        function confirmarEliminar(id){
            citaEliminar = id;
            let modal = new bootstrap.Modal(document.getElementById('modalEliminar'));
            modal.show();
        }

        document.getElementById('btnConfirmarEliminar').onclick = function(){
            document.getElementById('formEliminar'+citaEliminar).submit();
        };


    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@endsection
