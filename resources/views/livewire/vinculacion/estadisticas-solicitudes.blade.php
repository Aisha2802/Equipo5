<div class="p-6 bg-white rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-800">Estadísticas de Solicitudes</h2>
        
        <div class="w-64">
            <label for="periodo" class="block text-sm font-medium text-gray-700 mb-1">Filtrar por período:</label>
            <select 
                id="periodo" 
                wire:model.live="periodoSeleccionado"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            >
                @foreach($periodos as $periodo)
                    <option value="{{ $periodo->id }}">
                        {{ $periodo->nombre }} {{ $periodo->activo ? '(Activo)' : '' }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <p class="text-gray-600 mb-6">
        Estas estadísticas muestran las solicitudes que los estudiantes han enviado a las empresas. 
        Se indican cuántas fueron <strong>aceptadas</strong>, <strong>rechazadas</strong>, y cuántas están en estado <strong>pendiente o cancelado (otros)</strong>.
    </p>

    @if ($resumen['total'] > 0)
        {{-- Gráfica de barras --}}
        <div class="w-full max-w-2xl mx-auto">
            <canvas id="graficaSolicitudes" wire:ignore height="200"></canvas>
        </div>

        {{-- Resumen de datos --}}
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
            <div class="bg-green-100 text-green-800 p-4 rounded">
                <p class="text-lg font-bold">{{ $resumen['aceptadas'] }}</p>
                <p>Aceptadas ({{ $resumen['porcentaje_aceptadas'] }}%)</p>
            </div>
            <div class="bg-red-100 text-red-800 p-4 rounded">
                <p class="text-lg font-bold">{{ $resumen['rechazadas'] }}</p>
                <p>Rechazadas ({{ $resumen['porcentaje_rechazadas'] }}%)</p>
            </div>
            <div class="bg-gray-100 text-gray-800 p-4 rounded">
                <p class="text-lg font-bold">{{ $resumen['otros'] }}</p>
                <p>Otros ({{ $resumen['porcentaje_otros'] }}%)</p>
            </div>
        </div>
    @else
        {{-- Mensaje si no hay datos --}}
        <div class="text-center text-gray-600 mt-10">
            <p class="text-lg">No hay datos de solicitudes para el período seleccionado.</p>
        </div>
    @endif
</div>

<script>
    let solicitudesChart = null;

    // Función para inicializar o actualizar el gráfico
    function renderChart(data) {
        const ctx = document.getElementById('graficaSolicitudes');
        if (!ctx) return;

        if (solicitudesChart) {
            // Actualizar gráfico existente
            solicitudesChart.data = data;
            solicitudesChart.update();
        } else {
            // Crear nuevo gráfico
            solicitudesChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
    }

    // Inicialización cuando todo está listo
    document.addEventListener('livewire:init', function() {
        // Renderizar con los datos iniciales
        renderChart(@json($datosGrafica));
        
        // Escuchar eventos de actualización
        Livewire.on('datosGraficaActualizados', () => {
            // Obtener los datos actualizados directamente del componente
            const nuevosDatos = @this.get('datosGrafica');
            renderChart(nuevosDatos);
        });
    });
</script>