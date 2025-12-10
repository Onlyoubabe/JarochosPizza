<x-guest-layout>
    <div x-data="{ showForm: false }" x-init="setTimeout(() => showForm = true, 500)">
        <h2 class="text-3xl font-bold text-gray-900 mb-2 font-serif" 
            x-show="showForm"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0">
            Bienvenido de nuevo
        </h2>
        <p class="text-gray-500 mb-8"
           x-show="showForm"
           x-transition:enter="transition ease-out duration-500 delay-100"
           x-transition:enter-start="opacity-0 translate-y-2"
           x-transition:enter-end="opacity-100 translate-y-0">
            Ingresa tus datos para iniciar sesión.
        </p>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div x-show="showForm"
                 x-transition:enter="transition ease-out duration-500 delay-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <x-input-label for="email" :value="__('Correo Electrónico')" />
                <x-text-input id="email" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:bg-white focus:border-red-500 focus:ring-red-500 transition-all" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nombre@ejemplo.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div x-show="showForm"
                 x-transition:enter="transition ease-out duration-500 delay-300"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <x-input-label for="password" :value="__('Contraseña')" />

                <x-text-input id="password" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:bg-white focus:border-red-500 focus:ring-red-500 transition-all"
                                type="password"
                                name="password"
                                required autocomplete="current-password" placeholder="••••••••" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between" 
                 x-show="showForm"
                 x-transition:enter="transition ease-out duration-500 delay-400"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500 group-hover:border-red-400 transition-colors" name="remember">
                    <span class="ms-2 text-sm text-gray-600 group-hover:text-gray-800 transition-colors">{{ __('Recuérdame') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-500 hover:text-red-600 transition-colors" href="{{ route('password.request') }}">
                        {{ __('¿Olvidaste tu contraseña?') }}
                    </a>
                @endif
            </div>

            <div x-show="showForm"
                 x-transition:enter="transition ease-out duration-500 delay-500"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <x-primary-button class="w-full justify-center bg-red-600 hover:bg-red-700 active:bg-red-800 shadow-lg shadow-red-500/20 py-3 text-base transition-all hover:-translate-y-0.5">
                    {{ __('Iniciar Sesión') }}
                </x-primary-button>
            </div>
            
            <div class="text-center mt-6 text-sm text-gray-500"
                 x-show="showForm"
                 x-transition:enter="transition ease-out duration-500 delay-600"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100">
                ¿No tienes una cuenta? 
                <a href="{{ route('register') }}" class="font-semibold text-red-600 hover:text-red-500 transition-colors">Regístrate</a>
            </div>
        </form>
    </div>
</x-guest-layout>
