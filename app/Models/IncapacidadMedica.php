<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncapacidadMedica extends Model
{
    protected $table = 'emitir_incapacidad';

    protected $fillable = [
        'paciente_id',
        'empleado_id',
        'fecha_inicio',
        'fecha_fin',
        'cantidad_dias',
        'motivo',
        'observaciones',
    ];

    protected $casts = [
        'fecha_inicio'  => 'date',
        'fecha_fin'     => 'date',
        'cantidad_dias' => 'integer',
    ];


    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }


    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }
}
