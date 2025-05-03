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
        // 
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
            $carrera = DB::table('carreras')
                ->updateOrInsert(
                    ['nombre' => $carreraData['nombre']],
                    [
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
                );

            // Obtener el ID de la carrera (ya existente o recién creada)
            $carrera_id = DB::table('carreras')
                ->where('nombre', $carreraData['nombre'])
                ->value('carrera_id');

            // Insertar especialidades si no existen
            foreach ($carreraData['especialidades'] as $especialidad) {
                DB::table('especialidades')
                    ->updateOrInsert(
                        [
                            'carrera_id' => $carrera_id,
                            'nombre' => $especialidad
                        ],
                        [
                            'created_at' => now(),
                            'updated_at' => now()
                        ]
                    );
            }
        }
    }
}
