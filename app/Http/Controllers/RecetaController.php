<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RecetaController extends Controller
{
    public function recetamedica()
    {
        if (!session('cargo') || session('cargo') != 'Doctor') {
            return redirect()->route('empleados.loginempleado')
                ->with('error', 'Debes iniciar sesión como Doctor');
        }

        return view('empleados.recetamedica');
    }

    // Genera y descarga el PDF
    public function generarPDF(Request $request)
    {
        $request->validate([
            'nombre_paciente' => 'required|string|max:255',
            'medicamento' => 'required|string|max:255',
            'dosis' => 'required|string|max:255',
            'duracion' => 'required|string|max:255',
            'observaciones' => 'nullable|string',
        ],[
            'nombre_paciente.required' => 'El nombre es obligatorio',
            'medicamento.required' => 'El medicamento es obligatorio',
            'dosis.required' => 'La dosis es obligatoria',
            'duracion.required' => 'La duracion es obligatoria',
        ]);

        $data = [
            'nombre_paciente' => $request->nombre_paciente,
            'medicamento' => $request->medicamento,
            'dosis' => $request->dosis,
            'duracion' => $request->duracion,
            'observaciones' => $request->observaciones,
            'fecha' => now()->format('d/m/Y'),
        ];

        $pdf = Pdf::loadView('empleados.receta_pdf', $data);

        return $pdf->download('receta_medica_'.$data['nombre_paciente'].'.pdf');
    }

}
