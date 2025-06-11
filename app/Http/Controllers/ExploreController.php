<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Event;
use Carbon\Carbon;

class ExploreController extends Controller
{
    // Muestra la página de exploración con categorías y eventos.
    public function index()
    {
        // Obtiene todas las categorías.
        $categories = Category::all();

        // Obtiene todos los eventos publicados, ordenados por fecha.
        $allEvents = Event::where('is_published', true)
                            ->orderBy('start_date', 'asc')
                            ->get();

        // Retorna la vista con categorías y eventos.
        return view('explore', [
            'categories' => $categories,
            'featuredEvents' => $allEvents, 
        ]);
    }
}