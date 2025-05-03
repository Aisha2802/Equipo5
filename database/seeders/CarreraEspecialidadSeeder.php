<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarreraEspecialidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Carreras con sus respectivas especialidades
        $carreras = [
            [
                'nombre' => 'Ingeniería en Sistemas Computacionales',
                'especialidades' => [
                    'Ciberseguridad',
                    'Ingeniería de Software',
                    'Desarrollo Web'
                ]
            ],
            [
                'nombre' => 'Ingeniería Industrial',
                'especialidades' => [
                    'Gestión de la Calidad',
                    'Logística y Cadena de Suministro',
                    'Seguridad Industrial'
                ]
            ],
            [
                'nombre' => 'Ingeniería Electrónica',
                'especialidades' => [
                    'Robótica',
                    'Automatización'
                ]
            ],
            [
                'nombre' => 'Ingeniería Mecatrónica',
                'especialidades' => [
                    'Mecatrónica Automotriz',
                    'Diseño Mecatrónico'
                ]
            ],
            [
                'nombre' => 'Ingeniería en Tecnologías de la Información',
                'especialidades' => [
                    'Seguridad Informática'
                ]
            ],
            [
                'nombre' => 'Licenciatura en Administración',
                'especialidades' => [
                    'Finanzas',
                    'Negocios Internacionales',
                    'Administración Pública'
                ]
            ]
        ];

          // Insertar en la base de datos
          foreach ($carreras as $carreraData) {
            // Insertar la carrera y obtener su ID
            $carrera_id = DB::table('carreras')->insertGetId([
                'nombre' => $carreraData['nombre'],
                'created_at' => now(),
                'updated_at' => now()
            ], 'carrera_id'); // Especificar que queremos obtener 'carrera_id'

            // Insertar sus especialidades
            foreach ($carreraData['especialidades'] as $especialidad) {
                DB::table('especialidades')->insert([
                    'carrera_id' => $carrera_id,
                    'nombre' => $especialidad,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}