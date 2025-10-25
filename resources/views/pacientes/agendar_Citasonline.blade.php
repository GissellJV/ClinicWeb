@extends('layouts.plantilla')

@section('contenido')
    <style>
    body {
        background: #f6f8fa;
        font-family: 'Poppins', sans-serif;
    }

    .calendar-wrapper {
        max-width: 1200px;
        margin: 50px auto;
        text-align: center;
    }

    h1 {
        color: #333;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .calendar-container {
        display: flex;
        align-items: flex-start;
        justify-content: center;
        gap: 30px;
    }

    .controls {
        text-align: left;
    }

    .controls label {
        display: block;
        font-weight: bold;
        margin-bottom: 8px;
        color: #333;
    }

    .controls input,
    .controls select {
        padding: 12px 18px;
        border-radius: 10px;
        border: 1px solid #999;
        font-size: 18px;
        width: 300px;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .controls input {
        margin-bottom: 10px;
    }

    .year-calendar {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(270px, 1fr));
        gap: 20px;
        flex: 1;
    }

    .month {
        background: white;
        border-radius: 12px;
        box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .month:hover {
        transform: scale(1.03);
    }

    .month-header {
        background: #007bff;
        color: white;
        padding: 10px;
        font-weight: 500;
    }

    .days {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        text-align: center;
        padding: 10px;
    }

    .day {
        padding: 8px;
        cursor: pointer;
        border-radius: 6px;
        transition: 0.2s;
    }

    .day:hover {
        background: #e8f1ff;
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.6);
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background: white;
        border-radius: 10px;
        padding: 20px;
        width: 500px;
        max-height: 90vh;
        overflow-y: auto;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: scale(0.8);}
        to {opacity: 1; transform: scale(1);}
    }

    .doctor-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px;
        margin-bottom: 12px;
        background: #f9f9f9;
    }

    .doctor-nombre {
        font-weight: bold;
        color: #2c3e50;
    }

    .horas {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 8px;
    }

    .hora {
        padding: 6px 10px;
        border-radius: 20px;
        cursor: pointer;
        font-size: 14px;
        transition: 0.3s;
    }

    .hora.disponible {
        background: #d4edda;
        color: #155724;
    }

    .hora.ocupada {
        background: #f8d7da;
        color: #721c24;
        cursor: not-allowed;
    }

    button {
        background: #007bff;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        margin-top: 10px;
    }
</style>

    <div class="calendar-wrapper">
        <br><br><br><br>
        <h1>Agenda de Citas Médicas</h1>


        <div class="calendar-container">

            <div class="controls">

                <label for="nombre">Nombre del Paciente:</label>
                <input type="text" id="nombre" placeholder="Ingrese su nombre" style="padding:12px; width: 300px; border-radius:10px; border:1px solid #999; font-size:16px;">

                <br><br>

                <!-- Selector de especialidad -->
                <label for="especialidad">Especialidad:</label>
                <select id="especialidad">
                    <option value="">Seleccione una especialidad</option>
                    <option value="medicina">Medicina General</option>
                    <option value="pediatria">Pediatría</option>
                    <option value="dermatologia">Dermatología</option>
                </select>

                <br><br><br><br><br><br><br><br>

                <!-- Botón para ir al listado -->
                <a href="{{route('citasprogramadas')}}" class="btn btn-primary " style=" font-size: 16px; border-radius: 8px; display:inline-block;">
                    Ver Citas Agendadas
                </a>
            </div>

            <!-- Contenedor del calendario -->
            <div class="year-calendar" id="year-calendar"></div>
        </div>

        <!-- Modal para doctores y horarios -->
        <div class="modal" id="modal-doctores">
            <div class="modal-content">
                <h3 id="titulo-doctores"></h3>
                <div id="doctores-container" class="doctores"></div>
                <button id="cerrar-modal-doctores">Cerrar</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const yearCalendar = document.getElementById('year-calendar');
            const modalDoctores = document.getElementById('modal-doctores');
            const tituloDoctores = document.getElementById('titulo-doctores');
            const doctoresContainer = document.getElementById('doctores-container');
            const cerrarModalDoctores = document.getElementById('cerrar-modal-doctores');
            const especialidadSelect = document.getElementById('especialidad');
            const nombreInput = document.getElementById('nombre');

            const meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
            const diasSemana = ['L','M','M','J','V','S','D'];
            const year = new Date().getFullYear();

            // Doctores y horarios por especialidad
            const doctores = {
                medicina: {
                    'Dr. Juan Pérez': ['08:00 AM', '09:00 AM', '10:00 AM'],
                    'Dr. Luis Gómez': ['01:00 PM', '02:00 PM', '03:00 PM'],
                    'Dra. Marta Díaz': ['09:30 AM', '11:00 AM', '12:00 PM']
                },
                pediatria: {
                    'Dra. Ana Rodríguez': ['09:00 AM', '10:00 AM', '11:00 AM'],
                    'Dr. Jorge Salinas': ['01:30 PM', '02:30 PM', '03:30 PM']
                },
                dermatologia: {
                    'Dr. Carlos López': ['08:30 AM', '09:30 AM', '11:00 AM'],
                    'Dra. Elena Martínez': ['01:00 PM', '02:00 PM', '03:00 PM']
                }
            };

            let citasPaciente = JSON.parse(localStorage.getItem('citas')) || [];

            // --- Generar calendario ---
            meses.forEach((mes, index) => {
                const monthDiv = document.createElement('div');
                monthDiv.classList.add('month');
                const header = document.createElement('div');
                header.classList.add('month-header');
                header.textContent = mes + ' ' + year;
                monthDiv.appendChild(header);

                const daysDiv = document.createElement('div');
                daysDiv.classList.add('days');

                diasSemana.forEach(d => {
                    const diaHeader = document.createElement('div');
                    diaHeader.style.fontWeight = 'bold';
                    diaHeader.style.color = '#666';
                    diaHeader.textContent = d;
                    daysDiv.appendChild(diaHeader);
                });

                const firstDay = new Date(year, index, 1).getDay();
                const daysInMonth = new Date(year, index + 1, 0).getDate();
                for (let i = 0; i < (firstDay === 0 ? 6 : firstDay - 1); i++) {
                    daysDiv.appendChild(document.createElement('div'));
                }

                for (let day = 1; day <= daysInMonth; day++) {
                    const dayDiv = document.createElement('div');
                    dayDiv.classList.add('day');
                    dayDiv.textContent = day;

                    const fecha = `${year}-${String(index + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                    dayDiv.dataset.fecha = fecha;

                    dayDiv.addEventListener('click', () => {
                        const esp = especialidadSelect.value;
                        const nombrePaciente = nombreInput.value.trim();
                        if (!esp) {
                            alert('Seleccione una especialidad primero.');
                            return;
                        }
                        if (!nombrePaciente) {
                            alert('Ingrese el nombre del paciente.');
                            return;
                        }
                        abrirModalDoctores(esp, fecha, nombrePaciente);
                    });

                    daysDiv.appendChild(dayDiv);
                }

                monthDiv.appendChild(daysDiv);
                yearCalendar.appendChild(monthDiv);
            });

            // --- Modal doctores con horarios ---
            function abrirModalDoctores(especialidad, fecha, nombrePaciente) {
                modalDoctores.style.display = 'flex';
                tituloDoctores.textContent = `Doctores disponibles - ${FormatoEspecialidad(especialidad)} (${FormatoFecha(fecha)})`;
                doctoresContainer.innerHTML = '';

                const listaDoctores = doctores[especialidad];
                Object.keys(listaDoctores).forEach(nombre => {
                    const card = document.createElement('div');
                    card.classList.add('doctor-card');
                    card.innerHTML = `<div class="doctor-nombre">${nombre}</div>`;

                    const horasDiv = document.createElement('div');
                    horasDiv.classList.add('horas');

                    listaDoctores[nombre].forEach(hora => {
                        const div = document.createElement('div');
                        div.textContent = hora;
                        div.classList.add('hora');

                        const ocupada = citasPaciente.some(
                            c => c.especialidad === especialidad && c.doctor === nombre && c.hora === hora && c.fecha === fecha
                        );

                        if (ocupada) {
                            div.classList.add('ocupada');
                        } else {
                            div.classList.add('disponible');
                            div.addEventListener('click', () => {
                                const nuevaCita = {
                                    nombre: nombrePaciente,
                                    especialidad,
                                    doctor: nombre,
                                    fecha,
                                    hora,
                                    estado: 'Pendiente'
                                };
                                citasPaciente.push(nuevaCita);
                                localStorage.setItem('citas', JSON.stringify(citasPaciente));
                                alert(`Cita agendada para ${nombrePaciente} con ${nombre} el ${FormatoFecha(fecha)} a las ${hora}`);
                                modalDoctores.style.display = 'none';
                            });
                        }

                        horasDiv.appendChild(div);
                    });

                    card.appendChild(horasDiv);
                    doctoresContainer.appendChild(card);
                });
            }

            function FormatoFecha(fecha) {
                const [y, m, d] = fecha.split('-');
                return `${d}/${m}/${y}`;
            }

            function FormatoEspecialidad(esp) {
                return esp.charAt(0).toUpperCase() + esp.slice(1);
            }

            cerrarModalDoctores.addEventListener('click', () => modalDoctores.style.display = 'none');
        });
    </script>
@endsection
