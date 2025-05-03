<?php

namespace Database\Seeders;

use App\Models\Periodo;
use Illuminate\Database\Seeder;

class PeriodoSeeder extends Seeder
{
    public function run()
    {
        Periodo::create([
            'nombre' => 'Enero-Junio 2025',
            'activo' => true
        ]);

        Periodo::create([
            'nombre' => 'Agosto-Diciembre 2024'
        ]);
    }
}