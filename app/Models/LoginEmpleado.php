<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginEmpleado extends Model
{
    protected $table = 'loginempleados';
    protected $fillable=[
        'empleado_id',
        'empleado_nombre',
        'empleado_apellido',
        'telefono',
        'password',
    ];

    protected $hidden = [
        'password'
    ];

    // Relación: Un login pertenece a un empleado
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }

}
