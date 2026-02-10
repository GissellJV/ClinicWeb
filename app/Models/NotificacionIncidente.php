<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificacionIncidente extends Model
{
    protected $table = 'notificaciones_incidentes';

    protected $fillable = [
        'incidente_id',
        'empleado_id',
        'leido',
        'fecha_envio'
    ];

    protected $casts = [
        'leido' => 'boolean',
        'fecha_envio' => 'datetime'
    ];

    // Relación con Incidente
    public function incidente()
    {
        return $this->belongsTo(Incidente::class, 'incidente_id');
    }

    // Relación con Empleado (Recepcionista)
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }
}
