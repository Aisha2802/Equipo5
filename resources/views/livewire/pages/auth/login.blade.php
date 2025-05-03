<!--LOGIN -->
<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex h-auto items-start justify-center bg-gray-75 p-6 mt-[-20px]">
    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-4 relative py-4">

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <h2 class="text-2xl font-semibold text-center text-gray-800 mb-4">Iniciar Sesión</h2>

        <form wire:submit="login">
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input wire:model="form.email" id="email"
                    class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    type="email" name="email" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-red-500" />
            </div>

            <!-- Password -->
            <div class="mt-3 relative">
                <label for="password" class="block text-sm font-medium text-gray-700">
                    {{ __('Password') }}
                </label>
            
                <div class="relative">
                    <input wire:model="form.password" id="password"
                        class="block mt-1 w-full border-gray-300 rounded-md shadow-sm pr-10 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        type="password" name="password" required autocomplete="current-password" />
                </div>
            
                <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-red-500" />
            </div>
            <!-- Remember Me -->
            <div class="block mt-3">
                <label for="remember" class="inline-flex items-center">
                    <input wire:model="form.remember" id="remember" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Recordarme') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-3">
                @if (Route::has('password.request'))
                    <a class="text-sm text-indigo-600 hover:underline" href="{{ route('password.request') }}"
                        wire:navigate>
                        {{ __('¿Olvidaste tu contraseña?') }}
                    </a>
                @endif

                <x-primary-button
                    class="ms-3 px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-all">
                    {{ __('Ingresar') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>

<script>
    function togglePasswordVisibility(inputId, eyeIconId, eyeSlashIconId) {
        const passwordInput = document.getElementById(inputId);
        const eyeIcon = document.getElementById(eyeIconId);
        const eyeSlashIcon = document.getElementById(eyeSlashIconId);
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.add('hidden');
            eyeSlashIcon.classList.remove('hidden');
        } else {
            passwordInput.type = 'password';
            eyeSlashIcon.classList.add('hidden');
            eyeIcon.classList.remove('hidden');
        }
    }
</script>

