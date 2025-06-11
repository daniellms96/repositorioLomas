<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Mis Entradas Compradas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white border-b border-gray-800">
                    <h3 class="text-xl font-bold mb-6">Tus Entradas</h3>

                    @if (session('success'))
                        <div class="bg-green-500 text-white p-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Sección de resumen de gastos --}}
                    @if ($tickets->isNotEmpty())
                        <div class="bg-gray-800 p-4 rounded-lg mb-6">
                            <h4 class="text-lg font-bold mb-2">Resumen de Gastos</h4>
                            {{-- Usa la nueva variable $totalSpent --}}
                            <p class="text-gray-300">Total gastado en entradas: <span class="text-red-400 font-bold">{{ number_format($totalSpent, 2) }} €</span></p>
                        </div>
                    @endif
                    {{-- Fin de la sección de resumen de gastos --}}

                    @if ($tickets->isEmpty())
                        <p class="text-gray-400">Aún no has comprado ninguna entrada.</p>
                        <p class="text-gray-400 mt-2">Explora eventos para encontrar tu próxima experiencia.</p>
                        <a href="{{ route('events.explore') }}" class="mt-4 inline-block bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition">
                            Explorar Eventos
                        </a>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-700">
                                <thead class="bg-gray-800">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                            ID Ticket
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                            Evento
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                            Código de Entrada
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                            Precio
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                            Fecha de Compra
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-gray-900 divide-y divide-gray-800">
                                    @foreach ($tickets as $ticket)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                {{ $ticket->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                                {{ $ticket->event->name ?? 'Evento Desconocido' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                {{ $ticket->ticket_code }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                {{ number_format($ticket->price, 2) }} €
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                {{ \Carbon\Carbon::parse($ticket->created_at)->format('d M Y H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $tickets->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>