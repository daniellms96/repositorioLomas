<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Perfil') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 text-white min-h-screen flex items-center justify-center">
        <div class="max-w-4xl w-full p-8 space-y-6 bg-gray-800 rounded-lg shadow-lg border border-gray-700">
            {{-- Sección de Información del Perfil --}}
            <div class="p-6 text-white border-b border-gray-700">
                <h3 class="text-xl font-bold mb-4 text-gray-200">Información del Perfil</h3>
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Sección de Actualización de Contraseña --}}
            <div class="p-6 text-white border-b border-gray-700">
                <h3 class="text-xl font-bold mb-4 text-gray-200">Actualizar Contraseña</h3>
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Sección de Eliminación de Cuenta --}}
            <div class="p-6 text-white">
                <h3 class="text-xl font-bold mb-4 text-gray-200">Eliminar Cuenta</h3>
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="number"],
    select,
    textarea {
        background-color: #1A1A1A;
        color: #ffffff;
        border: 1px solid #444444;
        border-radius: 0.375rem;
        padding: 0.5rem 0.75rem;
        width: 100%;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.4);
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus,
    input[type="number"]:focus,
    select:focus,
    textarea:focus {
        border-color: #666666;
        outline: none;
        box-shadow: 0 0 0 3px rgba(102, 102, 102, 0.4);
    }


    input::placeholder,
    textarea::placeholder {
        color: #aaaaaa;
    }

    .button-dark {
        background-color: #2D2D2D;
        color: #ffffff;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        transition: background-color 0.3s ease;
    }

    .button-dark:hover {
        background-color: #3F3F3F;
    }
</style>