<?php

namespace Database\Seeders;

use App\Models\Encuesta;
use App\Models\Pregunta;
use Illuminate\Database\Seeder;

class EncuestasSeeder extends Seeder
{
    public function run(): void
    {
        // ========== ENCUESTAS PARA ESTUDIANTES ==========

        // 1. Encuesta para estudiantes - Proceso en curso
        $encuestaEstudiante1 = Encuesta::create([
            'titulo' => 'Evaluación del Proceso de Estancia (En curso)',
            'descripcion' => 'Encuesta para evaluar cómo va el proceso de estancia hasta el momento.',
            'tipo' => 'estudiante',
            'habilitada' => true,
        ]);

        $preguntasEstudiante1 = [
            ['texto' => '¿Cómo calificarías la calidad de las instalaciones hasta ahora?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Cómo calificarías la calidad de los profesores en esta etapa?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Cómo calificarías el plan de estudios que estás cursando?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Cómo calificarías la atención administrativa recibida hasta ahora?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Cómo calificarías las oportunidades de vinculación que has tenido?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Estás satisfecho con el apoyo recibido por parte de tu tutor académico?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Consideras que estás adquiriendo habilidades útiles para tu futuro profesional?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Cómo calificarías la comunicación con la institución durante el proceso?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Qué tan satisfecho estás con el proceso hasta ahora?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Qué aspectos consideras que podrían mejorar en esta etapa del proceso?', 'tipo' => 'texto', 'opciones' => null],
        ];

        foreach ($preguntasEstudiante1 as $pregunta) {
            Pregunta::create([
                'encuesta_id' => $encuestaEstudiante1->encuesta_id,
                'texto' => $pregunta['texto'],
                'tipo' => $pregunta['tipo'],
                'opciones' => $pregunta['opciones'],
            ]);
        }

        // 2. Encuesta para estudiantes - Proceso finalizado
        $encuestaEstudiante2 = Encuesta::create([
            'titulo' => 'Evaluación Final del Proceso de Estancia',
            'descripcion' => 'Encuesta para evaluar cómo fue el proceso completo de estancia.',
            'tipo' => 'estudiante',
            'habilitada' => true,
        ]);

        $preguntasEstudiante2 = [
            ['texto' => '¿Cómo calificarías la calidad general de las instalaciones durante toda tu estancia?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Cómo calificarías la calidad general de los profesores durante todo el programa?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Cómo calificarías el plan de estudios completo que cursaste?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Consideras que la experiencia adquirida cumplió con tus expectativas profesionales?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Cómo calificarías las oportunidades de vinculación que tuviste durante todo el proceso?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Qué tan preparado te sientes para el campo laboral después de esta experiencia?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Recomendarías este programa a otros estudiantes?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Cómo calificarías el acompañamiento institucional durante todo el proceso?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Qué tan satisfecho estás con el proceso completo?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Qué sugerencias tienes para mejorar el programa para futuros estudiantes?', 'tipo' => 'texto', 'opciones' => null],
        ];

        foreach ($preguntasEstudiante2 as $pregunta) {
            Pregunta::create([
                'encuesta_id' => $encuestaEstudiante2->encuesta_id,
                'texto' => $pregunta['texto'],
                'tipo' => $pregunta['tipo'],
                'opciones' => $pregunta['opciones'],
            ]);
        }

        // ========== ENCUESTAS PARA EMPRESAS ==========

        // 1. Encuesta para empresas - Proceso en curso
        $encuestaEmpresa1 = Encuesta::create([
            'titulo' => 'Evaluación del Desempeño del Estudiante (En curso)',
            'descripcion' => 'Encuesta para evaluar el desempeño del estudiante durante el proceso actual.',
            'tipo' => 'empresa',
            'habilitada' => true,
        ]);

        $preguntasEmpresa1 = [
            ['texto' => '¿Cómo calificarías el desempeño general del estudiante hasta ahora?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Cómo calificarías la puntualidad del estudiante en esta etapa?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Cómo calificarías la responsabilidad del estudiante hasta el momento?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Cómo calificarías la capacidad de trabajo en equipo del estudiante?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Cómo calificarías la iniciativa del estudiante en las tareas asignadas?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Consideras que el estudiante está adquiriendo las habilidades necesarias?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Cómo calificarías la comunicación del estudiante con el equipo de trabajo?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Cómo calificarías la adaptabilidad del estudiante al entorno laboral?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Estás satisfecho con el desempeño general del estudiante hasta ahora?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Qué aspectos consideras que el estudiante debería mejorar en esta etapa?', 'tipo' => 'texto', 'opciones' => null],
        ];

        foreach ($preguntasEmpresa1 as $pregunta) {
            Pregunta::create([
                'encuesta_id' => $encuestaEmpresa1->encuesta_id,
                'texto' => $pregunta['texto'],
                'tipo' => $pregunta['tipo'],
                'opciones' => $pregunta['opciones'],
            ]);
        }

        // 2. Encuesta para empresas - Proceso finalizado
        $encuestaEmpresa2 = Encuesta::create([
            'titulo' => 'Evaluación Final del Desempeño del Estudiante',
            'descripcion' => 'Encuesta para evaluar el desempeño completo del estudiante al finalizar el proceso.',
            'tipo' => 'empresa',
            'habilitada' => true,
        ]);

        $preguntasEmpresa2 = [
            ['texto' => '¿Cómo calificarías el desempeño general del estudiante durante todo el proceso?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Cómo calificarías la puntualidad y asistencia del estudiante durante toda su estancia?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Cómo calificarías el cumplimiento de objetivos y metas asignadas?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Cómo calificarías la integración del estudiante con el equipo de trabajo?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Consideras que el estudiante desarrolló habilidades profesionales durante su estancia?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Cómo calificarías la capacidad del estudiante para resolver problemas?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Contratarías o recomendarías al estudiante para un puesto profesional?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Cómo calificarías la preparación académica del estudiante para el entorno laboral?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Qué tan satisfecho estás con la colaboración general del estudiante?', 'tipo' => 'rango', 'opciones' => json_encode(['min' => 1, 'max' => 5])],
            ['texto' => '¿Qué sugerencias tienes para mejorar la formación de futuros estudiantes?', 'tipo' => 'texto', 'opciones' => null],
        ];

        foreach ($preguntasEmpresa2 as $pregunta) {
            Pregunta::create([
                'encuesta_id' => $encuestaEmpresa2->encuesta_id,
                'texto' => $pregunta['texto'],
                'tipo' => $pregunta['tipo'],
                'opciones' => $pregunta['opciones'],
            ]);
        }
    }
}