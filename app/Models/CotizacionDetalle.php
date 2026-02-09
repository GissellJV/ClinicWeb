<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CotizacionDetalle extends Model
{
    public function medicamento()
    {
        return $this->belongsTo(InventarioMedicamento::class, 'inventario_medicamento_id');
    }

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }

}
