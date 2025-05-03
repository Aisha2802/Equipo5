<div>
    @if(Auth::user()->role === 'aspirante')
    @include('livewire.vinculacion.modales.modal-residencias')
    @include('livewire.vinculacion.modales.modal-verinfocavante')

    <!-- Mensajes flash mejorados -->
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
             class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg flex items-center space-x-2 max-w-sm z-50">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
             class="fixed bottom-4 right-4 bg-red-500 text-white px-4 py-3 rounded-lg shadow-lg flex items-center space-x-2 max-w-sm z-50">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif
    
    <h1 class="text-2xl font-bold mb-4">Vacantes Disponibles para tu Perfil</h1>

    @if ($empresas->isEmpty())
        <p class="text-gray-600">No hay vacantes disponibles que coincidan con tu perfil.</p>
    @else
        <div class="space-y-6">
            @foreach ($empresas as $empresa)
                @if ($empresa->vacantes->isNotEmpty())
                    <div class="p-6 border rounded-lg shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="flex mb-4">
                                <svg class="w-16 h-16 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div class="flex-grow">
                                <h2 class="text-xl font-semibold">{{ $empresa->nombreComercial }}</h2>
                            </div>
                            <button 
                                wire:click="prepare('{{ Crypt::encrypt($empresa->empresa_id) }}')" 
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-2 py-1 rounded-lg transition"
                            >
                                <i class="fa-solid fa-circle-info" style="color: #ffffff;"></i>
                            </button>
                        </div>

                        <div class="mt-4">
                            <h3 class="text-lg font-semibold mb-3">Vacantes que Coinciden con tu Perfil</h3>

                            <div class="space-y-4">
                                @foreach ($empresa->vacantes as $vacante)
                                    <div class="p-4 border rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                        <div class="flex items-center gap-4">
                                            <button wire:click="prepareV('{{ Crypt::encrypt($vacante->vacante_id) }}')"
                                                class="bg-blue-600 hover:bg-blue-700 px-2 py-1 rounded-lg flex-shrink-0">
                                                <i class="fa-solid fa-circle-info text-white"></i>
                                            </button>
                                        
                                            <div class="flex-grow">
                                                <h4 class="text-lg font-semibold">{{ $vacante->titulo }}</h4>
                                                <p class="text-sm text-gray-600">{{ Str::limit($vacante->descripcion, 100) }}</p>
                                            </div>
                                        
                                            <button wire:click="aplicar({{ $vacante->vacante_id }})"
                                                class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg whitespace-nowrap">
                                                Aplicar
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
    @endif
</div>
