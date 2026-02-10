<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incidente extends Model
{
    protected $fillable = [
        'descripcion',
        'fecha_hora_incidente',
        'paciente_id',
        'empleado_id',
        'empleado_nombre',
        'tipo_incidente',
        'gravedad',
        'acciones_tomadas',
        'estado'
    ];

    protected $casts = [
        'fecha_hora_incidente' => 'datetime',
    ];

    // Relación con Paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    // Relación con Empleado (Enfermero)
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }
    // Relación con Notificaciones
    public function notificaciones()
    {
        return $this->hasMany(NotificacionIncidente::class, 'incidente_id');
    }
}
