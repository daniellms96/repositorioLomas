<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ravePass') }}</title>

    {{-- Favicon para el sitio web. --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    {{-- Hoja de estilos principal para el diseño de RavePass. --}}
    <link href="{{ asset('css/ravepass.css') }}" rel="stylesheet">

    {{-- Enlaces a fuentes de Google Fonts (Bunny CDN). --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Inclusión de assets CSS y JS de Vite para desarrollo. --}}
    @vite([
        'resources/css/app.css',
        'resources/css/ravepass.css',
        'resources/js/app.js',
        'resources/js/ravepass.js'
    ])

    {{-- Slot para estilos CSS específicos de la vista, si existen. --}}
    @isset($styles)
        {{ $styles }}
    @endisset

</head>
<body class="bg-black text-white font-sans antialiased min-h-screen"> {{-- Estilos de fondo y tipografía para toda la aplicación. --}}

    {{-- Barra de navegación personalizada. --}}
    <nav class="bg-black border-b border-red-600 shadow-md p-4 flex justify-between items-center">
        {{-- Logo/enlace principal a la página de inicio. --}}
        <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-red-500">ravePass</a>

        <div class="flex items-center space-x-4">
            {{-- Sección de botones de acción para usuarios autenticados. --}}
            @auth
                <div class="flex items-center space-x-4 mr-6">
                    {{-- Botón para gestionar eventos. --}}
                    <a href="{{ route('my-events.index') }}" class="inline-flex items-center px-3 py-1.5 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        GESTIONAR MIS EVENTOS
                    </a>

                    {{-- Botón para ver Mis Entradas. --}}
                    <a href="{{ route('my-tickets.index') }}" class="inline-flex items-center px-3 py-1.5 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 012 2v3a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2H5z" />
                        </svg>
                        MIS ENTRADAS
                    </a>
                </div>
            @endauth

            {{-- Links de autenticación y perfil. --}}
            <div class="space-x-4 pl-6 border-l border-gray-700">
                @auth
                    {{-- Enlace al perfil del usuario. --}}
                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center text-white hover:text-red-400 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Perfil
                    </a>
                    {{-- Formulario para cerrar sesión. --}}
                    <form method="POST" action="{{ route('logout') }}" class="inline-flex items-center">
                        @csrf
                        <button type="submit" class="text-white hover:text-red-400 transition inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Cerrar sesión
                        </button>
                    </form>
                @else
                    {{-- Enlaces para Iniciar Sesión y Registrarse si no está autenticado. --}}
                    <a href="{{ route('login') }}" class="text-white hover:text-red-400 transition">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="text-white hover:text-red-400 transition">Registrarse</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Contenido principal de la página. --}}
    <main class="py-6 px-4 sm:px-6 lg:px-8">
        {{ $slot }} {{-- Aquí se inyectará el contenido de las vistas hijas. --}}
    </main>

    {{-- Pie de página. --}}
    <footer>
        <p style="text-align: center; color: gray; font-size: 0.875rem; margin-top: 2rem; padding-bottom: 1.5rem;">© 2025 ravePass. Todos los derechos reservados.</p>
    </footer>

    {{-- Sección para scripts JavaScript específicos de cada vista. --}}
    @stack('scripts')

</body>
</html>