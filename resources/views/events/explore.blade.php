<x-app-layout>
    {{-- Inclusión de estilos y scripts personalizados para el tema RavePass --}}
    <x-slot name="styles">
        <link href="{{ asset('css/ravepass.css') }}" rel="stylesheet">
        <script src="{{ asset('js/ravepass.js') }}" defer></script>
        {{-- Estilos personalizados para el efecto de sombra al pasar el ratón --}}
        <style>
            .hover\:shadow-glow:hover {
                box-shadow: 0 0 15px rgba(220, 38, 38, 0.5), 0 0 25px rgba(220, 38, 38, 0.3), 0 0 35px rgba(220, 38, 38, 0.1);
            }
        </style>
    </x-slot>

    {{-- Este diseño no incluye un encabezado fijo para permitir un banner completo. --}}

    <div class="py-8 bg-black">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">

            {{-- Sección de banner principal con imagen de fondo y efecto de partículas --}}
            <div style="background-image: url('{{ asset('img/explorer.jpg') }}');"
            class="bg-cover bg-center overflow-hidden shadow-2xl sm:rounded-lg border border-red-600/30 relative text-center">
                <div class="absolute inset-0 overflow-hidden">
                    {{-- Contenedor para el efecto de partículas en el fondo --}}
                    <div id="particles-container-explore" class="absolute inset-0 opacity-10"></div>
                </div>
                <div class="relative z-10 p-6 md:p-10">
                    {{-- Etiqueta con estilo glitch para la frase principal --}}
                    <div class="inline-block px-4 py-1 bg-red-600/20 border border-red-600 rounded-full mb-4 glitch-text">
                        <span class="text-red-600 font-medium">Encuentra Tu Próxima Experiencia</span>
                    </div>
                    {{-- Título principal con efecto neón --}}
                    <h1 class="text-3xl md:text-5xl font-bold mb-4 text-white neon-text">Adéntrate en la <span class="text-red-600">Escena</span></h1>
                    {{-- Descripción de la sección principal --}}
                    <p class="text-lg text-gray-300 mb-6 max-w-2xl mx-auto">Navega por géneros, descubre nuevos ambientes o déjate sorprender por nuestros destacados. La noche te espera.</p>
                </div>
            </div>

            {{-- Sección para explorar eventos por Género (Categorías) --}}
            <div class="relative pt-12">
                <div class="absolute inset-0 bg-radial-gradient opacity-10"></div>
                <div class="relative z-10">
                    <div class="text-center mb-10">
                        {{-- Título de la sección de géneros --}}
                        <h2 class="text-2xl md:text-4xl font-bold mb-3">Explora por <span class="text-red-600">Género</span></h2>
                        {{-- Descripción de la sección de géneros --}}
                        <p class="text-gray-400 max-w-2xl mx-auto text-sm md:text-base">Desde los ritmos hipnóticos del techno hasta la contundencia del hard techno.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {{-- Itera sobre cada categoría para crear una tarjeta de género --}}
                        @forelse ($categories as $index => $category)
                            <a href="{{ route('events.public.index', ['category' => $category->slug]) }}"
                               class="relative bg-gradient-to-br from-black via-gray-950 to-gray-900
                                      @if ($index % 2 == 0)
                                           border border-white/20
                                      @else
                                           border border-red-600/30
                                      @endif
                                      rounded-lg overflow-hidden group transition-all duration-300 hover:shadow-glow transform hover:-translate-y-1
                                      p-6 flex flex-col justify-center items-center text-center h-56"> 
                                {{-- Overlay sutil que aparece al pasar el ratón --}}
                                <div class="absolute inset-0 z-0 bg-red-900 opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>

                                <div class="relative z-10"> {{-- Asegura que el texto esté por encima de los overlays --}}
                                    {{-- Nombre de la categoría con efecto de cambio de color al pasar el ratón --}}
                                    <h3 class="text-2xl font-bold mb-2 text-white group-hover:text-red-500 transition-colors">{{ $category->name }}</h3>
                                    {{-- Descripción de la categoría --}}
                                    <p class="text-gray-300 text-sm">{{ $category->description ?? 'Explora los eventos de este género.' }}</p>
                                </div>
                            </a>
                        @empty
                            {{-- Mensaje si no hay categorías disponibles --}}
                            <p class="col-span-full text-center text-gray-400 text-lg">No hay categorías disponibles en este momento.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Sección para descubrir todos los eventos --}}
            <div id="eventos-destacados" class="relative pt-12">
                <div class="absolute inset-0 bg-radial-gradient opacity-10"></div>
                <div class="relative z-10">
                    <div class="text-center mb-10">
                        {{-- Título de la sección de todos los eventos --}}
                        <h2 class="text-2xl md:text-4xl font-bold mb-3">Descubre <span class="text-red-600">Todos Nuestros Eventos</span></h2>
                        {{-- Descripción de la sección de todos los eventos --}}
                        <p class="text-gray-400 max-w-2xl mx-auto text-sm md:text-base">Explora la lista completa de todas las experiencias techno disponibles en RavePass.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {{-- Bucle sobre todos los eventos destacados/publicados --}}
                        @forelse ($featuredEvents as $event)
                            <div class="bg-gray-900/50 border border-gray-800 rounded-lg overflow-hidden group hover:border-red-600/50 transition-all duration-300 hover:shadow-glow">
                                <div class="relative h-48 overflow-hidden">
                                    {{-- Muestra la imagen del póster del evento o una imagen por defecto --}}
                                    @if ($event->poster_path)
                                        <img src="{{ asset('storage/' . $event->poster_path) }}"
                                             alt="{{ $event->name }}"
                                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    @else
                                        <img src="{{ asset('img/default-event-poster.jpg') }}"
                                             alt="Default Event Poster"
                                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    @endif
                                    {{-- Gradiente oscuro sobre la imagen para mejorar la legibilidad del texto --}}
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/60 to-transparent"></div>
                                    {{-- Fecha del evento superpuesta --}}
                                    <div class="absolute top-3 left-3 bg-red-600 px-2 py-1 rounded-full text-xs font-medium z-10 text-white">
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                                    </div>
                                    {{-- Precio del evento superpuesto --}}
                                    <div class="absolute bottom-3 right-3 bg-black/90 backdrop-blur-sm px-2 py-1 rounded-full text-xs font-medium border border-white/10 z-10 text-white">
                                        €{{ number_format($event->price, 2) }}
                                    </div>
                                </div>
                                <div class="p-4">
                                    {{-- Nombre del evento con efecto de cambio de color al pasar el ratón --}}
                                    <h3 class="text-lg font-bold mb-2 transition-colors duration-300 group-hover:text-red-600">{{ $event->name }}</h3>
                                    {{-- Descripción del evento truncada --}}
                                    <p class="text-gray-400 mb-4 text-sm">{{ Str::limit($event->description, 70) }}</p>
                                    <div class="flex justify-between items-center">
                                        {{-- Botón para ver detalles del evento --}}
                                        <a href="{{ route('events.show', $event->slug) }}" class="border border-red-600/50 text-red-600 hover:bg-red-600 hover:text-white group-hover:border-red-600 transition-colors px-3 py-1.5 rounded-md inline-flex items-center text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" /></svg>
                                            Ver Detalles
                                        </a>
                                        {{-- Icono de "Me gusta" (puede ser funcional o meramente visual) --}}
                                        <button class="text-gray-400 hover:text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            {{-- Mensaje si no hay eventos disponibles --}}
                            <p class="col-span-full text-center text-gray-400 text-lg">No hay eventos disponibles en este momento. ¡Vuelve pronto!</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>