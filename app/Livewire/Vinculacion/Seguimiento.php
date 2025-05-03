<?php

namespace App\Livewire\Vinculacion;

use Livewire\Component;
use App\Models\Vinculacion\Aspirante;
use App\Models\Vinculacion\Carrera;
use App\Models\Vinculacion\Empresa;
use App\Models\Vinculacion\SolicitudVacante;
use App\Models\Vinculacion\Vacante;
use App\Models\Vinculacion\RegistroSeguimiento;
use App\Models\Vinculacion\Tipo;
use Illuminate\Support\Facades\Crypt;
use App\Models\Periodo;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;

class Seguimiento extends Component
{
    use WithPagination;

    public $modalV = false, $titleV = '';
    public $modal = false, $title = '';
    public $vacante_id;
    public $empresaSeleccionada;
    public $tituloV, $descripcionV, $ubicacionV, $tipoV, $estadoV, $maxV, $pagoV, $carreraV, $especialidadV;
    public $carreras; // Lista de carreras disponibles
    public $search = '';
    public $periodos;
    public $periodoSeleccionado = '';
    public $perPage = 10;
    public $carreraSeleccionada = '';


    public function mount()
    {
        $this->periodos = Periodo::orderBy('nombre', 'desc')->get();
        $this->carreras = Carrera::orderBy('nombre')->get();
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

    public function prepare($id)
    {
        $id = Crypt::decrypt($id);
        $this->empresaSeleccionada = Empresa::findOrFail($id);
        $this->title = 'Detalles de la Empresa: ' . $this->empresaSeleccionada->nombreComercial;
        $this->modal = true;
    }

    public function resetFilters()
    {
        $this->reset(['search', 'periodoSeleccionado','carreraSeleccionada']);
    }

    public function render()
    {
        // Obtener los registros de seguimiento con sus relaciones
        $registrosSeguimiento = RegistroSeguimiento::with([
            'aspirante.user.perfil.carrera',
            'vacante.empresa',
            'seguimientos.tipo',
            'periodo'
        ])
            ->when($this->periodoSeleccionado, function ($query) {
                $query->whereHas('periodo', function ($q) {
                    $q->where('id', $this->periodoSeleccionado);
                });
            })
            ->when($this->carreraSeleccionada, function ($query) {
                $query->whereHas('aspirante.user.perfil.carrera', function ($q) {
                    $q->where('carrera_id', $this->carreraSeleccionada);
                });
            })
            ->when($this->search, function ($query) {
                $query->whereHas('aspirante', function ($q) {
                    $q->where('nombre', 'like', '%' . $this->search . '%')
                        ->orWhere('numero_control', 'like', '%' . $this->search . '%');
                })
                    ->orWhereHas('vacante.empresa', function ($q) {
                        $q->where('nombreComercial', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('vacante', function ($q) {
                        $q->where('titulo', 'like', '%' . $this->search . '%');
                    });
            })
            ->paginate($this->perPage);

        // Procesar los datos para mostrar en la vista
        $datos = $registrosSeguimiento->map(function ($registro) {
            $ultimoSeguimiento = $registro->seguimientos()
                ->orderBy('created_at', 'desc')
                ->first();

            return [
                'nombre' => $registro->aspirante->nombre,
                'numero_control' => $registro->aspirante->numero_control,
                'carrera' => $registro->aspirante->user->perfil->carrera->nombre ?? 'Sin carrera',
                'periodo' => $registro->periodo->nombre ?? 'Sin periodo',
                'periodo_id' => $registro->periodo->id ?? null,
                'vacante' => $registro->vacante->titulo,
                'vacante_id' => $registro->vacante->vacante_id,
                'estado' => $registro->estado,
                'ultimo_tipo' => $ultimoSeguimiento ? $ultimoSeguimiento->tipo->nombre : 'Sin seguimiento',
                'empresa' => $registro->vacante->empresa->nombreComercial ?? 'Sin empresa',
                'empresa_id' => $registro->vacante->empresa->empresa_id ?? null,
            ];
        });

        return view('livewire.vinculacion.seguimiento', [
            'datos' => $datos,
            'registrosSeguimiento' => $registrosSeguimiento,
        ]);
    }
}
