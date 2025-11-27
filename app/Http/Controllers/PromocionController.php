<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promocion;

class PromocionController extends Controller
{
    // Mostrar vista promociones
    public function promociones()
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        $promociones = Promocion::all();
        return view('recepcionista.promociones', compact('promociones'));
    }

    // Guardar promoción
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|max:2048',
        ]);

        $promocion = new Promocion();
        $promocion->titulo = $request->titulo;
        $promocion->descripcion = $request->descripcion;

        if ($request->hasFile('imagen')) {
            $promocion->imagen = file_get_contents($request->file('imagen')->getRealPath());
        }

        $promocion->save();

        return redirect()->route('promociones')->with('success', 'Promoción creada correctamente');
    }

    public function mostrarImagen($id)
    {
        $promocion = Promocion::findOrFail($id);

        if ($promocion->imagen) {
            return response($promocion->imagen)
                ->header('Content-Type', 'image/jpeg');
        }

        return response(null, 404);
    }

}
