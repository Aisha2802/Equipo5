<!-- Modal para ver la información de la vacante -->
<x-info-modal wire:model="modalV">
    <div class="p-6">
        <h2 class="text-lg font-semibold mb-4">{{ $titleV }}</h2>

        <!-- Mostrar los detalles de la vacante -->
        <div class="space-y-4">
            <p><strong>Título:</strong> {{ $tituloV }}</p>
            <p><strong>Descripción:</strong> {{ $descripcionV }}</p>
            <p><strong>Ubicación:</strong> {{ $ubicacionV }}</p>
            <p><strong>Tipo:</strong> {{ $tipoV }}</p>
            <p><strong>Estado:</strong>
                <span
                    class="{{ $estadoV === 'abierta' ? 'text-green-600' : ($estadoV === 'pendiente' ? 'text-yellow-600' : 'text-red-600') }}">
                    {{ $estadoV }}
                </span>
            </p>
            <div class="mb-2">
                <span class="font-semibold">Cupos disponibles:</span> {{ $maxV }}
            </div>
            <p><strong>Pago:</strong> {{ $pagoV ? '$' . number_format($pagoV, 2) : 'No especificado' }}</p>
            <!-- Mostrar el perfil requerido de una manera más estilizada -->
            <div class="flex items-center">
                <p>
                    <strong>Perfil Requerido:</strong>
                    <span>{{ $carreraV ?? 'No especificado' }}</span>
                </p>
                <p>
                    <strong>-</strong>
                    <span>{{ $especialidadV ?? 'No especificado' }}</span>
                </p>
            </div>

        </div>
    </div>
</x-info-modal>
