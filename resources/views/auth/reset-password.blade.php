<x-guest-layout>
    {{-- Formulario para restablecer la contraseña --}}
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        {{-- Token de restablecimiento de contraseña (oculto) --}}
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        {{-- Campo para la dirección de correo electrónico --}}
        <div>
            {{-- Etiqueta del campo de correo electrónico --}}
            <x-input-label for="email" :value="__('Email')" />
            {{-- Campo de texto para el correo electrónico, precargado con el valor antiguo o de la petición --}}
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            {{-- Muestra errores de validación para el campo de correo electrónico --}}
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Campo para la nueva contraseña --}}
        <div class="mt-4">
            {{-- Etiqueta del campo de contraseña --}}
            <x-input-label for="password" :value="__('Password')" />
            {{-- Campo de texto para la nueva contraseña --}}
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            {{-- Muestra errores de validación para el campo de contraseña --}}
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Campo para confirmar la nueva contraseña --}}
        <div class="mt-4">
            {{-- Etiqueta del campo de confirmación de contraseña --}}
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            {{-- Campo de texto para confirmar la contraseña --}}
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                 type="password"
                                 name="password_confirmation" required autocomplete="new-password" />

            {{-- Muestra errores de validación para el campo de confirmación de contraseña --}}
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Botón para enviar el formulario de restablecimiento de contraseña --}}
        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>