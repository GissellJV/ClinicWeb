<?php

namespace Database\Factories;

use App\Models\Cotizacion;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cotizacion>
 */
class CotizacionFactory extends Factory
{
    protected $model = Cotizacion::class;

    public function definition()
    {
        $paciente = Paciente::inRandomOrder()->first();

        if (!$paciente) {
            throw new \Exception('No hay pacientes en la base de datos');
        }

        return [
            'paciente_id' => $paciente->id,
            'fecha' => $this->faker->date(),
            'total' => 0,
        ];
    }
}
