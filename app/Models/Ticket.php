<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    // Campos que se pueden asignar masivamente.
    protected $fillable = [
        'event_id',
        'user_id',
        'ticket_code',
        'price',
        'purchase_date', 
        'status',      
        'is_scanned',
    ];

    // Casteo de atributos a tipos nativos.
    protected $casts = [
        'purchase_date' => 'datetime', 
        'is_scanned' => 'boolean',
        'price' => 'decimal:2',
    ];

    // Una entrada pertenece a un evento.
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Una entrada es comprada por un usuario.
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}