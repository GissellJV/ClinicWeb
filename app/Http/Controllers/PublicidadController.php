<?php

namespace App\Http\Controllers;

use App\Models\Publicidad;
use Illuminate\Http\Request;

class PublicidadController extends Controller
{
    public function index()
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

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
    public function edit($id)
    {
        $publicidad = Publicidad::findOrFail($id);

        return view('recepcionista.publicidad', compact('publicidad'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required',
            'subtitulo' => 'required',
            'descripcion' => 'required',
        ]);

        $publicidad = Publicidad::findOrFail($id);
        $publicidad->update($request->all());

        return redirect('/#promos')
            ->with('success', 'Publicidad actualizada correctamente');

    }
    public function destroy($id)
    {
        $pub = Publicidad::findOrFail($id);
        $pub->delete();

        return redirect()->back()->with('success', 'Promoción eliminada');
    }


}
