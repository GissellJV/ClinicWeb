<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidenteRuta extends Model
{
    use HasFactory;

    protected $table = 'incidente_rutas';

    protected $fillable = [
        'traslado_id',
        'tipo_incidente',
        'minutos_retraso',
        'nota_descriptiva',
        'estado_incidente'
    ];

    public function traslado() {
        return $this->belongsTo(Traslado::class, 'traslado_id');
    }
}
