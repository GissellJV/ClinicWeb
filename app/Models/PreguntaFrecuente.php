<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreguntaFrecuente extends Model
{
    //
    protected $table = 'preguntas_frecuentes';

    protected $fillable = [
        'pregunta',
        'respuesta',
        'orden',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Scope para obtener preguntas activas ordenadas
     */
    public function scopeActivas($query)
    {
        return $query->where('activo', true)->orderBy('orden', 'asc');
    }

    /**
     * Scope para obtener todas las preguntas ordenadas
     */
    public function scopeOrdenadas($query)
    {
        return $query->orderBy('orden', 'asc');
    }
}
