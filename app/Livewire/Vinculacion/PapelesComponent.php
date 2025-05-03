<?php

namespace App\Livewire\Vinculacion;

use App\Models\Vinculacion\Seguimiento;
use Livewire\Component;

class PapelesComponent extends Component
{
    public $seguimientos; // Lista de seguimientos con estado pendiente

    public function mount()
    {
        // Obtener los seguimientos con estado "pendiente" y cargar las relaciones necesarias
        $this->seguimientos = Seguimiento::with(['aspirante', 'documento', 'tipo'])
            ->where('estado', 'pendiente')
            ->get();
    }

    // Método para aceptar un documento
    public function aceptarDocumento($seguimientoId)
    {
        $seguimiento = Seguimiento::find($seguimientoId);

        if ($seguimiento) {
            $seguimiento->estado = 'aceptado'; // Cambiar el estado a "aceptado"
            $seguimiento->save();

            // Actualizar la lista de seguimientos
            $this->mount();
        }
    }

    // Método para rechazar un documento
    public function rechazarDocumento($seguimientoId)
    {
        $seguimiento = Seguimiento::find($seguimientoId);

        if ($seguimiento) {
            $seguimiento->estado = 'rechazado'; // Cambiar el estado a "rechazado"
            $seguimiento->save();

            // Actualizar la lista de seguimientos
            $this->mount();
        }
    }

    public function render()
    {
        return view('livewire.vinculacion.papeles-component');
    }
}