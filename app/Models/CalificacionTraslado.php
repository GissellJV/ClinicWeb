<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalificacionTraslado extends Model
{
    protected $table = 'calificaciones_traslados';

    protected $fillable = [
        'traslado_id',
        'puntuacion',
        'comentario'
    ];

    public function traslado()
    {
        return $this->belongsTo(Traslado::class, 'traslado_id');
    }
}
