<?php

namespace App\Livewire\Vinculacion;

use App\Models\Periodo;
use Livewire\Component;
use App\Models\Vinculacion\Empresa;
use App\Models\Vinculacion\SolicitudVacante;
use App\Models\Vinculacion\Vacante;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class EstudianteComponent extends Component
{
    public $empresas;
    public $perfilUsuario;
    public $estadoAspirante;
    public $tipoVacante;
    public $modal = false, $title = '';
    public $empresaSeleccionada;
    public $vacanteSeleccionada;
    public $modalV = false, $titleV = '';

    // Propiedades para el modal de empresa
    public $empresaNombre;
    public $empresaDireccion;
    public $empresaTelefono;
    public $empresaEmail;

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

    public function mount()
    {
        if (Auth::check() && Auth::user()->role === 'aspirante') {
            $this->perfilUsuario = Auth::user()->perfil_id;
            $this->estadoAspirante = Auth::user()->aspirante->estado;
            $this->tipoVacante = ($this->estadoAspirante === 'estudiante') ? 'residencia' : 'empleo';

            // Verificar si hay un período activo
            $periodoActivo = Periodo::where('activo', true)->exists();
            if (!$periodoActivo) {
                session()->flash('error', 'Actualmente no hay un período activo para aplicar a vacantes.');
            }

            $this->cargarVacantes();
        } else {
            $this->empresas = collect();
        }
    }

    public function prepare($empresaId)
    {
        $this->cargarVacantes();
        try {
            $id = Crypt::decrypt($empresaId);
            $empresa = Empresa::findOrFail($id);

            $this->empresaSeleccionada = $empresa;
            $this->empresaNombre = $empresa->nombreComercial;
            $this->empresaDireccion = $empresa->direccion;
            $this->empresaTelefono = $empresa->telefono;
            $this->empresaEmail = $empresa->email;

            $this->title = 'Detalles de la Empresa: ' . $this->empresaNombre;
            $this->modal = true;
        } catch (\Exception $e) {
            session()->flash('error', 'Error al cargar la información de la empresa');
        }
    }
    public function prepareV($vacanteId)
    {
        $this->cargarVacantes();
        try {
            $id = Crypt::decrypt($vacanteId);

            $vacante = Vacante::where('vacante_id', $id)
                ->where('tipo', $this->tipoVacante)
                ->where('estado', 'abierta')
                ->whereHas('perfiles', function ($q) {
                    $q->where('perfiles.perfil_id', $this->perfilUsuario);
                })
                ->with(['perfiles.carrera', 'perfiles.especialidad'])
                ->firstOrFail();

            $this->vacanteSeleccionada = $vacante;
            $this->tituloV = $vacante->titulo;
            $this->descripcionV = $vacante->descripcion;
            $this->ubicacionV = $vacante->ubicacion;
            $this->tipoV = $vacante->tipo;
            $this->estadoV = $vacante->estado;
            $this->maxV = $vacante->max;
            $this->pagoV = $vacante->pago;

            $perfil = $vacante->perfiles->first();
            $this->carreraV = $perfil->carrera->nombre;
            $this->especialidadV = $perfil->especialidad->nombre;

            $this->titleV = 'Información de la Vacante';
            $this->modalV = true;
        } catch (\Exception $e) {
            session()->flash('error', 'La vacante solicitada no está disponible');
            $this->modalV = false;
        }
    }

    public function cargarVacantes()
    {
        // Antes de aplicar los filtros, logueamos todas las vacantes
        $vacantesAntes = Vacante::with(['perfiles.carrera', 'perfiles.especialidad'])
            ->where('estado', 'abierta')
            ->get(); // Traemos todas las vacantes abiertas


        // Cargar empresas con vacantes
        $this->empresas = Empresa::query()
            ->with(['vacantes' => function ($query) {
                $query->where('tipo', $this->tipoVacante)
                    ->where('estado', 'abierta')
                    ->whereHas('perfiles', function ($q) {
                        $q->where('perfiles.perfil_id', $this->perfilUsuario);
                    })
                    ->with(['perfiles.carrera', 'perfiles.especialidad']);
            }])
            ->whereHas('vacantes', function ($query) {
                $query->where('tipo', $this->tipoVacante)
                    ->where('estado', 'abierta')
                    ->whereHas('perfiles', function ($q) {
                        $q->where('perfiles.perfil_id', $this->perfilUsuario);
                    });
            })
            ->get()
            ->map(function ($empresa) {
                // Filtramos las vacantes de la empresa que cumplen con los criterios
                $empresa->setRelation('vacantes', $empresa->vacantes->filter());
                return $empresa;
            })
            ->filter(function ($empresa) {
                // Filtramos las empresas que tienen vacantes
                return $empresa->vacantes->isNotEmpty();
            });
    }

    public function aplicar($vacanteId)
    {
        if (Auth::check() && Auth::user()->role === 'aspirante') {
            $aspiranteId = Auth::user()->aspirante->aspirante_id;

            // Verificar si existe un período activo
            $periodoActivo = Periodo::where('activo', true)->first();

            if (!$periodoActivo) {
                session()->flash('error', 'No hay un período activo para aplicar a vacantes.');
                return;
            }

            $solicitudExistente = SolicitudVacante::where('vacante_id', $vacanteId)
                ->where('aspirante_id', $aspiranteId)
                ->exists();

            if ($solicitudExistente) {
                session()->flash('error', 'Ya has aplicado a esta vacante.');
            } else {
                SolicitudVacante::create([
                    'vacante_id' => $vacanteId,
                    'aspirante_id' => $aspiranteId,
                    'periodo_id' => $periodoActivo->id,
                    'estado' => 'pendiente',
                ]);

                session()->flash('success', 'Has aplicado a la vacante correctamente.');
            }
        } else {
            session()->flash('error', 'No tienes permiso para aplicar a esta vacante.');
        }

        $this->cargarVacantes();
    }

    public function render()
    {
        return view('livewire.vinculacion.estudiante-component');
    }
}
