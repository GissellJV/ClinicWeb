<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolTurnoDoctor extends Model
{
    protected $table = 'rolturnosdoctores';

    protected $fillable = [
        'fecha',
        'empleado_id',
        'codigo_turno',
        'nota',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }
}
