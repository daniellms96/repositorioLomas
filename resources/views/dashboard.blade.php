@auth
<x-app-layout>
    <x-slot name="styles">
        <link href="{{ asset('css/ravepass.css') }}" rel="stylesheet">
        {{-- Puedes añadir CSS específico para el carrusel si lo necesitas aquí --}}
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Bienvenido a RavePass') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-black">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
            {{-- SECCIÓN DEL CARRUSEL DE EVENTOS --}}
            <div class="bg-gradient-to-r from-black to-gray-900 overflow-hidden shadow-2xl sm:rounded-lg border border-red-600/30 relative">
                <div class="absolute inset-0 overflow-hidden">
                    <div id="particles-container" class="absolute inset-0 opacity-20"></div>
                </div>
                <div class="relative z-10 p-6 md:p-10">
                    <div class="flex flex-col md:flex-row items-center gap-8">
                        <div class="md:w-1/2">
                            <div class="inline-block px-4 py-1 bg-red-600/20 border border-red-600 rounded-full mb-4 glitch-text">
                                <span class="text-red-600 font-medium">La nueva era de eventos techno</span>
                            </div>
                            <h1 class="text-3xl md:text-5xl font-bold mb-4 text-white neon-text">Vive la <span class="text-red-600">experiencia</span> techno definitiva</h1>
                            <p class="text-lg text-gray-300 mb-6">Descubre, compra y vende entradas para los mejores eventos de música electrónica. Tu pasaporte al mundo del techno y hard techno.</p>
                            <div class="flex flex-col sm:flex-row gap-4">
                                <a href="{{ route('events.explore') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 text-base rounded-md inline-block text-center transition-all duration-300 pulse-btn">Explorar Eventos</a>
                                <a href="{{ route('profile.edit') }}" class="border border-white/30 hover:border-white text-white px-6 py-3 text-base rounded-md inline-block text-center transition-all duration-300">Mi Perfil</a>
                            </div>
                        </div>
                        <div class="md:w-1/2 relative mt-8 md:mt-0">
                            {{-- Contenedor del Carrusel --}}
                            <div id="event-carousel" class="relative w-full h-[250px] md:h-[350px] rounded-lg overflow-hidden border-2 border-red-600/50 shadow-glow">
                                @forelse($allEvents as $event)
                                    <div class="carousel-item absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0 {{ $loop->first ? 'opacity-100' : '' }}">
                                        <img src="{{ asset('storage/' . $event->poster_path) }}"
                                             class="w-full h-full object-cover"
                                             alt="{{ $event->name ?? 'Evento de RavePass' }}"
                                             onerror="this.onerror=null;">
                                        {{-- Sombreado de degradado existente en la parte inferior de la imagen --}}
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/60 to-transparent"></div>
                                        <div class="absolute bottom-0 left-0 right-0 p-4 z-10 text-white">
                                            <div class="flex items-center gap-2 mb-2">
                                                <span class="px-2 py-1 bg-red-600 rounded-full text-xs font-medium">DESTACADO</span>
                                                <span class="px-2 py-1 bg-white/10 backdrop-blur-sm rounded-full text-xs">{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</span>
                                            </div>
                                            {{-- ***** MODIFICACIÓN APLICADA AQUÍ: Contenedor para el título ***** --}}
                                            <div class="inline-block bg-black/70 backdrop-blur-sm px-3 py-2 rounded-lg mb-2">
                                                <h3 class="text-xl md:text-2xl font-bold text-white drop-shadow-lg">
                                                    {{ $event->name }}
                                                </h3>
                                            </div>
                                            {{-- ***** FIN DE LA MODIFICACIÓN ***** --}}

                                            <div class="mt-2 flex flex-col md:flex-row gap-2">
                                                @if($event->duration_hours) {{-- Asumiendo que tienes una columna de duración --}}
                                                <div class="inline-flex items-center gap-2 bg-black/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs font-medium border border-white/10">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                                    </svg>
                                                    <span class="whitespace-nowrap text-white">{{ $event->duration_hours }} horas non-stop!</span>
                                                </div>
                                                @endif
                                                @if($event->attendees_count) {{-- Asumiendo que tienes una columna para el conteo de asistentes --}}
                                                <div class="inline-flex items-center gap-2 bg-black/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs font-medium border border-white/10">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                    </svg>
                                                    <span class="whitespace-nowrap text-white">¡Más de {{ $event->attendees_count }}+ asistentes!</span>
                                                </div>
                                                @endif
                                            </div>
                                            {{-- La descripción puede ir aquí o ajustarse si ya no es necesaria con el título del evento --}}
                                            <p class="text-gray-300 text-sm mt-1">{{ Str::limit($event->description, 150) }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="carousel-item absolute inset-0 flex items-center justify-center bg-gray-800 text-gray-400">
                                        <p>No hay eventos destacados disponibles.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECCIÓN DE LOS 3 PRIMEROS PRÓXIMOS EVENTOS --}}
            <div id="eventos" class="relative pt-16">
                <div class="absolute inset-0 bg-radial-gradient opacity-20"></div>
                <div class="relative z-10">
                    <div class="text-center mb-10">
                        <h2 class="text-2xl md:text-4xl font-bold mb-3">Próximos <span class="text-red-600">Eventos</span></h2>
                        <p class="text-gray-400 max-w-2xl mx-auto text-sm md:text-base">Descubre y asegura tu entrada para los eventos más exclusivos de la escena techno y hard techno.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($upcomingEvents as $event)
                            <div class="bg-gray-900/50 border border-gray-800 rounded-lg overflow-hidden group hover:border-red-600/50 transition-all duration-300 hover:shadow-glow">
                                <div class="relative h-48 overflow-hidden">
                                    <img src="{{ asset('storage/' . $event->poster_path) }}"
                                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                         alt="{{ $event->name ?? 'Evento de RavePass' }}"
                                         onerror="this.onerror=null;">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/60 to-transparent"></div>
                                    <div class="absolute top-3 left-3 bg-red-600 px-2 py-1 rounded-full text-xs font-medium z-10">
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                                    </div>
                                    <div class="absolute bottom-3 right-3 bg-black/90 backdrop-blur-sm px-2 py-1 rounded-full text-xs font-medium border border-white/10 z-10">
                                        €{{ number_format($event->price, 2, ',', '.') }}
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="text-lg font-bold mb-2 transition-colors duration-300 group-hover:text-red-600">{{ $event->name }}</h3>
                                    <p class="text-gray-400 mb-4 text-sm">{{ Str::limit($event->description, 100) }}</p> {{-- Limita la descripción --}}
                                    <div class="flex justify-between items-center">
                                        {{-- Enlace a la página de detalles del evento (usando el slug) --}}
                                        <a href="{{ route('events.show', $event->slug) }}" class="border border-red-600/50 text-red-600 hover:bg-red-600 hover:text-white group-hover:border-red-600 transition-colors px-3 py-1.5 rounded-md inline-flex items-center text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                            </svg>
                                            Comprar Entrada
                                        </a>
                                        <button class="text-gray-400 hover:text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="col-span-full text-center text-gray-400">No hay próximos eventos disponibles en este momento.</p>
                        @endforelse
                    </div>

                    <div class="text-center mt-8">
                        <a href="{{ route('events.explore') }}" class="inline-flex items-center gap-2 border border-red-600/50 text-red-600 hover:bg-red-600 hover:text-white transition-colors px-4 py-2 rounded-md text-sm">
                            Ver todos los eventos
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- SECCIÓN DE BENEFICIOS --}}
            <div class="relative pt-16">
                <div class="absolute inset-0 bg-radial-gradient-bottom opacity-20"></div>
                <div class="relative z-10">
                    <div class="text-center mb-10">
                        <h2 class="text-2xl md:text-4xl font-bold mb-3">¿Por qué <span class="text-red-600">elegirnos</span>?</h2>
                        <p class="text-gray-400 max-w-2xl mx-auto text-sm md:text-base">Descubre las ventajas que hacen de RavePass la plataforma preferida por los amantes del techno.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="bg-gray-900/30 border border-gray-800 rounded-lg p-5 hover:border-red-600/50 transition-all duration-300 hover:shadow-glow benefit-card">
                            <div class="mb-3 text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold mb-2">Seguridad Garantizada</h3>
                            <p class="text-gray-400 text-sm">Todas las transacciones están protegidas con la más alta tecnología de encriptación.</p>
                        </div>

                        <div class="bg-gray-900/30 border border-gray-800 rounded-lg p-5 hover:border-red-600/50 transition-all duration-300 hover:shadow-glow benefit-card">
                            <div class="mb-3 text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold mb-2">Entradas Verificadas</h3>
                            <p class="text-gray-400 text-sm">Verificamos la autenticidad de cada entrada para evitar fraudes.</p>
                        </div>

                        <div class="bg-gray-900/30 border border-gray-800 rounded-lg p-5 hover:border-red-600/50 transition-all duration-300 hover:shadow-glow benefit-card">
                            <div class="mb-3 text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold mb-2">Comunidad Activa</h3>
                            <p class="text-gray-400 text-sm">Forma parte de una comunidad apasionada por la música electrónica.</p>
                        </div>

                        <div class="bg-gray-900/30 border border-gray-800 rounded-lg p-5 hover:border-red-600/50 transition-all duration-300 hover:shadow-glow benefit-card">
                            <div class="mb-3 text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold mb-2">Acceso Prioritario</h3>
                            <p class="text-gray-400 text-sm">Sé el primero en conseguir entradas para eventos exclusivos.</p>
                        </div>

                        <div class="bg-gray-900/30 border border-gray-800 rounded-lg p-5 hover:border-red-600/50 transition-all duration-300 hover:shadow-glow benefit-card">
                            <div class="mb-3 text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold mb-2">Sin Comisiones Ocultas</h3>
                            <p class="text-gray-400 text-sm">Precios transparentes sin sorpresas de último momento.</p>
                        </div>

                        <div class="bg-gray-900/30 border border-gray-800 rounded-lg p-5 hover:border-red-600/50 transition-all duration-300 hover:shadow-glow benefit-card">
                            <div class="mb-3 text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold mb-2">Eventos Exclusivos</h3>
                            <p class="text-gray-400 text-sm">Accede a eventos que no encontrarás en ninguna otra plataforma.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative pt-16">
                <div class="max-w-4xl mx-auto bg-gradient-to-r from-gray-900/80 to-black border border-gray-800 rounded-xl p-6 md:p-8 shadow-xl relative overflow-hidden">
                    <div class="absolute inset-0 bg-radial-gradient opacity-20"></div>
                    <div class="relative z-10 text-center">
                        <h2 class="text-2xl md:text-3xl font-bold mb-3">Sumérgete <span class="text-red-600 glitch-text">Más Profundo</span></h2>
                        <p class="text-gray-300 max-w-2xl mx-auto mb-6 text-sm md:text-base">Como miembro de RavePass, descubre contenido exclusivo, interactúa con la comunidad y accede a preventas especiales. ¡Tu viaje techno continúa!</p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            {{-- Estos enlaces puedes dejarlos a '#' o apuntarlos a rutas reales cuando las crees --}}
                            <a href="#" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 text-base rounded-md inline-block text-center transition-all duration-300 pulse-btn">Eventos VIP</a>
                            <a href="#" class="border border-white/30 hover:border-white text-white px-6 py-3 text-base rounded-md inline-block text-center transition-all duration-300">Nuestra Comunidad</a>
                        </div>
                    </div>
                </div>
            </div>

            <button id="audio-toggle" class="fixed bottom-4 right-4 z-50 bg-red-600 p-2 rounded-full shadow-lg hover:bg-red-700 transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15.536a5 5 0 001.414 1.414m0 0l-2.828 2.828m0 0a9 9 0 010-12.728m2.828 2.828L8.414 8.414" />
                </svg>
            </button>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const carousel = document.getElementById('event-carousel');
                if (carousel) {
                    const items = carousel.querySelectorAll('.carousel-item');
                    let currentIndex = 0;
                    const intervalTime = 5000; // 5 segundos

                    function showItem(index) {
                        items.forEach((item, i) => {
                            if (i === index) {
                                item.classList.remove('opacity-0');
                                item.classList.add('opacity-100');
                            } else {
                                item.classList.remove('opacity-100');
                                item.classList.add('opacity-0');
                            }
                        });
                    }

                    function nextItem() {
                        currentIndex = (currentIndex + 1) % items.length;
                        showItem(currentIndex);
                    }

                    if (items.length > 1) { // Solo si hay más de un evento
                        setInterval(nextItem, intervalTime);
                    } else if (items.length === 1) { // Si solo hay un evento, asegúrate de que se muestre
                        showItem(0);
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>
@else
    {{-- Redirige a la página de registro si el usuario no está autenticado --}}
    <script>window.location.href = "{{ route('register') }}";</script>
@endauth