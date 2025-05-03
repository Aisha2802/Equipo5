<!-- Modal para agregar una nueva vacante -->
<x-info-modal wire:model="modal">
    <div class="p-6">
        <h2 class="text-lg font-semibold mb-4">{{ $title }}</h2>

        <!-- Formulario para crear una nueva vacante -->
        <form wire:submit.prevent="guardarVacante">
            <!-- Título -->
            <div class="mb-4">
                <label for="titulo" class="block text-sm font-medium text-gray-700">Título</label>
                <input
                    type="text"
                    id="titulo"
                    wire:model="titulo"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    required
                >
            </div>

            <!-- Descripción -->
            <div class="mb-4">
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea
                    id="descripcion"
                    wire:model="descripcion"
                    rows="3"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    required
                ></textarea>
            </div>

            <!-- Ubicación -->
            <div class="mb-4">
                <label for="ubicacion" class="block text-sm font-medium text-gray-700">Ubicación</label>
                <input
                    type="text"
                    id="ubicacion"
                    wire:model="ubicacion"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    required
                >
            </div>

            <!-- Tipo de vacante -->
            <div class="mb-4">
                <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo de vacante</label>
                <select
                    id="tipo"
                    wire:model="tipo"
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
                <label for="perfil_id" class="block text-sm font-medium text-gray-700">Perfil</label>
                <select
                    id="perfil_id"
                    wire:model="perfil_id"
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
                <label for="max" class="block text-sm font-medium text-gray-700">Número máximo de vacantes</label>
                <input
                    type="number"
                    id="max"
                    wire:model="max"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    min="1"
                    required
                >
            </div>

            <!-- Pago (opcional, sin negativos) -->
            <div class="mb-4">
                <label for="pago" class="block text-sm font-medium text-gray-700">Pago (opcional)</label>
                <input
                    type="number"
                    id="pago"
                    wire:model="pago"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    min="0"
                >
            </div>

            <!-- Botones -->
            <div class="mt-6 flex justify-end">
                <button
                    type="button"
                    wire:click="$set('modal', false)"
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
