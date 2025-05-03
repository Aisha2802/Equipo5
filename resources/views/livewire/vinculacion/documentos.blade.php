<!--Menu Seguimiento (Vista Estudiante) -->
<div>
    @if(Auth::user()->role === 'aspirante')
    @include('livewire.vinculacion.modales.modal-subirarchivo')
    @include('livewire.vinculacion.modales.modal-editarlink')

    <h1 class="text-2xl font-bold mb-4">Seguimiento de Mis Documentos</h1>
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
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if ($tiposVisibles->isEmpty()))
        <p class="text-gray-600">No hay tipos de documentos registrados.</p>
    @else
        <div class="space-y-4">
            @foreach ($tiposVisibles as $tipo)
                <div class="p-4 border rounded-lg shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-lg font-semibold">{{ $tipo->nombre }}</span>
                        <p class="text-sm text-gray-600">
                            @if ($estados[$tipo->id] === 'no_subido')
                                El archivo no se ha subido.
                            @else
                                Estado: {{ ucfirst($estados[$tipo->id]) }}
                        
                                @if (isset($seguimientos[$tipo->id]) && isset($seguimientos[$tipo->id]->documento->link))
                                    <br>
                                    <a href="{{ $seguimientos[$tipo->id]->documento->link }}" target="_blank"
                                       class="text-blue-500 hover:underline">
                                       Ver Documento
                                    </a>
                                @endif
                            @endif
                        </p>
                        
                    </div>
                    <div class="flex gap-2">
                        @if ($estados[$tipo->id] === 'no_subido')
                            <button wire:click="abrirModal('{{ $tipo->id }}')"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition">
                                Subir Documento
                            </button>
                        @elseif ($estados[$tipo->id] !== 'aceptado')
                            <button wire:click="editarDocumento('{{ $tipo->id }}')"
                                class="bg-yellow-600 hover:bg-yellow-700 text-white font-semibold px-4 py-2 rounded-lg transition">
                                Mandar a revisión
                            </button>

                            <button wire:click="prepareD('{{ $tipo->id }}')"
                                class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg transition">
                                Editar link
                            </button>
                        @endif

                    </div>
                </div>
            @endforeach
        </div>
    @endif
    @endif
</div>
