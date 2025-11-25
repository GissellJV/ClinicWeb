<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Habitacion;
use App\Models\Paciente;
use App\Models\AsignacionHabitacion;

class HabitacionesSeeder extends Seeder
{
    public function run()
    {

        // Crear 10 habitaciones
        Habitacion::factory()->count(10)->create();

    }
}

