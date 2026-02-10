<?php

namespace Database\Seeders;

use App\Models\CotizacionDetalle;
use Illuminate\Database\Seeder;

class CotizacionDetalleSeeder extends Seeder
{
    public function run()
    {
        CotizacionDetalle::factory()->count(10)->create();
    }
}

