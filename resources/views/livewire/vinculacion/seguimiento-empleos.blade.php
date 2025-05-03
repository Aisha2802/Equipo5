<div>
    @if (Auth::user()->role === 'jefe')
        @include('livewire.vinculacion.modales.modal-verinfocavante')
        @include('livewire.vinculacion.modales.modal-residencias')
        <h1 class="font-bold text-2xl mb-5">Egresados en Proceso de Empleo</h1>

        <!-- Contenedor de filtros -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <!-- Buscador -->
            <div class="relative flex items-center rounded-full border-2 border-blue-500 px-2 py-1">
                <i class="fa-solid fa-magnifying-glass text-blue-500 ml-2 absolute left-3"></i>
                <input type="search" wire:model.live="search"
                    class="w-full bg-transparent rounded-full border-none focus:outline-none focus:ring-0 pl-10 pr-4 text-gray-700 placeholder-gray-400"
                    placeholder="Buscar egresado, empresa o vacante..." wire:keydown.escape="$set('search', '')">
            </div>
            <!-- Filtro por carrera -->
            <select wire:model.live="carreraSeleccionada"
                class="rounded-full border-2 border-blue-500 px-4 py-1 focus:outline-none focus:ring-0">
                <option value="">Todas las carreras</option>
                @foreach ($carreras as $carrera)
                    <option value="{{ $carrera->carrera_id }}">{{ $carrera->nombre }}</option>
                @endforeach
            </select>
            <!-- Filtro por periodo -->
            <select wire:model.live="periodoSeleccionado"
                class="rounded-full border-2 border-blue-500 px-4 py-1 focus:outline-none focus:ring-0">
                <option value="">Todos los periodos</option>
                @foreach ($periodos as $periodo)
                    <option value="{{ $periodo->id }}">{{ $periodo->nombre }}</option>
                @endforeach
            </select>
        </div>

        @if ($datos->isEmpty())
            <div class="bg-gray-100 p-6 rounded-lg text-center">
                <i class="fas fa-search text-gray-400 text-4xl mb-3"></i>
                <p class="text-gray-600">
                    @if ($search || $periodoSeleccionado || $carreraSeleccionada)
                        No se encontraron resultados para tu búsqueda
                    @else
                        Actualmente no hay egresados en proceso de empleo
                    @endif
                </p>
                @if ($search || $periodoSeleccionado || $carreraSeleccionada)
                    <button wire:click="resetFilters" class="mt-3 text-blue-600 hover:text-blue-800">
                        <i class="fas fa-undo mr-1"></i> Limpiar filtros
                    </button>
                @endif
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left font-semibold text-gray-700">Nombre</th>
                            <th class="py-3 px-4 text-left font-semibold text-gray-700">No Control</th>
                            <th class="py-3 px-4 text-left font-semibold text-gray-700">Carrera</th>
                            <th class="py-3 px-4 text-left font-semibold text-gray-700">Periodo</th>
                            <th class="py-3 px-4 text-left font-semibold text-gray-700">Empleo</th>
                            <th class="py-3 px-4 text-left font-semibold text-gray-700">Empresa</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($datos as $dato)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-3 px-4">{{ $dato['nombre'] }}</td>
                                <td class="py-3 px-4">{{ $dato['numero_control'] }}</td>
                                <td class="py-3 px-4">{{ $dato['carrera'] }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800">
                                        {{ $dato['periodo'] }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-2">
                                        {{ $dato['vacante'] }}
                                        <button wire:click="prepareV('{{ Crypt::encrypt($dato['vacante_id']) }}')"
                                            class="text-blue-600 hover:text-blue-800">
                                            <i class="fa-solid fa-circle-info"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-2">
                                        {{ $dato['empresa'] }}
                                        <button wire:click="prepare('{{ Crypt::encrypt($dato['empresa_id']) }}')"
                                            class="text-blue-600 hover:text-blue-800">
                                            <i class="fa-solid fa-circle-info"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $seguimientosEmpleo->links() }}
                </div>
            </div>
        @endif
    @endif
</div>