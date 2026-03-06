<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Empleado extends Model
{
    //use HasFactory;

    // Nombre de la tabla
    protected $table = 'empleados';

    protected $fillable = [
        'nombre',
        'apellido',
        'numero_identidad',
        'cargo',
        'departamento',
        'fecha_ingreso',
        'genero',
        'email',
        'foto'
    ];

    // Ocultar campos sensibles
    protected $hidden = [
        'foto', // Por si acaso las fotos son pesadas
    ];


    protected $casts = [
        'fecha_ingreso' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación con calificaciones (un empleado/doctor tiene muchas calificaciones)
     */
    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class, 'doctor_id');
    }

    /**
     * Obtener el promedio de calificación del doctor
     */
    public function getPromedioCalificacionAttribute()
    {
        $calificaciones = $this->calificaciones;

        if ($calificaciones->count() === 0) {
            return 0;
        }

        return round($calificaciones->avg('estrellas'), 1);
    }

    /**
     * Obtener el número total de calificaciones
     */
    public function getTotalCalificacionesAttribute()
    {
        return $this->calificaciones->count();
    }

    /**
     * Verificar si el empleado es un doctor
     */
    public function getEsDoctorAttribute()
    {
        return $this->cargo === 'Doctor';
    }

    /**
     * Scope para obtener solo doctores
     */
    public function scopeDoctores($query)
    {
        return $query->where('cargo', 'Doctor');
    }

    /**
     * Scope para obtener doctores por departamento
     */
    public function scopePorDepartamento($query, $departamento)
    {
        return $query->where('departamento', $departamento);
    }

    /**
     * Obtener distribución de calificaciones (1-5 estrellas)
     */
    public function getDistribucionCalificacionesAttribute()
    {
        return [
            5 => $this->calificaciones->where('estrellas', 5)->count(),
            4 => $this->calificaciones->where('estrellas', 4)->count(),
            3 => $this->calificaciones->where('estrellas', 3)->count(),
            2 => $this->calificaciones->where('estrellas', 2)->count(),
            1 => $this->calificaciones->where('estrellas', 1)->count(),
        ];
    }

    /**
     * Relación con citas (si la tienes)
     */
    public function citas()
    {
        return $this->hasMany(Cita::class, 'doctor_id');
    }

    public function turnos()
    {
        return $this->hasMany(Turno::class, 'empleado_id');
    }


    // Relación: Un empleado tiene un login
    public function loginEmpleado()
    {
        return $this->hasOne(LoginEmpleado::class, 'empleado_id');
    }


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

    public function incidentes()
    {
        return $this->hasMany(Incidente::class, 'empleado_id');
    }

    public function notificacionesIncidentes()
    {
        return $this->hasMany(NotificacionIncidente::class, 'empleado_id');
    }

    public function esAdministrador()
    {
        return $this->cargo === 'Recepcionista';

    }
}







