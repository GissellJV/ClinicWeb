<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Comentario;

class ComentarioController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comentario' => 'required|string|max:1000',
        ], [
            'comentario.required' => 'Escribe un comentario antes de enviar.'
        ]);

        // Solo pacientes pueden comentar
        if (session('tipo_usuario') !== 'paciente') {
            if ($request->ajax()) {
                return response()->json(['error' => 'Debes iniciar sesión como paciente para comentar.'], 401);
            }
            return back()->with('error', 'Debes iniciar sesión como paciente para comentar.');
        }

        $usuario = session('paciente_nombre') ?? 'Paciente';

        // Crear comentario
        $comentario = Comentario::create([
            'usuario' => $usuario,
            'comentario' => $request->comentario,
        ]);

        // Tiempo humano
        $comentario->tiempo = $comentario->created_at->diffForHumans();

        // Si es AJAX, devuelve JSON
        if ($request->ajax()) {
            return response()->json($comentario);
        }

        // Si no es AJAX, redirige normalmente
        return back()->with('success', 'Comentario agregado correctamente.');
    }

}
