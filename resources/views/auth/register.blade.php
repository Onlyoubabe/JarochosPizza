<x-guest-layout>
    <div x-data="{ showForm: false }" x-init="setTimeout(() => showForm = true, 500)">
        <h2 class="text-3xl font-bold text-gray-900 mb-2 font-serif"
            x-show="showForm"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0">
            Crear Cuenta
        </h2>
        <p class="text-gray-500 mb-8"
           x-show="showForm"
           x-transition:enter="transition ease-out duration-500 delay-100"
           x-transition:enter-start="opacity-0 translate-y-2"
           x-transition:enter-end="opacity-100 translate-y-0">
            Únete a nosotros y empieza a pedir deliciosas pizzas.
        </p>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Name -->
            <div x-show="showForm"
                 x-transition:enter="transition ease-out duration-500 delay-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <x-input-label for="name" :value="__('Nombre')" />
                <x-text-input id="name" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:bg-white focus:border-red-500 focus:ring-red-500 transition-all" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Juan Pérez" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div x-show="showForm"
                 x-transition:enter="transition ease-out duration-500 delay-300"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <x-input-label for="email" :value="__('Correo Electrónico')" />
                <x-text-input id="email" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:bg-white focus:border-red-500 focus:ring-red-500 transition-all" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nombre@ejemplo.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div x-show="showForm"
                 x-transition:enter="transition ease-out duration-500 delay-400"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <x-input-label for="password" :value="__('Contraseña')" />

                <x-text-input id="password" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:bg-white focus:border-red-500 focus:ring-red-500 transition-all"
                                type="password"
                                name="password"
                                required autocomplete="new-password" placeholder="••••••••" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div x-show="showForm"
                 x-transition:enter="transition ease-out duration-500 delay-500"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:bg-white focus:border-red-500 focus:ring-red-500 transition-all"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div x-show="showForm"
                 x-transition:enter="transition ease-out duration-500 delay-600"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <x-primary-button class="w-full justify-center bg-red-600 hover:bg-red-700 active:bg-red-800 shadow-lg shadow-red-500/20 py-3 text-base transition-all hover:-translate-y-0.5">
                    {{ __('Registrarse') }}
                </x-primary-button>
            </div>
            
            <div class="text-center mt-6 text-sm text-gray-500"
                 x-show="showForm"
                 x-transition:enter="transition ease-out duration-500 delay-700"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100">
                ¿Ya tienes una cuenta? 
                <a href="{{ route('login') }}" class="font-semibold text-red-600 hover:text-red-500 transition-colors">Inicia Sesión</a>
            </div>
        </form>
    </div>
</x-guest-layout>
