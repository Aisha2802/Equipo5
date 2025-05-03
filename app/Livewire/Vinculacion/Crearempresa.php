<?php

namespace App\Livewire\Vinculacion;

use Livewire\Component;
use App\Models\Vinculacion\Empresa;

class Crearempresa extends Component
{
    // Propiedades para el formulario
    public $RFC;
    public $nombreComercial;
    public $razonSocial;
    public $giro;
    public $noEmpleado;
    public $codigoPostal;
    public $colonia;
    public $ciudad;
    public $estado;
    public $pais;
    public $sitioWeb;

    // Método para guardar la empresa
    public function guardarEmpresa()
    {
        // Validar los datos del formulario
        $this->validate([
            'RFC' => 'required|string|max:13',
            'nombreComercial' => 'required|string|max:255',
            'razonSocial' => 'required|string|max:255',
            'giro' => 'required|string|max:255',
            'noEmpleado' => 'required|integer|min:1',
            'codigoPostal' => 'required|string|max:5',
            'colonia' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'pais' => 'required|string|max:255',
            'sitioWeb' => 'nullable|url|max:255',
        ]);

        // Crear la empresa en la base de datos
        Empresa::create([
            'RFC' => $this->RFC,
            'nombreComercial' => $this->nombreComercial,
            'razonSocial' => $this->razonSocial,
            'giro' => $this->giro,
            'noEmpleado' => $this->noEmpleado,
            'codigoPostal' => $this->codigoPostal,
            'colonia' => $this->colonia,
            'ciudad' => $this->ciudad,
            'estado' => $this->estado,
            'pais' => $this->pais,
            'sitioWeb' => $this->sitioWeb,
        ]);

        // Limpiar el formulario después de guardar
        $this->reset([
            'RFC',
            'nombreComercial',
            'razonSocial',
            'giro',
            'noEmpleado',
            'codigoPostal',
            'colonia',
            'ciudad',
            'estado',
            'pais',
            'sitioWeb',
        ]);

        // Mostrar un mensaje de éxito
        session()->flash('success', 'La empresa se ha creado correctamente.');
    }

    public function render()
    {
        return view('livewire.vinculacion.crearempresa');
    }
}