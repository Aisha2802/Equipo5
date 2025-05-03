<?php

namespace App\Livewire\Vinculacion;

use Livewire\Component;
use App\Models\Encuesta;
use App\Models\Pregunta;
use App\Models\Respuesta;
use Illuminate\Support\Facades\DB;

class EstadisticasComponent extends Component
{
    public $encuestas;
    public $encuestaSeleccionadaId = null;
    public $estadisticas = [];
    public $filtroTipo = 'todos';
    public $totalRespuestasEncuesta = 0;
    public $mostrarMensajeSinDatos = false;
    public $porPagina = 5; 

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

        $this->encuestas = $query->orderBy('encuesta_id')->get();
    }

    public function updatedEncuestaSeleccionadaId()
    {
        $this->generarEstadisticas();
    }

    public function cambiarFiltro($tipo)
    {
        $this->filtroTipo = $tipo;
        $this->cargarEncuestas();
        $this->encuestaSeleccionadaId = null;
        $this->estadisticas = [];
        $this->mostrarMensajeSinDatos = false;
    }

    public function generarEstadisticas()
    {
        $this->reset(['estadisticas', 'totalRespuestasEncuesta', 'mostrarMensajeSinDatos']);

        if (!$this->encuestaSeleccionadaId) {
            return;
        }

        // Contar personas únicas que han respondido la encuesta
        $this->totalRespuestasEncuesta = DB::table('respuestas')
            ->join('preguntas', 'respuestas.pregunta_id', '=', 'preguntas.pregunta_id')
            ->where('preguntas.encuesta_id', $this->encuestaSeleccionadaId)
            ->select(DB::raw('COUNT(DISTINCT COALESCE(aspirante_id, empresa_id)) as total'))
            ->value('total');

        if ($this->totalRespuestasEncuesta === 0) {
            $this->mostrarMensajeSinDatos = true;
            return;
        }

        $preguntas = Pregunta::where('encuesta_id', $this->encuestaSeleccionadaId)->get();
        $estadisticas = [];

        foreach ($preguntas as $pregunta) {
            if ($pregunta->tipo === 'rango') {
                $respuestas = Respuesta::where('pregunta_id', $pregunta->pregunta_id)
                    ->select(
                        DB::raw('AVG(CAST(respuesta AS DECIMAL(10,2))) as promedio'),
                        DB::raw('COUNT(*) as total_respuestas'),
                        DB::raw('SUM(CASE WHEN CAST(respuesta AS INTEGER) = 1 THEN 1 ELSE 0 END) as respuestas_1'),
                        DB::raw('SUM(CASE WHEN CAST(respuesta AS INTEGER) = 2 THEN 1 ELSE 0 END) as respuestas_2'),
                        DB::raw('SUM(CASE WHEN CAST(respuesta AS INTEGER) = 3 THEN 1 ELSE 0 END) as respuestas_3'),
                        DB::raw('SUM(CASE WHEN CAST(respuesta AS INTEGER) = 4 THEN 1 ELSE 0 END) as respuestas_4'),
                        DB::raw('SUM(CASE WHEN CAST(respuesta AS INTEGER) = 5 THEN 1 ELSE 0 END) as respuestas_5')
                    )
                    ->first();

                $estadisticas[] = [
                    'pregunta' => $pregunta->texto,
                    'tipo' => 'rango',
                    'promedio' => number_format($respuestas->promedio ?? 0, 2),
                    'total_respuestas' => $respuestas->total_respuestas ?? 0,
                    'distribucion' => [
                        1 => $respuestas->respuestas_1 ?? 0,
                        2 => $respuestas->respuestas_2 ?? 0,
                        3 => $respuestas->respuestas_3 ?? 0,
                        4 => $respuestas->respuestas_4 ?? 0,
                        5 => $respuestas->respuestas_5 ?? 0,
                    ]
                ];
            } elseif ($pregunta->tipo === 'opcion_multiple') {
                $opciones = json_decode($pregunta->opciones);
                $conteoOpciones = [];

                foreach ($opciones as $opcion) {
                    $count = Respuesta::where('pregunta_id', $pregunta->pregunta_id)
                        ->where('respuesta', $opcion)
                        ->count();
                    $conteoOpciones[$opcion] = $count;
                }

                $total = array_sum($conteoOpciones);

                $estadisticas[] = [
                    'pregunta' => $pregunta->texto,
                    'tipo' => 'opcion_multiple',
                    'opciones' => $conteoOpciones,
                    'total_respuestas' => $total
                ];
            }elseif ($pregunta->tipo === 'texto') {
                $comentarios = Respuesta::where('pregunta_id', $pregunta->pregunta_id)
                    ->whereNotNull('respuesta')
                    ->where('respuesta', '!=', '')
                    ->orderBy('created_at', 'desc')
                    ->get(['respuesta', 'created_at']);
            
                $estadisticas[] = [
                    'pregunta' => $pregunta->texto,
                    'tipo' => 'texto',
                    'comentarios' => $comentarios,
                    'total_respuestas' => $comentarios->count()
                ];
            }
        }

        $this->estadisticas = $estadisticas;
    }

    public function render()
    {
        return view('livewire.vinculacion.estadisticas-component');
    }
}
