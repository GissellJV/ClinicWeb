<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;


class PacienteCotizacionController extends Controller
{
    public function cotizar(Request $request)
    {
        // Consulta base
        $query = Inventario::where('cantidad', '>', 0)
            ->orderBy('nombre');

        // Si hay búsqueda
        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%');
        }

        // Paginación de 10 en 10
        $medicamentos = $query->paginate(10);

        return view('pacientes.cotizar', compact('medicamentos'));
    }

// Método AJAX para búsqueda en tiempo real
    public function buscarMedicamentos(Request $request)
    {
        $query = $request->input('q', '');

        $medicamentos = Inventario::where('cantidad', '>', 0)
            ->where('nombre', 'like', "%{$query}%")
            ->orderBy('nombre')
            ->take(10) // máximo 10 resultados en autocompletado
            ->get();

        if($medicamentos->isEmpty()){
            return response()->json([
                'html' => '<div class="alert alert-warning">No se encontraron medicamentos disponibles</div>'
            ]);
        }

        $html = '<table class="table table-striped bg-white">
                <thead>
                    <tr>
                        <th>Medicamento</th>
                        <th>Disponible</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>';

        foreach($medicamentos as $med){
            $html .= '<tr>
                    <td>'.$med->nombre.'</td>
                    <td>'.$med->cantidad.'</td>
                    <td class="precio">'.number_format($med->precio_unitario,2).'</td>
                    <td><input type="number" class="form-control cantidad" min="1" max="'.$med->cantidad.'" value="1"></td>
                    <td class="total">L. '.number_format($med->precio_unitario,2).'</td>
                  </tr>';
        }

        $html .= '</tbody></table>';

        return response()->json(['html' => $html]);
    }





}
