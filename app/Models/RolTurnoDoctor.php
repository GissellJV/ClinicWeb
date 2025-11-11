<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolTurnoDoctor extends Model
{
    protected $table = 'rolturnosdoctores';

    protected $fillable = [
        'fecha',
        'hora_turno',
        'empleado_id',
        'cita_id',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }

    public function cita()
    {
        return $this->belongsTo(Cita::class, 'cita_id');
    }
}
