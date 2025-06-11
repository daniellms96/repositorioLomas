<?php

namespace App\Http\Controllers;

use App\Models\Ticket; // Importa el modelo Ticket.
use App\Models\Event;   // Importa el modelo Event.
use App\Models\User;    // Importa el modelo User.
use Illuminate\Http\Request; // Importa la clase Request para manejar peticiones HTTP.
use Illuminate\Support\Str; // Importa la clase Str para utilidades de cadenas.
use Illuminate\Support\Facades\Auth; // Importa Auth para acceso al usuario autenticado.
use Illuminate\View\View; // Importa View para tipos de retorno de vistas.
use Illuminate\Http\RedirectResponse; // Importa RedirectResponse para tipos de retorno de redirecciones.

class TicketController extends Controller
{
    // Muestra la lista de entradas compradas por el usuario autenticado.
    public function index(): View|RedirectResponse
    {
        $userId = Auth::id(); // Obtiene el ID del usuario actual.

        if (!$userId) { // Verifica si el usuario no está logueado.
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para ver tus entradas.'); // Redirige si no hay sesión.
        }

        $allTickets = Ticket::where('user_id', $userId)->get(); // Obtiene todas las entradas del usuario.

        $totalSpent = $allTickets->sum('price'); // Calcula el total gastado en todas las entradas.

        $tickets = Ticket::where('user_id', $userId) // Inicia la consulta para entradas del usuario.
                         ->with('event') // Carga la relación con el evento.
                         ->latest() // Ordena por las entradas más recientes.
                         ->paginate(10); // Pagina los resultados, 10 por página.
        
        return view('tickets.index', compact('tickets', 'totalSpent')); // Retorna la vista con datos.
    }

    // Almacena una nueva entrada en la base de datos.
    public function store(Request $request)
    {
        $request->validate([ // Valida los datos de la petición.
            'event_id' => 'required|exists:events,id', // El evento debe existir.
            'user_id' => 'required|exists:users,id',  // El usuario debe existir.
            'price' => 'required|numeric|min:0', // El precio es requerido y numérico.
            'is_scanned' => 'boolean', // 'is_scanned' debe ser booleano.
        ]);

        Ticket::create([ // Crea un nuevo registro de entrada.
            'event_id' => $request->event_id, // Asigna el ID del evento.
            'user_id' => $request->user_id, // Asigna el ID del usuario.
            'ticket_code' => Str::upper(Str::random(12)), // Genera un código de entrada único.
            'price' => $request->price, // Asigna el precio.
            'is_scanned' => $request->boolean('is_scanned'), // Asigna el estado de escaneo.
        ]);

        return redirect()->route('tickets.index')->with('success', 'Entrada creada exitosamente.'); // Redirige con mensaje de éxito.
    }

    // Muestra los detalles de una entrada específica.
    public function show(Ticket $ticket)
    {
        return view('tickets.show', compact('ticket')); // Retorna la vista con la entrada.
    }

    // Muestra el formulario para editar una entrada existente.
    public function edit(Ticket $ticket)
    {
        $events = Event::all(); // Obtiene todos los eventos para el select.
        $users = User::all();  // Obtiene todos los usuarios para el select.
        
        return view('tickets.edit', compact('ticket', 'events', 'users')); // Retorna la vista de edición.
    }

    // Actualiza una entrada existente en la base de datos.
    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([ // Valida los datos de la petición.
            'event_id' => 'required|exists:events,id',
            'user_id' => 'required|exists:users,id',
            'ticket_code' => 'required|string|max:255|unique:tickets,ticket_code,' . $ticket->id, // Código único excluyendo el actual.
            'price' => 'required|numeric|min:0',
            'is_scanned' => 'boolean',
        ]);

        $ticket->update([ // Actualiza la entrada con los nuevos datos.
            'event_id' => $request->event_id,
            'user_id' => $request->user_id,
            'ticket_code' => $request->ticket_code,
            'price' => $request->price,
            'is_scanned' => $request->boolean('is_scanned'),
        ]);

        return redirect()->route('tickets.index')->with('success', 'Entrada actualizada exitosamente.'); // Redirige con mensaje de éxito.
    }

    // Elimina una entrada de la base de datos.
    public function destroy(Ticket $ticket)
    {
        $ticket->delete(); // Elimina la entrada.

        return redirect()->route('tickets.index')->with('success', 'Entrada eliminada exitosamente.'); // Redirige con mensaje de éxito.
    }
}