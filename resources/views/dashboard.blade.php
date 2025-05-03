<!-- Navegador Horizontal de las vistas -->
<x-app-layout>
    <x-slot name="header">
        <nav class="flex space-x-4 bg-gray-100 p-4 rounded-lg shadow-md sticky top-0 z-10">
            @php
                $links = [
                    'aspirante' => [
                        ['route' => 'dashboard.vacantesEstudiantes', 'label' => 'Estado de mis Vacantes'],
                        ['route' => 'dashboard.documento', 'label' => 'Seguimiento'],
                        ['route' => 'dashboard.encuestas', 'label' => 'Encuestas']
                    ],
                    'empresa' => [
                        ['route' => 'dashboard.vacante', 'label' => 'Mis Vacantes']
                    ],
                    'vinculacion' => [
                        ['route' => 'dashboard.empresas', 'label' => 'Vacantes de las empresas'],
                        ['route' => 'dashboard.alta-encuestas', 'label' => 'Encuestas']
                    ],
                    'jefe' => [
                        ['route' => 'dashboard.seguimiento', 'label' => 'Seguimiento de Residencias'],
                        ['route' => 'dashboard.seguimiento-empleos', 'label' => 'Seguimiento de Egresados']
                    ]
                ];
            @endphp
            
            @foreach ($links as $role => $routes)
                @if (Auth::user()->role === $role || Auth::user()->role === 'admin')
                    @foreach ($routes as $link)
                        <a href="{{ route($link['route']) }}"
                           class="px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs($link['route']) ? 'bg-blue-900 text-white' : 'text-blue-900 hover:bg-blue-900 hover:text-white' }}">
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                @endif
            @endforeach
        </nav>
    </x-slot>

    <div class="py-12">
        <div class="min-h-screen max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4 border-b border-gray-200"></div>
                    @switch($submodulo)
                        @case(1) @livewire('inicio') @break
                        @case(2) @livewire('vinculacion.estudiante-component') @break
                        @case(3) @livewire('vinculacion.carreras-component') @break
                        @case(4) @livewire('vinculacion.estadisticas-component') @break
                        @case(5) @livewire('vinculacion.control-vacante') @break
                        @case(6) @livewire('vinculacion.solicitudes') @break
                        @case(7) @livewire('vinculacion.confirmarvacante') @break
                        @case(8) @livewire('vinculacion.crearempresa') @break
                        @case(9) @livewire('vinculacion.empresas-component') @break
                        @case(10) @livewire('vinculacion.encuestas-component') @break
                        @case(11) @livewire('vinculacion.alta-encuestas-component') @break
                        @case(12) @livewire('vinculacion.documentos') @break
                        @case(13) @livewire('vinculacion.papeles-component') @break
                        @case(14) @livewire('vinculacion.seguimiento') @break
                        @case(15) @livewire('vinculacion.crear-encuesta') @break
                        @case(16) @livewire('vinculacion.estadisticas-solicitudes') @break
                        @case(17) @livewire('vinculacion.seguimiento-empleos') @break
                    @endswitch
                </div>
            </div>
        </div>
    </div>
    @component('components.footer')
    @endcomponent
</x-app-layout>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.plugin(Collapse)
    })
</script>
