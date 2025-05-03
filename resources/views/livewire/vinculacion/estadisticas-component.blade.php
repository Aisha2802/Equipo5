<div class="p-6 bg-white rounded-lg shadow">
    @if (Auth::user()->role === 'vinculacion' || Auth::user()->role === 'jefe')
        <h2 class="text-2xl font-bold mb-6">Estadísticas de Encuestas</h2>

        <!-- Filtros -->
        <div class="flex space-x-4 mb-6">
            <button wire:click="cambiarFiltro('todos')"
                class="{{ $filtroTipo === 'todos' ? 'bg-indigo-600 text-white' : 'bg-gray-200' }} px-4 py-2 rounded">
                Todas
            </button>
            <button wire:click="cambiarFiltro('estudiante')"
                class="{{ $filtroTipo === 'estudiante' ? 'bg-indigo-600 text-white' : 'bg-gray-200' }} px-4 py-2 rounded">
                Estudiantes
            </button>
            <button wire:click="cambiarFiltro('empresa')"
                class="{{ $filtroTipo === 'empresa' ? 'bg-indigo-600 text-white' : 'bg-gray-200' }} px-4 py-2 rounded">
                Empresas
            </button>
        </div>

        <!-- Selector de encuesta -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Selecciona una encuesta:</label>
            <select wire:model.live="encuestaSeleccionadaId"
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">-- Selecciona una encuesta --</option>
                @foreach ($encuestas as $encuesta)
                    <option value="{{ $encuesta->encuesta_id }}">{{ $encuesta->titulo }}</option>
                @endforeach
            </select>
        </div>

        <!-- Mensaje cuando no hay respuestas -->
        @if ($mostrarMensajeSinDatos)
            <div class="p-4 bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-lg">
                <p class="font-medium">No hay suficientes respuestas para generar estadísticas.</p>
                <p class="text-sm mt-1">Esta encuesta aún no ha sido respondida por ningún usuario.</p>
            </div>
        @endif

        <!-- Estadísticas -->
        @if ($encuestaSeleccionadaId && count($estadisticas) > 0)
            <div class="space-y-8">
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="font-medium text-blue-800">Total de respuestas recibidas: {{ $totalRespuestasEncuesta }}
                    </p>
                </div>

                @foreach ($estadisticas as $estadistica)
                    <div class="p-4 border rounded-lg">
                        <h3 class="font-semibold text-lg mb-4">{{ $estadistica['pregunta'] }}</h3>

                        @if ($estadistica['tipo'] === 'rango')
                            <div class="mb-4">
                                <p class="text-gray-600">Promedio: <span
                                        class="font-bold">{{ $estadistica['promedio'] }}/5</span></p>
                                <p class="text-gray-600">Total respuestas: {{ $estadistica['total_respuestas'] }}</p>
                            </div>

                            <div class="space-y-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="flex items-center">
                                        <span class="w-8 text-gray-600">{{ $i }}:</span>
                                        <div class="flex-1 bg-gray-200 rounded h-4">
                                            @if ($estadistica['total_respuestas'] > 0)
                                                <div class="bg-indigo-600 h-4 rounded"
                                                    style="width: {{ ($estadistica['distribucion'][$i] / $estadistica['total_respuestas']) * 100 }}%">
                                                </div>
                                            @endif
                                        </div>
                                        <span class="ml-2 text-sm text-gray-600">
                                            {{ $estadistica['distribucion'][$i] }}
                                            ({{ $estadistica['total_respuestas'] > 0 ? number_format(($estadistica['distribucion'][$i] / $estadistica['total_respuestas']) * 100, 1) : 0 }}%)
                                        </span>
                                    </div>
                                @endfor
                            </div>
                        @elseif ($estadistica['tipo'] === 'opcion_multiple')
                            <p class="text-gray-600 mb-4">Total respuestas: {{ $estadistica['total_respuestas'] }}</p>

                            <div class="space-y-2">
                                @foreach ($estadistica['opciones'] as $opcion => $conteo)
                                    <div class="flex items-center">
                                        <span class="w-48 text-gray-600">{{ $opcion }}:</span>
                                        <div class="flex-1 bg-gray-200 rounded h-4">
                                            @if ($estadistica['total_respuestas'] > 0)
                                                <div class="bg-indigo-600 h-4 rounded"
                                                    style="width: {{ ($conteo / $estadistica['total_respuestas']) * 100 }}%">
                                                </div>
                                            @endif
                                        </div>
                                        <span class="ml-2 text-sm text-gray-600">
                                            {{ $conteo }}
                                            ({{ $estadistica['total_respuestas'] > 0 ? number_format(($conteo / $estadistica['total_respuestas']) * 100, 1) : 0 }}%)
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @elseif ($estadistica['tipo'] === 'texto')
                            <div class="p-4 border rounded-lg">
                                <p class="text-gray-600 mb-4">Total de comentarios:
                                    {{ $estadistica['total_respuestas'] }}</p>

                                @if ($estadistica['total_respuestas'] > 0)
                                    <div class="space-y-4 max-h-96 overflow-y-auto">
                                        @foreach ($estadistica['comentarios'] as $comentario)
                                            <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                                                <p class="text-gray-700">{{ $comentario->respuesta }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500 italic">No hay comentarios para esta pregunta.</p>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @elseif ($encuestaSeleccionadaId && count($estadisticas) === 0 && !$mostrarMensajeSinDatos)
            <p class="text-gray-500">No hay estadísticas disponibles para esta encuesta.</p>
        @elseif (!$encuestaSeleccionadaId)
            <p class="text-gray-500">Selecciona una encuesta para ver las estadísticas.</p>
        @endif
    @endif
</div>
