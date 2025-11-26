<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    use HasFactory;

    // Nombre de la tabla (si no sigue la convención plural)
    protected $table = 'calificaciones';

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'doctor_id',
        'paciente_id',
        'estrellas',
        'comentario'
    ];

    // Validación de datos
    protected $casts = [
        'estrellas' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Reglas de validación (opcional, pero recomendado)
    public static $rules = [
        'doctor_id' => 'required|exists:empleados,id',
        'paciente_id' => 'required|exists:pacientes,id',
        'estrellas' => 'required|integer|min:1|max:5',
        'comentario' => 'nullable|string|max:500'
    ];

    /**
     * Relación con el modelo Empleado (Doctor)
     */
    public function doctor()
    {
        return $this->belongsTo(Empleado::class, 'doctor_id');
    }

    /**
     * Relación con el modelo Paciente
     */
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    /**
     * Scope para obtener calificaciones de un doctor específico
     */
    public function scopeDeDoctor($query, $doctorId)
    {
        return $query->where('doctor_id', $doctorId);
    }

    /**
     * Scope para obtener calificaciones de un paciente específico
     */
    public function scopeDePaciente($query, $pacienteId)
    {
        return $query->where('paciente_id', $pacienteId);
    }

    /**
     * Obtener el promedio de calificación
     */
    public static function promedioDoctor($doctorId)
    {
        return self::where('doctor_id', $doctorId)->avg('estrellas') ?? 0;
    }

    /**
     * Verificar si un paciente ya calificó a un doctor
     */
    public static function yaCalificado($doctorId, $pacienteId)
    {
        return self::where('doctor_id', $doctorId)
            ->where('paciente_id', $pacienteId)
            ->exists();
    }
}
