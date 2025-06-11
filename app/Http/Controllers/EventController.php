<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    // Muestra la página principal de exploración de eventos.
    public function explore(): View
    {
        // Obtiene eventos destacados y publicados.
        $featuredEvents = Event::with('category', 'user')
                               ->where('is_published', true)
                               ->where('start_date', '>=', now())
                               ->orderBy('start_date', 'asc')
                               ->get();

        // Obtiene todas las categorías.
        $categories = Category::all();

        // Retorna la vista de exploración con los datos.
        return view('events.explore', compact('featuredEvents', 'categories'));
    }

    // Muestra una lista de eventos, para administración o exploración pública.
    public function index(Request $request): View
    {
        // Inicializa la consulta de eventos.
        $query = Event::with(['category', 'user']);
        $selectedCategory = null;
        $categories = []; 

        // Diferencia la lógica según la ruta.
        if ($request->routeIs('my-events.index')) {
            // Eventos del usuario autenticado.
            $query->where('user_id', Auth::id())
                  ->latest(); 
            $viewName = 'events.index'; 
        } else {
            // Eventos públicos, futuros y publicados.
            $query->where('is_published', true)
                  ->where('start_date', '>=', now()) 
                  ->orderBy('start_date', 'asc');

            // Carga categorías para la vista pública.
            $categories = Category::all(); 

            // Aplica filtro por categoría si existe.
            if ($request->has('category') && $request->input('category') !== '') {
                $categorySlug = $request->input('category');
                $selectedCategory = $categories->firstWhere('slug', $categorySlug); 

                if ($selectedCategory) {
                    $query->whereHas('category', function ($q) use ($categorySlug) {
                        $q->where('slug', $categorySlug);
                    });
                }
            }
            $viewName = 'events.public_index'; 
        }

        // Pagina los resultados.
        $events = $query->paginate(10); 

        // Retorna la vista apropiada con los datos.
        return view($viewName, compact('events', 'selectedCategory', 'categories'));
    }

    // Muestra el formulario para crear un nuevo evento.
    public function create(): View
    {
        // Obtiene todas las categorías.
        $categories = Category::all();
        // Retorna la vista de creación.
        return view('events.create', compact('categories'));
    }

    // Almacena un nuevo evento en la base de datos.
    public function store(Request $request): RedirectResponse
    {
        // Valida los datos del formulario.
        $request->validate([
            'name' => 'required|string|max:255|unique:events,name',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'poster_image' => 'nullable|image|max:2048',
            'price' => 'nullable|numeric|min:0',
            'available_tickets' => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'is_published' => ['nullable', 'boolean'],
        ]);

        // Prepara los datos del evento.
        $eventData = $request->except(['_token', 'poster_image']);
        $eventData['slug'] = Str::slug($request->name);

        // Procesa la imagen del póster si se subió.
        if ($request->hasFile('poster_image')) {
            $image = $request->file('poster_image');
            $path = $image->store('events_posters', 'public');
            $eventData['poster_path'] = $path;
        } else {
            $eventData['poster_path'] = null;
        }

        // Asigna valores predeterminados y el ID del usuario autenticado.
        $eventData['price'] = $request->price ?? 0.00;
        $eventData['is_published'] = $request->boolean('is_published');
        $eventData['user_id'] = Auth::id(); 

        // Crea el evento.
        Event::create($eventData);

        // Redirige al índice de "Mis Eventos".
        return redirect()->route('my-events.index')->with('success', 'Evento creado exitosamente.');
    }

    // Muestra un evento específico al público.
    public function show(string $slug): View
    {
        // Busca el evento por slug.
        $event = Event::where('slug', $slug)
                      ->with('category', 'user')
                      ->firstOrFail();
        Log::info('Accediendo a detalles del evento: ' . $event->slug . ' (ID: ' . $event->id . ')');
        // Retorna la vista del evento.
        return view('events.show', compact('event'));
    }

    // Muestra el formulario para editar un evento existente.
    public function edit(Event $myEvent): View 
    {
        // Autoriza que solo el propietario edite.
        if (Auth::id() !== $myEvent->user_id) { 
            abort(403, 'No tienes permiso para editar este evento.');
        }

        // Obtiene todas las categorías.
        $categories = Category::all();
        // Retorna la vista de edición.
        return view('events.edit', ['event' => $myEvent, 'categories' => $categories]); 
    }

    // Actualiza un evento existente.
    public function update(Request $request, Event $myEvent): RedirectResponse 
    {
        // Autoriza que solo el propietario actualice.
        if (Auth::id() !== $myEvent->user_id) { 
            abort(403, 'No tienes permiso para actualizar este evento.');
        }

        // Valida los datos.
        $request->validate([
            'name' => 'required|string|max:255|unique:events,name,' . $myEvent->id, 
        ]);

        // Prepara los datos para actualizar.
        $eventData = $request->except(['_token', '_method', 'poster_image', 'remove_poster']);

        // Actualiza el slug si el nombre cambia.
        if ($request->name !== $myEvent->name) { 
            $eventData['slug'] = Str::slug($request->name);
        }

        // Gestiona la carga y eliminación de la imagen del póster.
        if ($request->hasFile('poster_image')) {
            if ($myEvent->poster_path) { 
                Storage::disk('public')->delete($myEvent->poster_path); 
            }
            $image = $request->file('poster_image');
            $path = $image->store('events_posters', 'public');
            $eventData['poster_path'] = $path;
        } elseif ($request->boolean('remove_poster')) {
            if ($myEvent->poster_path) { 
                Storage::disk('public')->delete($myEvent->poster_path); 
            }
            $eventData['poster_path'] = null;
        }

        // Asigna valores predeterminados y actualiza.
        $eventData['price'] = $request->price ?? 0.00;
        $eventData['is_published'] = $request->boolean('is_published');
        $myEvent->update($eventData); 

        // Redirige con mensaje de éxito.
        return redirect()->route('my-events.index')->with('success', 'Evento actualizado exitosamente.');
    }

    // Elimina un evento.
    public function destroy(Event $myEvent): RedirectResponse 
    {
        Log::info('--- Iniciando EventController@destroy ---');
        Log::info('Usuario autenticado ID: ' . (Auth::check() ? Auth::id() : 'NO AUTENTICADO'));
        Log::info('Evento recibido (toArray): ' . ($myEvent ? json_encode($myEvent->toArray()) : 'NULL Event Object')); 
        Log::info('ID del evento (propiedad): ' . ($myEvent ? $myEvent->id : 'N/A')); 
        Log::info('ID de usuario del evento (propiedad): ' . ($myEvent ? $myEvent->user_id : 'N/A')); 
        Log::info('------------------------------------------');

        // Autoriza la eliminación.
        if (!Auth::check() || Auth::id() !== $myEvent->user_id) { 
            Log::warning('Intento de eliminar evento sin permiso. User ID: ' . (Auth::id() ?? 'null') . ', Event User ID: ' . ($myEvent->user_id ?? 'null') . ', Event ID: ' . ($myEvent->id ?? 'null')); 
            abort(403, 'No tienes permiso para eliminar este evento.');
        }

        // Elimina el póster si existe.
        if ($myEvent->poster_path) { 
            Storage::disk('public')->delete($myEvent->poster_path);
            Log::info('Imagen del póster eliminada: ' . $myEvent->poster_path);
        }

        // Elimina el evento.
        $myEvent->delete(); 
        Log::info('Evento eliminado con ID: ' . $myEvent->id); 

        // Redirige con mensaje de éxito.
        return redirect()->route('my-events.index')->with('success', 'Evento eliminado exitosamente.');
    }

    // Procesa la compra de una entrada.
    public function processPurchase(Request $request, string $slug): JsonResponse
    {
        Log::info('Inicio de processPurchase para slug recibido: ' . $slug);

        // Busca el evento por slug.
        $event = Event::where('slug', $slug)->first();

        // Maneja evento no encontrado.
        if (!$event) {
            Log::error('Evento no encontrado por slug en processPurchase: ' . $slug);
            return response()->json(['success' => false, 'message' => 'Evento no encontrado.'], 404);
        }

        Log::info('Evento encontrado por slug: ' . $event->slug . ' (ID: ' . $event->id . ')');

        // Valida el método de pago.
        $request->validate([
            'payment_method' => 'required|string|in:card,paypal',
        ]);

        // Requiere autenticación para comprar.
        if (!Auth::check()) {
            Log::warning('Intento de compra sin autenticar para evento: ' . $event->slug);
            return response()->json(['success' => false, 'message' => 'Debes iniciar sesión para comprar entradas.'], 401);
        }

        // Inicia transacción de base de datos.
        DB::beginTransaction();
        try {
            // Verifica disponibilidad de tickets.
            if ($event->available_tickets <= 0) {
                DB::rollBack();
                Log::warning('Entradas agotadas para evento: ' . $event->slug);
                return response()->json(['success' => false, 'message' => 'Entradas agotadas para este evento.'], 400);
            }

            // Decrementa tickets disponibles.
            $event->decrement('available_tickets');
            Log::info('Tickets disponibles decrementados para evento: ' . $event->slug . '. Nuevos disponibles: ' . $event->available_tickets);

            // Obtiene el ID del usuario autenticado.
            $userId = Auth::id();
            if (is_null($userId)) {
                DB::rollBack();
                Log::error('Auth::id() es nulo antes de crear ticket. Usuario no autenticado correctamente.');
                return response()->json(['success' => false, 'message' => 'Error de autenticación. Inténtalo de nuevo.'], 401);
            }

            Log::info('Intentando crear Ticket con datos:', [
                'event_id' => $event->id,
                'user_id' => $userId,
                'purchase_date' => now()->toDateTimeString(),
                'price' => $event->price,
                'status' => 'confirmed',
                'ticket_code' => 'RAVE-' . Str::random(8),
            ]);

            // Crea el ticket.
            $ticket = Ticket::create([
                'event_id' => $event->id,
                'user_id' => $userId,
                'purchase_date' => now(),
                'price' => $event->price,
                'status' => 'confirmed',
                'ticket_code' => 'RAVE-' . Str::random(8),
            ]);
            Log::info('Ticket creado con ID: ' . $ticket->id);

            Log::info('Intentando crear Payment con datos:', [
                'user_id' => $userId,
                'ticket_id' => $ticket->id,
                'amount' => $event->price,
                'payment_method' => $request->payment_method,
                'transaction_id' => 'TRX-' . Str::random(10),
                'status' => 'completed',
                'currency' => 'EUR',
            ]);

            // Crea el registro de pago.
            $payment = Payment::create([
                'user_id' => $userId,
                'ticket_id' => $ticket->id,
                'amount' => $event->price,
                'payment_method' => $request->payment_method,
                'transaction_id' => 'TRX-' . Str::random(10),
                'status' => 'completed',
                'currency' => 'EUR',
            ]);
            Log::info('Payment creado con ID: ' . $payment->id);

            // Confirma la transacción.
            DB::commit();
            Log::info('Transacción de compra completada exitosamente para evento: ' . $event->slug);

            // Retorna respuesta JSON de éxito.
            return response()->json([
                'success' => true,
                'message' => '¡Compra exitosa!',
                'new_tickets_available' => $event->available_tickets,
                'ticket_code' => $ticket->ticket_code,
                'payment_transaction_id' => $payment->transaction_id,
            ]);

        } catch (\Exception $e) {
            // Revierte la transacción en caso de error.
            DB::rollBack();
            Log::error('Error al procesar la compra: ' . $e->getMessage(), [
                'event_id' => $event->id ?? 'N/A',
                'user_id' => Auth::id(),
                'exception_trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
                'slug_recibido' => $slug,
            ]);
            // Retorna respuesta JSON de error.
            return response()->json(['success' => false, 'message' => 'Error al procesar la compra. Detalles: ' . $e->getMessage()], 500);
        }
    }
}