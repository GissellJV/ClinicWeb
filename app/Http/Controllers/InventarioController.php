<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index()
    {
        if (!session('cargo') || session('cargo') != 'Enfermero') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Enfermera');
        }
        $inventarios = Inventario::all();
        return view('inventario.principal')->with('inventarios', $inventarios);
    }

    public function create()
    {
       return view('inventario.registrar');
    }

    public function store(Request $request)
    {


        request()->validate([
            'codigo' => 'required|string|max:6|unique:inventario_medicamentos,codigo',
            'nombre' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:0',
            'fecha_vencimiento' => 'required|date|after:today',
        ],
            [
                'codigo.unique' => 'El codigo ya  esta en existencia',
                'codigo.required' => 'El codigo es obligatorio',
                'nombre.required' => 'El nombre del medicamento es obligatorio',
                'cantidad.required' => 'La cantidad es obligatoria',
                'fecha_vencimiento.required' => 'La fecha de vencimiento es obligatoria',
                'fecha_vencimiento.after' => 'La fecha de vencimiento debe ser una fecha futura.',


            ]);

        $nuevo_medicamento = new Inventario();
        $nuevo_medicamento->codigo = $request->input('codigo');
        $nuevo_medicamento->nombre = $request->input('nombre');
        $nuevo_medicamento->cantidad = $request->input('cantidad');
        $nuevo_medicamento->fecha_vencimiento = $request->input('fecha_vencimiento');

        $cantidad = $request->input('cantidad');
        if ($cantidad < 10) {
            $nuevo_medicamento->estado = 'Crítico';
        } elseif ($cantidad >= 10 && $cantidad <= 50) {
            $nuevo_medicamento->estado = 'Bajo';
        } else {
            $nuevo_medicamento->estado = 'Normal';
        }

        if ($nuevo_medicamento->save()) {
            return redirect('/inventario')->with('success', 'Medicamento registrado con exito');
        }

    }
    public function edit($id)
    {
        $inventario = Inventario::findOrFail($id);
        return view('inventario.registrar')->with('inventario', $inventario);
    }

    public function update(Request $request, $id)
    {


        request()->validate([
            'codigo'=> "required|string|max:255|unique:inventario_medicamentos,codigo,$id",
            'nombre'=> 'required|string|max:255',
            'cantidad'=> 'required|integer|min:0',
            'fecha_vencimiento' => 'required|date|after:today',
        ],
        [
            'codigo.unique' => 'El codigo ya  esta en existencia',
            'codigo.required' => 'El codigo es obligatorio',
            'nombre.required' => 'El nombre del medicamento es obligatorio',
            'cantidad.required' => 'La cantidad es obligatoria',
            'fecha_vencimiento.required' => 'La fecha vencimiento es obligatoria',
            'fecha_vencimiento.after' => 'La fecha de vencimiento debe ser una fecha futura',


        ]);

        $medicamento = Inventario::findOrFail($id);

        $medicamento->codigo = $request->input('codigo');
        $medicamento->nombre = $request->input('nombre');
        $medicamento->cantidad = $request->input('cantidad');
        $medicamento->fecha_vencimiento = $request->input('fecha_vencimiento');

        $cantidad = $request->input('cantidad');
        if ($cantidad < 10) {
            $medicamento->estado = 'Crítico';
        } elseif ($cantidad >= 10 && $cantidad <= 50) {
            $medicamento->estado = 'Bajo';
        } else {
            $medicamento->estado = 'Normal';
        }

        if ($medicamento->save()) {
            return redirect('/inventario')->with('success', 'Medicamento actualizado con exito');
        }

        else{
            //
        }

    }

    public function destroy($id)
    {
        $medicamento = Inventario::findOrFail($id);
        $medicamento->delete();

        return redirect()->route('inventario.principal')->with('success', 'Medicamento eliminado con exito.');
    }
}
