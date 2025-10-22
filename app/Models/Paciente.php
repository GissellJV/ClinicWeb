<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    //use HasFactory;
    protected $table = 'pacientes';
    protected $fillable=[
        'nombres',
        'apellidos',
        'fecha_nacimiento',
        'numero_identidad',
        'genero',
        'telefono',
        'contraseña'
    ];

    protected $hidden = [
        'contraseña'
    ];
}
