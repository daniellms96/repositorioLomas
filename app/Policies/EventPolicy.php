<?php

namespace App\Policies;

use App\Models\Event; 
use App\Models\User;  
use Illuminate\Auth\Access\Response; 

class EventPolicy
{
    // Determina si el usuario puede actualizar el evento.
    public function update(User $user, Event $event): bool
    {
        // Solo el propietario puede actualizar su evento.
        return $user->id === $event->user_id; 
    }

    // Determina si el usuario puede eliminar el evento.
    public function delete(User $user, Event $event): bool
    {
        // Solo el propietario puede eliminar su evento.
        return $user->id === $event->user_id; 
    }
}