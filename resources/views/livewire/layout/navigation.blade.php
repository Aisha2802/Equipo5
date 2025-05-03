<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
   
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-end h-16">
            <div class="flex">
                <!-- Logo de laravel-->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" wire:navigate>
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                

                <!-- Contenedor principal -->
                <div x-data="{ isOpen: false }" class="flex min-h-screen">
                    <!-- Botón para abrir/cerrar la navegación -->
                    <button @click="isOpen = !isOpen" class="p-4 fixed top-0 left-0 z-50 focus:outline-none">
                        <!-- Icono de menú (Heroicons) -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>

                    <!-- Fondo oscuro semitransparente -->
                    <div x-show="isOpen" class="fixed inset-0 bg-black bg-opacity-50 z-40" @click="isOpen = false">
                    </div>

                    <!-- Menú lateral -->
                    <div id="sidebar" :class="isOpen ? 'translate-x-0' : '-translate-x-full'"
                        class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out z-50">
                        <!-- Contenido de la navegación -->
                        <div class="p-4">
                            <h2 class="text-lg font-semibold">Menú</h2>
                            <ul class="mt-4 space-y-2">
                                <li>
                                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                                        {{ __('Inicio') }}
                                    </x-nav-link>
                                </li>
                                @if (Auth::user()->role === 'vinculacion' || Auth::user()->role === 'admin')
                                    <li>
                                        <x-nav-link :href="route('dashboard.nuevaEmpresa')" :active="request()->routeIs('dashboard.nuevaEmpresa')" wire:navigate>
                                            {{ __('Crear nueva empresa') }}
                                        </x-nav-link>
                                    </li>
                                    <li>
                                        <x-nav-link :href="route('dashboard.crear-encuestas')" :active="request()->routeIs('dashboard.crear-encuestas')" wire:navigate>
                                            {{ __('Crear encuestas') }}
                                        </x-nav-link>
                                    <li>
                                    <li>
                                        <x-nav-link :href="route('dashboard.papeles')" :active="request()->routeIs('dashboard.papeles')" wire:navigate>
                                            {{ __('Revisión de documentos') }}
                                        </x-nav-link>
                                    </li>
                                        <x-nav-link :href="route('dashboard.reportes')" :active="request()->routeIs('dashboard.reportes')" wire:navigate>
                                            {{ __('Estadísticas de las encuestas') }}
                                        </x-nav-link>
                                    </li>
                                    <li>
                                        <x-nav-link :href="route('dashboard.estadistica-solicitud')" :active="request()->routeIs('dashboard.estadistica-solicitud')" wire:navigate>
                                            {{ __('Estadísticas de las solicitudes') }}
                                        </x-nav-link>
                                    </li>
                                    </li>
                                @endif

                                @if (Auth::user()->role === 'empresa' || Auth::user()->role === 'admin')
                                    <li>
                                        <x-nav-link :href="route('dashboard.encuestas')" :active="request()->routeIs('dashboard.encuestas')" wire:navigate>
                                            {{ __('Encuestas') }}
                                        </x-nav-link>
                                    </li>
                                    <li>
                                        <x-nav-link :href="route('dashboard.solicitud')" :active="request()->routeIs('dashboard.solicitud')" wire:navigate>
                                            {{ __('Solicitudes de mis vacantes') }}
                                        </x-nav-link>
                                    </li>
                                @endif

                                @if (Auth::user()->role === 'aspirante' || Auth::user()->role === 'admin')
                                    <li>
                                        <x-nav-link :href="route('dashboard.estudiantes')" :active="request()->routeIs('dashboard.estudiantes')" wire:navigate>
                                            {{ __('Buscar vacantes') }}
                                        </x-nav-link>
                                    </li>
                                @endif

                                @if (Auth::user()->role === 'jefe' || Auth::user()->role === 'admin')
                                    <li>
                                        <x-nav-link :href="route('dashboard.seguimiento')" :active="request()->routeIs('dashboard.seguimiento')" wire:navigate>
                                            {{ __('Seguimiento de Residencias') }}
                                        </x-nav-link>
                                    </li>
                                    <li>
                                        <x-nav-link :href="route('dashboard.reportes')" :active="request()->routeIs('dashboard.reportes')" wire:navigate>
                                            {{ __('Estadísticas de las encuestas') }}
                                        </x-nav-link>
                                    </li>
                                    <li>
                                        <x-nav-link :href="route('dashboard.estadistica-solicitud')" :active="request()->routeIs('dashboard.estadistica-solicitud')" wire:navigate>
                                            {{ __('Estadísticas de las solicitudes') }}
                                        </x-nav-link>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name"
                                    x-on:profile-updated.window="name = $event.detail.name"></div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Authentication -->
                            <button wire:click="logout" class="w-full text-start">
                                <x-dropdown-link>
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </button>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Hamburger -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name"
                        x-on:profile-updated.window="name = $event.detail.name"></div>
                    <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile')" wire:navigate>
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <button wire:click="logout" class="w-full text-start">
                        <x-responsive-nav-link>
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </button>
                </div>
            </div>
        </div>
</nav>
