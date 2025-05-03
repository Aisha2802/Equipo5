<div>
    @if (Auth::user()->role === 'aspirante')
        @include('livewire.vinculacion.modales.modal-residencias')
        @include('livewire.vinculacion.modales.modal-verinfocavante')
        @include('livewire.vinculacion.modales.modal-confirmacion')

        <!-- Notificaciones flotantes -->
        <div x-data="{ show: @entangle('showSuccessNotification') }" x-init="Livewire.on('notify-success', message => {
            show = true;
            setTimeout(() => show = false, 5000);
        })" x-show="show"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
            class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg flex items-center space-x-2 max-w-sm z-50">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span x-text="$wire.notificationMessage"></span>
        </div>

        <div x-data="{ show: @entangle('showErrorNotification') }" x-init="Livewire.on('notify-error', message => {
            show = true;
            setTimeout(() => show = false, 5000);
        })" x-show="show"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
            class="fixed bottom-4 right-4 bg-red-500 text-white px-4 py-3 rounded-lg shadow-lg flex items-center space-x-2 max-w-sm z-50">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            <span x-text="$wire.notificationMessage"></span>
        </div>

        <h1 class="text-2xl font-bold mb-6">Mis Solicitudes</h1>

        @if (count($solicitudes) > 0)
            <div class="space-y-6">
                @foreach ($solicitudes as $solicitud)
                    <div class="p-6 border rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-start gap-4 mb-4">
                            <svg class="w-12 h-12 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>

                            <div class="flex-grow">
                                <div class="flex items-center gap-2">
                                    <h2 class="text-xl font-semibold">
                                        {{ $solicitud->vacante->empresa->nombreComercial }}
                                    </h2>
                                    <button
                                        wire:click="prepare('{{ Crypt::encrypt($solicitud->vacante->empresa->empresa_id) }}')"
                                        class="text-blue-600 hover:text-blue-800">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </button>
                                </div>

                                <div class="mt-2 flex flex-wrap items-center gap-4">
                                    <button
                                        wire:click="prepareV('{{ Crypt::encrypt($solicitud->vacante->vacante_id) }}')"
                                        class="flex items-center gap-1 text-blue-600 hover:text-blue-800">
                                        <i class="fa-solid fa-circle-info"></i>
                                        <span>{{ $solicitud->vacante->titulo }}</span>
                                    </button>

                                    <span
                                        class="px-3 py-1 rounded-full text-sm font-medium 
                                        {{ $solicitud->estado === 'seguimiento'
                                            ? 'bg-purple-100 text-purple-800'
                                            : ($solicitud->estado === 'aceptado'
                                                ? 'bg-green-100 text-green-800'
                                                : ($solicitud->estado === 'pendiente'
                                                    ? 'bg-yellow-100 text-yellow-800'
                                                    : 'bg-red-100 text-red-800')) }}">
                                        {{ ucfirst($solicitud->estado) }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-2">
                                @if ($solicitud->estado !== 'seguimiento')
                                    @if ($solicitud->estado === 'aceptado' && $solicitud->vacante->max > 0)
                                        <button
                                            wire:click="confirmarAccion('{{ Crypt::encrypt($solicitud->id) }}', 'seguimiento')"
                                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg transition flex items-center gap-2">
                                            <i class="fas fa-tasks"></i>
                                            @if (Auth::user()->aspirante->estado === 'egresado')
                                                Aceptar empleo
                                            @else
                                                Iniciar residencia
                                            @endif
                                        </button>
                                    @endif
                                    @if ($solicitud->estado !== 'rechazado' && $solicitud->estado !== 'cancelada')
                                        <button
                                            wire:click="confirmarAccion('{{ Crypt::encrypt($solicitud->id) }}', 'cancelar')"
                                            wire:loading.attr="disabled"
                                            @if ($solicitud->vacante->seguimiento) disabled title="No se puede cancelar con seguimiento iniciado" @endif
                                            class="bg-gray-600 hover:bg-gray-700 text-white font-medium px-4 py-2 rounded-lg transition flex items-center gap-2
                                       @if ($solicitud->vacante->seguimiento) opacity-50 cursor-not-allowed @endif">
                                            <i class="fas fa-times"></i> Cancelar
                                        </button>
                                    @endif
                                @endif
                            </div>
                            <div>
                                @if ($solicitud->vacante->max <= 0 && $solicitud->estado !== 'seguimiento')
                                    <p class="text-red-500 font-medium">Esta vacante ya no tiene cupos disponibles</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-8 text-center bg-gray-50 rounded-lg">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">No tienes solicitudes registradas</h3>
                <p class="mt-1 text-gray-500">Todavía no has aplicado a ninguna vacante.</p>
            </div>
        @endif
    @endif
</div>
