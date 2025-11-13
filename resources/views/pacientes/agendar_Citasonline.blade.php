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
        .controls input { margin-bottom: 10px; }

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
        .month:hover { transform: scale(1.03); }
        .month-header {
            background: rgb(68, 160, 141);
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
        .day:hover { background: #e8f1ff; }

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
        .btn-citas {
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

        .form-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .text-info-emphasis{
            font-weight: bold;
        }
    </style>

    <div class="calendar-wrapper">
        <br>
        <h1 class="text-center text-info-emphasis">Agenda de Citas Médicas</h1>

        <br>
        <div id="alert-container" class="container mt-3" style="max-width: 700px;"></div>

        <br>
        <div class="calendar-container">
            <div class="controls">
                <label class="form-label">Nombre del Paciente:</label>
                <label id="nombre" style="padding:12px; width: 300px; border-radius:10px; border:1px solid #999; font-size:16px;">
                    {{ session('paciente_nombre') }}
                </label>

                <br><br>

                <label for="especialidad" class="form-label" >Especialidad:</label>
                <select id="especialidad">
                    <option value="">Seleccione una especialidad</option>
                    <option value="medicina">Medicina General</option>
                    <option value="pediatria">Pediatría</option>
                    <option value="dermatologia">Dermatología</option>
                </select>

                <br><br><br><br><br><br><br><br>

                <a href="{{ route('citas.mis-citas') }}" class="btn btn-citas" >
                    Mis Citas
                </a>
            </div>

            <div class="year-calendar" id="year-calendar"></div>
        </div>

        <!-- Modal -->
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
            const nombreLabel = document.getElementById('nombre');
            const alertContainer = document.getElementById('alert-container');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            const meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
            const diasSemana = ['L','M','M','J','V','S','D'];
            const year = new Date().getFullYear();

            const doctores = {
                medicina: {

                    'Dr. Juan Pérez': ['08:00 AM','09:00 AM','10:00 AM'],
                    'Dr. Luis Gómez': ['01:00 PM','02:00 PM','03:00 PM']
                },
                pediatria: {
                    'Dra. Ana Rodríguez': ['09:00 AM','10:00 AM','11:00 AM'],
                    'Dr. Jorge Salinas': ['01:30 PM','02:30 PM','03:30 PM']
                },
                dermatologia: {
                    'Dr. Carlos López': ['08:30 AM','09:30 AM','11:00 AM'],
                    'Dra. Elena Martínez': ['01:00 PM','02:00 PM','03:00 PM']
                }
            };

            // Función para mostrar alertas Bootstrap
            function mostrarAlerta(tipo, mensaje) {
                const alert = document.createElement('div');
                alert.className = `alert alert-${tipo} alert-dismissible fade show mt-2`;
                alert.role = 'alert';
                alert.innerHTML = `
            ${mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
                alertContainer.appendChild(alert);

                setTimeout(() => {
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                    setTimeout(() => alert.remove(), 300);
                }, 4000);
            }

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
                    diaHeader.style.fontWeight='bold';
                    diaHeader.style.color='#666';
                    diaHeader.textContent=d;
                    daysDiv.appendChild(diaHeader);
                });

                const firstDay = new Date(year, index, 1).getDay();
                const daysInMonth = new Date(year, index + 1, 0).getDate();
                for (let i=0;i<(firstDay===0?6:firstDay-1);i++){daysDiv.appendChild(document.createElement('div'));}
                for (let day=1;day<=daysInMonth;day++){
                    const dayDiv=document.createElement('div');
                    dayDiv.classList.add('day');
                    dayDiv.textContent=day;
                    const fecha=`${year}-${String(index+1).padStart(2,'0')}-${String(day).padStart(2,'0')}`;
                    dayDiv.dataset.fecha=fecha;
                    dayDiv.addEventListener('click', ()=>{
                        const esp=especialidadSelect.value;
                        const nombrePaciente=nombreLabel.textContent.trim();
                        if(!esp){mostrarAlerta('warning','Seleccione una especialidad primero.');return;}
                        if(!nombrePaciente){mostrarAlerta('danger','No se encontró el nombre del paciente.');return;}
                        abrirModalDoctores(esp,fecha,nombrePaciente);
                    });
                    daysDiv.appendChild(dayDiv);
                }
                monthDiv.appendChild(daysDiv);
                yearCalendar.appendChild(monthDiv);
            });

            // --- Modal de doctores ---
            function abrirModalDoctores(especialidad,fecha,nombrePaciente){
                modalDoctores.style.display='flex';
                tituloDoctores.textContent=`Doctores disponibles - ${especialidad.charAt(0).toUpperCase()+especialidad.slice(1)} (${FormatoFecha(fecha)})`;
                doctoresContainer.innerHTML='';

                Object.keys(doctores[especialidad]).forEach(nombre=>{
                    const card=document.createElement('div');
                    card.classList.add('doctor-card');
                    card.innerHTML=`<div class="doctor-nombre">${nombre}</div>`;

                    const horasDiv=document.createElement('div');
                    horasDiv.classList.add('horas');

                    doctores[especialidad][nombre].forEach(hora=>{
                        const div=document.createElement('div');
                        div.textContent=hora;
                        div.classList.add('hora','disponible');

                        div.addEventListener('click', async ()=>{
                            const response = await fetch("{{ route('citas.guardar') }}", {
                                method:"POST",
                                headers:{
                                    "Content-Type":"application/json",
                                    "X-CSRF-TOKEN":csrfToken
                                },
                                body:JSON.stringify({
                                    fecha,
                                    hora,
                                    doctor:nombre,
                                    especialidad
                                })
                            });

                            const data = await response.json();
                            if (data.success) {
                                mostrarAlerta('success', 'Tu cita ha sido agendada exitosamente.');
                                modalDoctores.style.display = 'none';
                            } else {
                                mostrarAlerta('danger', 'Error: ' + data.message);
                            }

                        });

                        horasDiv.appendChild(div);
                    });

                    card.appendChild(horasDiv);
                    doctoresContainer.appendChild(card);
                });
            }

            function FormatoFecha(fecha){
                const [y,m,d]=fecha.split('-');
                return `${d}/${m}/${y}`;
            }

            cerrarModalDoctores.addEventListener('click',()=>modalDoctores.style.display='none');
        });
    </script>
@endsection
