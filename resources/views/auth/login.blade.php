<x-guest-layout>
    {{-- Contenedor principal del formulario de inicio de sesión. --}}
    <div class="w-full max-w-md p-8 space-y-6 bg-gray-800 rounded-lg shadow-2xl border border-red-600/30 text-white">
        {{-- Título de la sección "Iniciar sesión" con estilo RavePass. --}}
        <h2 class="text-2xl lg:text-3xl font-bold text-center neon-text-red shadow-glow-red">Iniciar sesión</h2>

        {{-- Contenedor para mostrar errores de validación. --}}
        @if ($errors->any())
            <div class="mb-4 text-sm text-red-400 p-3 rounded-md bg-red-900/40 border border-red-700">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulario de inicio de sesión. --}}
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            {{-- Campo para el correo electrónico. --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-300">Correo electrónico</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                    class="mt-1 block w-full px-4 py-2 border border-gray-600 rounded-md shadow-sm
                           bg-gray-700 text-white placeholder-gray-400
                           focus:ring-red-600 focus:border-red-600" />
            </div>

            {{-- Campo para la contraseña. --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-300">Contraseña</label>
                <input id="password" name="password" type="password" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-600 rounded-md shadow-sm
                           bg-gray-700 text-white placeholder-gray-400
                           focus:ring-red-600 focus:border-red-600" />
            </div>

            {{-- Opción "Recordarme". --}}
            <div class="flex items-center">
                <input id="remember_me" name="remember" type="checkbox"
                    class="h-4 w-4 text-red-600 border-gray-600 rounded focus:ring-red-600 bg-gray-700" />
                <label for="remember_me" class="ml-2 block text-sm text-gray-300">Recordarme</label>
            </div>

            {{-- Enlace para "Olvidaste tu contraseña?". --}}
            <div class="flex items-center justify-between">
                @if (Route::has('password.request'))
                    <a class="text-sm text-red-500 hover:text-red-400 hover:underline transition-colors duration-200" href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>

            {{-- Botón para iniciar sesión. --}}
            <div>
                <button type="submit"
                    class="w-full py-2 px-4 bg-red-700 text-white font-semibold rounded-md transition-all duration-300
                           hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-900 neon-button">
                    Iniciar sesión
                </button>
            </div>

            {{-- Enlace para registrarse. --}}
            <div class="text-center">
                <p class="text-sm text-gray-400">¿No tienes una cuenta?
                    <a href="{{ route('register') }}" class="text-red-500 hover:text-red-400 hover:underline transition-colors duration-200">Regístrate</a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>