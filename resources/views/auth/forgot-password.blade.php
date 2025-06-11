<x-guest-layout>
    {{-- Contenedor principal del formulario de restablecimiento de contraseña. --}}
    <div class="w-full max-w-md p-8 space-y-6 bg-gray-800 rounded-lg shadow-2xl border border-red-600/30 text-white">
        {{-- Título del formulario con estilo neón. --}}
        <h2 class="text-2xl lg:text-3xl font-bold text-center neon-text-red shadow-glow-red">Restablecer Contraseña</h2>

        {{-- Descripción para el usuario sobre el proceso de restablecimiento. --}}
        <div class="mb-4 text-sm text-gray-300">
            {{ __('Has olvidado tu contraseña? No hay problema. Indícanos tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña y elegir una nueva.') }}
        </div>

        {{-- Mensaje de estado de la sesión (ej. éxito al enviar el enlace). --}}
        @if (session('status'))
            <div class="mb-4 text-sm text-green-400 p-3 rounded-md bg-green-900/40 border border-green-700">
                {{ session('status') }}
            </div>
        @endif

        {{-- Muestra los errores de validación. --}}
        @if ($errors->any())
            <div class="mb-4 text-sm text-red-400 p-3 rounded-md bg-red-900/40 border border-red-700">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulario para enviar el correo electrónico de restablecimiento. --}}
        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            {{-- Campo de entrada para el correo electrónico. --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-300">Correo electrónico</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                    class="mt-1 block w-full px-4 py-2 border border-gray-600 rounded-md shadow-sm
                           bg-gray-700 text-white placeholder-gray-400
                           focus:ring-red-600 focus:border-red-600" />
            </div>

            {{-- Botón para enviar el enlace de restablecimiento. --}}
            <div class="flex items-center justify-end mt-4">
                <button type="submit"
                    class="w-full py-2 px-4 bg-red-700 text-white font-semibold rounded-md transition-all duration-300
                           hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-900 neon-button">
                    {{ __('Enviar enlace de restablecimiento') }}
                </button>
            </div>
        </form>

        {{-- Enlace para volver a la página de inicio de sesión. --}}
        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-sm text-red-500 hover:text-red-400 hover:underline transition-colors duration-200">
                {{ __('Volver a Iniciar Sesión') }}
            </a>
        </div>
    </div>
</x-guest-layout>