<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialDiario extends Model
{
    protected $table = 'historiales_diarios';

    protected $fillable = [
        'nombre_paciente',
        'doctor',
        'fecha'
    ];



}
