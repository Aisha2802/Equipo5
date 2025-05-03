<!--Menu Vacantes de las empresas (Vista para vinculacion)-->
<div>
    @if (Auth::user()->role === 'vinculacion')
        @include('livewire.vinculacion.modales.modal-residencias')
        @include('livewire.vinculacion.modales.modal-verinfocavante')

        <!-- Mensajes flash mejorados -->
        @if (session()->has('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg flex items-center space-x-2 max-w-sm z-50">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session()->has('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                class="fixed bottom-4 right-4 bg-red-500 text-white px-4 py-3 rounded-lg shadow-lg flex items-center space-x-2 max-w-sm z-50">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <h1 class="text-2xl font-bold mb-4">Listado de Empresas</h1>

        <!-- Filtro de estado de vacantes -->
        <div class="mb-6 flex items-center gap-4">
            <label for="filtroEstado" class="block text-sm font-medium text-gray-700">Filtrar por estado:</label>
            <select id="filtroEstado" wire:model="filtroEstado" wire:change="aplicarFiltro"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="">Todas</option>
                <option value="abierta">Abiertas</option>
                <option value="pendiente">Pendientes</option>
                <option value="cerrada">Cerradas</option>
            </select>

            <!-- Filtro por nombre de empresa -->
            <label for="filtroEmpresa" class="block text-sm font-medium text-gray-700">Filtrar por empresa:</label>
            <select id="filtroEmpresa" wire:model="filtroEmpresa" wire:change="aplicarFiltro"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="">Todas</option>
                @foreach ($todasLasEmpresas as $empresa)
                    <option value="{{ $empresa->nombreComercial }}">{{ $empresa->nombreComercial }}</option>
                @endforeach
            </select>
        </div>

        @if ($empresas->isEmpty())
            <p class="text-gray-600">No hay empresas registradas.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-6">
                @foreach ($empresas as $empresa)
                    <div class="p-6 border rounded-lg shadow-sm bg-white hover:shadow-md transition-shadow">
                        <!-- icono de la empresa -->
                        <div class="flex  mb-4">
                            <svg class="w-16 h-16 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>

                        <div class="flex items-center  gap-4">
                            <h2 class="text-xl font-semibold">{{ $empresa->nombreComercial }}</h2>
                            <button wire:click="prepare('{{ Crypt::encrypt($empresa->empresa_id) }}')"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-3 py-1 rounded-lg transition">
                                <i class="fa-solid fa-circle-info text-xs" style="color: #ffffff;"></i>
                            </button>
                        </div>

                        <!-- Lista de vacantes -->
                        <div class="p-6">
                            <h2 class="text-xl font-bold mb-4">Vacantes</h2>
                            @if ($empresa->vacantes->isEmpty())
                                <p class="text-gray-600">No hay vacantes disponibles.</p>
                            @else
                                <div class="space-y-4">
                                    @foreach ($empresa->vacantes as $vacante)
                                        @if (!$filtroEstado || $vacante->estado === $filtroEstado)
                                            <div class="p-4 border rounded-lg shadow-sm">
                                                <div class="flex gap-2">
                                                    <button
                                                        wire:click="prepareV('{{ Crypt::encrypt($vacante->vacante_id) }}')"
                                                        class="bg-blue-600 hover:bg-blue-700 px-1.5 rounded-lg">
                                                        <i class="fa-solid fa-circle-info" style="color: #ffffff;"></i>
                                                    </button>
                                                    <h4 class="text-lg font-semibold">{{ $vacante->titulo }}</h4>
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
                                                <div class="flex gap-2 mt-4">
                                                    <button wire:click="abrirVacante('{{ $vacante->vacante_id }}')"
                                                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition">
                                                        Abrir
                                                    </button>
                                                    <button wire:click="cerrarVacante('{{ $vacante->vacante_id }}')"
                                                        class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg transition">
                                                        Cerrar
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif

</div>
