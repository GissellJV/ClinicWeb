<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publicidad extends Model
{
    protected $table = 'publicidades';

    protected $fillable = [
        'titulo',
        'subtitulo',
        'descripcion',
    ];
}
