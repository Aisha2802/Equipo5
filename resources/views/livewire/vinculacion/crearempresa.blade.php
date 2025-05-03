<div class="bg-white p-6 rounded-lg shadow-lg max-w-3xl mx-auto">
<div>
    @if (Auth::user()->role === 'vinculacion')
        <!-- Título -->
        <h1 class="text-2xl font-bold mb-4">Crear Nueva Empresa</h1>

        <!-- Mensajes flash mejorados -->
        @if (session()->has('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg flex items-center space-x-2 max-w-sm z-50">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session()->has('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                class="fixed bottom-4 right-4 bg-red-500 text-white px-4 py-3 rounded-lg shadow-lg flex items-center space-x-2 max-w-sm z-50">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Formulario -->
        <form wire:submit.prevent="guardarEmpresa">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- RFC -->
                <div>
                    <label for="RFC" class="block text-sm font-medium text-gray-700">RFC</label>
                    <input type="text" wire:model="RFC" id="RFC"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    @error('RFC') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Nombre Comercial -->
                <div>
                    <label for="nombreComercial" class="block text-sm font-medium text-gray-700">Nombre Comercial</label>
                    <input type="text" wire:model="nombreComercial" id="nombreComercial"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    @error('nombreComercial') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Razón Social -->
                <div>
                    <label for="razonSocial" class="block text-sm font-medium text-gray-700">Razón Social</label>
                    <input type="text" wire:model="razonSocial" id="razonSocial"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    @error('razonSocial') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Giro -->
                <div>
                    <label for="giro" class="block text-sm font-medium text-gray-700">Giro</label>
                    <input type="text" wire:model="giro" id="giro"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    @error('giro') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Número de Empleados -->
                <div>
                    <label for="noEmpleado" class="block text-sm font-medium text-gray-700">Número de Empleados</label>
                    <input type="number" wire:model="noEmpleado" id="noEmpleado"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    @error('noEmpleado') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Código Postal -->
                <div>
                    <label for="codigoPostal" class="block text-sm font-medium text-gray-700">Código Postal</label>
                    <input type="text" wire:model="codigoPostal" id="codigoPostal"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    @error('codigoPostal') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Colonia -->
                <div>
                    <label for="colonia" class="block text-sm font-medium text-gray-700">Colonia</label>
                    <input type="text" wire:model="colonia" id="colonia"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    @error('colonia') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Ciudad -->
                <div>
                    <label for="ciudad" class="block text-sm font-medium text-gray-700">Ciudad</label>
                    <input type="text" wire:model="ciudad" id="ciudad"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    @error('ciudad') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Estado -->
                <div>
                    <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                    <input type="text" wire:model="estado" id="estado"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    @error('estado') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- País -->
                <div>
                    <label for="pais" class="block text-sm font-medium text-gray-700">País</label>
                    <input type="text" wire:model="pais" id="pais"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    @error('pais') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Sitio Web -->
                <div class="col-span-2">
                    <label for="sitioWeb" class="block text-sm font-medium text-gray-700">Sitio Web</label>
                    <input type="url" wire:model="sitioWeb" id="sitioWeb"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    @error('sitioWeb') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Botón para guardar -->
            <div class="mt-6 text-center">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow-md transition-all">
                    Guardar Empresa
                </button>
            </div>
        </form>
    @endif
</div>