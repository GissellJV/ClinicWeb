@extends('layouts.plantilla')
@section('contenido')
    <h1 class="text-center mb-4">Pacientes con Citas Programadas</h1>

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-primary">
        <tr>
            <th>Nombre</th>
            <th>Hora</th>
            <th>Motivo</th>
            <th>Estado</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>María López</td>
            <td>09:30 AM</td>
            <td>Chequeo general</td>
            <td><span class="badge bg-warning text-dark">Pendiente</span></td>
        </tr>
        <tr>
            <td>Carlos Martínez</td>
            <td>10:15 AM</td>
            <td>Dolor de cabeza</td>
            <td><span class="badge bg-info text-dark">En atención</span></td>
        </tr>
        <tr>
            <td>Lucía Fernández</td>
            <td>11:00 AM</td>
            <td>Control de presión</td>
            <td><span class="badge bg-success">Finalizada</span></td>
        </tr>
        </tbody>
    </table>
@endsection
