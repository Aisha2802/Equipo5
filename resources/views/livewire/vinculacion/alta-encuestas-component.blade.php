<!-- Menu encuestas (vista para vinculacion) -->
<div class="py-6">
    @if (Auth::user()->role === 'vinculacion')
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold mb-6">Administración de Encuestas</h2>

                    <!-- Filtros -->
                    <div class="mb-6">
                        <div class="flex space-x-4">
                            <button wire:click="cambiarFiltro('todos')"
                                class="px-4 py-2 rounded-md {{ $filtroTipo === 'todos' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                Todas
                            </button>
                            <button wire:click="cambiarFiltro('estudiante')"
                                class="px-4 py-2 rounded-md {{ $filtroTipo === 'estudiante' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                Estudiantes
                            </button>
                            <button wire:click="cambiarFiltro('egresado')"
                                class="px-4 py-2 rounded-md {{ $filtroTipo === 'egresado' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                Egresados
                            </button>
                            <button wire:click="cambiarFiltro('empresa')"
                                class="px-4 py-2 rounded-md {{ $filtroTipo === 'empresa' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                Empresas
                            </button>
                        </div>
                    </div>

                    <!-- Tabla de encuestas -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Título
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Descripción
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tipo
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Usuarios que han respondido
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Estado
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($encuestas as $encuesta)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $encuesta->encuesta_id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $encuesta->titulo }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-normal max-w-xs">
                                            {{ $encuesta->descripcion }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                   {{ $encuesta->tipo === 'estudiante'
                                                       ? 'bg-blue-100 text-blue-800'
                                                       : ($encuesta->tipo === 'empresa'
                                                           ? 'bg-green-100 text-green-800'
                                                           : 'bg-purple-100 text-purple-800') }}">
                                                {{ $encuesta->tipo === 'estudiante' ? 'Estudiante' : ($encuesta->tipo === 'empresa' ? 'Empresa' : 'Egresado') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                {{ $contadorRespuestas[$encuesta->encuesta_id] ?? 0 }}
                                                {{ ($contadorRespuestas[$encuesta->encuesta_id] ?? 0) == 1
                                                    ? ($encuesta->tipo === 'estudiante' 
                                                        ? 'estudiante' 
                                                        : ($encuesta->tipo === 'empresa' 
                                                            ? 'empresa' 
                                                            : 'egresado'))
                                                    : ($encuesta->tipo === 'estudiante' 
                                                        ? 'estudiantes' 
                                                        : ($encuesta->tipo === 'empresa' 
                                                            ? 'empresas' 
                                                            : 'egresados')) }}
                                            </span>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $encuesta->habilitada ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $encuesta->habilitada ? 'Habilitada' : 'Deshabilitada' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button wire:click="toggleHabilitada({{ $encuesta->encuesta_id }})"
                                                class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                {{ $encuesta->habilitada ? 'Deshabilitar' : 'Habilitar' }}
                                            </button>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7"
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            No hay encuestas disponibles con los filtros seleccionados.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mensajes de éxito o error -->
                    @if (session()->has('message'))
                        <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('message') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
