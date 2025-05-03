<!-- Modal para editar un link existente -->
<x-info-modal wire:model="modalD">
    <div class="p-6">
        <h2 class="text-lg font-semibold mb-4">Editar Link del Documento</h2>

        <!-- Mensaje para el usuario -->
        <p class="text-sm text-gray-600 mb-4">
            Actualiza el link del documento. El estado volverá a "pendiente" para nueva revisión.
        </p>

        <!-- Campo para el link -->
        <div class="mb-4">
            <label for="editLink" class="block text-sm font-medium text-gray-700">Nuevo Link</label>
            <input type="url" id="editLink" wire:model="link"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                placeholder="https://ejemplo.com/documento.pdf" required>
        </div>
        @error('link')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror

        <!-- Botones -->
        <div class="flex justify-end space-x-4">
            <button wire:click="cerrarModalD"
                class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded-lg transition">
                Cancelar
            </button>
            <button wire:click="actualizarLink"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition">
                Actualizar
            </button>
        </div>
    </div>
</x-info-modal>
