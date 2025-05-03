<!--Menu Solicitudes de mis vacantes (vista de empresa)-->
<div>
    @if (Auth::user()->role === 'empresa')
        @include('livewire.vinculacion.modales.modal-verinfocavante')
        @include('livewire.vinculacion.modales.modal-verinfoaspirante')
        @if ($mostrarConfirmacion)
            <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center p-4 z-50">
                <div class="bg-white rounded-lg shadow-xl p-6 max-w-sm w-full">
                    <h3 class="text-lg font-semibold mb-4">
                        Confirmar {{ $accionConfirmar === 'aceptado' ? 'aceptación' : 'rechazo' }}
                    </h3>
                    <p class="mb-6">¿Estás seguro que deseas
                        {{ $accionConfirmar === 'aceptado' ? 'aceptar' : 'rechazar' }}
                        esta solicitud?</p>

                    <div class="flex justify-end space-x-3">
                        <button wire:click="cancelarAccion"
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded-lg transition">
                            Cancelar
                        </button>
                        <button wire:click="ejecutarAccion"
                            class="px-4 py-2 {{ $accionConfirmar === 'aceptado' ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }} text-white rounded-lg transition">
                            Confirmar
                        </button>
                    </div>
                </div>
            </div>
        @endif
        @if (session()->has('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
                class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg flex items-center space-x-2 max-w-sm z-50">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if (session()->has('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
                class="fixed bottom-4 right-4 bg-red-500 text-white px-4 py-3 rounded-lg shadow-lg flex items-center space-x-2 max-w-sm z-50">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif
        <h1 class="text-2xl font-bold mb-4">Solicitudes de Vacantes</h1>
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
            <!-- Filtro por vacante -->
            <div class="w-full sm:w-auto">
                <p class="text-sm font-medium text-gray-700">Seleccionar vacante</p>
                <select id="filtroVacante" wire:model="filtroVacante" wire:change="aplicarFiltro"
                    class="mt-1 block w-full sm:w-48 p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Todas las vacantes</option>
                    @foreach ($vacantesEmpresa as $vacante)
                        <option value="{{ $vacante->vacante_id }}">{{ $vacante->titulo }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @if ($vacantes->isEmpty())
            <p class="text-gray-600 mt-10">No hay vacantes con solicitudes.</p>
        @else
            <div class="space-y-6 mt-4">
                @foreach ($vacantes as $vacante)
                    <div class="p-6 border rounded-lg shadow-sm">
                        <div class="flex items-center gap-4">
                            <button wire:click="prepareV('{{ Crypt::encrypt($vacante->vacante_id) }}')"
                                class="bg-blue-600 hover:bg-blue-700 px-1.5 rounded-lg">
                                <i class="fa-solid fa-circle-info" style="color: #ffffff;"></i>
                            </button>
                            <h2 class="text-xl font-semibold">{{ $vacante->titulo }}</h2>
                        </div>
                        <p><strong>Estado:</strong>
                            <span
                                class="{{ $vacante->estado === 'abierta' ? 'text-green-600' : ($vacante->estado === 'pendiente' ? 'text-yellow-600' : 'text-red-600') }}">
                                {{ $vacante->estado }}
                            </span>
                        </p>

                        <div class="mt-4" x-data="{ abierto: false }">
                            <div class="flex items-center gap-2 cursor-pointer" @click="abierto = !abierto"
                                x-bind:aria-expanded="abierto">
                                <h3 class="text-lg font-semibold">Solicitudes</h3>
                                @if (!$vacante->solicitudes->isEmpty())
                                    <button type="button" aria-label="Toggle solicitudes">
                                        <i class="fa-solid fa-chevron-down transition-transform duration-200"
                                            x-bind:class="{ 'rotate-180': abierto }"></i>
                                    </button>
                                @else
                                    <p class="text-gray-600">No hay solicitudes para esta vacante.</p>
                                @endif
                            </div>

                            <div x-show="abierto" x-collapse>
                                @if ($vacante->solicitudes->isEmpty())
                                    <p class="text-gray-600">No hay solicitudes para esta vacante.</p>
                                @else
                                    <div class="space-y-4 mt-2">
                                        @foreach ($vacante->solicitudes as $solicitud)
                                            <div class="p-4 border rounded-lg shadow-sm">
                                                <div class="flex items-center gap-4">
                                                    <h4 class="text-lg font-semibold">
                                                        {{ $solicitud->aspirante->nombre }}
                                                    </h4>
                                                    <button
                                                        wire:click="prepare('{{ Crypt::encrypt($solicitud->id) }}')"
                                                        class="text-blue-600 hover:text-blue-700 font-semibold px-3 py-1 rounded-lg transition">
                                                        Ver información
                                                    </button>
                                                </div>
                                                <p><strong>Estado:</strong>
                                                    <span
                                                        class="{{ $solicitud->estado === 'aceptado' ? 'text-green-600' : ($solicitud->estado === 'pendiente' ? 'text-yellow-600' : 'text-red-600') }}">
                                                        {{ $solicitud->estado }}
                                                    </span>
                                                </p>
                                                @if ($solicitud->estado == 'aceptado' || $solicitud->estado == 'pendiente' || $solicitud->estado == 'rechazado')
                                                    <div class="mt-3 flex gap-2">
                                                        <button
                                                            wire:click="confirmarAccion('{{ Crypt::encrypt($solicitud->id) }}', 'aceptado')"
                                                            class="bg-green-600 hover:bg-green-700 text-white font-semibold px-3 py-1 rounded-lg transition flex items-center gap-1">
                                                            <i class="fas fa-check"></i> Aceptar
                                                        </button>

                                                        <button
                                                            wire:click="confirmarAccion('{{ Crypt::encrypt($solicitud->id) }}', 'rechazado')"
                                                            class="bg-red-600 hover:bg-red-700 text-white font-semibold px-3 py-1 rounded-lg transition flex items-center gap-1">
                                                            <i class="fas fa-times"></i> Rechazar
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif
</div>
