<?php

namespace Database\Factories;

use App\Models\Cotizacion;
use App\Models\Inventario;
use App\Models\CotizacionDetalle;
use Illuminate\Database\Eloquent\Factories\Factory;

class CotizacionDetalleFactory extends Factory
{
    protected $model = CotizacionDetalle::class;

    public function definition()
    {
        $cotizacion = Cotizacion::inRandomOrder()->first()
            ?? Cotizacion::factory()->create();
        $inventario = Inventario::inRandomOrder()->first();
        $cantidad = $this->faker->numberBetween(1, 10);
        $precio = $inventario->precio ?? $this->faker->randomFloat(2, 10, 200);

        return [
            'cotizacion_id' => $cotizacion->id,
            'inventario_medicamento_id' => $inventario->id,
            'cantidad' => $cantidad,
            'precio_unitario' => $precio,
            'subtotal' => $cantidad * $precio,
        ];
    }
}
