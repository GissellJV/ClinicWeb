@extends('layouts.plantilla')

@section('contenido')
    <div class=" d-flex justify-content-center align-items-center vh-100">
        <div class="bg-white p-5 rounded-4 shadow " style="width: 40rem; border-top: 4px solid rgba(0,188,212,0.78);">
                <h2 class="mb-4 text-center">Receta Médica</h2>

                <form method=" " action="">
                    @csrf

                    <div class="mb-3">
                        <label for="paciente_id" class="form-label">Paciente</label>
                        <input type="text" name="paciente" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Medicamento</label>
                        <input type="text" name="medicamento" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Dosis</label>
                        <input type="text" name="dosis" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Duración del tratamiento</label>
                        <input type="text" name="duracion" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Observaciones</label>
                        <textarea name="observaciones" class="form-control"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Generar Receta </button>
                </form>

        </div>
    </div>

@endsection
