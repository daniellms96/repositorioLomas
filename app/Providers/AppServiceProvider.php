<?php

namespace App\Providers;

use App\Models\Event; 
use App\Policies\EventPolicy; 
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    // Mapeo de modelos a sus políticas correspondientes.
    protected $policies = [
        Event::class => EventPolicy::class, 
    ];

    // Registra cualquier servicio de autenticación/autorización.
    public function boot(): void
    {
        //
    }
}