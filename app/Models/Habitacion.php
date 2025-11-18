<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    protected $table = 'habitaciones';

    protected $fillable = [
        'numero_habitacion',
        'tipo',
        'estado',
        'descripcion'
    ];

    // Relación con asignaciones
    public function asignaciones()
    {
        return $this->hasMany(AsignacionHabitacion::class);
    }

    // Obtener asignación activa
    public function asignacionActiva()
    {
        return $this->hasOne(AsignacionHabitacion::class)
            ->where('estado', 'activo')
            ->latest();
    }

    // Verificar si está disponible
    public function estaDisponible()
    {
        return $this->estado === 'disponible' && !$this->asignacionActiva;
    }
}
