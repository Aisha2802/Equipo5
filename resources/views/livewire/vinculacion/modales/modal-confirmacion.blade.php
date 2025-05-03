<div x-data="{ open: @entangle('mostrarConfirmacion') }" x-show="open" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 flex items-center justify-center p-4">
     
    <div @click.away="open = false" class="bg-white rounded-lg shadow-xl overflow-hidden w-full max-w-md">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900">
                Confirmar {{ $accionConfirmar === 'cancelar' ? 'Cancelación' : 'Seguimiento' }}
            </h3>
            
            <div class="mt-4">
                <p class="text-gray-600">
                    ¿Estás seguro que deseas 
                    {{ $accionConfirmar === 'cancelar' ? 'cancelar esta solicitud' : 'iniciar el seguimiento para esta vacante' }} ?  
                </p>
                
                <div class="mt-6 flex justify-end gap-3">
                    <button @click="open = false; $wire.cancelarAccion()" 
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded-lg transition">
                        Cancelar
                    </button>
                    
                    <button @click="open = false; $wire.ejecutarAccionConfirmada()"
                            class="px-4 py-2 {{ $accionConfirmar === 'cancelar' ? 'bg-red-600 hover:bg-red-700' : 'bg-blue-600 hover:bg-blue-700' }} text-white rounded-lg transition">
                        Confirmar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>