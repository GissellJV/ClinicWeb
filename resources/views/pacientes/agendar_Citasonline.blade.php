@extends('layouts.plantilla')

@section('contenido')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:whitesmoke;
            display: flex;
        }

        .calendar-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        h1 {
            color: #0f766e;
            font-size: 2.5rem;
            margin-bottom: 30px;
            font-weight: 700;
        }

        .calendar-container {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .controls {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            min-width: 320px;
            max-width: 350px;
        }

        .controls .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #374151;
            font-size: 0.95rem;
        }

        .controls select {
            padding: 12px 16px;
            border-radius: 10px;
            border: 1px solid #d1d5db;
            font-size: 16px;
            width: 100%;
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .controls select:focus {
            outline: none;
            border-color: #14b8a6;
            box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.15);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .nombre-paciente {
            padding: 12px 16px;
            width: 100%;
            border-radius: 10px;
            border: 1px solid #d1d5db;
            font-size: 16px;
            background-color: #f0fdfa;
            color: #0f766e;
            font-weight: 500;
            box-sizing: border-box;
        }

        .loading-text {
            display: none;
            margin-top: 8px;
            color: #0d9488;
            font-size: 14px;
            font-style: italic;
        }

        /* Calendario Mensual */
        .month-calendar {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            min-width: 420px;
            max-width: 500px;
            flex: 1;
        }

        .month-header {
            background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
            color: white;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .month-header h2 {
            margin: 0;
            font-weight: 700;
            font-size: 1.4rem;
        }

        .nav-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 8px;
            padding: 10px 16px;
            color: white;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .nav-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .days-header {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
            padding: 15px 15px 5px 15px;
            background: #f8fafc;
        }

        .day-name {
            font-weight: 700;
            color: #6b7280;
            padding: 10px;
            font-size: 0.9rem;
        }

        .days-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
            padding: 10px 15px 20px 15px;
            gap: 6px;
        }

        .day {
            padding: 14px 8px;
            cursor: pointer;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            background: #f0fdfa;
            color: #374151;
            transition: all 0.2s ease;
        }

        .day:hover {
            background: #ccfbf1;
            color: #0f766e;
        }

        .day.today {
            background: #14b8a6;
            color: white;
            font-weight: 700;
        }

        .day.selected {
            background: #0d9488;
            color: white;
            box-shadow: 0 4px 12px rgba(13, 148, 136, 0.4);
        }

        .day.empty {
            background: transparent;
            cursor: default;
        }

        .day.no-disponible {
            background: #f3f4f6;
            color: #9ca3af;
        }


        /* Leyenda */
        .legend {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .legend h4 {
            font-size: 0.9rem;
            color: #374151;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
            font-size: 0.85rem;
            color: #4b5563;
        }

        .legend-color {
            width: 24px;
            height: 24px;
            border-radius: 6px;
        }

        .legend-color.disponible { background: #22c55e; }
        .legend-color.agendada { background: #0d9488; }
        .legend-color.no-disponible { background: #9ca3af; }

        /* Modal */
        .modal-horarios {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-horarios .modal-content {
            background: white;
            border-radius: 16px;
            padding: 25px;
            width: 90%;
            max-width: 550px;
            max-height: 85vh;
            overflow-y: auto;
            animation: modalFadeIn 0.3s ease;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }



        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.9) translateY(-20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .modal-horarios .modal-content h3 {
            color: #0f766e;
            margin-bottom: 20px;
            font-size: 1.2rem;
        }

        .doctor-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 15px;
            background: #f9fafb;
            transition: all 0.3s ease;
        }

        .doctor-card:hover {
            border-color: #14b8a6;
            background: #f0fdfa;
        }

        .doctor-nombre {
            font-weight: 700;
            color: #1f2937;
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .horas {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .hora {
            padding: 10px 16px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .hora.disponible {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
        }

        .hora.disponible:hover {
            background: #22c55e;
            color: white;
            transform: scale(1.05);
        }

        .hora.ocupada {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
            cursor: not-allowed;
            opacity: 0.7;
        }

        .hora.seleccionada {
            background: #0d9488;
            color: white;
            border: 2px solid #0f766e;
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(13, 148, 136, 0.4);
        }

        .btn-agendar {
            display: block;
            width: 100%;
            padding: 14px 28px;
            background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(20, 184, 166, 0.3);
        }

        .btn-agendar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(20, 184, 166, 0.4);
        }

        .btn-agendar:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-citas {
            display: inline-block;
            padding: 14px 28px;
            background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(20, 184, 166, 0.3);
            margin-top: 20px;
            width: 100%;
            text-align: center;
            box-sizing: border-box;
        }

        .btn-citas:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(20, 184, 166, 0.4);
            color: white;
        }

        .btn-cerrar {
            padding: 12px 28px;
            background: #6b7280;
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 15px;
        }

        .btn-cerrar:hover {
            background: #4b5563;
        }

        .fecha-seleccionada {
            background: #f0fdfa;
            border: 1px solid #99f6e4;
            border-radius: 10px;
            padding: 12px 16px;
            color: #0f766e;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .calendar-container {
                flex-direction: column;
                align-items: center;
            }

            .controls {
                width: 100%;
                max-width: 100%;
            }

            .month-calendar {
                width: 100%;
                min-width: auto;
            }
        }


        /* =========================
       MODAL SELECTOR CLINICWEB
    ========================= */

        .modal-selector .modal-content.selector-content {
            background: #fff;
            border: 3px solid #24f3e2;
            box-shadow: 0 0 20px rgba(36, 243, 226, 0.4);
            border-radius: 18px;
            overflow: hidden;
            padding: 0;
            animation: popSelector 0.25s ease-out;
        }

        @keyframes popSelector {
            0% {
                transform: scale(.7);
                opacity: 0;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .modal-selector .selector-header {
            background: linear-gradient(90deg, #00e1ff, #00ffc8);
            padding: 15px 20px;
            border-bottom: none;
        }

        .modal-selector .modal-title {
            color: #fff;
            margin: 0;
            font-size: 26px;
            font-weight: 800;
        }

        .modal-selector .selector-close {
            filter: brightness(0) invert(1);
            transition: transform .35s ease, opacity .3s ease;
            opacity: 0.9;
        }

        .modal-selector .selector-close:hover {
            transform: rotate(180deg);
            opacity: 1;
        }

        .modal-selector .selector-body {
            padding: 24px 24px 18px;
            background: #fff;
        }

        .modal-selector .selector-footer {
            border-top: 1px solid #e5e5e5;
            padding: 18px 24px 22px;
            display: flex;
            justify-content: center;
            gap: 14px;
            background: #fff;
        }

        /* Interior tipo DataTable */
        .table-container-modal {
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 20px;
        }

        .modal-selector table.dataTable {
            width: 100% !important;
            border-collapse: collapse;
        }

        .modal-selector table.dataTable thead th {
            padding: 20px;
            text-align: left;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border-bottom: 2px solid #e0e0e0;
            color: white !important;
            background: #4ecdc4 !important;
        }

        .modal-selector table.dataTable tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s;
        }

        .modal-selector table.dataTable tbody tr:hover {
            background: #f8f9fa;
        }

        .modal-selector table.dataTable tbody td {
            padding: 18px;
            color: #666;
            vertical-align: middle;
        }

        .modal-selector .dataTables_wrapper .dataTables_length,
        .modal-selector .dataTables_wrapper .dataTables_filter {
            margin-bottom: 20px;
        }

        .modal-selector .dataTables_wrapper .dataTables_filter input {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 8px 15px;
            margin-left: 10px;
        }

        .modal-selector .dataTables_wrapper .dataTables_filter input:focus {
            outline: none;
            border-color: #4ecdc4;
            box-shadow: 0 0 0 0.25rem rgba(78, 205, 196, 0.25);
        }

        .modal-selector .dataTables_wrapper .dataTables_length select {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 5px 10px;
            margin: 0 10px;
        }

        .modal-selector .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 8px 12px !important;
            border-radius: 8px !important;
            transition: all 0.3s !important;
            box-shadow: none !important;
            font-weight: 600 !important;
        }

        .modal-selector .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            color: white !important;
            box-shadow: none !important;
            transform: translateY(-2px);
        }

        .modal-selector .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%) !important;
            color: white !important;
            border-color: #4ecdc4 !important;
        }

        .modal-selector .dataTables_wrapper .dataTables_info {
            font-size: 14px;
            padding-top: 15px;
        }

        .btn-modal-seleccionar {
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 13px;
            font-weight: 500;
            text-align: center;
            min-width: 120px;
            cursor: pointer;
            white-space: nowrap;
            background: linear-gradient(135deg, #4ecdc4 0%, #44b8af 100%);
            color: white;
            border: none;
        }

        .btn-modal-seleccionar:hover {
            background: linear-gradient(135deg, #44b8af 0%, #3aa39a 100%);
            box-shadow: 0 3px 10px rgba(78, 205, 196, 0.25);
            color: white;
        }

        .btn-cancel {
            padding: 0.875rem 2rem;
            background: white;
            border: 2px solid #131212;
            border-radius: 8px;
            color: #221414;
            font-weight: 600;
            font-size: 1.05rem;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }

        .btn-open-selector {
            padding: 0.875rem 1.5rem;
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.3);
            white-space: nowrap;
        }

        .btn-open-selector:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
            color: white;
        }

        .btn-open-selector:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        #doctor_nombre {
            border: 2px solid #24f3e2;
            border-radius: 14px;
            background: white;
            padding: 10px 14px;
            font-size: 16px;
            box-shadow: 0 0 12px rgba(36, 243, 226, 0.20);
            transition: 0.2s;
        }

        #doctor_nombre:hover {
            box-shadow: 0 0 18px rgba(36, 243, 226, 0.30);
        }

        @media (max-width: 768px) {
            .btn-open-selector {
                width: 100%;
            }
        }

        /* ================= DARK MODE CALENDARIO ================= */

        .dark-mode body,
        .dark-mode .calendar-wrapper {
            background: #121212 !important;
            color: #e4e4e4;
        }

        .dark-mode h1 {
            color: #4ecdc4;
        }

        /* CONTROLES PANEL */
        .dark-mode .controls {
            background: #1e1e1e;
            border: 1px solid #333;
            color: #e4e4e4;
            box-shadow: 0 4px 20px rgba(0,0,0,0.5);
        }

        .dark-mode .controls .form-label {
            color: #ccc !important;
        }

        .dark-mode select {
            background: #2a2a2a !important;
            color: #fff !important;
            border: 1px solid #444 !important;
        }

        .dark-mode select:focus {
            border-color: #4ecdc4;
            box-shadow: 0 0 0 3px rgba(78,205,196,0.3);
        }

        .dark-mode .nombre-paciente {
            background: #1e1e1e;
            border: 1px solid #4ecdc4;
            color: #4ecdc4;
        }

        .dark-mode #doctor_nombre {
            background: #1e1e1e !important;
            color: #e4e4e4 !important;
            border: 2px solid #4ecdc4 !important;
            box-shadow: 0 0 12px rgba(78,205,196,0.18);
        }

        .dark-mode #doctor_nombre::placeholder {
            color: #9ca3af;
        }

        /* CALENDARIO */
        .dark-mode .month-calendar {
            background: #1e1e1e !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.5);
        }

        .dark-mode .month-header {
            background: linear-gradient(135deg, #1c1c1c, #2c5364);
            color: #fff;
        }

        .dark-mode .nav-btn {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .dark-mode .days-header {
            background: #1f2937;
        }

        .dark-mode .day-name {
            color: #9ca3af;
        }

        .dark-mode .days-grid .day {
            background: #1e1e1e;
            color: #e4e4e4;
        }

        .dark-mode .days-grid .day:hover {
            background: #064e3b;
            color: #d1fae5;
        }

        .dark-mode .days-grid .day.today {
            background: #4ecdc4;
            color: #111827;
        }

        .dark-mode .days-grid .day.selected {
            background: #0d9488;
            color: #fff;
            box-shadow: 0 4px 12px rgba(13,148,136,0.5);
        }

        .dark-mode .days-grid .day.no-disponible {
            background: #374151;
            color: #9ca3af;
        }

        /* MODAL HORARIOS */
        .dark-mode .modal-horarios .modal-content {
            background: #1e1e1e !important;
            color: #e4e4e4;
            border: 1px solid #333;
        }

        .dark-mode .modal-horarios .modal-content h3 {
            color: #4ecdc4;
        }

        .dark-mode .doctor-card {
            background: #1e1e1e;
            border: 1px solid #333;
        }

        .dark-mode .doctor-card:hover {
            border-color: #4ecdc4;
            background: #064e3b;
        }

        .dark-mode .doctor-nombre {
            color: #e5e7eb;
        }

        .dark-mode .hora.disponible {
            background: #064e3b;
            color: #d1fae5;
            border: 1px solid #4ecdc4;
        }

        .dark-mode .hora.disponible:hover {
            background: #4ecdc4;
            color: #111827;
        }

        .dark-mode .hora.ocupada {
            background: #7f1d1d;
            color: #fee2e2;
            border: 1px solid #fca5a5;
        }

        .dark-mode .hora.seleccionada {
            background: #0d9488;
            color: #fff;
            border: 2px solid #4ecdc4;
        }

        /* MODAL SELECTOR DOCTORES */
        .dark-mode .modal-selector .modal-content.selector-content {
            background: #1e1e1e !important;
            color: #e4e4e4;
            border: 2px solid #24f3e2;
            box-shadow: 0 0 20px rgba(36, 243, 226, 0.18);
        }

        .dark-mode .modal-selector .selector-header {
            background: linear-gradient(135deg, #203a43, #2c5364);
            border-bottom: none;
        }

        .dark-mode .modal-selector .modal-title {
            color: #ffffff;
        }

        .dark-mode .modal-selector .selector-close {
            filter: brightness(0) invert(1);
        }

        .dark-mode .modal-selector .selector-body {
            background: #1e1e1e !important;
        }

        .dark-mode .modal-selector .selector-footer {
            background: #1e1e1e !important;
            border-top: 1px solid #333;
        }

        .dark-mode .table-container-modal {
            background: #161616 !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.35);
        }

        .dark-mode .modal-selector table.dataTable thead th {
            background: #111827 !important;
            color: #e5e7eb !important;
            border-bottom: 2px solid #374151 !important;
        }

        .dark-mode .modal-selector table.dataTable tbody tr {
            background: #1e1e1e;
            border-bottom: 1px solid #2f2f2f;
        }

        .dark-mode .modal-selector table.dataTable tbody tr:hover {
            background: #27303d;
        }

        .dark-mode .modal-selector table.dataTable tbody td {
            color: #d1d5db;
        }

        .dark-mode .modal-selector .dataTables_wrapper .dataTables_length,
        .dark-mode .modal-selector .dataTables_wrapper .dataTables_filter,
        .dark-mode .modal-selector .dataTables_wrapper .dataTables_info {
            color: #cbd5e1 !important;
        }

        .dark-mode .modal-selector .dataTables_wrapper .dataTables_filter input,
        .dark-mode .modal-selector .dataTables_wrapper .dataTables_length select {
            background: #2a2a2a !important;
            color: #ffffff !important;
            border: 1px solid #444 !important;
        }

        .dark-mode .modal-selector .dataTables_wrapper .dataTables_filter input:focus,
        .dark-mode .modal-selector .dataTables_wrapper .dataTables_length select:focus {
            border-color: #4ecdc4 !important;
            box-shadow: 0 0 0 0.25rem rgba(78,205,196,0.22) !important;
            outline: none;
        }

        .dark-mode .modal-selector .dataTables_wrapper .dataTables_paginate .paginate_button {
            background: #2a2a2a !important;
            color: #d1d5db !important;
            border: 1px solid #444 !important;
        }

        .dark-mode .modal-selector .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #374151 !important;
            color: #ffffff !important;
            border-color: #4ecdc4 !important;
        }

        .dark-mode .modal-selector .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #4ecdc4, #00ffe7) !important;
            color: #111827 !important;
            border-color: #4ecdc4 !important;
        }

        .dark-mode .btn-modal-seleccionar {
            background: linear-gradient(135deg, #2c5364, #203a43);
            color: #e5e7eb;
        }

        .dark-mode .btn-modal-seleccionar:hover {
            background: linear-gradient(135deg, #4ecdc4, #00ffe7);
            color: #111827;
            box-shadow: 0 0 10px rgba(0,255,231,0.35);
        }

        .dark-mode .btn-open-selector {
            background: linear-gradient(135deg, #2c5364, #203a43);
            color: #e5e7eb;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.45);
        }

        .dark-mode .btn-open-selector:hover {
            background: linear-gradient(135deg, #4ecdc4, #00ffe7);
            color: #111827;
            box-shadow: 0 0 15px #00ffe7, 0 0 25px rgba(0,255,231,0.35);
        }

        .dark-mode .btn-open-selector:disabled {
            opacity: 0.55;
            box-shadow: none;
        }

        .dark-mode .btn-cancel {
            background: #2a2a2a;
            color: #e5e7eb;
            border: 1px solid #555;
        }

        .dark-mode .btn-cancel:hover {
            background: #dc3545;
            color: #fff;
            border-color: #dc3545;
            box-shadow: 0 0 10px rgba(220,53,69,0.35);
        }

        /* BOTONES GENERALES */
        .dark-mode .btn-agendar,
        .dark-mode .btn-citas,
        .dark-mode .btn-cerrar {
            background: #2a2a2a;
            color: #e4e4e4;
            border: 1px solid #555;
        }

        .dark-mode .btn-agendar:hover,
        .dark-mode .btn-citas:hover {
            background: linear-gradient(135deg, #4ecdc4, #00ffe7);
            color: #111827;
            box-shadow: 0 0 15px #00ffe7, 0 0 25px rgba(0,255,231,0.4);
            transform: translateY(-2px);
        }

        .dark-mode .btn-cerrar:hover {
            background: #374151;
        }

        /* ALERTAS */
        .dark-mode .alert-success {
            background: #1e3a2f;
            color: #4ade80;
            border-color: #2f5f4a;
        }

        .dark-mode .alert-danger {
            background: #3a1e1e;
            color: #ff6b6b;
            border-color: #5f2f2f;
        }

        .dark-mode .fecha-seleccionada {
            background: #1e1e1e !important;
            border: 1px solid #4ecdc4 !important;
            color: #4ecdc4 !important;
        }
    </style>

    <div class="calendar-wrapper">
        <h1 class="text-center">Agenda de Citas Médicas</h1>

        <div id="alert-container" class="container" style="max-width: 700px;"></div>

        <div class="calendar-container">
            <div class="controls">
                <div class="form-group">
                    <label class="form-label">Nombre del Paciente:</label>
                    <div class="nombre-paciente" id="nombre">
                        {{ session('paciente_nombre') }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="especialidad" class="form-label">Seleccionar Especialidad:</label>
                    <select name="especialidad" id="especialidad" class="form-control" required>
                        <option value="">Seleccione especialidad</option>
                        @foreach($especialidades as $esp)
                            <option value="{{ $esp }}">{{ $esp }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="doctor_nombre" class="form-label">Seleccionar Doctor:</label>

                    <input type="hidden" name="empleado_id" id="empleado_id" required>

                    <div style="display: flex; gap: 10px; align-items: center;">
                        <input
                            type="text"
                            id="doctor_nombre"
                            class="form-control"
                            placeholder="Seleccione un doctor"
                            readonly
                            required
                        >

                        <button type="button" class="btn btn-open-selector" id="btnAbrirModalDoctor" disabled>
                            Buscar
                        </button>
                    </div>

                    <div id="loadingDoctores" class="loading-text">Cargando doctores...</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Fecha Seleccionada:</label>
                    <div class="fecha-seleccionada" id="fecha-display">
                        Seleccione una fecha en el calendario
                    </div>
                </div>

                <a href="{{ route('citas.mis-citas') }}" class="btn-citas">
                    Ver Mis Citas
                </a>
            </div>

            <!-- Calendario Mensual -->
            <div class="month-calendar">
                <div class="month-header">
                    <button class="nav-btn" id="prev-month">&#8592;</button>
                    <h2 id="month-title"></h2>
                    <button class="nav-btn" id="next-month">&#8594;</button>
                </div>
                <div class="days-header" id="days-header"></div>
                <div class="days-grid" id="days-grid"></div>
            </div>
        </div>

        <!-- Modal de Horarios -->
        <div class="modal-horarios" id="modal-doctores">
            <div class="modal-content">
                <div id="alert-modal-container" style="margin-bottom: 15px;"></div>
                <h3 id="titulo-doctores"></h3>
                <div id="doctores-container" class="doctores"></div>
                <button class="btn-cerrar" id="cerrar-modal-doctores">Cerrar</button>
            </div>
        </div>
    </div>

    <!-- Modal selector de doctores -->
    <div class="modal fade modal-selector" id="modalDoctores" tabindex="-1" aria-labelledby="modalDoctoresLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content selector-content">
                <div class="modal-header selector-header">
                    <h5 class="modal-title" id="modalDoctoresLabel">Seleccionar Doctor</h5>
                    <button type="button" class="btn-close selector-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body selector-body">
                    <div class="table-container-modal">
                        <table id="tablaDoctoresModal" class="table table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre Completo</th>
                                <th>Especialidad</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer selector-footer">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const monthTitle = document.getElementById('month-title');
            const daysHeader = document.getElementById('days-header');
            const daysGrid = document.getElementById('days-grid');
            const prevMonthBtn = document.getElementById('prev-month');
            const nextMonthBtn = document.getElementById('next-month');
            const modalDoctores = document.getElementById('modal-doctores');
            const tituloDoctores = document.getElementById('titulo-doctores');
            const doctoresContainer = document.getElementById('doctores-container');
            const cerrarModalDoctores = document.getElementById('cerrar-modal-doctores');
            const especialidadSelect = document.getElementById('especialidad');
            const empleadoIdInput = document.getElementById('empleado_id');
            const doctorNombreInput = document.getElementById('doctor_nombre');
            const btnAbrirModalDoctor = document.getElementById('btnAbrirModalDoctor');
            const loadingDoctores = document.getElementById('loadingDoctores');
            const nombreLabel = document.getElementById('nombre');
            const fechaDisplay = document.getElementById('fecha-display');
            const alertContainer = document.getElementById('alert-container');
            const alertModalContainer = document.getElementById('alert-modal-container');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
            const diasSemana = ['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom'];

            let currentDate = new Date();
            let currentMonth = currentDate.getMonth();
            let currentYear = currentDate.getFullYear();
            let selectedDate = null;
            let selectedDayElement = null;

            diasSemana.forEach(dia => {
                const div = document.createElement('div');
                div.classList.add('day-name');
                div.textContent = dia;
                daysHeader.appendChild(div);
            });

            function mostrarAlerta(tipo, mensaje) {
                const alert = document.createElement('div');
                alert.className = `alert alert-${tipo} fade show mt-2`;
                alert.role = 'alert';
                alert.innerHTML = mensaje;
                alertContainer.innerHTML = '';
                alertContainer.appendChild(alert);

                setTimeout(() => {
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                    setTimeout(() => alert.remove(), 300);
                }, 4000);
            }

            function mostrarAlertaModal(tipo, mensaje) {
                alertModalContainer.innerHTML = '';

                const alert = document.createElement('div');
                alert.className = `alert alert-${tipo} fade show`;
                alert.role = 'alert';
                alert.style.marginBottom = '15px';
                alert.innerHTML = mensaje;
                alertModalContainer.appendChild(alert);

                setTimeout(() => {
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            }

            const tablaDoctores = $('#tablaDoctoresModal').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    processing: "Procesando...",
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ registros",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty: "Mostrando 0 a 0 de 0 registros",
                    infoFiltered: "(filtrado de _MAX_ registros totales)",
                    loadingRecords: "Cargando...",
                    zeroRecords: "No se encontraron registros",
                    emptyTable: "No hay doctores disponibles",
                    paginate: {
                        first: "Primero",
                        previous: "Anterior",
                        next: "Siguiente",
                        last: "Último"
                    }
                },
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                columnDefs: [
                    {
                        targets: 3,
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            function enlazarBotonesDoctor() {
                document.querySelectorAll('.seleccionar-doctor').forEach(boton => {
                    boton.addEventListener('click', function () {
                        const id = this.dataset.id;
                        const nombre = this.dataset.nombre;

                        empleadoIdInput.value = id;
                        doctorNombreInput.value = nombre;

                        const modalElement = document.getElementById('modalDoctores');
                        const modalInstance = bootstrap.Modal.getOrCreateInstance(modalElement);
                        modalInstance.hide();
                    });
                });
            }

            especialidadSelect.addEventListener('change', function () {
                empleadoIdInput.value = '';
                doctorNombreInput.value = '';
                tablaDoctores.clear().draw();

                if (this.value) {
                    btnAbrirModalDoctor.disabled = false;
                } else {
                    btnAbrirModalDoctor.disabled = true;
                }
            });

            btnAbrirModalDoctor.addEventListener('click', function () {
                const especialidad = especialidadSelect.value;

                if (!especialidad) {
                    mostrarAlerta('warning', 'Seleccione una especialidad primero.');
                    return;
                }

                loadingDoctores.style.display = 'block';
                tablaDoctores.clear().draw();

                fetch(`/recepcionista/doctores-expediente/${encodeURIComponent(especialidad)}`)
                    .then(res => res.json())
                    .then(data => {
                        tablaDoctores.clear();

                        data.forEach(doctor => {
                            const prefijo = doctor.genero === 'Femenino' ? 'Dra.' : 'Dr.';
                            const nombreCompleto = `${prefijo} ${doctor.nombre} ${doctor.apellido || ''}`.trim();

                            tablaDoctores.row.add([
                                doctor.id,
                                nombreCompleto,
                                especialidad,
                                `<button
                            type="button"
                            class="btn-modal-seleccionar seleccionar-doctor"
                            data-id="${doctor.id}"
                            data-nombre="${nombreCompleto}"
                        >
                            Seleccionar
                        </button>`
                            ]);
                        });

                        tablaDoctores.draw();

                        setTimeout(() => {
                            enlazarBotonesDoctor();
                        }, 100);

                        const modalElement = document.getElementById('modalDoctores');
                        const modalInstance = bootstrap.Modal.getOrCreateInstance(modalElement);
                        modalInstance.show();
                    })
                    .catch(error => {
                        console.error('Error al cargar doctores:', error);
                        mostrarAlerta('danger', 'Error al cargar los doctores.');
                    })
                    .finally(() => {
                        loadingDoctores.style.display = 'none';
                    });
            });

            $('#modalDoctores').on('shown.bs.modal', function () {
                tablaDoctores.columns.adjust().responsive.recalc();
            });

            function renderCalendar() {
                daysGrid.innerHTML = '';
                monthTitle.textContent = `${meses[currentMonth]} ${currentYear}`;

                const firstDay = new Date(currentYear, currentMonth, 1).getDay();
                const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

                const offset = firstDay === 0 ? 6 : firstDay - 1;
                for (let i = 0; i < offset; i++) {
                    const emptyDiv = document.createElement('div');
                    emptyDiv.classList.add('day', 'empty');
                    daysGrid.appendChild(emptyDiv);
                }

                const hoy = new Date();
                hoy.setHours(0, 0, 0, 0);

                for (let day = 1; day <= daysInMonth; day++) {
                    const dayDiv = document.createElement('div');
                    dayDiv.classList.add('day');
                    dayDiv.textContent = day;

                    const fecha = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                    const fechaObj = new Date(fecha);

                    if (fechaObj < hoy) {
                        dayDiv.classList.add('no-disponible');
                        dayDiv.style.cursor = 'not-allowed';
                        dayDiv.addEventListener('click', () => {
                            mostrarAlerta('warning', 'No se puede agendar citas en fechas pasadas.');
                        });
                    } else {
                        dayDiv.addEventListener('click', () => handleDayClick(dayDiv, day, fecha));
                    }

                    if (fechaObj.getTime() === hoy.getTime()) {
                        dayDiv.classList.add('today');
                    }

                    if (selectedDate === fecha) {
                        dayDiv.classList.add('selected');
                        selectedDayElement = dayDiv;
                    }

                    daysGrid.appendChild(dayDiv);
                }
            }

            function handleDayClick(dayDiv, day, fecha) {
                const esp = especialidadSelect.value;
                const doctorId = empleadoIdInput.value;
                const doctorNombre = doctorNombreInput.value.trim();
                const nombrePaciente = nombreLabel.textContent.trim();

                if (!esp) {
                    mostrarAlerta('warning', 'Seleccione una especialidad primero.');
                    return;
                }

                if (!doctorId || !doctorNombre) {
                    mostrarAlerta('warning', 'Seleccione un doctor primero.');
                    return;
                }

                if (!nombrePaciente) {
                    mostrarAlerta('danger', 'No se encontró el nombre del paciente.');
                    return;
                }

                if (selectedDayElement) {
                    selectedDayElement.classList.remove('selected');
                }

                dayDiv.classList.add('selected');
                selectedDayElement = dayDiv;
                selectedDate = fecha;

                fechaDisplay.textContent = `${day} de ${meses[currentMonth]} ${currentYear}`;

                abrirModalDoctores(esp, fecha, nombrePaciente, doctorId, doctorNombre);
            }

            prevMonthBtn.addEventListener('click', () => {
                currentMonth--;
                if (currentMonth < 0) {
                    currentMonth = 11;
                    currentYear--;
                }
                renderCalendar();
            });

            nextMonthBtn.addEventListener('click', () => {
                currentMonth++;
                if (currentMonth > 11) {
                    currentMonth = 0;
                    currentYear++;
                }
                renderCalendar();
            });

            const horariosDisponibles = [
                { hora: '08:00 AM', disponible: true },
                { hora: '09:00 AM', disponible: true },
                { hora: '10:00 AM', disponible: true },
                { hora: '11:00 AM', disponible: true },
                { hora: '12:00 PM', disponible: true },
                { hora: '01:00 PM', disponible: true },
                { hora: '02:00 PM', disponible: true },
                { hora: '03:00 PM', disponible: true },
                { hora: '04:00 PM', disponible: true },
                { hora: '05:00 PM', disponible: true }
            ];

            let horaSeleccionada = null;
            let horaSeleccionadaElement = null;

            function abrirModalDoctores(especialidad, fecha, nombrePaciente, doctorId, doctorNombre) {
                modalDoctores.style.display = 'flex';
                alertModalContainer.innerHTML = '';
                tituloDoctores.textContent = `Horarios disponibles - ${formatoFecha(fecha)}`;
                doctoresContainer.innerHTML = '';
                horaSeleccionada = null;
                horaSeleccionadaElement = null;

                const card = document.createElement('div');
                card.classList.add('doctor-card');
                card.innerHTML = `<div class="doctor-nombre">${doctorNombre}</div>`;

                const horasDiv = document.createElement('div');
                horasDiv.classList.add('horas');

                horariosDisponibles.forEach(horario => {
                    const div = document.createElement('div');
                    div.textContent = horario.hora;
                    div.classList.add('hora');
                    div.classList.add(horario.disponible ? 'disponible' : 'ocupada');

                    if (horario.disponible) {
                        div.addEventListener('click', () => {
                            if (horaSeleccionadaElement) {
                                horaSeleccionadaElement.classList.remove('seleccionada');
                            }
                            div.classList.add('seleccionada');
                            horaSeleccionadaElement = div;
                            horaSeleccionada = horario.hora;
                        });
                    }

                    horasDiv.appendChild(div);
                });

                card.appendChild(horasDiv);

                const btnAgendar = document.createElement('button');
                btnAgendar.textContent = 'Agendar Cita';
                btnAgendar.classList.add('btn-agendar');

                btnAgendar.addEventListener('click', async () => {
                    if (!horaSeleccionada) {
                        mostrarAlertaModal('warning', 'Seleccione un horario primero.');
                        return;
                    }

                    btnAgendar.disabled = true;
                    btnAgendar.textContent = 'Agendando...';

                    try {
                        const response = await fetch("{{ route('citas.guardar') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": csrfToken
                            },
                            body: JSON.stringify({
                                fecha: fecha,
                                hora: horaSeleccionada,
                                doctor_id: doctorId,
                                especialidad: especialidad
                            })
                        });

                        const data = await response.json();

                        if (data.success) {
                            modalDoctores.style.display = 'none';
                            mostrarAlerta('success', 'Tu cita ha sido agendada exitosamente.');
                            renderCalendar();
                        } else {
                            mostrarAlertaModal(
                                response.status === 422 ? 'warning' : 'danger',
                                data.message || 'No se pudo agendar la cita'
                            );
                            btnAgendar.disabled = false;
                            btnAgendar.textContent = 'Agendar Cita';
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        mostrarAlertaModal('danger', 'Error al agendar la cita. Intente nuevamente.');
                        btnAgendar.disabled = false;
                        btnAgendar.textContent = 'Agendar Cita';
                    }
                });

                doctoresContainer.appendChild(card);
                doctoresContainer.appendChild(btnAgendar);
            }

            function formatoFecha(fecha) {
                const [y, m, d] = fecha.split('-');
                return `${d}/${m}/${y}`;
            }

            cerrarModalDoctores.addEventListener('click', () => {
                alertModalContainer.innerHTML = '';
                modalDoctores.style.display = 'none';
            });

            modalDoctores.addEventListener('click', (e) => {
                if (e.target === modalDoctores) {
                    alertModalContainer.innerHTML = '';
                    modalDoctores.style.display = 'none';
                }
            });

            renderCalendar();
        });
    </script>

@endsection
