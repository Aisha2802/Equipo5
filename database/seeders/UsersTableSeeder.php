<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vinculacion\Aspirante;
use App\Models\Vinculacion\Empresa;
use App\Models\Vinculacion\Especialidad;
use App\Models\Vinculacion\Perfil;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Especialidades para Sistemas Computacionales (carrera_id = 1)
        $especialidadCiberseguridad = Especialidad::where('carrera_id', 1)
            ->where('nombre', 'Ciberseguridad')
            ->first();

        $especialidadSoftware = Especialidad::where('carrera_id', 1)
            ->where('nombre', 'Ingeniería de Software')
            ->first();

        $especialidadNube = Especialidad::where('carrera_id', 1)
            ->where('nombre', 'Desarrollo Web')
            ->first();

        // Especialidades para Industrial (carrera_id = 2)
        $especialidadLogistica = Especialidad::where('carrera_id', 2)
            ->where('nombre', 'Logística y Cadena de Suministro')
            ->first();

        $especialidadGestion = Especialidad::where('carrera_id', 2)
            ->where('nombre', 'Gestión de la Calidad')
            ->first();

        $especialidadSeguridad = Especialidad::where('carrera_id', 2)
            ->where('nombre', 'Seguridad Industrial')
            ->first();

        // Especialidades para Electrónica (carrera_id = 3)
        $especialidadRobotica = Especialidad::where('carrera_id', 3)
            ->where('nombre', 'Robótica')
            ->first();

        $especialidadAutoma = Especialidad::where('carrera_id', 3)
            ->where('nombre', 'Automatización')
            ->first();

        // Especialidades para Mecatrónica (carrera_id = 4)
        $especialidadMAutomo = Especialidad::where('carrera_id', 4)
            ->where('nombre', 'Mecatrónica Automotriz')
            ->first();

        $especialidadDiseno = Especialidad::where('carrera_id', 4)
            ->where('nombre', 'Diseño Mecatrónico')
            ->first();

        // Especialidades para TIC (carrera_id = 5)
        $especialidadSeguridadInfo = Especialidad::where('carrera_id', 5)
            ->where('nombre', 'Seguridad Informática')
            ->first();

        // Especialidades para Administración (carrera_id = 6)
        $especialidadFinanza = Especialidad::where('carrera_id', 6)
            ->where('nombre', 'Finanzas')
            ->first();

        $especialidadNegocio = Especialidad::where('carrera_id', 6)
            ->where('nombre', 'Negocios Internacionales')
            ->first();

        $especialidadAdmin = Especialidad::where('carrera_id', 6)
            ->where('nombre', 'Administración Pública')
            ->first();
        // Obtener perfiles existentes
        // Perfiles adicionales para Sistemas Computacionales (carrera_id = 1)
        $perfilSoftware = Perfil::where('carrera_id', 1)
            ->where('especialidad_id', $especialidadSoftware->especialidad_id)
            ->first();

        $perfilCiberseguridad = Perfil::where('carrera_id', 1)
            ->where('especialidad_id', $especialidadCiberseguridad->especialidad_id)
            ->first();

        $perfilNube = Perfil::where('carrera_id', 1)
            ->where('especialidad_id', $especialidadNube->especialidad_id)
            ->first();

        // Perfiles adicionales para Industrial (carrera_id = 2)
        $perfilGestion = Perfil::where('carrera_id', 2)
            ->where('especialidad_id', $especialidadGestion->especialidad_id)
            ->first();

        $perfilSeguridad = Perfil::where('carrera_id', 2)
            ->where('especialidad_id', $especialidadSeguridad->especialidad_id)
            ->first();

        $perfilLogistica = Perfil::where('carrera_id', 2)
            ->where('especialidad_id', $especialidadLogistica->especialidad_id)
            ->first();

        // Perfiles para Electrónica (carrera_id = 3)
        $perfilRobotica = Perfil::where('carrera_id', 3)
            ->where('especialidad_id', $especialidadRobotica->especialidad_id)
            ->first();

        $perfilAutoma = Perfil::where('carrera_id', 3)
            ->where('especialidad_id', $especialidadAutoma->especialidad_id)
            ->first();

        // Perfiles para Mecatrónica (carrera_id = 4)
        $perfilMAutomo = Perfil::where('carrera_id', 4)
            ->where('especialidad_id', $especialidadMAutomo->especialidad_id)
            ->first();

        $perfilDiseno = Perfil::where('carrera_id', 4)
            ->where('especialidad_id', $especialidadDiseno->especialidad_id)
            ->first();

        // Perfiles para TIC (asumiendo carrera_id = 5)
        $perfilSeguridadInfo = Perfil::where('carrera_id', 5)
            ->where('especialidad_id', $especialidadSeguridadInfo->especialidad_id)
            ->first();

        // Perfiles para Administración (asumiendo carrera_id = 6)
        $perfilFinanza = Perfil::where('carrera_id', 6)
            ->where('especialidad_id', $especialidadFinanza->especialidad_id)
            ->first();

        $perfilNegocio = Perfil::where('carrera_id', 6)
            ->where('especialidad_id', $especialidadNegocio->especialidad_id)
            ->first();

        $perfilAdmin = Perfil::where('carrera_id', 6)
            ->where('especialidad_id', $especialidadAdmin->especialidad_id)
            ->first();

        // Obtener las empresas existentes
        $empresa1 = Empresa::where('nombreComercial', 'Tech Solutions')->first();
        $empresa2 = Empresa::where('nombreComercial', 'Industrial Corp')->first();
        $empresa3 = Empresa::where('nombreComercial', 'Logística Global')->first();
        $empresa4 = Empresa::where('nombreComercial', 'Seguridad Digital')->first();

        $users = [
            // Usuarios de vinculación
            [
                'name' => 'Admin Vinculación',
                'email' => 'vinculacion@example.com',
                'password' => Hash::make('password123'),
                'role' => 'vinculacion',
                'perfil_id' => null,
                'empresa_id' => null,
            ],
            // Usuarios de empresa
            [
                'name' => 'Gerente Tech Solutions',
                'email' => 'gerente.tech@example.com',
                'password' => Hash::make('password123'),
                'role' => 'empresa',
                'perfil_id' => null,
                'empresa_id' => $empresa1->empresa_id,
            ],
            [
                'name' => 'RH Industrial Corp',
                'email' => 'rh.industrial@example.com',
                'password' => Hash::make('password123'),
                'role' => 'empresa',
                'perfil_id' => null,
                'empresa_id' => $empresa2->empresa_id,
            ],
            [
                'name' => 'Director Logística Global',
                'email' => 'director.logistica@example.com',
                'password' => Hash::make('password123'),
                'role' => 'empresa',
                'perfil_id' => null,
                'empresa_id' => $empresa3->empresa_id,
            ],
            [
                'name' => 'CEO Seguridad Digital',
                'email' => 'ceo.seguridad@example.com',
                'password' => Hash::make('password123'),
                'role' => 'empresa',
                'perfil_id' => null,
                'empresa_id' => $empresa4->empresa_id,
            ],
            //estudiantes
            [
                'name' => 'Laura Martínez',
                'email' => 'laura.martinez@example.com',
                'password' => Hash::make('password123'),
                'role' => 'aspirante',
                'perfil_id' => $perfilSoftware->perfil_id,
                'empresa_id' => null,
            ],

            // Perfil: Ciberseguridad (Sistemas)
            [
                'name' => 'Carlos Méndez',
                'email' => 'carlos.mendez@example.com',
                'password' => Hash::make('password123'),
                'role' => 'aspirante',
                'perfil_id' => $perfilCiberseguridad->perfil_id,
                'empresa_id' => null,
            ],

            // Perfil: Desarrollo Web (Sistemas)
            [
                'name' => 'Sofía Ramírez',
                'email' => 'sofia.ramirez@example.com',
                'password' => Hash::make('password123'),
                'role' => 'aspirante',
                'perfil_id' => $perfilNube->perfil_id,
                'empresa_id' => null,
            ],

            // Perfil: Gestión de la Calidad (Industrial)
            [
                'name' => 'Miguel Ángel Torres',
                'email' => 'miguel.torres@example.com',
                'password' => Hash::make('password123'),
                'role' => 'aspirante',
                'perfil_id' => $perfilGestion->perfil_id,
                'empresa_id' => null,
            ],

            // Perfil: Seguridad Industrial (Industrial)
            [
                'name' => 'Ana Patricia López',
                'email' => 'ana.lopez@example.com',
                'password' => Hash::make('password123'),
                'role' => 'aspirante',
                'perfil_id' => $perfilSeguridad->perfil_id,
                'empresa_id' => null,
            ],

            // Perfil: Logística (Industrial)
            [
                'name' => 'Eduardo Torres',
                'email' => 'eduardo.torres@example.com',
                'password' => Hash::make('password123'),
                'role' => 'aspirante',
                'perfil_id' => $perfilLogistica->perfil_id,
                'empresa_id' => null,
            ],

            // Perfil: Robótica (Electrónica)
            [
                'name' => 'Gabriel Soto',
                'email' => 'gabriel.soto@example.com',
                'password' => Hash::make('password123'),
                'role' => 'aspirante',
                'perfil_id' => $perfilRobotica->perfil_id,
                'empresa_id' => null,
            ],

            // Perfil: Automatización (Electrónica)
            [
                'name' => 'Héctor Vargas',
                'email' => 'hector.vargas@example.com',
                'password' => Hash::make('password123'),
                'role' => 'aspirante',
                'perfil_id' => $perfilAutoma->perfil_id,
                'empresa_id' => null,
            ],

            // Perfil: Mecatrónica Automotriz (Mecatrónica)
            [
                'name' => 'Isabel Cruz',
                'email' => 'isabel.cruz@example.com',
                'password' => Hash::make('password123'),
                'role' => 'aspirante',
                'perfil_id' => $perfilMAutomo->perfil_id,
                'empresa_id' => null,
            ],

            // Perfil: Diseño Mecatrónico (Mecatrónica)
            [
                'name' => 'Javier Morales',
                'email' => 'javier.morales@example.com',
                'password' => Hash::make('password123'),
                'role' => 'aspirante',
                'perfil_id' => $perfilDiseno->perfil_id,
                'empresa_id' => null,
            ],

            // Perfil: Seguridad Informática (TIC)
            [
                'name' => 'Daniela Méndez',
                'email' => 'daniela.mendez@example.com',
                'password' => Hash::make('password123'),
                'role' => 'aspirante',
                'perfil_id' => $perfilSeguridadInfo->perfil_id,
                'empresa_id' => null,
            ],

            // Perfil: Finanzas (Administración)
            [
                'name' => 'Roberto Sánchez',
                'email' => 'roberto.sanchez@example.com',
                'password' => Hash::make('password123'),
                'role' => 'aspirante',
                'perfil_id' => $perfilFinanza->perfil_id,
                'empresa_id' => null,
            ],

            // Perfil: Negocios Internacionales (Administración)
            [
                'name' => 'María Fernanda Gómez',
                'email' => 'maria.gomez@example.com',
                'password' => Hash::make('password123'),
                'role' => 'aspirante',
                'perfil_id' => $perfilNegocio->perfil_id,
                'empresa_id' => null,
            ],

            // Perfil: Administración Pública (Administración)
            [
                'name' => 'Luis Alberto Ramírez',
                'email' => 'luis.ramirez@example.com',
                'password' => Hash::make('password123'),
                'role' => 'aspirante',
                'perfil_id' => $perfilAdmin->perfil_id,
                'empresa_id' => null,
            ],
            // Jefes de carrera
            [
                'name' => 'Usuario Jefe',
                'email' => 'jefe@example.com',
                'password' => Hash::make('password123'),
                'role' => 'jefe',
                'perfil_id' => null,
                'empresa_id' => null, // No está asociado a una empresa
            ],
        ];

        $cont = 0;
        foreach ($users as $userData) {
            $user = User::create($userData);

            if($cont==18){
            if ($user->role === 'aspirante') {
                Aspirante::create([
                    'nombre' => $user->name,
                    'numero_control' => 'CTRL' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                    'estado' => 'egresado',
                    'user_id' => $user->id,
                ]);
            }}else{
                Aspirante::create([
                    'nombre' => $user->name,
                    'numero_control' => 'CTRL' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                    'estado' => 'estudiante',
                    'user_id' => $user->id,
                ]);
            }
            $cont++;
        }
    }
}
