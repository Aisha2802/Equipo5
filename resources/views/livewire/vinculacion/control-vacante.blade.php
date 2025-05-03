<div>
    @if (Auth::user()->role === 'empresa')
        @include('livewire.vinculacion.modales.modal-nuevavacante')
        @include('livewire.vinculacion.modales.modal-editarvacante')
        @include('livewire.vinculacion.modales.modal-verinfocavante')

        @if ($empresa)
            <div class="flex items-center mb-4">
                <svg class="w-16 h-16 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                    </path>
                </svg>
                <h1 class="text-2xl font-bold">{{ $empresa->nombreComercial }}</h1>
            </div>

            <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-4 gap-4">
                <!-- Contenedor de los filtros -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 w-full md:w-auto">
                    <!-- Filtro por tipo de vacante -->
                    <div class="w-full sm:w-auto">
                        <p class="text-sm font-medium text-gray-700">Tipo de vacante</p>
                        <select id="filtroTipo" wire:model="filtroTipo" wire:change="aplicarFiltro"
                            class="mt-1 block w-full sm:w-48 p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Todas las vacantes</option>
                            <option value="residencia">Residencia</option>
                            <option value="empleo">Empleo</option>
                        </select>
                    </div>

                    <!-- Filtro por estado de vacante -->
                    <div class="w-full sm:w-auto">
                        <p class="text-sm font-medium text-gray-700">Estado de la vacante</p>
                        <select id="filtroEstado" wire:model="filtroEstado" wire:change="aplicarFiltro"
                            class="mt-1 block w-full sm:w-48 p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Todas</option>
                            <option value="abierta">Abiertas</option>
                            <option value="pendiente">Pendientes</option>
                            <option value="cerrada">Cerradas</option>
                        </select>
                    </div>
                </div>

                <!-- Botón "Agregar vacante" -->
                <div class="w-full sm:w-auto">
                    <button wire:click="prepare('{{ Crypt::encrypt(0) }}')"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition flex items-center justify-center gap-2 w-full sm:w-auto">
                        <i class="fa-solid fa-plus" style="color: #ffffff;"></i> Nueva Vacante
                    </button>
                </div>
            </div>
            <!-- Vacantes -->
            @if ($vacantes->isEmpty())
                <p class="text-gray-600">No hay vacantes registradas.</p>
            @else
                <div class="space-y-4">
                    @foreach ($vacantes as $vacante)
                        <div class="p-4 border rounded-lg shadow-sm">
                            <div class="flex items-center justify-between">
                                <div class="flex gap-2">
                                    <button wire:click="prepareV('{{ Crypt::encrypt($vacante->vacante_id) }}')"
                                        class="bg-blue-600 hover:bg-blue-700 px-1.5 rounded-lg">
                                        <i class="fa-solid fa-circle-info" style="color: #ffffff;"></i>
                                    </button>
                                    <h4 class="text-lg font-semibold">{{ $vacante->titulo }}</h4>
                                </div>
                                <!-- Botón para editar -->
                                <button wire:click="prepareE('{{ Crypt::encrypt($vacante->vacante_id) }}')"
                                    class="bg-blue-600 hover:bg-blue-700 px-2 rounded-lg">
                                    <i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                                </button>
                            </div>
                            <p><strong>Estado:</strong>
                                <span
                                    class="{{ $vacante->estado === 'abierta'
                                        ? 'text-green-600'
                                        : ($vacante->estado === 'pendiente'
                                            ? 'text-yellow-600'
                                            : 'text-red-600') }}">
                                    {{ $vacante->estado }}
                                </span>
                            </p>

                        </div>
                    @endforeach
                </div>
            @endif
        @else
            <p class="text-gray-600">No se encontró información de la empresa.</p>
        @endif
        @if (session()->has('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-2"
                class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg flex items-start space-x-2 max-w-sm">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
    @endif
</div>
