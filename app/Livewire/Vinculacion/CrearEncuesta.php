<?php

namespace App\Livewire\Vinculacion;

use Livewire\Component;
use App\Models\Encuesta;
use App\Models\Pregunta;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CrearEncuesta extends Component
{
    public $titulo;
    public $descripcion;
    public $tipo = 'estudiante';
    public $preguntas = [];
    public $habilitada = false;
    public $mostrarExito = false;
    public $showSuccessNotification = false;
    public $showErrorNotification = false;
    public $notificationMessage = '';

    protected $rules = [
        'titulo' => 'required|string|max:255|unique:encuestas,titulo',
        'descripcion' => 'required|string|max:500',
        'tipo' => 'required|in:estudiante,empresa,egresado',
        'preguntas.*.texto' => 'required|string|max:255',
        'preguntas.*.tipo' => 'required|in:rango,texto',
    ];

    public function mount()
    {
        // Inicializar con 10 preguntas (9 de rango y 1 de texto oculta)
        for ($i = 0; $i < 9; $i++) {
            $this->preguntas[] = [
                'texto' => '',
                'tipo' => 'rango',
                'opciones' => json_encode(['min' => 1, 'max' => 5]),
                'visible' => true // Mostrar al usuario
            ];
        }
        // Última pregunta es de texto (comentario) - oculta
        $this->preguntas[] = [
            'texto' => 'Comentarios adicionales',
            'tipo' => 'texto',
            'opciones' => null,
            'visible' => false // No mostrar al usuario
        ];
    }



    public function guardarEncuesta()
    {
        // Validar datos básicos
        $this->validate();

        // Verificar preguntas duplicadas
        $preguntasVisibles = array_filter($this->preguntas, fn($p) => $p['visible']);
        $textosPreguntas = array_map('strtolower', array_column($preguntasVisibles, 'texto'));
        $preguntasUnicas = array_unique($textosPreguntas);

        if (count($textosPreguntas) !== count($preguntasUnicas)) {
            // Encontrar los índices de las preguntas duplicadas
            $duplicados = array_diff_assoc($textosPreguntas, $preguntasUnicas);

            foreach ($duplicados as $index => $texto) {
                $this->addError('preguntas.' . $index . '.texto', 'Esta pregunta está duplicada');
            }

            $this->notificationMessage = 'Existen preguntas duplicadas. Por favor corrige los errores.';
            $this->showErrorNotification = true;
            return;
        }

        // Verificar que no haya preguntas vacías (solo las visibles)
        foreach ($this->preguntas as $index => $pregunta) {
            if ($pregunta['visible'] && empty(trim($pregunta['texto']))) {
                $this->addError('preguntas.' . $index . '.texto', 'El texto de la pregunta es requerido');
                $this->notificationMessage = 'Hay preguntas sin texto. Por favor completa todas las preguntas.';
                $this->showErrorNotification = true;
                return;
            }
        }

        // Crear la encuesta
        try {
            $encuesta = Encuesta::create([
                'titulo' => $this->titulo,
                'descripcion' => $this->descripcion,
                'tipo' => $this->tipo,
                'habilitada' => false,
            ]);

            // Crear las preguntas 
            foreach ($this->preguntas as $pregunta) {
                Pregunta::create([
                    'encuesta_id' => $encuesta->encuesta_id,
                    'texto' => $pregunta['texto'],
                    'tipo' => $pregunta['tipo'],
                    'opciones' => $pregunta['tipo'] === 'rango' ? json_encode(['min' => 1, 'max' => 5]) : null,
                ]);
            }

            // Mostrar mensaje de éxito y resetear formulario
            $this->mostrarExito = true;
            $this->showSuccessNotification = true;
            $this->notificationMessage = 'Encuesta creada exitosamente!';
            $this->reset(['titulo', 'descripcion', 'tipo', 'preguntas']);
            $this->mount(); // Reiniciar preguntas

        } catch (\Exception $e) {
            $this->notificationMessage = 'Error al crear la encuesta: ' . $e->getMessage();
            $this->showErrorNotification = true;
        }
    }

    public function updatedTitulo($value)
    {
        $this->validateOnly('titulo');
    }

    public function updatedPreguntas()
    {
        // Limpiar errores de duplicados al modificar preguntas
        $this->resetErrorBag();
        $this->showErrorNotification = false;
    }

    public function render()
    {
        return view('livewire.vinculacion.crear-encuesta');
    }
}
