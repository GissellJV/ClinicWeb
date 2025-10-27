<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginEmpleado extends Model
{
    protected $table = 'loginempleados';
    protected $fillable=[
        'telefono',
        'password',
    ];

    protected $hidden = [
        'password'
    ];
}
