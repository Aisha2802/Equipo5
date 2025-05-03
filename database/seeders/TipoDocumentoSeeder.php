<?php

namespace Database\Seeders;

use App\Models\Vinculacion\Tipo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Definir los tipos de documentos
        $tipos = [
            ['nombre' => 'CV'],
            ['nombre' => 'Carta de Aceptación'],
            ['nombre' => 'Evaluación Final'],
            ['nombre' => 'Constancia de Terminación'],
            ['nombre' => 'Carta de Liberación'],
        ];

        // Insertar los tipos de documentos en la tabla
        foreach ($tipos as $tipo) {
            Tipo::create($tipo);
        }

    }
}
