<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EventController; 
use App\Http\Controllers\TicketController; 
use App\Http\Controllers\DashboardController; 

// --- Rutas Públicas ---

// Ruta raíz: Redirige al dashboard si el usuario está autenticado,
// de lo contrario, a la página de exploración de eventos.
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard'); // Redirige al dashboard si está logueado.
    } else {
        return redirect()->route('events.explore'); // Redirige a la exploración de eventos si no está logueado.
    }
})->name('home'); // Nombre de la ruta principal.

// Página pública de exploración de eventos.
Route::get('/explore', [EventController::class, 'explore'])->name('events.explore');

// Ruta pública para ver todos los eventos (con posible filtrado por categoría).
Route::get('/events', [EventController::class, 'index'])->name('events.public.index');

// Ruta pública para mostrar los detalles de un evento específico por su slug.
Route::get('/events/{event:slug}', [EventController::class, 'show'])->name('events.show');

// --- Rutas Protegidas (Requieren Autenticación y Verificación de Email) ---

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard del usuario.
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); 

    // Rutas para la gestión del perfil del usuario.
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ruta para limpiar los errores de eliminación de perfil (uso interno).
    Route::get('/profile/clear-deletion-errors', function () {
        session()->forget('errors'); // Limpia los errores de la sesión.
        return redirect()->route('profile.edit'); // Redirige al perfil.
    })->name('profile.clear-deletion-errors');

    // Rutas de gestión de eventos del usuario (CRUD completo excepto 'show' público).
    Route::resource('my-events', EventController::class)->except(['show']);

    // Ruta para ver las entradas compradas por el usuario.
    Route::get('/my-tickets', [TicketController::class, 'index'])->name('my-tickets.index');

    // Rutas de creación de eventos (mantenidas para coherencia, aunque resource ya las define).
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');

    // Ruta para procesar la compra de entradas de un evento.
    Route::post('/events/{event:slug}/purchase', [EventController::class, 'processPurchase'])->name('events.purchase');
});

// --- Rutas de Autenticación ---
// Incluye las rutas estándar de autenticación de Laravel (login, registro, etc.).
require __DIR__.'/auth.php';