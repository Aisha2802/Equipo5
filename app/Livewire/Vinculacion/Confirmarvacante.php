<?php

namespace App\Livewire\Vinculacion;

use App\Models\Periodo;
use App\Models\SeguimientoEmpleo;
use App\Models\Vinculacion\Empresa;
use App\Models\Vinculacion\SolicitudVacante;
use App\Models\Vinculacion\Vacante;
use App\Models\Vinculacion\RegistroSeguimiento;
use App\Models\Vinculacion\SeguimientoEmpleo as VinculacionSeguimientoEmpleo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;

class Confirmarvacante extends Component
{
    public $solicitudes = [];
    public $modal = false, $title = '';
    public $empresaSeleccionada;
    public $modalV = false, $titleV = '';
    public $vacante_id;

    // Propiedades para los modales de confirmación
    public $mostrarConfirmacion = false;
    public $accionConfirmar = ''; // 'cancelar' o 'seguimiento'
    public $solicitudConfirmarId = null;

    // Propiedades para los datos de empresa/vacante
    public $empresaNombre, $empresaDireccion, $empresaTelefono, $empresaEmail;
    public $tituloV, $descripcionV, $ubicacionV, $tipoV, $estadoV, $maxV, $pagoV, $carreraV, $especialidadV;

    // Propiedades para notificaciones
    public $showSuccessNotification = false;
    public $showErrorNotification = false;
    public $notificationMessage = '';

    public function mount()
    {
        $this->cargarSolicitudes();
    }

    public function cargarSolicitudes()
    {
        if (Auth::check() && Auth::user()->aspirante) {
            $this->solicitudes = Auth::user()->aspirante->solicitudes()
                ->with('vacante.empresa', 'vacante.perfiles.carrera', 'vacante.perfiles.especialidad')
                ->orderByRaw("
                CASE 
                    WHEN estado = 'seguimiento' THEN 1
                    WHEN estado = 'aceptado' THEN 2
                    WHEN estado = 'pendiente' THEN 3
                    WHEN estado = 'rechazado' THEN 4
                    ELSE 5
                END
            ")
                ->get();
        }
    }

    public function prepare($empresaId)
    {
        try {
            $id = Crypt::decrypt($empresaId);
            $empresa = Empresa::findOrFail($id);

            $this->empresaSeleccionada = $empresa;
            $this->empresaNombre = $empresa->nombreComercial;
            $this->empresaDireccion = $empresa->direccion;
            $this->empresaTelefono = $empresa->telefono;
            $this->empresaEmail = $empresa->email;

            $this->title = 'Detalles de la Empresa';
            $this->modal = true;
        } catch (\Exception $e) {
            $this->notifyError('Error al cargar la información de la empresa');
        }
    }

    public function prepareV($vacanteId)
    {
        try {
            $id = Crypt::decrypt($vacanteId);
            $vacante = Vacante::with('perfiles.carrera', 'perfiles.especialidad')->findOrFail($id);

            $this->vacante_id = $id;
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
            $this->notifyError('Error al cargar la información de la vacante');
        }
    }

    public function confirmarAccion($id, $accion)
    {
        try {
            $this->solicitudConfirmarId = Crypt::decrypt($id);
            $this->accionConfirmar = $accion;
            $this->mostrarConfirmacion = true;
        } catch (\Exception $e) {
            $this->notifyError('Error al procesar la solicitud');
        }
    }

    public function ejecutarAccionConfirmada()
    {
        try {
            $solicitud = SolicitudVacante::findOrFail($this->solicitudConfirmarId);
            $aspiranteId = $solicitud->aspirante_id;

            if ($this->accionConfirmar === 'cancelar') {
                $this->cancelarSolicitud($solicitud);
            } elseif ($this->accionConfirmar === 'seguimiento') {
                $this->iniciarSeguimiento($solicitud, $aspiranteId);
                return redirect()->route('dashboard.documento');
            }

            $this->cargarSolicitudes();
            $this->mostrarConfirmacion = false;
        } catch (\Exception $e) {
            $this->notifyError('Error: ' . $e->getMessage());
        }
    }

    protected function cancelarSolicitud($solicitud)
    {
        $solicitud->estado = 'cancelada';
        $solicitud->save();

        $message = 'Has cancelado tu solicitud con la empresa ' . $solicitud->vacante->empresa->nombreComercial;
        $this->notifySuccess($message);
    }

    protected function iniciarSeguimiento($solicitud, $aspiranteId)
    {
        $aspirante = Auth::user()->aspirante;

        // Verificar si ya existe un registro de seguimiento
        $seguimientoExistente = $aspirante->estado === 'estudiante'
            ? RegistroSeguimiento::where('aspirante_id', $aspiranteId)
            ->where('vacante_id', $solicitud->vacante_id)
            ->exists()
            : VinculacionSeguimientoEmpleo::where('aspirante_id', $aspiranteId)
            ->where('vacante_id', $solicitud->vacante_id)
            ->exists();

        if ($seguimientoExistente) {
            throw new \Exception('Ya tienes un seguimiento activo para esta vacante');
        }

        // Obtener el periodo actual activo
        $periodoActual = Periodo::actual();

        if (!$periodoActual) {
            throw new \Exception('No hay un periodo activo configurado');
        }

        // Verificar si aún hay cupo disponible en la vacante
        $vacante = Vacante::findOrFail($solicitud->vacante_id);
        if ($vacante->max <= 0) {
            throw new \Exception('No hay cupo disponible para esta vacante');
        }

        // Cancelar otras solicitudes del aspirante
        SolicitudVacante::where('aspirante_id', $aspiranteId)
            ->where('id', '!=', $solicitud->id)
            ->update(['estado' => 'cancelada']);

        // Actualizar el estado de esta solicitud a "seguimiento"
        $solicitud->estado = 'seguimiento';
        $solicitud->save();

        // Reducir en 1 el cupo máximo de la vacante
        $vacante->max -= 1;
        $vacante->save();

        // Crear nuevo registro de seguimiento según el tipo de aspirante
        if ($aspirante->estado === 'estudiante') {
            RegistroSeguimiento::create([
                'aspirante_id' => $aspiranteId,
                'vacante_id' => $solicitud->vacante_id,
                'periodo_id' => $periodoActual->id
            ]);
        } else { // Egresado
            VinculacionSeguimientoEmpleo::create([
                'aspirante_id' => $aspiranteId,
                'vacante_id' => $solicitud->vacante_id,
                'periodo_id' => $periodoActual->id
            ]);
        }

        $this->notifySuccess('Seguimiento iniciado correctamente');
    }

    public function cancelarAccion()
    {
        $this->reset(['mostrarConfirmacion', 'accionConfirmar', 'solicitudConfirmarId']);
    }

    protected function notifySuccess($message)
    {
        $this->notificationMessage = $message;
        $this->showSuccessNotification = true;
        $this->dispatch('notify-success');
    }

    protected function notifyError($message)
    {
        $this->notificationMessage = $message;
        $this->showErrorNotification = true;
        $this->dispatch('notify-error');
    }

    public function render()
    {
        return view('livewire.vinculacion.confirmarvacante');
    }
}
