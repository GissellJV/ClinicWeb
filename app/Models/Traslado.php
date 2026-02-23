<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Traslado extends Model
{
    // Definimos la tabla que creamos en la migración
    protected $table = 'traslados';

    // Habilitamos los campos para poder guardar la información de la H80
    protected $fillable = [
        'paciente_id',
        'direccion_destino',
        'fecha_traslado',
        'unidad_asignada',
        'costo_estimado',
        'estado'
    ];

    /**
     * Relación con el Paciente
     * Un traslado pertenece a un paciente único.
     */
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }
}
