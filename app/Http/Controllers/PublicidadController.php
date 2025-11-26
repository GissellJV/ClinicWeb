<?php

namespace App\Http\Controllers;

use App\Models\Publicidad;
use Illuminate\Http\Request;

class PublicidadController extends Controller
{
    public function index()
    {
        return view('recepcionista.publicidad');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'subtitulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
        ]);

        Publicidad::create([
            'titulo' => $request->titulo,
            'subtitulo' => $request->subtitulo,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->back()->with('success', 'Publicidad guardada correctamente');
    }
}
