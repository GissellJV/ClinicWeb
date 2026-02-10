<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expediente extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
        'numero_expediente',
        'peso',
        'altura',
        'temperatura',
        'presion_arterial',
        'frecuencia_cardiaca',
        'tiene_fiebre',
        'sintomas_actuales',
        'diagnostico',
        'tratamiento',
        'alergias',
        'medicamentos_actuales',
        'antecedentes_familiares',
        'antecedentes_personales',
        'observaciones',
        'estado'
    ];
    public function historiales()
    {
        return $this->hasMany(HistorialExpediente::class);
    }



    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
    public static function generarNumeroExpediente()
    {
        $ultimo = self::orderBy('id', 'desc')->first();
        $numero = $ultimo ? intval(substr($ultimo->numero_expediente, 3)) + 1 : 1;
        return 'EXP' . str_pad($numero, 6, '0', STR_PAD_LEFT);
    }
}
