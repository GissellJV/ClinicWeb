<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EspecialidadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'icono' => 'required|image'
        ]);

        // Guardar el ícono
        $rutaIcono = $request->file('icono')->store('iconos', 'public');

        Especialidad::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'icono' => $rutaIcono
        ]);

        return redirect()->back()->with('success', 'Especialidad agregada correctamente.');
    }

    public function destroy($id)
    {
        $especialidad = Especialidad::findOrFail($id);

        // WNoUsadas icono si existe
        if ($especialidad->icono && Storage::exists('public/' . $especialidad->icono)) {
            Storage::delete('public/' . $especialidad->icono);
        }

        $especialidad->delete();

        return back()->with('success', 'Especialidad eliminada correctamente.');
    }

}
