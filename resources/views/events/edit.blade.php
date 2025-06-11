<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{-- Muestra el título del encabezado con el nombre del evento a editar. --}}
            {{ __('Editar Evento: ') }}{{ $event->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white border-b border-gray-800">
                    <form action="{{ route('my-events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <div class="mb-4">
                            <label for="name" class="block text-gray-300 text-sm font-bold mb-2">Nombre del Evento:</label>
                            <input type="text" name="name" id="name"
                                   class="shadow appearance-none border rounded w-full py-2 px-3
                                          bg-gray-700 text-white border-gray-600 leading-tight
                                          focus:outline-none focus:shadow-outline focus:border-indigo-500 focus:ring-indigo-500
                                          placeholder-gray-400"
                                   value="{{ old('name', $event->name) }}" required>
                            @error('name') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-300 text-sm font-bold mb-2">Descripción:</label>
                            <textarea name="description" id="description" rows="5"
                                      class="shadow appearance-none border rounded w-full py-2 px-3
                                             bg-gray-700 text-white border-gray-600 leading-tight
                                             focus:outline-none focus:shadow-outline focus:border-indigo-500 focus:ring-indigo-500
                                             placeholder-gray-400"
                            >{{ old('description', $event->description) }}</textarea>
                            @error('description') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="mb-4">
                                <label for="start_date" class="block text-gray-300 text-sm font-bold mb-2">Fecha y Hora de Inicio:</label>
                                <input type="datetime-local" name="start_date" id="start_date"
                                       class="shadow appearance-none border rounded w-full py-2 px-3
                                              bg-gray-700 text-white border-gray-600 leading-tight
                                              focus:outline-none focus:shadow-outline focus:border-indigo-500 focus:ring-indigo-500"
                                       value="{{ old('start_date', \Carbon\Carbon::parse($event->start_date)->format('Y-m-d\TH:i')) }}" required>
                                @error('start_date') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="mb-4">
                                <label for="end_date" class="block text-gray-300 text-sm font-bold mb-2">Fecha y Hora de Fin (Opcional):</label>
                                <input type="datetime-local" name="end_date" id="end_date"
                                       class="shadow appearance-none border rounded w-full py-2 px-3
                                              bg-gray-700 text-white border-gray-600 leading-tight
                                              focus:outline-none focus:shadow-outline focus:border-indigo-500 focus:ring-indigo-500"
                                       value="{{ old('end_date', $event->end_date ? \Carbon\Carbon::parse($event->end_date)->format('Y-m-d\TH:i') : '') }}">
                                @error('end_date') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="mb-4">
                                <label for="location" class="block text-gray-300 text-sm font-bold mb-2">Ubicación (Dirección):</label>
                                <input type="text" name="location" id="location"
                                       class="shadow appearance-none border rounded w-full py-2 px-3
                                              bg-gray-700 text-white border-gray-600 leading-tight
                                              focus:outline-none focus:shadow-outline focus:border-indigo-500 focus:ring-indigo-500"
                                       value="{{ old('location', $event->location) }}" required>
                                @error('location') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="mb-4">
                                <label for="city" class="block text-gray-300 text-sm font-bold mb-2">Ciudad (Opcional):</label>
                                <input type="text" name="city" id="city"
                                       class="shadow appearance-none border rounded w-full py-2 px-3
                                              bg-gray-700 text-white border-gray-600 leading-tight
                                              focus:outline-none focus:shadow-outline focus:border-indigo-500 focus:ring-indigo-500"
                                       value="{{ old('city', $event->city) }}">
                                @error('city') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="poster_image" class="block text-gray-300 text-sm font-bold mb-2">Póster del Evento (Max 2MB, JPG/PNG):</label>
                            @if ($event->poster_path)
                                <div class="mb-2">
                                    <p class="text-gray-400 text-sm">Póster actual:</p>
                                    <img src="{{ asset('storage/' . $event->poster_path) }}" alt="Póster actual" class="h-32 w-32 object-cover rounded mt-1">
                                    <label for="remove_poster" class="inline-flex items-center mt-2">
                                        <input type="checkbox" name="remove_poster" id="remove_poster" class="rounded border-gray-600 text-red-600 shadow-sm focus:ring-red-500 bg-gray-700">
                                        <span class="ml-2 text-sm text-gray-300">Eliminar póster actual</span>
                                    </label>
                                </div>
                            @endif
                            <input type="file" name="poster_image" id="poster_image"
                                   class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition-colors duration-200">
                            @error('poster_image') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="mb-4">
                                <label for="price" class="block text-gray-300 text-sm font-bold mb-2">Precio (€):</label>
                                <input type="number" step="0.01" name="price" id="price"
                                       class="shadow appearance-none border rounded w-full py-2 px-3
                                              bg-gray-700 text-white border-gray-600 leading-tight
                                              focus:outline-none focus:shadow-outline focus:border-indigo-500 focus:ring-indigo-500"
                                       value="{{ old('price', $event->price) }}" required>
                                @error('price') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="mb-4">
                                <label for="available_tickets" class="block text-gray-300 text-sm font-bold mb-2">Entradas Disponibles (Opcional):</label>
                                <input type="number" name="available_tickets" id="available_tickets"
                                       class="shadow appearance-none border rounded w-full py-2 px-3
                                              bg-gray-700 text-white border-gray-600 leading-tight
                                              focus:outline-none focus:shadow-outline focus:border-indigo-500 focus:ring-indigo-500"
                                       value="{{ old('available_tickets', $event->available_tickets) }}">
                                @error('available_tickets') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="category_id" class="block text-gray-300 text-sm font-bold mb-2">Categoría:</label>
                            <select name="category_id" id="category_id"
                                    class="shadow border rounded w-full py-2 px-3
                                           bg-gray-700 text-white border-gray-600 leading-tight
                                           focus:outline-none focus:shadow-outline focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                <option value="">Selecciona una categoría</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $event->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="is_published" class="inline-flex items-center">
                                <input type="checkbox" name="is_published" id="is_published"
                                       class="rounded border-gray-600 text-red-600 shadow-sm focus:ring-red-500 bg-gray-700"
                                       {{ old('is_published', $event->is_published) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-300">Publicar Evento</span>
                            </label>
                            @error('is_published') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition">
                                Actualizar Evento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>