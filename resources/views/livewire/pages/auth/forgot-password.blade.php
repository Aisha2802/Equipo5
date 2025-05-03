<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div class="flex h-auto items-start justify-center bg-gray-75 p-6 mt-[-20px]">
    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6 relative py-6">
        <h2 class="text-2xl font-semibold text-center text-gray-800 mb-4">Recuperar Contraseña</h2>
        
        <div class="mb-4 text-sm text-gray-600 text-center">
            {{ __('¿Olvidaste tu contraseña? No hay problema. Ingresa tu correo y te enviaremos un enlace para restablecerla.') }}
        </div>
        
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
        
        <form wire:submit="sendPasswordResetLink">
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input wire:model="email" id="email" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="email" name="email" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
            </div>
        
            <div class="flex items-center justify-center mt-4">
                <x-primary-button class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-all">
                    {{ __('Enviar Enlace') }}
                </x-primary-button>
            </div>

            <!-- Botón para regresar al Login -->
            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold transition-all">
                    ← Volver al Login
                </a>
            </div>
        </form>
    </div>
</div>
