<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
        'empleado_id',
        'rolturnosdoctores_id',
        'fecha',
        'hora',
        'estado'

    ];

    protected $casts = [
        'fecha' => 'date'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'empleado_id');
    }
}
