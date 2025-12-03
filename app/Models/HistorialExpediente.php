<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialExpediente extends Model
{
    protected $fillable = [
        'expediente_id',
        'fecha',
        'peso',
        'altura',
        'temperatura',
        'presion_arterial',
        'frecuencia_cardiaca',
        'tiene_fiebre',
        'sintomas_actuales',
        'alergias',
        'antecedentes_familiares',
        'antecedentes_personales',
        'medicamentos_actuales',
        'observaciones',
    ];
    public function expediente()
    {
        return $this->belongsTo(Expediente::class);
    }

}
