<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Esta es una área segura de la aplicación. Por favor confirma tu contraseña antes de continuar.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Contraseña')" />

            <x-text-input id="password" class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button class="bg-red-600 hover:bg-red-700 focus:bg-red-700 active:bg-red-800">
                {{ __('Confirmar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
