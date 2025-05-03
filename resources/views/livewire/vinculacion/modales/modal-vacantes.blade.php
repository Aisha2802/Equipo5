<x-info-modal wire:model="modalE">
    <div class="p-6">
        <h2 class="text-xl font-bold mb-4">Vacantes</h2>
        @if ($empresa->vacantes->isEmpty())
            <p class="text-gray-600">No hay vacantes disponibles.</p>
        @else
            <div class="space-y-4">
                @foreach ($empresa->vacantes as $vacante)
                    <div class="p-4 border rounded-lg shadow-sm">
                        <h4 class="text-lg font-semibold">{{ $vacante->titulo }}</h4>
                        <p class="text-gray-600">{{ $vacante->descripcion }}</p>
                        <p><strong>Ubicación:</strong> {{ $vacante->ubicacion }}</p>
                        <p><strong>Tipo:</strong> {{ $vacante->tipo }}</p>
                        <p><strong>Estado:</strong> 
                                <span class="{{ 
                                    $vacante->estado === 'abierta' ? 'text-green-600' : 
                                    ($vacante->estado === 'pendiente' ? 'text-yellow-600' : 'text-red-600') 
                                }}">
                                    {{ $vacante->estado }}
                                </span>   
    
                        </p>

                        <h5 class="mt-2 font-semibold">Requisitos:</h5>
                        <ul class="list-disc list-inside">
                            @foreach ($vacante->perfiles as $perfil)
                                <li>
                                    {{ $perfil->carrera->nombre }} - {{ $perfil->especialidad->nombre }}
                                </li>
                            @endforeach
                        </ul>
                        <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition">Aceptar</button>
                        <button class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg transition">Rechazar</button>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-info-modal>
