<?php

namespace Database\Seeders;

use App\Models\Vinculacion\SolicitudVacante;
use App\Models\Vinculacion\Vacante;
use App\Models\Vinculacion\Aspirante;
use App\Models\Periodo;
use Illuminate\Database\Seeder;

class SolicitudVacanteSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener el período activo
        $periodoActivo = Periodo::where('activo', true)->first();
        
        // Si no hay período activo, usar el primero disponible o crear uno
        if (!$periodoActivo) {
            $periodoActivo = Periodo::first();
            if (!$periodoActivo) {
                $periodoActivo = Periodo::create([
                    'nombre' => 'Enero-Junio 2025',
                    'activo' => true
                ]);
            }
        }

        // Obtener todas las vacantes y aspirantes existentes, excluyendo al aspirante con ID 19
        $vacantes = Vacante::all();
        $aspirantes = Aspirante::where('aspirante_id', '!=', 19)->get();

        // Estados posibles para las solicitudes
        $estados = ['pendiente', 'aceptado', 'rechazado', 'cancelada'];

        // Crear al menos 2 solicitudes por aspirante
        foreach ($aspirantes as $aspirante) {
            // Seleccionar 2 vacantes aleatorias que coincidan con el perfil del aspirante
            $vacantesCompatibles = $vacantes->filter(function($vacante) use ($aspirante) {
                return $vacante->perfiles->contains('perfil_id', $aspirante->user->perfil_id);
            })->take(2);

            foreach ($vacantesCompatibles as $vacante) {
                $estado = $estados[array_rand($estados)];
                
                SolicitudVacante::create([
                    'vacante_id' => $vacante->vacante_id,
                    'aspirante_id' => $aspirante->aspirante_id,
                    'periodo_id' => $periodoActivo->id,
                    'estado' => $estado,
                ]);
            }

            // Si no hay suficientes vacantes compatibles, asignar alguna adicional
            if ($vacantesCompatibles->count() < 2) {
                $vacanteExtra = $vacantes->whereNotIn('vacante_id', $vacantesCompatibles->pluck('vacante_id'))
                                       ->first();
                
                if ($vacanteExtra) {
                    SolicitudVacante::create([
                        'vacante_id' => $vacanteExtra->vacante_id,
                        'aspirante_id' => $aspirante->aspirante_id,
                        'periodo_id' => $periodoActivo->id,
                        'estado' => $estados[array_rand($estados)],
                    ]);
                }
            }
        }

        // Verificar explícitamente que el aspirante 19 no tenga solicitudes
        $aspirante19 = Aspirante::find(19);
        if ($aspirante19) {
            $solicitudesAspirante19 = SolicitudVacante::where('aspirante_id', 19)->count();
            if ($solicitudesAspirante19 > 0) {
                SolicitudVacante::where('aspirante_id', 19)->delete();
            }
        }
    }
}