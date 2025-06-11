<x-guest-layout>
    {{-- Establece una clase para la columna izquierda con altura máxima y desbordamiento oculto. --}}
    @section('leftColumnClass', 'max-h-[80vh] overflow-hidden')
    {{-- Define estilos CSS adicionales para controlar el desbordamiento. --}}
    @push('styles')
        <style>
            .left-column {
                max-height: 90vh;
                overflow: hidden;
            }
        </style>
    @endpush

    {{-- Contenedor principal para centrar el formulario de registro. --}}
    <div class="flex items-center justify-center min-h-screen bg-gray-900">
        {{-- Contenedor del formulario con estilos que se adaptan al tema oscuro. --}}
        <div class="w-full max-w-md max-h-[80vh] overflow-y-auto p-6 space-y-4 bg-gray-900 rounded-lg shadow-2xl border border-gray-800">
            {{-- Título del formulario de creación de cuenta. --}}
            <h2 class="text-2xl font-bold text-center text-white">Crear cuenta</h2>

            {{-- Muestra los errores de validación, si los hay. --}}
            @if ($errors->any())
                <div class="mb-4 text-sm text-red-500">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Formulario de registro. --}}
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                {{-- Campo para el nombre completo. --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300">Nombre completo</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                        class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm
                               bg-gray-700 text-white border-gray-600
                               focus:ring-red-600 focus:border-red-600 focus:outline-none
                               placeholder-gray-400" />
                </div>

                {{-- Campo para el correo electrónico. --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300">Correo electrónico</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm
                               bg-gray-700 text-white border-gray-600
                               focus:ring-red-600 focus:border-red-600 focus:outline-none
                               placeholder-gray-400" />
                </div>

                {{-- Campo para la contraseña. --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300">Contraseña</label>
                    <input id="password" name="password" type="password" required
                        class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm
                               bg-gray-700 text-white border-gray-600
                               focus:ring-red-600 focus:border-red-600 focus:outline-none
                               placeholder-gray-400" />
                </div>

                {{-- Campo para confirmar la contraseña. --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Confirmar contraseña</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm
                               bg-gray-700 text-white border-gray-600
                               focus:ring-red-600 focus:border-red-600 focus:outline-none
                               placeholder-gray-400" />
                </div>

                {{-- Botón para registrarse. --}}
                <div>
                    <button type="submit"
                        class="w-full py-2 px-4 bg-red-600 text-white font-semibold rounded-md
                               hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition">
                        Registrarse
                    </button>
                </div>

                {{-- Enlace para iniciar sesión si ya se tiene una cuenta. --}}
                <div class="text-center">
                    <p class="text-sm text-gray-400">
                        ¿Ya tienes una cuenta?
                        <a href="{{ route('login') }}" class="text-red-600 hover:text-red-500 hover:underline">Inicia sesión</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    {{-- Bloque de estilos adicionales, si es necesario. --}}
    @push('styles')
    <style>
        /* Estilos específicos para la columna izquierda del contenido. */
        .left-column-content {
            max-height: 80vh;
            overflow: hidden;
        }
    </style>
@endpush

</x-guest-layout>