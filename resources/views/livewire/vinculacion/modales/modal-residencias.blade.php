<!--Modal para ver los detalles de las empresas-->
<x-info-modal wire:model="modal">
    <div class="p-6">
        <h2 class="text-xl font-bold mb-4">{{ $title }}</h2>

        <!-- Mostrar los detalles de la empresa seleccionada -->
        @if ($empresaSeleccionada)
            <div class="space-y-4">
                <p><strong>RFC:</strong> {{ $empresaSeleccionada->RFC }}</p>
                <p><strong>Nombre Comercial:</strong> {{ $empresaSeleccionada->nombreComercial }}</p>
                <p><strong>Razón Social:</strong> {{ $empresaSeleccionada->razonSocial }}</p>
                <p><strong>Giro:</strong> {{ $empresaSeleccionada->giro }}</p>
                <p><strong>Número de Empleados:</strong> {{ $empresaSeleccionada->noEmpleado }}</p>
                <p><strong>Ubicación:</strong> {{ $empresaSeleccionada->ciudad }}, {{ $empresaSeleccionada->estado }}, {{ $empresaSeleccionada->pais }}</p>
                <p><strong>Sitio Web:</strong> <a href="{{ $empresaSeleccionada->sitioWeb }}" target="_blank" class="text-blue-500 hover:underline">{{ $empresaSeleccionada->sitioWeb }}</a></p>
            </div>
        @else
            <p>No se ha seleccionado ninguna empresa.</p>
        @endif
    </div>
</x-info-modal>