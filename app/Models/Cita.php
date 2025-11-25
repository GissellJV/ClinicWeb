<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

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

    // Reglas de validación
    public static function rules($id = null)
    {
        return [
            'fecha' => [
                'required',
                'date',
                'after_or_equal:today'
            ],
            'hora' => 'required',
            'paciente_id' => 'required|exists:pacientes,id',
            'empleado_id' => 'required|exists:empleados,id',
            'especialidad' => 'required|string|max:255',
        ];
    }

    // Validar si la fecha es válida
    public function isFechaValida()
    {
        return $this->fecha >= now()->startOfDay();
    }

    public function doctor()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }
}
