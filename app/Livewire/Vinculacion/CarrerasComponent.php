<?php

namespace App\Livewire\Vinculacion;
use App\Models\Vinculacion\Carrera;
use Livewire\Component;

class CarrerasComponent extends Component
{
    public $carreras = [];

    public function mount()
    {
        
        $this->carreras = Carrera::with('especialidades')->get();
    }
    public function render()
    {
        return view('livewire.vinculacion.carreras-component', [
            'carreras' => $this->carreras
        ]);
    }
}
