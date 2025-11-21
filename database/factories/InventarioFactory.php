<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class InventarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $medicamentos = [
            'Paracetamol 500mg',
            'Amoxicilina 500mg',
            'Diclofenaco Inyectable 75mg/3ml',
            'Omeprazol 20mg',
            'Losartán 50mg',
            'Metformina 850mg',
            'Complejo B Inyectable (B1+B6+B12)',
            'Ibuprofeno 400mg',
            'Ketorolaco Inyectable 30mg/ml',
            'Loratadina 10mg'
        ];


        $codigo = strtoupper(fake()->bothify('CLP###'));


        $cantidad = fake()->randomElement([
            fake()->numberBetween(1, 9),
            fake()->numberBetween(10, 50),
            fake()->numberBetween(51, 200),
        ]);

        if ($cantidad < 10) {
            $estado = 'Crítico';
        } elseif ($cantidad >= 10 && $cantidad <= 50) {
            $estado = 'Bajo';
        } else {
            $estado = 'Normal';
        }

        $fechaVencimiento = fake()->dateTimeBetween('tomorrow', '+2 years')->format('Y-m-d');

        return [

                'codigo' => $codigo,
                'nombre' => fake()->unique()->randomElement($medicamentos),
                'cantidad' => $cantidad,
                'estado' => $estado,
                'fecha_vencimiento' => $fechaVencimiento,
                'created_at' => now(),
                'updated_at' => now()
            ];
    }
}
