<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Habitacion>
 */
class HabitacionFactory extends Factory
{

    public function definition(): array
    {
        return [
            'numero_habitacion' => $this->faker->unique()->bothify('H-###'), // Ej: H-101
            'tipo' => $this->faker->randomElement(['individual', 'doble', 'UCI', 'emergencia']),
            'estado' => $this->faker->randomElement(['disponible', 'ocupada', 'mantenimiento']),
            'descripcion' => $this->faker->optional()->sentence(),
        ];
    }
}
