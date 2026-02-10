<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;
    protected $table = 'cotizaciones';
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function detalles()
    {
        return $this->hasMany(CotizacionDetalle::class);
    }

}
