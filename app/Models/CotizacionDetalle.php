<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionDetalle extends Model
{
    use HasFactory;

    protected $fillable = [
        'cotizacion_id',
        'inventario_medicamento_id',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];
    public function inventario()
    {
        return $this->belongsTo(Inventario::class, 'inventario_medicamento_id');
    }

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }

}
