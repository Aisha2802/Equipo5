<?php

namespace App\Livewire\Vinculacion;

use Livewire\Component;
use App\Models\Encuesta;
use App\Models\Pregunta;
use App\Models\Respuesta;
use Illuminate\Support\Facades\DB;

class AltaEncuestasComponent extends Component
{
    public $filtroTipo = 'todos';
    public $encuestas = [];
    public $contadorRespuestas = [];

    public function mount()
    {
        $this->cargarEncuestas();
    }

    public function cargarEncuestas()
    {

        $query = Encuesta::query();


        if ($this->filtroTipo !== 'todos') {
            $query->where('tipo', $this->filtroTipo);
        }


        $query->orderBy('encuesta_id', 'asc');


        $this->encuestas = $query->get();


        $this->contarRespuestas();
    }

    public function contarRespuestas()
    {
        $this->contadorRespuestas = [];

        foreach ($this->encuestas as $encuesta) {
            $preguntasIds = Pregunta::where('encuesta_id', $encuesta->encuesta_id)
                ->pluck('pregunta_id')
                ->toArray();

            if (empty($preguntasIds)) {
                $this->contadorRespuestas[$encuesta->encuesta_id] = 0;
                continue;
            }

            // Modificar esta parte para incluir egresados
            if ($encuesta->tipo === 'estudiante' || $encuesta->tipo === 'egresado') {
                $count = DB::table('respuestas')
                    ->whereIn('pregunta_id', $preguntasIds)
                    ->whereNotNull('aspirante_id')
                    ->select('aspirante_id')
                    ->distinct()
                    ->count('aspirante_id');
            } else {
                $count = DB::table('respuestas')
                    ->whereIn('pregunta_id', $preguntasIds)
                    ->whereNotNull('empresa_id')
                    ->select('empresa_id')
                    ->distinct()
                    ->count('empresa_id');
            }

            $this->contadorRespuestas[$encuesta->encuesta_id] = $count;
        }
    }

    public function cambiarFiltro($tipo)
    {
        $this->filtroTipo = $tipo;
        $this->cargarEncuestas();
    }

    public function toggleHabilitada($encuestaId)
    {
        $encuesta = Encuesta::find($encuestaId);
        if ($encuesta) {
            $encuesta->habilitada = !$encuesta->habilitada;
            $encuesta->save();


            $this->cargarEncuestas();

            $estado = $encuesta->habilitada ? 'habilitada' : 'deshabilitada';
            session()->flash('message', "Encuesta {$estado} correctamente.");
        }
    }

    public function render()
    {
        return view('livewire.vinculacion.alta-encuestas-component');
    }
}
