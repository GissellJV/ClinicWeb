<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{

    use HasFactory;
   protected $table = 'inventario_medicamentos';

    protected $fillable = [
        'codigo',
        'nombre',
        'cantidad',
        'estado',
        'fecha_vencimiento',
    ];
    // Relación inversa con Paciente
    public function pacientes()
    {
        return $this->belongsToMany(
            Paciente::class,
            'aplicacion_medicamento',
            'inventario_id',
            'paciente_id'
        )
            ->withPivot('cantidad', 'habitacion_id', 'fecha_aplicacion', 'observaciones')
            ->withTimestamps();
    }
    public function cotizacionDetalles()
    {
        return $this->hasMany(CotizacionDetalle::class,
            'inventario_medicamento_id');
    }
}
