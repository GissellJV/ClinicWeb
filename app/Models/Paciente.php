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
        'password'
    ];

    protected $hidden = [
        'password'
    ];

    public function asignacionesHabitacion()
    {
        return $this->hasMany(AsignacionHabitacion::class);
    }

    public function expediente()
    {
        return $this->hasOne(Expediente::class);
    }
    // Relación muchos a muchos con inventario (medicamentos)
    public function medicamentos()
    {
        return $this->belongsToMany(
            Inventario::class,
            'aplicacion_medicamento',
            'paciente_id',
            'inventario_id'
        )
            ->withPivot('cantidad', 'habitacion_id', 'fecha_aplicacion', 'observaciones')
            ->withTimestamps();
    }
    public function citas()
    {
        return $this->hasMany(Cita::class, 'paciente_id');
    }



}

