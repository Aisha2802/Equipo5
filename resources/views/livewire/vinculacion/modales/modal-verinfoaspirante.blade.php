<!--Modal para ver la informacion del aspirante-->
<x-info-modal wire:model="modal">
    <div class="p-6">
        <h2 class="text-lg font-semibold mb-4">{{ $title }}</h2>
        <div class="space-y-4">
            <p><strong>Nombre:</strong> {{ $nombre }}</p>
            <p><strong>Número de Control:</strong> {{ $numero_control }}</p>
            <p><strong></strong> {{ $estado }}</p>

            <!-- Mostrar el CV si está aprobado -->
            @if ($cvAprobado)
                <p><strong>CV:</strong> 
                    <a href="{{ $cvLink }}" target="_blank" class="text-blue-500 hover:underline">
                        Ver CV
                    </a>
                </p>
            @else
                <p><strong>CV:</strong> No disponible.</p>
            @endif
        </div>

        <!-- Botón para cerrar el modal -->
        <div class="mt-6 flex justify-end">
            <button
                wire:click="$set('modal', false)"
                class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded-lg transition"
            >
                Cerrar
            </button>
        </div>
    </div>
</x-info-modal>