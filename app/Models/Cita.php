<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
        'paciente_nombre',
        'empleado_id',
        'doctor_nombre',
        'especialidad',
        'fecha',
        'hora',
        'estado',
        'mensaje',
        'motivo'
    ];

    protected $casts = [
        'fecha' => 'date'
    ];

    public function doctor()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }
}
