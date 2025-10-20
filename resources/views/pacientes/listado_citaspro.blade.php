@extends('layouts.plantilla')
@section('contenido')
    <br><br><br><br><br>
    <h1 class="text-center mb-4">Pacientes con Citas Programadas</h1>

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-primary">
        <tr>
            <th>Paciente</th>
            <th>Doctor</th>
            <th>Hora</th>
            <th>Especialidad</th>
            <th>Estado</th>
        </tr>
        </thead>
        <tbody>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const citas = JSON.parse(localStorage.getItem('citas')) || [];
                const tbody = document.querySelector('tbody');

                tbody.innerHTML = '';

                if (citas.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="5" class="text-center">No hay citas registradas</td></tr>`;
                } else {
                    citas.forEach(cita => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${cita.nombre}</td>
                            <td>${cita.doctor}</td>
                            <td>${cita.hora}</td>
                            <td>${cita.especialidad.charAt(0).toUpperCase() + cita.especialidad.slice(1)}</td>
                            <td><span class="badge bg-warning text-dark">${cita.estado}</span></td>
                        `;
                        tbody.appendChild(tr);
                    });
                }
            });
        </script>
        </tbody>
    </table>

    <br><br>
    <a href="{{'/'}}">
        <button type="reset" class="btn btn-primary">Clinic Web</button>
    </a>
@endsection
