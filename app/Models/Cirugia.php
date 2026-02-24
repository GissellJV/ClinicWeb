<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cirugia extends Model
{
    use HasFactory;

    protected $table = 'cirugias';

    protected $fillable = [
        'evaluacion_id',
        'paciente_id',
        'empleado_id',
        'tipo_cirugia',
        'quirofano',
        'fecha_cirugia',
        'hora_inicio',
        'hora_fin',
        'duracion_estimada_min',
        'anestesiologo',
        'instrumentos_requeridos',
        'notas_adicionales',
        'estado',
    ];

    protected $casts = [
        'fecha_cirugia' => 'date',
    ];

    public function evaluacion()
    {
        return $this->belongsTo(EvaluacionPrequirurgica::class, 'evaluacion_id');
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }

    // Reglas de validación
    public static function rules(): array
    {
        return [
            'evaluacion_id'         => 'required|exists:evaluaciones_prequirurgicas,id',
            'quirofano'             => 'required|string|max:100',
            'fecha_cirugia'         => 'required|date|after_or_equal:today',
            'hora_inicio'           => 'required|date_format:H:i',
            'hora_fin'              => 'required|date_format:H:i|after:hora_inicio',
            'duracion_estimada_min' => 'required|integer|min:15|max:720',
            'anestesiologo'         => 'nullable|string|max:255',
            'instrumentos_requeridos' => 'nullable|string',
            'notas_adicionales'     => 'nullable|string',
        ];
    }
}
