<?php

namespace App\Livewire\Vinculacion;

use Livewire\Component;
use App\Models\Encuesta;
use App\Models\Pregunta;
use App\Models\Respuesta;
use Illuminate\Support\Facades\Auth;

class EncuestasComponent extends Component
{
    public $encuestas;
    public $encuestaSeleccionadaId = null;
    public $preguntas = [];
    public $respuestas = [];
    public $encuestaYaContestada = false;
    public $erroresValidacion = []; // Para almacenar errores de validación

    public function mount()
    {
        $user = Auth::user();

        if ($user->role === 'aspirante') {
            // Determinar si es estudiante o egresado
            $tipoEncuesta = $user->aspirante->estado === 'egresado' ? 'egresado' : 'estudiante';

            $this->encuestas = Encuesta::where('habilitada', true)
                ->where('tipo', $tipoEncuesta)
                ->get();
        } elseif ($user->role === 'empresa') {
            $this->encuestas = Encuesta::where('habilitada', true)
                ->where('tipo', 'empresa')
                ->get();
        } elseif ($user->role === 'admin') {
            $this->encuestas = Encuesta::where('habilitada', true)->get();
        } else {
            $this->encuestas = [];
        }
    }

    public function updatedEncuestaSeleccionadaId()
    {
        $this->resetValidation();

        if (!$this->encuestaSeleccionadaId) {
            $this->preguntas = [];
            $this->respuestas = [];
            $this->encuestaYaContestada = false;
            return;
        }

        $user = Auth::user();
        $yaContestada = false;

        if ($user->role === 'aspirante' && $user->aspirante) {
            $preguntasIds = Pregunta::where('encuesta_id', $this->encuestaSeleccionadaId)
                ->pluck('pregunta_id');

            $respuestasCount = Respuesta::where('aspirante_id', $user->aspirante->aspirante_id)
                ->whereIn('pregunta_id', $preguntasIds)
                ->count();

            $yaContestada = $respuestasCount > 0;
        } elseif ($user->role === 'empresa' && $user->empresa) {
            $preguntasIds = Pregunta::where('encuesta_id', $this->encuestaSeleccionadaId)
                ->pluck('pregunta_id');

            $respuestasCount = Respuesta::where('empresa_id', $user->empresa->empresa_id)
                ->whereIn('pregunta_id', $preguntasIds)
                ->count();

            $yaContestada = $respuestasCount > 0;
        }

        $this->encuestaYaContestada = $yaContestada;

        if ($yaContestada) {
            $this->preguntas = [];
            $this->respuestas = [];
            return;
        }

        $this->preguntas = Pregunta::where('encuesta_id', $this->encuestaSeleccionadaId)
            ->orderBy('pregunta_id', 'asc')
            ->get();

        $this->respuestas = [];
        foreach ($this->preguntas as $pregunta) {
            $this->respuestas[$pregunta->pregunta_id] = null;
        }
    }

    public function guardarRespuestas()
    {
        $this->erroresValidacion = [];
        $user = Auth::user();
        $ultimaPreguntaId = $this->preguntas->last()->pregunta_id ?? null;

        // Validar que todas las preguntas (excepto posiblemente la última) tengan respuesta
        foreach ($this->preguntas as $pregunta) {
            // Si es la última pregunta y es de tipo texto, la consideramos opcional
            if ($pregunta->pregunta_id === $ultimaPreguntaId && $pregunta->tipo === 'texto') {
                continue;
            }

            if (empty($this->respuestas[$pregunta->pregunta_id])) {
                $this->erroresValidacion[$pregunta->pregunta_id] = 'Esta pregunta es obligatoria';
            }
        }

        if (!empty($this->erroresValidacion)) {
            session()->flash('error', 'Por favor completa todas las preguntas obligatorias.');
            return;
        }

        // Guardar respuestas
        foreach ($this->respuestas as $preguntaId => $respuesta) {
            // Solo guardar si hay respuesta (para la opcional)
            if ($respuesta !== null) {
                Respuesta::create([
                    'pregunta_id' => $preguntaId,
                    'aspirante_id' => $user->role === 'aspirante' ? $user->aspirante->aspirante_id : null,
                    'empresa_id' => $user->role === 'empresa' ? $user->empresa->empresa_id : null,
                    'respuesta' => $respuesta,
                ]);
            }
        }

        // Limpiar formulario
        $this->respuestas = [];
        $this->preguntas = [];
        $this->encuestaYaContestada = false;
        $this->encuestaSeleccionadaId = null;

        session()->flash('message', 'Respuestas guardadas correctamente.');
    }

    public function render()
    {
        return view('livewire.vinculacion.encuestas-component');
    }
}
