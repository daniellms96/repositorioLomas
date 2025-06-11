<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{-- Mensaje de confirmación de área segura. --}}
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div>
            {{-- Etiqueta para el campo de contraseña. --}}
            <x-input-label for="password" :value="__('Password')" />

            {{-- Campo de entrada para la contraseña. --}}
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            {{-- Muestra errores de validación para la contraseña. --}}
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            {{-- Botón para confirmar la contraseña. --}}
            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>