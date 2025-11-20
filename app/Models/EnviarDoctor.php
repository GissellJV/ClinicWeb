<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnviarDoctor extends Model
{
    protected $table = 'enviardoctores';

    protected $fillable = [
        'paciente_id',
        'empleado_id',
        'especialidad',
        'estado'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }
}

