<?php

namespace Database\Seeders;

use App\Models\Vinculacion\Carrera;
use App\Models\Vinculacion\Empresa;
use App\Models\Vinculacion\Especialidad;
use App\Models\Vinculacion\Perfil;
use App\Models\Vinculacion\Vacante;
use Illuminate\Database\Seeder;

class EmpresaVacanteSeeder extends Seeder
{
    public function run(): void
    {
        //carreras
        $carreraSistemas = Carrera::firstOrCreate(
            ['nombre' => 'Ingeniería en Sistemas Computacionales'],
        );
        $carreraIndustrial = Carrera::firstOrCreate(
            ['nombre' => 'Ingeniería Industrial'],
        );
        $carreraElectrica = $carreraElectrica = Carrera::firstOrCreate(
            ['nombre' => 'Ingeniería Electrónica'],
        );
        $carreraMecatronica = $carreraMecatronica = Carrera::firstOrCreate(
            ['nombre' => 'Ingeniería Mecatrónica'],
        );
        $carreraTIC = $carreraTIC = Carrera::firstOrCreate(
            ['nombre' => 'Ingeniería en Tecnologías de la Información'],
        );
        $carreraAdmin = $carreraAdmin = Carrera::firstOrCreate(
            ['nombre' => 'Licenciatura en Administración'],
        );
        //especialidades
        //sistemas
        $especialidaSoftware = Especialidad::firstOrCreate(
            ['nombre' => 'Ingeniería de Software', 'carrera_id' => $carreraSistemas->carrera_id]
        );
        $especialidadNube = Especialidad::firstOrCreate(
            ['nombre' => 'Desarrollo Web', 'carrera_id' => $carreraSistemas->carrera_id]
        );
        $especialidadCiberseguridad = Especialidad::firstOrCreate(
            ['nombre' => 'Ciberseguridad', 'carrera_id' => $carreraSistemas->carrera_id]
        );
        //industrial
        $especialidadLogistica = Especialidad::firstOrCreate(
            ['nombre' => 'Logística y Cadena de Suministro', 'carrera_id' => $carreraIndustrial->carrera_id]
        );
        $especialidadGestion = Especialidad::firstOrCreate(
            ['nombre' => 'Gestión de la Calidad', 'carrera_id' => $carreraIndustrial->carrera_id]
        );
        $especialidadSeguridad = Especialidad::firstOrCreate(
            ['nombre' => 'Seguridad Industrial', 'carrera_id' => $carreraIndustrial->carrera_id]
        );
        //electrica
        $especialidadRobotica = Especialidad::firstOrCreate(
            ['nombre' => 'Robótica', 'carrera_id' => $carreraElectrica->carrera_id]
        );
        $especialidadAutoma = Especialidad::firstOrCreate(
            ['nombre' => 'Automatización', 'carrera_id' => $carreraElectrica->carrera_id]
        );
        //mecatronica
        $especialidadMAutomo = Especialidad::firstOrCreate(
            ['nombre' => 'Mecatrónica Automotriz', 'carrera_id' => $carreraMecatronica->carrera_id]
        );
        $especialidadDiseno = Especialidad::firstOrCreate(
            ['nombre' => 'Diseño Mecatrónico', 'carrera_id' => $carreraMecatronica->carrera_id]
        );
        //TICS
        $especialidadSeguridadInfo = Especialidad::firstOrCreate(
            ['nombre' => 'Seguridad Informática', 'carrera_id' => $carreraTIC->carrera_id]
        );
        //admin
        $especialidadFinanza = Especialidad::firstOrCreate(
            ['nombre' => 'Finanzas', 'carrera_id' => $carreraAdmin->carrera_id]
        );
        $especialidadNegocio = Especialidad::firstOrCreate(
            ['nombre' => 'Negocios Internacionales', 'carrera_id' => $carreraAdmin->carrera_id]
        );
        $especialidadAdmin = Especialidad::firstOrCreate(
            ['nombre' => 'Administración Pública', 'carrera_id' => $carreraAdmin->carrera_id]
        );
        //perfiles
        //sistemas
        $perfilCiberseguridad = Perfil::firstOrCreate([
            'carrera_id' => $carreraSistemas->carrera_id,
            'especialidad_id' => $especialidadCiberseguridad->especialidad_id
        ]);

        $perfilSoftware = Perfil::firstOrCreate([
            'carrera_id' => $carreraSistemas->carrera_id,
            'especialidad_id' => $especialidaSoftware->especialidad_id
        ]);

        $perfilNube = Perfil::firstOrCreate([
            'carrera_id' => $carreraSistemas->carrera_id,
            'especialidad_id' => $especialidadNube->especialidad_id
        ]);
        //industrial
        $perfilLogistica = Perfil::firstOrCreate([
            'carrera_id' => $carreraIndustrial->carrera_id,
            'especialidad_id' => $especialidadLogistica->especialidad_id
        ]);
        $perfilGestion = Perfil::firstOrCreate([
            'carrera_id' => $carreraIndustrial->carrera_id,
            'especialidad_id' => $especialidadGestion->especialidad_id
        ]);
        $perfilSeguridad = Perfil::firstOrCreate([
            'carrera_id' => $carreraIndustrial->carrera_id,
            'especialidad_id' => $especialidadSeguridad->especialidad_id
        ]);
        //Electrica
        $perfilRobotica = Perfil::firstOrCreate([
            'carrera_id' => $carreraElectrica->carrera_id,
            'especialidad_id' => $especialidadRobotica->especialidad_id
        ]);
        $perfilAutoma = Perfil::firstOrCreate([
            'carrera_id' => $carreraElectrica->carrera_id,
            'especialidad_id' => $especialidadAutoma->especialidad_id
        ]);
        //mecatronica
        $perfilMAutomo = Perfil::firstOrCreate([
            'carrera_id' => $carreraMecatronica->carrera_id,
            'especialidad_id' => $especialidadMAutomo->especialidad_id
        ]);
        $perfilDiseno = Perfil::firstOrCreate([
            'carrera_id' => $carreraMecatronica->carrera_id,
            'especialidad_id' => $especialidadDiseno->especialidad_id
        ]);
        //TIC
        $perfilSeguridadInfo = Perfil::firstOrCreate([
            'carrera_id' => $carreraTIC->carrera_id,
            'especialidad_id' => $especialidadSeguridadInfo->especialidad_id
        ]);
        //Admin
        $perfilFinanza = Perfil::firstOrCreate([
            'carrera_id' => $carreraAdmin->carrera_id,
            'especialidad_id' => $especialidadFinanza->especialidad_id
        ]);
        $perfilAdmin = Perfil::firstOrCreate([
            'carrera_id' => $carreraAdmin->carrera_id,
            'especialidad_id' => $especialidadAdmin->especialidad_id
        ]);
        $perfilNegocio = Perfil::firstOrCreate([
            'carrera_id' => $carreraAdmin->carrera_id,
            'especialidad_id' => $especialidadNegocio->especialidad_id
        ]);
        // empresas
        $empresa1 = Empresa::firstOrCreate(
            ['RFC' => 'EMP123456789'],
            [
                'nombreComercial' => 'Tech Solutions',
                'razonSocial' => 'Tech Solutions S.A. de C.V.',
                'giro' => 'Tecnología',
                'noEmpleado' => 100,
                'codigoPostal' => '12345',
                'colonia' => 'Centro',
                'ciudad' => 'Ciudad de México',
                'estado' => 'CDMX',
                'pais' => 'México',
                'sitioWeb' => 'https://techsolutions.com',
            ]
        );

        $empresa2 = Empresa::firstOrCreate(
            ['RFC' => 'EMP987654321'],
            [
                'nombreComercial' => 'Industrial Corp',
                'razonSocial' => 'Industrial Corp S.A. de C.V.',
                'giro' => 'Manufactura',
                'noEmpleado' => 200,
                'codigoPostal' => '54321',
                'colonia' => 'Industrial',
                'ciudad' => 'Monterrey',
                'estado' => 'Nuevo León',
                'pais' => 'México',
                'sitioWeb' => 'https://industrialcorp.com',
            ]
        );
        $empresa3 = Empresa::firstOrCreate(
            ['RFC' => 'LOG789123456'],
            [
                'nombreComercial' => 'Logística Global',
                'razonSocial' => 'Logística Global S.A. de C.V.',
                'giro' => 'Transporte y Logística',
                'noEmpleado' => 150,
                'codigoPostal' => '44600',
                'colonia' => 'Zona Industrial',
                'ciudad' => 'Guadalajara',
                'estado' => 'Jalisco',
                'pais' => 'México',
                'sitioWeb' => 'https://logisticaglobal.com'
            ]
        );

        $empresa4 = Empresa::firstOrCreate(
            ['RFC' => 'SEG321654987'],
            [
                'nombreComercial' => 'Seguridad Digital',
                'razonSocial' => 'Seguridad Digital S.A. de C.V.',
                'giro' => 'Seguridad Informática',
                'noEmpleado' => 80,
                'codigoPostal' => '06600',
                'colonia' => 'Juárez',
                'ciudad' => 'Ciudad de México',
                'estado' => 'CDMX',
                'pais' => 'México',
                'sitioWeb' => 'https://seguridaddigital.mx'
            ]
        );
        //vacantes
        $vacantes = [
            // Tech Solutions - Perfil de Sistemas
            [
                'empresa_id' => $empresa1->empresa_id,
                'titulo' => 'Desarrollador de Software Senior',
                'descripcion' => 'Buscamos desarrollador con experiencia en arquitectura de software y patrones de diseño.',
                'ubicacion' => 'Ciudad de México',
                'tipo' => 'residencia',
                'estado' => 'abierta',
                'max' => 2,
                'pago' => 12000,
                'perfiles' => [$perfilSoftware->perfil_id]
            ],

            // Tech Solutions - Perfil de Ciberseguridad
            [
                'empresa_id' => $empresa1->empresa_id,
                'titulo' => 'Analista de Seguridad',
                'descripcion' => 'Buscamos profesional para análisis de vulnerabilidades y pruebas de penetración.',
                'ubicacion' => 'Remoto',
                'tipo' => 'residencia',
                'estado' => 'abierta',
                'max' => 3,
                'pago' => 15000,
                'perfiles' => [$perfilCiberseguridad->perfil_id]
            ],

            // Industrial Corp - Perfil de Logística
            [
                'empresa_id' => $empresa2->empresa_id,
                'titulo' => 'Coordinador de Cadena de Suministro',
                'descripcion' => 'Optimización de procesos logísticos y gestión de inventarios.',
                'ubicacion' => 'Monterrey',
                'tipo' => 'practicas',
                'estado' => 'abierta',
                'max' => 4,
                'pago' => 9000,
                'perfiles' => [$perfilLogistica->perfil_id]
            ],

            // Logística Global - Perfil de Gestión Industrial
            [
                'empresa_id' => $empresa3->empresa_id,
                'titulo' => 'Especialista en Calidad',
                'descripcion' => 'Implementación de sistemas de gestión de calidad ISO 9001.',
                'ubicacion' => 'Guadalajara',
                'tipo' => 'residencia',
                'estado' => 'pendiente',
                'max' => 1,
                'pago' => 10000,
                'perfiles' => [$perfilGestion->perfil_id]
            ],

            // Seguridad Digital - Perfil de Seguridad Informática (TIC)
            [
                'empresa_id' => $empresa4->empresa_id,
                'titulo' => 'Consultor en Seguridad',
                'descripcion' => 'Auditorías de seguridad y cumplimiento de normativas.',
                'ubicacion' => 'Híbrido',
                'tipo' => 'residencia',
                'estado' => 'abierta',
                'max' => 2,
                'pago' => 18000,
                'perfiles' => [$perfilSeguridadInfo->perfil_id]
            ],

            // Industrial Corp - Perfil DIFERENTE (Mecatrónica Automotriz)
            [
                'empresa_id' => $empresa2->empresa_id,
                'titulo' => 'Ingeniero en Automatización',
                'descripcion' => 'Diseño e implementación de sistemas automatizados para líneas de producción.',
                'ubicacion' => 'Monterrey',
                'tipo' => 'residencia',
                'estado' => 'abierta',
                'max' => 3,
                'pago' => 14000,
                'perfiles' => [$perfilMAutomo->perfil_id] // Perfil de Mecatrónica Automotriz
            ],

            // Tech Solutions - Perfil de Desarrollo Web
            [
                'empresa_id' => $empresa1->empresa_id,
                'titulo' => 'Desarrollador Frontend',
                'descripcion' => 'Creación de interfaces de usuario con React y Vue.js.',
                'ubicacion' => 'Remoto',
                'tipo' => 'practicas',
                'estado' => 'abierta',
                'max' => 5,
                'pago' => 8000,
                'perfiles' => [$perfilNube->perfil_id]
            ],

            // Seguridad Digital - Perfil de Negocios Internacionales
            [
                'empresa_id' => $empresa4->empresa_id,
                'titulo' => 'Asesor Comercial Internacional',
                'descripcion' => 'Expansión de mercados globales para soluciones de seguridad.',
                'ubicacion' => 'Ciudad de México',
                'tipo' => 'residencia',
                'estado' => 'abierta',
                'max' => 2,
                'pago' => 16000,
                'perfiles' => [$perfilNegocio->perfil_id]
            ],

            [
                'empresa_id' => $empresa2->empresa_id, // Industrial Corp
                'titulo' => 'Ingeniero en Robótica Industrial',
                'descripcion' => 'Diseño y programación de sistemas robóticos para líneas de producción automatizadas.',
                'ubicacion' => 'Monterrey',
                'tipo' => 'residencia',
                'estado' => 'abierta',
                'max' => 2,
                'pago' => 15000,
                'perfiles' => [$perfilRobotica->perfil_id]
            ],

            // 2. Vacante para Diseño Mecatrónico
            [
                'empresa_id' => $empresa3->empresa_id, // Logística Global
                'titulo' => 'Diseñador Mecatrónico',
                'descripcion' => 'Diseño de sistemas mecatrónicos para optimización de almacenes automatizados.',
                'ubicacion' => 'Guadalajara',
                'tipo' => 'residencia',
                'estado' => 'abierta',
                'max' => 1,
                'pago' => 13000,
                'perfiles' => [$perfilDiseno->perfil_id]
            ],

            // 3. Vacante para Finanzas (Administración)
            [
                'empresa_id' => $empresa1->empresa_id, // Tech Solutions
                'titulo' => 'Analista Financiero',
                'descripcion' => 'Análisis de estados financieros y proyecciones económicas para proyectos tecnológicos.',
                'ubicacion' => 'Híbrido',
                'tipo' => 'practicas',
                'estado' => 'abierta',
                'max' => 3,
                'pago' => 9000,
                'perfiles' => [$perfilFinanza->perfil_id]
            ],

            // 4. Vacante para Automatización (Electrónica)
            [
                'empresa_id' => $empresa4->empresa_id, // Seguridad Digital
                'titulo' => 'Especialista en Automatización',
                'descripcion' => 'Automatización de sistemas de seguridad física y lógica.',
                'ubicacion' => 'Ciudad de México',
                'tipo' => 'residencia',
                'estado' => 'pendiente',
                'max' => 2,
                'pago' => 14000,
                'perfiles' => [$perfilAutoma->perfil_id]
            ],

            // 5. Vacante para Seguridad Industrial
            [
                'empresa_id' => $empresa2->empresa_id, // Industrial Corp
                'titulo' => 'Coordinador de Seguridad Industrial',
                'descripcion' => 'Implementación de protocolos de seguridad en planta industrial.',
                'ubicacion' => 'Monterrey',
                'tipo' => 'residencia',
                'estado' => 'abierta',
                'max' => 1,
                'pago' => 11000,
                'perfiles' => [$perfilSeguridad->perfil_id]
            ],

            // 6. Vacante para Administración Pública
            [
                'empresa_id' => $empresa3->empresa_id, // Logística Global
                'titulo' => 'Consultor en Regulaciones Logísticas',
                'descripcion' => 'Asesoría en cumplimiento de normativas gubernamentales para transporte.',
                'ubicacion' => 'Guadalajara',
                'tipo' => 'residencia',
                'estado' => 'abierta',
                'max' => 1,
                'pago' => 12000,
                'perfiles' => [$perfilAdmin->perfil_id]
            ],

            // 7. Vacante para Desarrollo Web (Sistemas)
            [
                'empresa_id' => $empresa4->empresa_id, // Seguridad Digital
                'titulo' => 'Desarrollador Full Stack',
                'descripcion' => 'Desarrollo de portales seguros para gestión de credenciales digitales.',
                'ubicacion' => 'Remoto',
                'tipo' => 'residencia',
                'estado' => 'abierta',
                'max' => 4,
                'pago' => 16000,
                'perfiles' => [$perfilNube->perfil_id]
            ],

            // 8. Vacante para Negocios Internacionales
            [
                'empresa_id' => $empresa1->empresa_id, // Tech Solutions
                'titulo' => 'Asesor de Exportación Tecnológica',
                'descripcion' => 'Gestión de procesos de internacionalización para productos de software.',
                'ubicacion' => 'Ciudad de México',
                'tipo' => 'residencia',
                'estado' => 'abierta',
                'max' => 2,
                'pago' => 13500,
                'perfiles' => [$perfilNegocio->perfil_id]
            ],
            [
                'empresa_id' => $empresa1->empresa_id, // Tech Solutions
                'titulo' => 'Desarrollador de Inteligencia Artificial',
                'descripcion' => 'Implementación de modelos de machine learning para soluciones empresariales.',
                'ubicacion' => 'Híbrido (CDMX)',
                'tipo' => 'residencia',
                'estado' => 'abierta',
                'max' => 3,
                'pago' => 18000,
                'perfiles' => [$perfilSeguridadInfo->perfil_id]
            ],

            // 2. Especialista en IoT (Perfil Electrónica)
            [
                'empresa_id' => $empresa4->empresa_id, // Seguridad Digital
                'titulo' => 'Ingeniero en IoT para Seguridad',
                'descripcion' => 'Desarrollo de sistemas IoT para monitoreo de seguridad física.',
                'ubicacion' => 'Ciudad de México',
                'tipo' => 'residencia',
                'estado' => 'abierta',
                'max' => 2,
                'pago' => 16000,
                'perfiles' => [$perfilAutoma->perfil_id]
            ],

            // 3. Consultor en Transformación Digital (Perfil Admin)
            [
                'empresa_id' => $empresa3->empresa_id, // Logística Global
                'titulo' => 'Consultor en Transformación Digital',
                'descripcion' => 'Implementación de estrategias digitales en operaciones logísticas.',
                'ubicacion' => 'Guadalajara',
                'tipo' => 'residencia',
                'estado' => 'pendiente',
                'max' => 1,
                'pago' => 15000,
                'perfiles' => [$perfilNegocio->perfil_id]
            ],

            // 4. Técnico en Mantenimiento Robótico (Perfil Mecatrónica)
            [
                'empresa_id' => $empresa2->empresa_id, // Industrial Corp
                'titulo' => 'Técnico en Mantenimiento de Robots',
                'descripcion' => 'Mantenimiento preventivo y correctivo a brazos robóticos industriales.',
                'ubicacion' => 'Monterrey',
                'tipo' => 'practicas',
                'estado' => 'abierta',
                'max' => 4,
                'pago' => 9500,
                'perfiles' => [$perfilMAutomo->perfil_id]
            ],

            // 5. Auditor de Sistemas (Perfil Ciberseguridad)
            [
                'empresa_id' => $empresa4->empresa_id, // Seguridad Digital
                'titulo' => 'Auditor de Sistemas',
                'descripcion' => 'Realización de auditorías de seguridad informática y pruebas de penetración.',
                'ubicacion' => 'Remoto',
                'tipo' => 'residencia',
                'estado' => 'abierta',
                'max' => 2,
                'pago' => 17000,
                'perfiles' => [$perfilCiberseguridad->perfil_id]
            ],

            // 6. Analista de Datos Logísticos (Perfil Industrial)
            [
                'empresa_id' => $empresa3->empresa_id, // Logística Global
                'titulo' => 'Analista de Datos Logísticos',
                'descripcion' => 'Análisis de big data para optimización de rutas de transporte.',
                'ubicacion' => 'Guadalajara',
                'tipo' => 'residencia',
                'estado' => 'abierta',
                'max' => 3,
                'pago' => 14000,
                'perfiles' => [$perfilLogistica->perfil_id]
            ],

            // 7. Desarrollador Blockchain (Perfil Sistemas)
            [
                'empresa_id' => $empresa1->empresa_id, // Tech Solutions
                'titulo' => 'Desarrollador Blockchain',
                'descripcion' => 'Creación de contratos inteligentes y soluciones descentralizadas.',
                'ubicacion' => 'Remoto',
                'tipo' => 'residencia',
                'estado' => 'abierta',
                'max' => 2,
                'pago' => 20000,
                'perfiles' => [$perfilSoftware->perfil_id]
            ],

            // 8. Coordinador de Proyectos Internacionales (Perfil Admin)
            [
                'empresa_id' => $empresa2->empresa_id, // Industrial Corp
                'titulo' => 'Coordinador de Proyectos Globales',
                'descripcion' => 'Gestión de proyectos de manufactura con equipos internacionales.',
                'ubicacion' => 'Monterrey',
                'tipo' => 'residencia',
                'estado' => 'abierta',
                'max' => 1,
                'pago' => 16000,
                'perfiles' => [$perfilAdmin->perfil_id]
            ]

        ];
        
        foreach ($vacantes as $vacanteData) {
            $perfiles = $vacanteData['perfiles'];
            unset($vacanteData['perfiles']);

            $vacante = Vacante::create($vacanteData);
            $vacante->perfiles()->attach($perfiles);
        }
    }
}
