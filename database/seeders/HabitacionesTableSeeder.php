<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HabitacionesTableSeeder extends Seeder
{
    /*public function run()
    {
        $now = Carbon::now();

        $habitaciones = [
            [
                'numero_habitacion' => '101',
                'tipo' => 'individual',
                'estado' => 'disponible',
                'descripcion' => 'Habitación individual con baño privado',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'numero_habitacion' => '102',
                'tipo' => 'doble',
                'estado' => 'disponible',
                'descripcion' => 'Habitación doble con vista al jardín',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'numero_habitacion' => '103',
                'tipo' => 'UCI',
                'estado' => 'disponible',
                'descripcion' => 'Unidad de Cuidados Intensivos',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'numero_habitacion' => '104',
                'tipo' => 'emergencia',
                'estado' => 'disponible',
                'descripcion' => 'Sala de emergencias',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'numero_habitacion' => '201',
                'tipo' => 'individual',
                'estado' => 'disponible',
                'descripcion' => 'Habitación individual estándar',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'numero_habitacion' => '202',
                'tipo' => 'doble',
                'estado' => 'disponible',
                'descripcion' => 'Habitación doble con aire acondicionado',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'numero_habitacion' => '203',
                'tipo' => 'UCI',
                'estado' => 'disponible',
                'descripcion' => 'UCI pediátrica',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'numero_habitacion' => '204',
                'tipo' => 'emergencia',
                'estado' => 'disponible',
                'descripcion' => 'Sala de emergencias 2',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        // Verificar y insertar solo las habitaciones que no existen
        foreach ($habitaciones as $habitacion) {
            $existe = DB::table('habitaciones')
                ->where('numero_habitacion', $habitacion['numero_habitacion'])
                ->exists();

            if (!$existe) {
                DB::table('habitaciones')->insert($habitacion);
                $this->command->info("✅ Habitación {$habitacion['numero_habitacion']} creada.");
            } else {
                $this->command->warn("⚠️ Habitación {$habitacion['numero_habitacion']} ya existe, omitiendo...");
            }
        }

        $this->command->info('🎉 ¡Proceso de seeding de habitaciones completado!');
    }
    */
}
