<x-app-layout>
    <x-slot name="header">
        {{-- Título de la página de exploración de eventos. --}}
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Explorar Todos los Eventos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white border-b border-gray-800">
                    {{-- Título de la sección de eventos próximos. --}}
                    <h3 class="text-xl font-bold mb-6">Eventos Próximos</h3>

                    {{-- Sección para filtrar eventos por categoría. --}}
                    <div class="mb-6">
                        <label for="category-filter" class="block text-gray-300 text-sm font-bold mb-2">Filtrar por Categoría:</label>
                        {{-- Select para cambiar la categoría mostrada. --}}
                        <select id="category-filter" onchange="window.location.href = this.value;" class="shadow border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-800 border-gray-700">
                            {{-- Opción para mostrar todas las categorías. --}}
                            <option value="{{ route('events.public.index') }}" {{ is_null($selectedCategory) ? 'selected' : '' }}>Todas las Categorías</option>
                            {{-- Itera sobre las categorías disponibles para crear opciones de filtro. --}}
                            @foreach ($categories as $category)
                                <option value="{{ route('events.public.index', ['category' => $category->slug]) }}" {{ $selectedCategory && $selectedCategory->id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Condicional para mostrar eventos o un mensaje si no hay. --}}
                    @if ($events->isEmpty())
                        {{-- Mensaje si no hay eventos disponibles en la categoría seleccionada. --}}
                        <p class="text-gray-400">No hay eventos próximos disponibles en esta categoría.</p>
                    @else
                        {{-- Contenedor de la cuadrícula para mostrar los eventos. --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            {{-- Itera sobre cada evento para mostrar su tarjeta. --}}
                            @foreach ($events as $event)
                                <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden flex flex-col">
                                    {{-- Muestra la imagen del póster del evento o un placeholder. --}}
                                    @if ($event->poster_path)
                                        <img class="w-full h-48 object-cover" src="{{ asset('storage/' . $event->poster_path) }}" alt="{{ $event->name }}">
                                    @else
                                        <div class="w-full h-48 bg-gray-700 flex items-center justify-center text-gray-400">
                                            Sin póster
                                        </div>
                                    @endif
                                    <div class="p-4 flex-grow flex flex-col">
                                        {{-- Nombre del evento. --}}
                                        <h4 class="font-bold text-lg text-white mb-2">{{ $event->name }}</h4>
                                        {{-- Fecha y hora de inicio del evento. --}}
                                        <p class="text-gray-400 text-sm mb-1">
                                            <i class="fa-solid fa-calendar-alt mr-1"></i>
                                            {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y H:i') }}
                                        </p>
                                        {{-- Ubicación y ciudad del evento. --}}
                                        <p class="text-gray-400 text-sm mb-2">
                                            <i class="fa-solid fa-location-dot mr-1"></i>
                                            {{ $event->location }}@if($event->city), {{ $event->city }}@endif
                                        </p>
                                        {{-- Precio del evento. --}}
                                        <p class="text-red-500 font-bold text-md mb-3">
                                            €{{ number_format($event->price, 2) }}
                                        </p>
                                        <div class="flex-grow"></div> {{-- Empuja el botón al final de la tarjeta. --}}
                                        {{-- Enlace para ver los detalles del evento. --}}
                                        <a href="{{ route('events.show', $event->slug) }}" class="mt-auto bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-center transition">
                                            Ver Detalles
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            {{-- Enlaces de paginación para la lista de eventos. --}}
                            {{ $events->links() }} 
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>