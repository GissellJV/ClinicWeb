<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluacionPrequirurgica extends Model
{
    use HasFactory;

    protected $table = 'evaluaciones_prequirurgicas';

    protected $fillable = [
        'cita_id',
        'paciente_id',
        'empleado_id',
        'tipo_cirugia',
        'diagnostico',
        'descripcion_procedimiento',
        'nivel_riesgo',
        'observaciones',
        'presion_arterial',
        'temperatura',
        'frecuencia_cardiaca',
        'frecuencia_respiratoria',
        'peso',
        'talla',
        'alergias',
        'medicamentos_actuales',
        'antecedentes_quirurgicos',
        'estado',
    ];

    public function cita()
    {
        return $this->belongsTo(Cita::class, 'cita_id');
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }

    public function cirugia()
    {
        return $this->hasOne(Cirugia::class, 'evaluacion_id');
    }

    // Reglas de validación
    public static function rules(): array
    {
        return [
            'cita_id'                  => 'required|exists:citas,id',
            'tipo_cirugia'             => 'required|string|max:255',
            'diagnostico'              => 'required|string|max:500',
            'descripcion_procedimiento'=> 'required|string',
            'nivel_riesgo'             => 'required|in:bajo,medio,alto',
            'observaciones'            => 'nullable|string',
            'presion_arterial'         => 'nullable|string|max:20',
            'temperatura'              => 'nullable|numeric|between:30,45',
            'frecuencia_cardiaca'      => 'nullable|integer|between:30,200',
            'frecuencia_respiratoria'  => 'nullable|integer|between:5,60',
            'peso'                     => 'nullable|numeric|between:1,300',
            'talla'                    => 'nullable|numeric|between:0.5,2.5',
            'alergias'                 => 'nullable|string',
            'medicamentos_actuales'    => 'nullable|string',
            'antecedentes_quirurgicos' => 'nullable|string',
        ];
    }
}
