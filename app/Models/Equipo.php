<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    // Indicamos la tabla que creamos en la migración
    protected $table = 'inventarios';

    // Definimos los campos que se pueden llenar (Mass Assignment)
    protected $fillable = [
        'identificador_unico',
        'nombre_equipo',
        'estado',
        'stock_actual'
    ];
}
