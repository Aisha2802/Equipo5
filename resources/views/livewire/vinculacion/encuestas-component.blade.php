<div>
    @if(Auth::user()->role === 'aspirante' || Auth::user()->role === 'empresa')
    <!-- Selector de encuesta -->
    <div class="mb-4">
        <label for="encuesta" class="block text-sm font-medium text-gray-700">Selecciona una encuesta:</label>
        <select
            id="encuesta"
            wire:model.live="encuestaSeleccionadaId"
            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
        >
            <option value="">-- Selecciona una encuesta --</option>
            @foreach ($encuestas as $encuesta)
                <option value="{{ $encuesta->encuesta_id }}">{{ $encuesta->titulo }}</option>
            @endforeach
        </select>
    </div>

    <!-- Mensaje de encuesta ya contestada -->
    @if ($encuestaSeleccionadaId && $encuestaYaContestada)
        <div class="p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded mb-4">
            <p class="font-medium">Ya has contestado esta encuesta anteriormente.</p>
            <p>No es posible volver a contestarla. Por favor, selecciona otra encuesta si deseas continuar.</p>
        </div>
   
    <!-- Formulario de preguntas -->
    @elseif ($encuestaSeleccionadaId && count($preguntas) > 0)
        <div class="space-y-4">
            @foreach ($preguntas as $index => $pregunta)
                <div class="p-4 bg-white shadow-sm rounded-lg border @error('respuestas.'.$pregunta->pregunta_id) border-red-500 @enderror">
                    <p class="font-medium text-gray-900">
                        {{ $pregunta->texto }}
                        <!-- Mostrar asterisco si es obligatoria -->
                        @if(!($loop->last && $pregunta->tipo === 'texto'))
                            <span class="text-red-500">*</span>
                        @endif
                    </p>

                    <!-- Mostrar error de validación -->
                    @error('respuestas.'.$pregunta->pregunta_id)
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <!-- Campo de respuesta según tipo -->
                    @if ($pregunta->tipo === 'rango')
                        @php
                            $opciones = json_decode($pregunta->opciones);
                        @endphp
                        
                        @if ($opciones && isset($opciones->min) && isset($opciones->max))
                            <div class="mt-2">
                                <select 
                                    wire:model.live="respuestas.{{ $pregunta->pregunta_id }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('respuestas.'.$pregunta->pregunta_id) border-red-500 @enderror"
                                >
                                    <option value="">-- Selecciona --</option>
                                    @for ($i = $opciones->min; $i <= $opciones->max; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        @else
                            <div class="text-red-500">Error: Formato de opciones inválido</div>
                        @endif
                    @elseif ($pregunta->tipo === 'opcion_multiple')
                        @php
                            $opciones = json_decode($pregunta->opciones);
                        @endphp
                        
                        @if ($opciones && is_array($opciones))
                            <div class="mt-2 space-y-2">
                                @foreach ($opciones as $opcion)
                                    <label class="inline-flex items-center block">
                                        <input 
                                            type="radio" 
                                            wire:model.live="respuestas.{{ $pregunta->pregunta_id }}" 
                                            value="{{ $opcion }}" 
                                            class="form-radio"
                                        >
                                        <span class="ml-2">{{ $opcion }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <div class="text-red-500">Error: Formato de opciones inválido</div>
                        @endif
                    @elseif ($pregunta->tipo === 'texto')
                        <div class="mt-2">
                            <textarea 
                                wire:model.live="respuestas.{{ $pregunta->pregunta_id }}"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('respuestas.'.$pregunta->pregunta_id) border-red-500 @enderror"
                                placeholder="{{ $loop->last ? 'Comentarios (opcional)' : 'Por favor ingresa tu respuesta' }}"
                            ></textarea>
                        </div>
                    @endif
                </div>
            @endforeach
            
            <!-- Botón de enviar -->
            <div class="mt-6">
                <button 
                    type="button"
                    wire:click="guardarRespuestas"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Enviar respuestas
                </button>
            </div>
            
            <!-- Nota sobre campos obligatorios -->
            <div class="mt-2 text-sm text-gray-500">
                <p>Los campos marcados con <span class="text-red-500">*</span> son obligatorios.</p>
            </div>
        </div>
    @elseif ($encuestaSeleccionadaId && count($preguntas) === 0 && !$encuestaYaContestada)
        <p class="text-gray-500">No hay preguntas disponibles para esta encuesta.</p>
    @else
        <p class="text-gray-500">Selecciona una encuesta para ver sus preguntas.</p>
    @endif
    
    <!-- Mensajes flash -->
    @if (session()->has('message'))
        <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif
    @endif
</div>