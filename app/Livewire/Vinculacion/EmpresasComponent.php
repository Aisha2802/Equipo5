<?php

namespace App\Livewire\Vinculacion;

use Livewire\Component;
use App\Models\Vinculacion\Empresa;
use App\Models\Vinculacion\Vacante;
use Illuminate\Support\Facades\Crypt;

class EmpresasComponent extends Component
{
    public $empresas;
    public $modal = false, $title = '';
    public $modalE = false, $titleE = '';
    public $modalS = false, $titleS = '';
    public $modalV = false, $titleV = '';
    public $empresaSeleccionada;
    public $vacante_id;
    public $filtroEmpresa = '';
    public $todasLasEmpresas = [];
    // Propiedades para el modal de vacante
    public $tituloV;
    public $descripcionV;
    public $ubicacionV;
    public $tipoV;
    public $estadoV;
    public $maxV;
    public $pagoV;
    public $carreraV;
    public $especialidadV;

    // Propiedad para el filtro de estado
    public $filtroEstado = '';

    public function mount()
    {
        // Cargar todas las empresas
        $this->todasLasEmpresas = Empresa::all();

        // Cargar las empresas con sus vacantes y perfiles
        $this->empresas = Empresa::with(['vacantes.perfiles.carrera', 'vacantes.perfiles.especialidad'])->get();
    }

    public function aplicarFiltro()
    {
        // Obtener todas las empresas con sus vacantes y perfiles
        $query = Empresa::with(['vacantes' => function ($query) {
            // Filtrar vacantes por estado si está seleccionado
            if ($this->filtroEstado) {
                $query->where('estado', $this->filtroEstado);
            }
        }, 'vacantes.perfiles.carrera', 'vacantes.perfiles.especialidad']);

        // Aplicar filtro por nombre de empresa si está seleccionado
        if ($this->filtroEmpresa) {
            $query->where('nombreComercial', 'like', '%' . $this->filtroEmpresa . '%');
        }

        // Obtener las empresas filtradas
        $this->empresas = $query->get();

        // Filtrar empresas que tengan al menos una vacante con el estado seleccionado
        if ($this->filtroEstado) {
            $this->empresas = $this->empresas->filter(function ($empresa) {
                return $empresa->vacantes->isNotEmpty(); // Solo empresas con vacantes que coincidan con el filtro
            });
        }
    }

    public function abrirVacante($vacanteId)
    {
        // Verificar que el ID no esté vacío
        if (empty($vacanteId)) {
            session()->flash('error', 'El ID de la vacante no es válido.');
            return;
        }

        // Buscar la vacante y actualizar su estado
        $vacante = Vacante::findOrFail($vacanteId);
        $vacante->estado = 'abierta';
        $vacante->save();

        // Actualizar la lista de empresas para reflejar el cambio
        $this->empresas = Empresa::with(['vacantes.perfiles.carrera', 'vacantes.perfiles.especialidad'])->get();

        session()->flash('success', 'La vacante se ha abierto.');
    }

    public function cerrarVacante($vacanteId)
    {
        // Verificar que el ID no esté vacío
        if (empty($vacanteId)) {
            session()->flash('error', 'El ID de la vacante no es válido.');
            return;
        }

        // Buscar la vacante y actualizar su estado
        $vacante = Vacante::findOrFail($vacanteId);
        $vacante->estado = 'cerrada';
        $vacante->save();

        // Actualizar la lista de empresas para reflejar el cambio
        $this->empresas = Empresa::with(['vacantes.perfiles.carrera', 'vacantes.perfiles.especialidad'])->get();

        session()->flash('success', 'La vacante se ha cerrado.');
    }

    public function prepare($id)
    {
        $id = Crypt::decrypt($id);
        $this->empresaSeleccionada = Empresa::findOrFail($id);
        $this->title = 'Detalles de la Empresa: ' . $this->empresaSeleccionada->nombreComercial;
        $this->modal = true;
    }

    public function prepareE($id)
    {
        $id = Crypt::decrypt($id);
        $this->empresaSeleccionada = Empresa::findOrFail($id);
        $this->titleE = 'Vacantes de la Empresa: ' . $this->empresaSeleccionada->nombreComercial;
        $this->modalE = true;
    }

    public function prepareS($id)
    {
        $id = Crypt::decrypt($id);
        $empresa = Empresa::findOrFail($id);
        $this->emit('empresaSeleccionada', $empresa);
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

    public function render()
    {
        // Filtrar vacantes si hay un estado seleccionado
        if ($this->filtroEstado) {
            $this->empresas->each(function ($empresa) {
                $empresa->vacantes = $empresa->vacantes->where('estado', $this->filtroEstado);
            });
        }

        return view('livewire.vinculacion.empresas-component', [
            'empresas' => $this->empresas,
        ]);
    }
}
