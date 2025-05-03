<?php

namespace App\Livewire\Vinculacion;

use App\Models\Vinculacion\Documento;
use Livewire\Component;
use App\Models\Vinculacion\Empresa;
use App\Models\Vinculacion\Seguimiento;
use App\Models\Vinculacion\SolicitudVacante;
use App\Models\Vinculacion\Tipo;
use App\Models\Vinculacion\Vacante;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class Solicitudes extends Component
{
    public $vacantes;
    public $empresa;
    public $filtroTipo = '';
    public $filtroEstado = '';
    public $filtroVacante = '';
    public $vacante_id;
    public $cvLink = null;
    public $cvAprobado = false;
    public $vacantesEmpresa;
    public $solicitudSeleccionadaId = null;
    public $accionConfirmar = null;
    public $mostrarConfirmacion = false;
    public $modalV = false, $titleV = '';
    public $modal = false, $title = '';
    public $tituloV, $descripcionV, $ubicacionV, $tipoV, $estadoV, $maxV, $pagoV, $carreraV, $especialidadV;
    public $aspirante_id, $nombre, $numero_control, $estado;

    public function mount()
    {
        if (Auth::check() && Auth::user()->role === 'empresa') {
            $this->empresa = Empresa::find(Auth::user()->empresa_id);
            if ($this->empresa) {
                $this->vacantesEmpresa = $this->empresa->vacantes;
                $this->aplicarFiltro();
            }
        }
    }

    public function prepare($id)
    {
        $id = Crypt::decrypt($id);
        Log::info('ID descifrado:', ['id' => $id]);

        $solicitud = SolicitudVacante::find($id);

        if ($solicitud) {
            $aspirante = $solicitud->aspirante; // Obtener el aspirante asociado a la solicitud

            // Cargar los datos del aspirante en las propiedades del modal
            $this->aspirante_id = $aspirante->aspirante_id;
            $this->nombre = $aspirante->nombre;
            $this->numero_control = $aspirante->numero_control;
            $this->estado = $aspirante->estado;

            // Buscar el CV del aspirante
            $this->buscarCVAprobado($aspirante->aspirante_id);

            $this->title = 'Información del Aspirante';
            $this->modal = true; // Abrir el modal
        }
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

    public function aplicarFiltro()
    {
        // Obtener las vacantes de la empresa con sus solicitudes
        $query = $this->empresa->vacantes()->with(['solicitudes' => function ($query) {
            // Excluir solicitudes con estado "cancelado"

        }]);

        // Aplicar filtro por tipo de vacante si está seleccionado
        if ($this->filtroTipo) {
            $query->where('tipo', $this->filtroTipo);
        }

        // Aplicar filtro por estado de vacante si está seleccionado
        if ($this->filtroEstado) {
            $query->where('estado', $this->filtroEstado);
        }

        // Aplicar filtro por vacante si está seleccionado
        if ($this->filtroVacante) {
            $query->where('vacante_id', $this->filtroVacante);
        }

        // Obtener las vacantes filtradas
        $this->vacantes = $query->get();
    }

    public function confirmarAccion($id, $accion)
    {
        $this->solicitudSeleccionadaId = Crypt::decrypt($id);
        $this->accionConfirmar = $accion;
        $this->mostrarConfirmacion = true;
    }

    public function ejecutarAccion()
    {
        try {
            $solicitud = SolicitudVacante::find($this->solicitudSeleccionadaId);

            if ($solicitud) {
                $solicitud->estado = $this->accionConfirmar;
                $solicitud->save();

                $mensaje = $this->accionConfirmar === 'aceptado'
                    ? 'Solicitud aceptada correctamente.'
                    : 'Solicitud rechazada correctamente.';

                session()->flash('success', $mensaje);
                $this->aplicarFiltro();
            } else {
                session()->flash('error', 'No se encontró la solicitud.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error al procesar la solicitud: ' . $e->getMessage());
        } finally {
            $this->reset(['solicitudSeleccionadaId', 'accionConfirmar', 'mostrarConfirmacion']);
        }
    }

    public function cancelarAccion()
    {
        $this->reset(['solicitudSeleccionadaId', 'accionConfirmar', 'mostrarConfirmacion']);
    }

    public function buscarCVAprobado($aspiranteId)
    {
        $seguimientoCV = Seguimiento::where('aspirante_id', $aspiranteId)
            ->where('tipo_id', 1)
            ->where('estado', 'aceptado')
            ->first();
        if ($seguimientoCV) {
            $documentoCV = $seguimientoCV->documento;

            if ($documentoCV) {
                $this->cvLink = $documentoCV->link;
                $this->cvAprobado = true;
            }
        }
    }

    public function aceptarSolicitud($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $solicitud = SolicitudVacante::find($id);

            if ($solicitud) {
                $solicitud->estado = 'aceptado';
                $solicitud->save();

                session()->flash('message', 'Solicitud aceptada correctamente.');
                $this->aplicarFiltro();
            } else {
                session()->flash('error', 'No se encontró la solicitud.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error al aceptar la solicitud: ' . $e->getMessage());
        }
    }

    public function rechazarSolicitud($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $solicitud = SolicitudVacante::find($id);

            if ($solicitud) {
                $solicitud->estado = 'rechazado';
                $solicitud->save();

                session()->flash('message', 'Solicitud rechazada correctamente.');
                $this->aplicarFiltro();
            } else {
                session()->flash('error', 'No se encontró la solicitud.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error al rechazar la solicitud: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.vinculacion.solicitudes', [
            'empresa' => $this->empresa,
            'vacantes' => $this->vacantes,
        ]);
    }
}
