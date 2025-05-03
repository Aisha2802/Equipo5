<?php

namespace App\Livewire\Vinculacion;

use Livewire\Component;
use App\Models\Vinculacion\Empresa;
use App\Models\Vinculacion\Perfil;
use App\Models\Vinculacion\Vacante;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class ControlVacante extends Component
{
    public $empresa; // Variable pública para la empresa
    public $vacantes; // Variable pública para las vacantes
    public $filtroTipo = '';
    public $filtroEstado = '';
    public $modal = false, $title = '';
    public $modalE = false, $titleE = '';
    public $modalV = false, $titleV = '';

    public $titulo, $descripcion, $ubicacion, $tipo, $perfil_id, $max, $pago;
    public $perfiles;

    public $tituloV, $descripcionV, $ubicacionV, $tipoV, $estadoV, $maxV, $pagoV, $carreraV, $especialidadV; // Propiedades para los datos de la vacante

    // Propiedades para el formulario de edición
    public $vacante_id; // ID de la vacante que se está editando
    public $tituloE, $descripcionE, $ubicacionE, $tipoE, $perfil_idE, $maxE, $pagoE;

    public function mount()
    {
        // Verificar si el usuario autenticado es una empresa
        if (Auth::check() && Auth::user()->role === 'empresa') {
            // Obtener la empresa asociada al usuario autenticado
            $this->empresa = Empresa::find(Auth::user()->empresa_id);

            // Obtener las vacantes de la empresa
            if ($this->empresa) {
                $this->vacantes = $this->empresa->vacantes; // Obtener las vacantes de la empresa
            }
            $this->perfiles = Perfil::all();
        }
    }

    public function aplicarFiltro()
    {
        // Filtrar vacantes si hay un estado seleccionado

    }

    public function prepare($id)
    {
        $id = Crypt::decrypt($id);
        $this->title = 'Nueva Vacante';
        $this->modal = true;
    }

    public function prepareV($id)
    {
        $id = Crypt::decrypt($id); // Descifrar el ID de la vacante
        $this->vacante_id = $id; // Guardar el ID de la vacante

        // Obtener la vacante seleccionada
        $vacante = Vacante::find($this->vacante_id);

        // Cargar los datos de la vacante en las propiedades del modal
        $this->tituloV = $vacante->titulo;
        $this->descripcionV = $vacante->descripcion;
        $this->ubicacionV = $vacante->ubicacion;
        $this->tipoV = $vacante->tipo;
        $this->estadoV = $vacante->estado;
        $this->maxV = $vacante->max;
        $this->pagoV = $vacante->pago;
        $perfil = $vacante->perfiles->first();
        $this->carreraV = $perfil->carrera->nombre;  // Accede al nombre de la carrera
        $this->especialidadV = $perfil->especialidad->nombre;


        $this->titleV = 'Información de la Vacante';
        $this->modalV = true; // Abrir el modal
    }

    public function prepareE($id)
    {
        $id = Crypt::decrypt($id);
        $this->vacante_id = $id; // Guardar el ID de la vacante que se está editando

        // Obtener la vacante seleccionada
        $vacante = Vacante::find($this->vacante_id);

        // Cargar los datos de la vacante en las propiedades del formulario de edición
        $this->tituloE = $vacante->titulo;
        $this->descripcionE = $vacante->descripcion;
        $this->ubicacionE = $vacante->ubicacion;
        $this->tipoE = $vacante->tipo;
        $this->perfil_idE = $vacante->perfiles->first()->perfil_id; // Obtener el primer perfil asociado
        $this->maxE = $vacante->max;
        $this->pagoE = $vacante->pago;

        $this->titleE = 'Editar Vacante';
        $this->modalE = true;

    }

    // En el método guardarVacante()
    public function guardarVacante()
    {
        // Validar los datos del formulario
        $this->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'ubicacion' => 'required|string|max:255',
            'tipo' => 'required|in:empleo,residencia',
            'perfil_id' => 'required|exists:perfiles,perfil_id',
            'max' => 'required|numeric',
        ]);

        // Crear la nueva vacante
        $vacante = Vacante::create([
            'empresa_id' => $this->empresa->empresa_id,
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            'ubicacion' => $this->ubicacion,
            'tipo' => $this->tipo,
            'estado' => 'pendiente',
            'max' => $this->max,
            'pago' => $this->pago,
        ]);

        // Asociar el perfil a la vacante
        $vacante->perfiles()->attach($this->perfil_id);

        // Cerrar el modal y resetear el formulario
        $this->modal = false;
        $this->reset(['titulo', 'descripcion', 'ubicacion', 'tipo', 'perfil_id', 'max', 'pago']);

        // Actualizar la lista de vacantes
        $this->vacantes = $this->empresa->vacantes;

        // Mostrar mensaje de éxito
        session()->flash('success', 'Vacante creada exitosamente!');
    }

    // En el método actualizarVacante()
    public function actualizarVacante()
    {
        // Validar los datos del formulario
        $this->validate([
            'tituloE' => 'required|string|max:255',
            'descripcionE' => 'required|string',
            'ubicacionE' => 'required|string|max:255',
            'tipoE' => 'required|in:empleo,residencia',
            'perfil_idE' => 'required|exists:perfiles,perfil_id',
            'maxE' => 'required|numeric',
        ]);

        // Obtener la vacante que se está editando
        $vacante = Vacante::find($this->vacante_id);

        // Actualizar los datos de la vacante
        $vacante->update([
            'titulo' => $this->tituloE, // Corregí un typo aquí (antes decía 'titulo')
            'descripcion' => $this->descripcionE,
            'ubicacion' => $this->ubicacionE,
            'tipo' => $this->tipoE,
            'estado' => 'pendiente', // Cambiar el estado a "pendiente"
            'max' => $this->maxE,
            'pago' => $this->pagoE,
        ]);

        // Actualizar el perfil asociado
        $vacante->perfiles()->sync([$this->perfil_idE]);

        // Cerrar el modal y resetear el formulario
        $this->modalE = false;
        $this->reset(['tituloE', 'descripcionE', 'ubicacionE', 'tipoE', 'perfil_idE', 'maxE', 'pagoE']);

        // Actualizar la lista de vacantes
        $this->vacantes = $this->empresa->vacantes;

        // Mostrar mensaje de éxito
        session()->flash('success', 'Vacante actualizada exitosamente!');
    }

    public function render()
    {
        // Obtener las vacantes de la empresa
        $query = $this->empresa->vacantes();

        // Aplicar filtro por tipo de vacante si está seleccionado
        if ($this->filtroTipo) {
            $query->where('tipo', $this->filtroTipo);
        }

        // Aplicar filtro por estado de vacante si está seleccionado
        if ($this->filtroEstado) {
            $query->where('estado', $this->filtroEstado);
        }

        // Obtener las vacantes filtradas
        $this->vacantes = $query->get();

        return view('livewire.vinculacion.control-vacante', [
            'empresa' => $this->empresa, // Pasar la empresa a la vista
            'vacantes' => $this->vacantes, // Pasar las vacantes filtradas a la vista
        ]);
    }
}
