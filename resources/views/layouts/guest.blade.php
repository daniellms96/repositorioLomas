<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'RavePass') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- Carga tu CSS personalizado de RavePass DESPUÉS de app.css para asegurar prioridad --}}
        <link href="{{ asset('css/ravepass.css') }}" rel="stylesheet">
        
        {{-- Si tienes un slot para estilos adicionales, mantenlo aquí --}}
        @isset($styles)
            {{ $styles }}
        @endisset
    </head>
    {{-- El body tendrá el fondo negro gracias a ravepass.css --}}
    <body class="font-sans antialiased text-white"> {{-- Añadimos text-white para el texto general --}}
        {{-- Contenedor principal que abarca toda la pantalla y tendrá el fondo oscuro --}}
        <div class="min-h-screen flex items-center justify-center p-6 bg-gray-900 relative overflow-hidden">
            {{-- Capa de partículas para toda la página --}}
            <div id="particles-container-fullpage" class="absolute inset-0 opacity-20 z-0"></div>

            {{-- Contenedor para el contenido principal (ya no es un grid de 2 columnas rígido) --}}
            <div class="relative z-10 w-full max-w-4xl grid grid-cols-1 md:grid-cols-2 gap-8 p-6 sm:p-8 lg:p-10 rounded-lg shadow-2xl bg-gradient-to-r from-black to-gray-900 border border-red-600/30">

                <div class="flex items-center justify-center text-center p-4 left-column-content">
                    <div>
                        {{-- Aplicamos clases de texto neón/glitch si las tienes definidas --}}
                        <h1 class="text-4xl lg:text-5xl font-bold mb-4 neon-text shadow-glow">Bienvenido a RavePass</h1>
                        <p class="text-lg lg:text-xl text-gray-300">Inicia sesión o crea una cuenta para continuar.</p>
                        {{-- Si tienes un logo o imagen que sea parte del branding, puedes insertarlo aquí --}}
                        {{-- <img src="{{ asset('path/to/your/ravepass-logo.png') }}" alt="RavePass Logo" class="mt-6 mx-auto w-32 md:w-48 float-element"> --}}
                    </div>
                </div>

                <div class="flex items-center justify-center p-4">
                    {{-- El div que envuelve el slot: Ya no necesita estilos de fondo/sombra ya que el padre (grid-cols-2)
                         y el propio guest-layout ya los proveen. Solo gestionamos el tamaño y centrado. --}}
                    <div class="w-full max-w-md"> {{-- Ya no necesitas bg-gray-900, shadow, border aquí --}}
                        {{ $slot }} {{-- Aquí se inserta el contenido de tu register.blade.php o login.blade.php --}}
                    </div>
                </div>
            </div>
        </div>

        {{-- Incluye tu script de partículas aquí --}}
        {{-- Asegúrate de que tu archivo particles.js está en public/js/particles.js --}}
        <script src="{{ asset('js/particles.js') }}"></script>
        <script>
            // Inicializar partículas para el contenedor de toda la página
            if (typeof particlesJS !== 'undefined') {
                particlesJS('particles-container-fullpage', {
                    // Copia aquí la configuración exacta de tus partículas desde tu ravepass.css o JS principal.
                    // Esta es una configuración básica como ejemplo:
                    "particles": {
                        "number": { "value": 100, "density": { "enable": true, "value_area": 800 } },
                        "color": { "value": "#dc2626" }, // Rojo para las partículas
                        "shape": { "type": "circle" },
                        "opacity": { "value": 0.5, "random": true },
                        "size": { "value": 3, "random": true },
                        "line_linked": { "enable": true, "distance": 150, "color": "#dc2626", "opacity": 0.4, "width": 1 },
                        "move": { "enable": true, "speed": 3, "direction": "none", "random": true, "straight": false, "out_mode": "out" }
                    },
                    "interactivity": {
                        "detect_on": "canvas",
                        "events": { "onhover": { "enable": true, "mode": "grab" }, "onclick": { "enable": true, "mode": "push" }, "resize": true }
                    },
                    "retina_detect": true
                });
            }
        </script>
        {{-- Aquí se insertan otros scripts si los usas con @stack('scripts') --}}
        @stack('scripts')
    </body>
</html>