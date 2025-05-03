<div class="p-6 bg-white rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6">Crear Nueva Encuesta</h2>
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


    <form wire:submit.prevent="guardarEncuesta">
        <!-- Información básica de la encuesta -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label for="titulo" class="block text-sm font-medium text-gray-700">Título de la encuesta *</label>
                <input wire:model="titulo" type="text" id="titulo"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('titulo')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo de encuesta *</label>
                <select wire:model="tipo" id="tipo"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="estudiante">Para Estudiantes</option>
                    <option value="empresa">Para Empresas</option>
                    <option value="egresado">Para Egresados</option> <!-- Nueva opción -->
                </select>
            </div>

            <div class="md:col-span-2">
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción *</label>
                <textarea wire:model="descripcion" id="descripcion" rows="3"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                @error('descripcion')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Preguntas de la encuesta -->
        <div class="mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Preguntas de la Encuesta</h3>
            <p class="text-sm text-gray-500 mb-4">
                Por favor completa todas las preguntas. Las primeras 9 deben ser de rango (1-5). 
                <span class="font-medium">Se agregará automáticamente un apartado para comentarios al final.</span>
            </p>

            <div class="space-y-6">
                @foreach ($preguntas as $index => $pregunta)
                    @if($pregunta['visible']) <!-- Solo mostrar preguntas visibles -->
                        <div class="p-4 border rounded-lg bg-gray-50">
                            <div class="flex items-start">
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700">Pregunta {{ $index + 1 }} *</label>
                                    <input wire:model="preguntas.{{ $index }}.texto" type="text"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('preguntas.' . $index . '.texto')
                                        <span class="text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="ml-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Escala 1-5
                                    </span>
                                </div>
                            </div>

                            <div class="mt-2 text-sm text-gray-500">
                                <span class="font-medium">Tipo de respuesta:</span> Escala numérica del 1 al 5
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Botón de envío -->
        <div class="flex justify-end">
            <button type="submit"
                class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Crear Encuesta
            </button>
        </div>
    </form>
</div>
