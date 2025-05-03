<!-- Modal para editar una vacante -->
<x-info-modal wire:model="modalE">
    <div class="p-6">
        <h2 class="text-lg font-semibold mb-4">{{ $titleE }}</h2>

        <!-- Formulario para editar la vacante -->
        <form wire:submit.prevent="actualizarVacante">
            <!-- Título -->
            <div class="mb-4">
                <label for="tituloE" class="block text-sm font-medium text-gray-700">Título</label>
                <input
                    type="text"
                    id="tituloE"
                    wire:model="tituloE"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    required
                >
            </div>

            <!-- Descripción -->
            <div class="mb-4">
                <label for="descripcionE" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea
                    id="descripcionE"
                    wire:model="descripcionE"
                    rows="3"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    required
                ></textarea>
            </div>

            <!-- Ubicación -->
            <div class="mb-4">
                <label for="ubicacionE" class="block text-sm font-medium text-gray-700">Ubicación</label>
                <input
                    type="text"
                    id="ubicacionE"
                    wire:model="ubicacionE"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    required
                >
            </div>

            <!-- Tipo de vacante -->
            <div class="mb-4">
                <label for="tipoE" class="block text-sm font-medium text-gray-700">Tipo de vacante</label>
                <select
                    id="tipoE"
                    wire:model="tipoE"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    required
                >
                    <option value="">Seleccione un tipo</option>
                    <option value="empleo">Empleo</option>
                    <option value="residencia">Residencia</option>
                </select>
            </div>

            <!-- Perfil -->
            <div class="mb-4">
                <label for="perfil_idE" class="block text-sm font-medium text-gray-700">Perfil</label>
                <select
                    id="perfil_idE"
                    wire:model="perfil_idE"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    required
                >
                    <option value="">Seleccione un perfil</option>
                    @foreach ($perfiles as $perfil)
                        <option value="{{ $perfil->perfil_id }}">{{ $perfil->carrera->nombre }} - {{ $perfil->especialidad->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Máximo de vacantes (mínimo 1, sin negativos ni cero) -->
            <div class="mb-4">
                <label for="maxE" class="block text-sm font-medium text-gray-700">Número máximo de vacantes</label>
                <input
                    type="number"
                    id="maxE"
                    wire:model="maxE"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    min="1"
                    required
                >
            </div>

            <!-- Pago (opcional, sin negativos) -->
            <div class="mb-4">
                <label for="pagoE" class="block text-sm font-medium text-gray-700">Pago (opcional)</label>
                <input
                    type="number"
                    id="pagoE"
                    wire:model="pagoE"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    min="0"
                >
            </div>

            <!-- Botones -->
            <div class="mt-6 flex justify-end">
                <button
                    type="button"
                    wire:click="$set('modalE', false)"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded-lg transition mr-2"
                >
                    Cancelar
                </button>
                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition"
                >
                    Guardar
                </button>
            </div>
        </form>
    </div>
</x-info-modal>
