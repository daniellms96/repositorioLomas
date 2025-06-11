<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event; 

class DashboardController extends Controller
{
    public function index()
    {
        // Obtiene todos los eventos ordenados por fecha.
        $allEvents = Event::orderBy('start_date', 'asc')->get();

        // Obtiene los 3 eventos próximos.
        $upcomingEvents = Event::where('start_date', '>=', now()) 
                             ->orderBy('start_date', 'asc')   
                             ->take(3)
                             ->get();

        // Retorna la vista del dashboard con los eventos.
        return view('dashboard', compact('allEvents', 'upcomingEvents'));
    }
}