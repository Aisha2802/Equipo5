<?php

namespace App\Livewire\Vinculacion;

use Livewire\Component;
use App\Models\Vinculacion\SolicitudVacante;
use App\Models\Periodo;
use Illuminate\Support\Facades\DB;
use stdClass; // Añadimos esta importación

class EstadisticasSolicitudes extends Component
{
    public array $datosGrafica = [];
    public array $resumen = [];
    public string $periodoSeleccionado = '';
    public $periodos = [];

    public function mount()
    {
        $this->periodos = Periodo::orderBy('created_at', 'desc')->get();
        $this->periodoSeleccionado = Periodo::where('activo', true)->value('id') ?? ($this->periodos->first()->id ?? '');
        $this->generarEstadisticas();
    }

    public function updatedPeriodoSeleccionado()
    {
        $this->generarEstadisticas();
    }

    public function generarEstadisticas()
    {
        $query = SolicitudVacante::query();
        
        if ($this->periodoSeleccionado) {
            $query->where('periodo_id', $this->periodoSeleccionado);
        }

        // Cambiamos a usar first() y luego convertimos a array si es necesario
        $datos = $query
            ->select(
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN estado IN (\'aceptado\', \'seguimiento\') THEN 1 ELSE 0 END) as aceptadas'),
                DB::raw('SUM(CASE WHEN estado = \'rechazado\' THEN 1 ELSE 0 END) as rechazadas'),
                DB::raw('SUM(CASE WHEN estado NOT IN (\'aceptado\', \'seguimiento\', \'rechazado\') THEN 1 ELSE 0 END) as otros')
            )
            ->first();

        // Creamos un objeto estándar si no hay resultados
        if (!$datos) {
            $datos = new stdClass();
            $datos->total = 0;
            $datos->aceptadas = 0;
            $datos->rechazadas = 0;
            $datos->otros = 0;
        }

        $total = $datos->total > 0 ? $datos->total : 1;

        $this->datosGrafica = [
            'labels' => ['Aceptadas', 'Rechazadas', 'Otros'],
            'datasets' => [
                [
                    'label' => 'Solicitudes',
                    'data' => [
                        $datos->aceptadas,
                        $datos->rechazadas,
                        $datos->otros
                    ],
                    'backgroundColor' => [
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(239, 68, 68, 0.7)',
                        'rgba(156, 163, 175, 0.7)'
                    ],
                    'borderColor' => [
                        'rgba(16, 185, 129, 1)',
                        'rgba(239, 68, 68, 1)',
                        'rgba(156, 163, 175, 1)'
                    ],
                    'borderWidth' => 1
                ]
            ]
        ];

        $this->resumen = [
            'total' => $datos->total,
            'aceptadas' => $datos->aceptadas,
            'rechazadas' => $datos->rechazadas,
            'otros' => $datos->otros,
            'porcentaje_aceptadas' => round(($datos->aceptadas / $total) * 100, 2),
            'porcentaje_rechazadas' => round(($datos->rechazadas / $total) * 100, 2),
            'porcentaje_otros' => round(($datos->otros / $total) * 100, 2)
        ];

        $this->dispatch('datosGraficaActualizados');
    }

    public function render()
    {
        return view('livewire.vinculacion.estadisticas-solicitudes');
    }
}