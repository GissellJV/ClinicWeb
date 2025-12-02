@extends('layouts.plantilla')

@section('contenido')
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
        .modal {
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

        .modal-content {
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

        .modal-content h3 {
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
                    <label for="empleado_id" class="form-label">Seleccionar Doctor:</label>
                    <select name="empleado_id" id="empleado_id" class="form-control" required>
                        <option value="">Seleccione Doctor</option>
                    </select>
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
        <div class="modal" id="modal-doctores">
            <div class="modal-content">
                <div id="alert-modal-container" style="margin-bottom: 15px;"></div>
                <h3 id="titulo-doctores"></h3>
                <div id="doctores-container" class="doctores"></div>
                <button class="btn-cerrar" id="cerrar-modal-doctores">Cerrar</button>
            </div>
        </div>
    </div>

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
            const doctorSelect = document.getElementById('empleado_id');
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

            especialidadSelect.addEventListener('change', function () {
                const especialidad = this.value;
                doctorSelect.innerHTML = '<option value="">Seleccione Doctor</option>';

                if (especialidad) {
                    loadingDoctores.style.display = 'block';

                    fetch(`/recepcionista/doctores-expediente/${especialidad}`)
                        .then(res => res.json())
                        .then(data => {
                            data.forEach(doctor => {
                                const option = document.createElement('option');
                                option.value = doctor.id;
                                option.textContent = `${doctor.genero === 'Femenino' ? 'Dra.' : 'Dr.'} ${doctor.nombre} ${doctor.apellido || ''}`;
                                doctorSelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Error al cargar doctores:', error);
                            mostrarAlerta('danger', 'Error al cargar los doctores');
                        })
                        .finally(() => loadingDoctores.style.display = 'none');
                }
            });

            // ALERTA PRINCIPAL (SIN ICONO, SIN X)
            function mostrarAlerta(tipo, mensaje) {
                const alert = document.createElement('div');
                alert.className = `alert alert-${tipo} fade show mt-2`;
                alert.role = 'alert';
                alert.innerHTML = mensaje;
                alertContainer.appendChild(alert);

                setTimeout(() => {
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                    setTimeout(() => alert.remove(), 300);
                }, 4000);
            }

            // ALERTA EN MODAL (SIN ICONO, SIN X)
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
                    dayDiv.dataset.fecha = fecha;

                    const fechaObj = new Date(fecha);

                    if (fechaObj < hoy) {
                        dayDiv.classList.add('no-disponible');
                        dayDiv.style.cursor = 'not-allowed';
                        dayDiv.addEventListener('click', () => {
                            mostrarAlerta('warning', 'No se puede agendar citas en fechas  pasadas.');
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
                const doctorId = doctorSelect.value;
                const nombrePaciente = nombreLabel.textContent.trim();

                if (!esp) {
                    mostrarAlerta('warning', 'Seleccione una especialidad primero.');
                    return;
                }

                if (!doctorId) {
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

                abrirModalDoctores(esp, fecha, nombrePaciente, doctorId);
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

            function abrirModalDoctores(especialidad, fecha, nombrePaciente, doctorId) {
                modalDoctores.style.display = 'flex';
                alertModalContainer.innerHTML = '';

                const doctorNombre = doctorSelect.options[doctorSelect.selectedIndex].text;
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
