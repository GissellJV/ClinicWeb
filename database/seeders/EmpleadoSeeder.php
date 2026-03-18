<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empleado;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmpleadoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear empleado
        $empleado = Empleado::create([
            'nombre' => 'Superadmin',
            'apellido' => 'General',
            'numero_identidad' => '0704199900348',
            'cargo' => 'Administrador',
            'foto' => null,
            'departamento' => 'Administración',
            'fecha_ingreso' => now(),
            'genero' => 'Masculino',
            'email' => 'admin@clinica.com',
        ]);

        // 2. Crear login asociado
        DB::table('loginempleados')->insert([
            'empleado_nombre' => $empleado->nombre,
            'empleado_apellido' => $empleado->apellido,
            'telefono' => '77777777',
            'password' => Hash::make('Seper12345*'),
            'empleado_id' => $empleado->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
