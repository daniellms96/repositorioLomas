<x-app-layout>
    {{-- Encabezado de la página --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Crear Nuevo Evento') }}
        </h2>
    </x-slot>

    {{-- Contenedor principal de la página --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white border-b border-gray-800">
                    {{-- Formulario para crear un nuevo evento con soporte para subida de archivos --}}
                    <form action="{{ route('my-events.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Campo para el nombre del evento --}}
                        <div class="mb-4">
                            <label for="name" class="block text-gray-300 text-sm font-bold mb-2">Nombre del Evento:</label>
                            <input type="text" name="name" id="name"
                                   class="shadow appearance-none border rounded w-full py-2 px-3
                                          bg-gray-700 text-white border-gray-600 leading-tight
                                          focus:outline-none focus:shadow-outline focus:border-indigo-500 focus:ring-indigo-500
                                          placeholder-gray-400"
                                   value="{{ old('name') }}" required>
                            @error('name') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Campo para la descripción del evento --}}
                        <div class="mb-4">
                            <label for="description" class="block text-gray-300 text-sm font-bold mb-2">Descripción:</label>
                            <textarea name="description" id="description" rows="5"
                                      class="shadow appearance-none border rounded w-full py-2 px-3
                                             bg-gray-700 text-white border-gray-600 leading-tight
                                             focus:outline-none focus:shadow-outline focus:border-indigo-500 focus:ring-indigo-500
                                             placeholder-gray-400"
                            >{{ old('description') }}</textarea>
                            @error('description') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Campos de fecha y hora de inicio y fin --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="mb-4">
                                <label for="start_date" class="block text-gray-300 text-sm font-bold mb-2">Fecha y Hora de Inicio:</label>
                                <input type="datetime-local" name="start_date" id="start_date"
                                       class="shadow appearance-none border rounded w-full py-2 px-3
                                              bg-gray-700 text-white border-gray-600 leading-tight
                                              focus:outline-none focus:shadow-outline focus:border-indigo-500 focus:ring-indigo-500"
                                       value="{{ old('start_date') }}" required>
                                @error('start_date') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="mb-4">
                                <label for="end_date" class="block text-gray-300 text-sm font-bold mb-2">Fecha y Hora de Fin (Opcional):</label>
                                <input type="datetime-local" name="end_date" id="end_date"
                                       class="shadow appearance-none border rounded w-full py-2 px-3
                                              bg-gray-700 text-white border-gray-600 leading-tight
                                              focus:outline-none focus:shadow-outline focus:border-indigo-500 focus:ring-indigo-500"
                                       value="{{ old('end_date') }}">
                                @error('end_date') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- Campos de ubicación y ciudad --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="mb-4">
                                <label for="location" class="block text-gray-300 text-sm font-bold mb-2">Ubicación (Dirección):</label>
                                <input type="text" name="location" id="location"
                                       class="shadow appearance-none border rounded w-full py-2 px-3
                                              bg-gray-700 text-white border-gray-600 leading-tight
                                              focus:outline-none focus:shadow-outline focus:border-indigo-500 focus:ring-indigo-500
                                              placeholder-gray-400"
                                       value="{{ old('location') }}" required>
                                @error('location') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="mb-4">
                                <label for="city" class="block text-gray-300 text-sm font-bold mb-2">Ciudad (Opcional):</label>
                                <input type="text" name="city" id="city"
                                       class="shadow appearance-none border rounded w-full py-2 px-3
                                              bg-gray-700 text-white border-gray-600 leading-tight
                                              focus:outline-none focus:shadow-outline focus:border-indigo-500 focus:ring-indigo-500
                                              placeholder-gray-400"
                                       value="{{ old('city') }}">
                                @error('city') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- Campo para subir el póster del evento --}}
                        <div class="mb-4">
                            <label for="poster_image" class="block text-gray-300 text-sm font-bold mb-2">Póster del Evento (Max 2MB, JPG/PNG):</label>
                            <input type="file" name="poster_image" id="poster_image"
                                   class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold
                                          file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition-colors duration-200">
                            @error('poster_image') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Campos de precio y tickets disponibles --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="mb-4">
                                <label for="price" class="block text-gray-300 text-sm font-bold mb-2">Precio (€):</label>
                                <input type="number" step="0.01" name="price" id="price"
                                       class="shadow appearance-none border rounded w-full py-2 px-3
                                              bg-gray-700 text-white border-gray-600 leading-tight
                                              focus:outline-none focus:shadow-outline focus:border-indigo-500 focus:ring-indigo-500
                                              placeholder-gray-400"
                                       value="{{ old('price', 0.00) }}" required>
                                @error('price') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="mb-4">
                                <label for="available_tickets" class="block text-gray-300 text-sm font-bold mb-2">Entradas Disponibles (Opcional):</label>
                                <input type="number" name="available_tickets" id="available_tickets"
                                       class="shadow appearance-none border rounded w-full py-2 px-3
                                              bg-gray-700 text-white border-gray-600 leading-tight
                                              focus:outline-none focus:shadow-outline focus:border-indigo-500 focus:ring-indigo-500
                                              placeholder-gray-400"
                                       value="{{ old('available_tickets') }}">
                                @error('available_tickets') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- Campo para seleccionar la categoría del evento --}}
                        <div class="mb-4">
                            <label for="category_id" class="block text-gray-300 text-sm font-bold mb-2">Categoría:</label>
                            <select name="category_id" id="category_id"
                                    class="shadow border rounded w-full py-2 px-3
                                           bg-gray-700 text-white border-gray-600 leading-tight
                                           focus:outline-none focus:shadow-outline focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                <option value="">Selecciona una categoría</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Checkbox para publicar el evento --}}
                        <div class="mb-4">
                            <label for="is_published" class="inline-flex items-center">
                                <input type="hidden" name="is_published" value="0"> {{-- Campo oculto para asegurar envío de 0 si no está marcado --}}
                                <input type="checkbox"
                                       name="is_published"
                                       id="is_published"
                                       value="1"
                                       class="rounded border-gray-600 text-red-600 shadow-sm focus:ring-red-500 bg-gray-700"
                                       {{ old('is_published') == '1' ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-300">Publicar Evento</span>
                            </label>
                            @error('is_published') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Botón para guardar el evento --}}
                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition">
                                Guardar Evento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>