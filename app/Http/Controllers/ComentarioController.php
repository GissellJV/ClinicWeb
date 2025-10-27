<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Comentario;

class ComentarioController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string|max:255',
            'comentario' => 'required|string',
        ]);

        Comentario::create($request->only('usuario', 'comentario'));

        return back()->with('success', 'Comentario agregado correctamente.');
    }
    public function index()
    {
        $comentarios = Comentario::latest()->get();
        return view('pacientes.contactanos', compact('comentarios'));
    }

}
