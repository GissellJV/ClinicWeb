<?php

namespace App\Http\Controllers;

use App\Models\PreguntaFrecuente;
use Illuminate\Http\Request;

class PreguntaController extends Controller
{
    public function index()
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        $preguntas = PreguntaFrecuente::ordenadas()->get();

        return view('recepcionista.Gestion_Preguntas.gestion_preguntas', compact('preguntas'));
    }

    public function create()
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        return view('recepcionista.Gestion_Preguntas.create');
    }

    public function store(Request $request)
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        $request->validate([
            'pregunta' => 'required|string|max:500',
            'respuesta' => 'required|string|max:2000',
        ], [
            'pregunta.required' => 'La pregunta es obligatoria',
            'pregunta.max' => 'La pregunta no puede tener más de 500 caracteres',
            'respuesta.required' => 'La respuesta es obligatoria',
            'respuesta.max' => 'La respuesta no puede tener más de 2000 caracteres',
        ]);

        $ultimoOrden = PreguntaFrecuente::max('orden') ?? 0;

        PreguntaFrecuente::create([
            'pregunta' => $request->pregunta,
            'respuesta' => $request->respuesta,
            'orden' => $ultimoOrden + 1,
            'activo' => true,
        ]);

        return redirect()->route('preguntas.index')
            ->with('success', 'Pregunta frecuente agregada correctamente');
    }

    public function edit($id)
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        $pregunta = PreguntaFrecuente::findOrFail($id);

        return view('recepcionista.Gestion_Preguntas.create', compact('pregunta'));
    }

    public function update(Request $request, $id)
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        $request->validate([
            'pregunta' => 'required|string|max:500',
            'respuesta' => 'required|string|max:2000',
        ], [
            'pregunta.required' => 'La pregunta es obligatoria',
            'pregunta.max' => 'La pregunta no puede tener más de 500 caracteres',
            'respuesta.required' => 'La respuesta es obligatoria',
            'respuesta.max' => 'La respuesta no puede tener más de 2000 caracteres',
        ]);

        $pregunta = PreguntaFrecuente::findOrFail($id);

        $pregunta->update([
            'pregunta' => $request->pregunta,
            'respuesta' => $request->respuesta,
        ]);

        return redirect()->route('preguntas.index')
            ->with('success', 'Pregunta actualizada correctamente');
    }

    public function destroy($id)
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        $pregunta = PreguntaFrecuente::findOrFail($id);
        $pregunta->delete();

        return redirect()->route('preguntas.index')
            ->with('success', 'Pregunta frecuente eliminada correctamente');
    }

    public function updateOrden(Request $request)
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $ordenIds = $request->input('orden', []);

        foreach ($ordenIds as $index => $id) {
            PreguntaFrecuente::where('id', $id)->update(['orden' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }


    public function publico()
    {
        $preguntas = PreguntaFrecuente::activas()->get();

        return view('pacientes.preguntas_frecuentes', compact('preguntas'));
    }
}
