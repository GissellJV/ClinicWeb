<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Empleado extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'numero_identidad',
        'cargo',
        'departamento',
        'fecha_ingreso'
    ];
    protected $casts = [
        'fecha_ingreso' => 'date'
    ];

    // Métodos helper para roles
    public function esRecepcionista()
    {
        return $this->cargo === 'Recepcionista';
    }

    public function esDoctor()
    {
        return $this->cargo === 'Doctor';
    }

    public function esGerente()
    {
        return $this->cargo === 'Gerente';
    }
}
