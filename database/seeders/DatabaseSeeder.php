<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            PeriodoSeeder::class,
            CarreraEspecialidadSeeder::class,
            EmpresaVacanteSeeder::class,
            UsersTableSeeder::class,
            EncuestasSeeder::class,
            TipoDocumentoSeeder::class,
            SolicitudVacanteSeeder::class,
            RespuestasSeeder::class
            ]);
        
    }
}
