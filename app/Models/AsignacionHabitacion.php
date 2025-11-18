<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsignacionHabitacion extends Model
{
    protected $table = 'asignaciones_habitaciones';

    protected $fillable = [
        'paciente_id',
        'habitacion_id',
        'fecha_asignacion',
        'fecha_salida',
        'estado',
        'observaciones'
    ];

    protected $casts = [
        'fecha_asignacion' => 'datetime',
        'fecha_salida' => 'datetime'
    ];

    // Relaciones
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class);
    }
}
