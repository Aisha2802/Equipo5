<!-- Seguimiento de Documentos (Vista Vinculacion) -->
<div>
    @if (Auth::user()->role === 'vinculacion')
        <h1 class="text-2xl font-bold mb-4">Seguimiento de Documentos Pendientes</h1>

        @if ($seguimientos->isEmpty())
            <p class="text-gray-600">No hay documentos pendientes de revisión.</p>
        @else
            <div class="space-y-4">
                @foreach ($seguimientos as $seguimiento)
                    <div class="p-4 border rounded-lg shadow-sm">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-lg font-semibold">
                                    Aspirante: {{ $seguimiento->aspirante->nombre ?? 'Nombre no disponible' }}
                                </p>
                                <p class="text-gray-600">
                                    Tipo de Documento: {{ $seguimiento->tipo->nombre }}
                                </p>
                                <p class="text-gray-600">
                                    Link del Documento:
                                    <a href="{{ $seguimiento->documento->link }}" target="_blank"
                                        class="text-blue-500 hover:underline">
                                        {{ $seguimiento->documento->link }}
                                    </a>
                                </p>
                            </div>
                            <div class="space-x-2">
                                <!-- Botón para aceptar el documento -->
                                <button wire:click="aceptarDocumento('{{ $seguimiento->id }}')"
                                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg transition">
                                    Aceptar
                                </button>
                                <!-- Botón para rechazar el documento -->
                                <button wire:click="rechazarDocumento('{{ $seguimiento->id }}')"
                                    class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg transition">
                                    Rechazar
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif
</div>
