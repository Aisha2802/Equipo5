<?php

namespace Database\Seeders;

use App\Models\Encuesta;
use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\Vinculacion\Aspirante;
use App\Models\Vinculacion\Empresa;
use Illuminate\Database\Seeder;

class RespuestasSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener todas las encuestas activas
        $encuestas = Encuesta::where('habilitada', true)->get();
        
        // Obtener aspirantes y empresas
        $aspirantes = Aspirante::all();
        $empresas = Empresa::all();

        // Generar respuestas para cada encuesta
        foreach ($encuestas as $encuesta) {
            $preguntas = Pregunta::where('encuesta_id', $encuesta->encuesta_id)->get();
            
            if ($encuesta->tipo === 'estudiante') {
                // Respuestas de estudiantes
                foreach ($aspirantes as $aspirante) {
                    foreach ($preguntas as $pregunta) {
                        Respuesta::create([
                            'pregunta_id' => $pregunta->pregunta_id,
                            'aspirante_id' => $aspirante->aspirante_id,
                            'empresa_id' => null,
                            'respuesta' => $this->generarRespuestaEstudiante($pregunta, $encuesta),
                        ]);
                    }
                }
            } else {
                // Respuestas de empresas
                foreach ($empresas as $empresa) {
                    foreach ($preguntas as $pregunta) {
                        Respuesta::create([
                            'pregunta_id' => $pregunta->pregunta_id,
                            'aspirante_id' => null,
                            'empresa_id' => $empresa->empresa_id,
                            'respuesta' => $this->generarRespuestaEmpresa($pregunta, $encuesta),
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Genera respuestas realistas para estudiantes
     */
    protected function generarRespuestaEstudiante($pregunta, $encuesta)
    {
        $esFinal = str_contains($encuesta->titulo, 'Final');
        
        switch ($pregunta->tipo) {
            case 'rango':
                // Para encuestas finales, las calificaciones suelen ser más altas
                $min = $esFinal ? 3 : 1;
                return (string) rand($min, 5);
                
            case 'texto':
                if ($esFinal) {
                    $respuestasPosibles = [
                        "La experiencia fue muy enriquecedora, aprendí mucho",
                        "Sugeriría más seguimiento por parte de los tutores",
                        "Me gustaría más práctica en áreas específicas",
                        "Excelente programa, lo recomendaría",
                        "Podrían mejorar los recursos disponibles"
                    ];
                } else {
                    $respuestasPosibles = [
                        "Hasta ahora todo bien",
                        "Necesito más apoyo en algunas áreas",
                        "Estoy satisfecho con el progreso",
                        "Las instalaciones podrían mejorar",
                        "Los profesores son muy buenos"
                    ];
                }
                return $respuestasPosibles[array_rand($respuestasPosibles)];
                
            default:
                return "Respuesta estándar";
        }
    }

    /**
     * Genera respuestas realistas para empresas
     */
    protected function generarRespuestaEmpresa($pregunta, $encuesta)
    {
        $esFinal = str_contains($encuesta->titulo, 'Final');
        
        switch ($pregunta->tipo) {
            case 'rango':
                // Las empresas suelen dar calificaciones más conservadoras
                $min = $esFinal ? 2 : 1;
                return (string) rand($min, $esFinal ? 5 : 4);
                
            case 'texto':
                if ($esFinal) {
                    $respuestasPosibles = [
                        "El estudiante mostró un excelente desempeño",
                        "Sugerimos más formación en habilidades blandas",
                        "El programa académico prepara bien a los estudiantes",
                        "El estudiante evolucionó positivamente durante la estancia",
                        "Recomendaríamos ajustar algunas áreas del plan de estudios"
                    ];
                } else {
                    $respuestasPosibles = [
                        "El desempeño es aceptable hasta ahora",
                        "El estudiante necesita mejorar en algunas áreas",
                        "Buena adaptación al entorno laboral",
                        "Muestra iniciativa en las tareas asignadas",
                        "Se integra bien con el equipo de trabajo"
                    ];
                }
                return $respuestasPosibles[array_rand($respuestasPosibles)];
                
            default:
                return "Respuesta estándar";
        }
    }
}