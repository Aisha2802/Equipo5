<?php

namespace App\Livewire\Vinculacion;

use App\Models\Vinculacion\Documento;
use App\Models\Vinculacion\Seguimiento;
use App\Models\Vinculacion\Tipo;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Documentos extends Component
{
    /** @var Collection|Tipo[] Lista de tipos de documentos */
    public $tipos;

    /** @var bool Controla la visibilidad del modal */
    public $modalA = false;

    /** @var int Almacena el tipo de documento seleccionado */
    public $tipoSeleccionado;

    /** @var string Almacena el link del archivo */
    public $link;

    /** @var array Almacena el estado de cada tipo de documento */
    public $estados = [];

    /** @var array Almacena los seguimientos de cada tipo de documento */
    public $seguimientos = [];

    /** @var Collection|Tipo[] Almacena los tipos de documentos que deben mostrarse */
    public $tiposVisibles;

    /** @var bool Controla la visibilidad del modal de edición */
    public $modalD = false;

    /** @var int Almacena el ID del documento seleccionado para edición */
    public $documentoId;

    public function mount()
    {
        // Obtener todos los tipos de documentos ordenados por ID (o por el orden que desees)
        $this->tipos = Tipo::orderBy('id')->get();

        // Inicializar $tiposVisibles como una colección vacía
        $this->tiposVisibles = collect();

        // Obtener el aspirante asociado al usuario autenticado
        $aspirante = Auth::user()->aspirante;

        if ($aspirante) {
            // Cargar el estado y los seguimientos de cada tipo de documento
            foreach ($this->tipos as $tipo) {
                $seguimiento = Seguimiento::where('aspirante_id', $aspirante->aspirante_id)
                    ->where('tipo_id', $tipo->id)
                    ->first();

                if ($seguimiento) {
                    $this->estados[$tipo->id] = $seguimiento->estado; // Estado del documento
                    $this->seguimientos[$tipo->id] = $seguimiento; // Seguimiento del documento
                } else {
                    $this->estados[$tipo->id] = 'no_subido'; // Si no hay seguimiento, el archivo no se ha subido
                    $this->seguimientos[$tipo->id] = null; // No hay seguimiento
                }
            }

            // Determinar qué tipos de documentos deben mostrarse
            $this->determinarTiposVisibles();
        }
    }

    // Método para determinar qué tipos de documentos deben mostrarse
    public function determinarTiposVisibles()
    {
        // Limpiar la colección antes de actualizarla
        $this->tiposVisibles = collect();

        $aspirante = Auth::user()->aspirante;

        // El CV siempre se muestra
        $this->tiposVisibles->push($this->tipos->first()); // Asumiendo que el CV es el primer tipo

        if ($aspirante->estado === 'egresado') {
            return;
        }
        // Recorrer los tipos de documentos en orden
        foreach ($this->tipos as $index => $tipo) {
            // Si no es el primer tipo (CV), verificar si el tipo anterior fue aceptado
            if ($index > 0) {
                $tipoAnterior = $this->tipos[$index - 1];
                if ($this->estados[$tipoAnterior->id] === 'aceptado') {
                    $this->tiposVisibles->push($tipo); // Mostrar el tipo actual
                } else {
                    break; // Detener el bucle si el tipo anterior no fue aceptado
                }
            }
        }
    }


    // Método para abrir el modal
    public function abrirModal($tipoId)
    {
        // Verificar si el usuario ya ha subido un documento de este tipo
        if ($this->estados[$tipoId] !== 'no_subido') {
            session()->flash('error', 'Ya has subido un documento de este tipo.');
            return;
        }

        $this->tipoSeleccionado = $tipoId; // Guardar el ID del tipo de documento seleccionado
        $this->modalA = true; // Abrir el modal
    }

    // Método para cerrar el modal
    public function cerrarModal()
    {
        $this->reset(['tipoSeleccionado', 'link', 'modalA']); // Limpiar las propiedades
    }

    // Método para guardar el link del archivo
    public function guardarLink()
    {
        // Validar que el link no esté vacío y sea una URL válida
        $this->validate([
            'link' => 'required|url',
        ]);

        $aspirante = Auth::user()->aspirante;

        $seguimientoExistente = Seguimiento::where('aspirante_id', $aspirante->aspirante_id)
            ->where('tipo_id', $this->tipoSeleccionado)
            ->exists();

        if ($seguimientoExistente) {
            session()->flash('error', 'Ya has subido un documento de este tipo.');
            return;
        }

        // Crear el documento
        $documento = Documento::create([
            'link' => $this->link,
            'aspirante_id' => $aspirante->aspirante_id,
        ]);

        // Crear el seguimiento
        Seguimiento::create([
            'aspirante_id' => $aspirante->aspirante_id,
            'documento_id' => $documento->id,
            'tipo_id' => $this->tipoSeleccionado,
            'estado' => 'pendiente',
        ]);

        // Recargar estados y seguimientos
        $this->mount(); // Recargar datos para evitar duplicados

        // Cerrar el modal y limpiar los campos
        $this->cerrarModal();

        session()->flash('success', 'El documento se ha subido correctamente.');
    }


    // Método para editar el documento (cambiar el estado a "pendiente")
    public function editarDocumento($tipoId)
    {
        // Obtener el seguimiento del documento
        $seguimiento = $this->seguimientos[$tipoId];

        if ($seguimiento) {
            // Cambiar el estado del seguimiento a "pendiente"
            $seguimiento->estado = 'pendiente';
            $seguimiento->save();

            // Actualizar el estado en la propiedad
            $this->estados[$tipoId] = 'pendiente';

            // Mostrar un mensaje de éxito
            session()->flash('success', 'El documento se ha marcado como pendiente para revisión.');
        } else {
            // Mostrar un mensaje de error si no se encuentra el seguimiento
            session()->flash('error', 'No se encontró el documento.');
        }
    }

    public function prepareD($tipoId)
    {
        try {
            $aspiranteId = Auth::user()->aspirante->aspirante_id;

            // Obtener el seguimiento para este tipo de documento
            $seguimiento = Seguimiento::where('aspirante_id', $aspiranteId)
                ->where('tipo_id', $tipoId)
                ->with('documento')
                ->firstOrFail();

            // Configurar propiedades para el modal
            $this->documentoId = $seguimiento->documento->id;
            $this->link = $seguimiento->documento->link;
            $this->tipoSeleccionado = $tipoId;
            $this->modalD = true;
        } catch (\Exception $e) {
            session()->flash('error', 'No se encontró el documento para editar');
        }
    }

    public function actualizarLink()
    {
        $this->validate([
            'link' => 'required|url',
        ], [
            'link.required' => 'El campo no puede estar vacío.',
            'link.url' => 'Debe ingresar una URL válida.',
        ]);

        try {
            $documento = Documento::findOrFail($this->documentoId);
            $documento->update([
                'link' => $this->link,
            ]);

            $seguimiento = Seguimiento::where('documento_id', $this->documentoId)
                ->where('tipo_id', $this->tipoSeleccionado)
                ->firstOrFail();

            $seguimiento->update([
                'estado' => 'pendiente'
            ]);

            $this->estados[$this->tipoSeleccionado] = 'pendiente';
            $this->cerrarModalD();
            session()->flash('success', 'El link se ha actualizado correctamente.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar el link: ' . $e->getMessage());
        }
    }


    public function cerrarModalD()
    {
        $this->reset(['modalD', 'documentoId', 'link', 'tipoSeleccionado']);
    }


    public function render()
    {
        return view('livewire.vinculacion.documentos');
    }
}
