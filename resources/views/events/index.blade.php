<x-app-layout>
    <x-slot name="header">
        {{-- Título de la sección de Mis Eventos. --}}
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Mis Eventos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white border-b border-gray-800">
                    <div class="flex justify-between items-center mb-6">
                        {{-- Subtítulo para la lista de eventos creados por el usuario. --}}
                        <h3 class="text-xl font-bold">Eventos que has creado</h3>
                        {{-- Botón para navegar a la página de creación de un nuevo evento. --}}
                        <a href="{{ route('my-events.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition">
                            Crear Nuevo Evento
                        </a>
                    </div>

                    {{-- Muestra un mensaje de éxito si la sesión lo contiene. --}}
                    @if (session('success'))
                        <div class="bg-green-500 text-white p-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Condición para mostrar un mensaje si no hay eventos o la tabla de eventos. --}}
                    @if ($events->isEmpty())
                        {{-- Mensaje para cuando el usuario no ha creado eventos. --}}
                        <p class="text-gray-400">Aún no has creado ningún evento.</p>
                        <p class="text-gray-400">Haz clic en "Crear Nuevo Evento" para empezar.</p>
                    @else
                        {{-- Contenedor responsivo para la tabla de eventos. --}}
                        <div class="overflow-x-auto">
                            {{-- Tabla para listar los eventos creados por el usuario. --}}
                            <table class="min-w-full divide-y divide-gray-700">
                                <thead class="bg-gray-800">
                                    <tr>
                                        {{-- Encabezados de la tabla. --}}
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                            ID
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                            Nombre
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                            Póster
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                            Fecha Inicio
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                            Publicado
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-gray-900 divide-y divide-gray-800">
                                    {{-- Itera sobre cada evento para mostrarlo en una fila de la tabla. --}}
                                    @foreach ($events as $event)
                                        <tr>
                                            {{-- Celda para el ID del evento. --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                {{ $event->id }}
                                            </td>
                                            {{-- Celda para el nombre del evento. --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                                {{ $event->name }}
                                            </td>
                                            {{-- Celda para el póster del evento. --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                @if ($event->poster_path)
                                                    <img src="{{ asset('storage/' . $event->poster_path) }}" alt="Póster" class="h-16 w-16 object-cover rounded">
                                                @else
                                                    <span class="text-gray-500">Sin póster</span>
                                                @endif
                                            </td>
                                            {{-- Celda para la fecha de inicio del evento, formateada. --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y H:i') }}
                                            </td>
                                            {{-- Celda para el estado de publicación del evento (Sí/No). --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                @if ($event->is_published)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Sí</span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">No</span>
                                                @endif
                                            </td>
                                            {{-- Celda para las acciones (Editar y Eliminar). --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                {{-- Enlace para editar el evento. --}}
                                                <a href="{{ route('my-events.edit', $event) }}" class="text-indigo-400 hover:text-indigo-600 mr-3">Editar</a>

                                                {{-- Formulario para eliminar el evento, con confirmación. --}}
                                                <form action="{{ route('my-events.destroy', $event) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-400 hover:text-red-600" onclick="return confirm('¿Estás seguro de que quieres eliminar este evento? Esto también borrará su imagen.')">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{-- Muestra los enlaces de paginación para la lista de eventos. --}}
                            {{ $events->links() }} 
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>