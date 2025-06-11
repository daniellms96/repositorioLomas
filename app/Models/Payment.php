<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 

class Payment extends Model
{
    use HasFactory;

    // Campos que se pueden asignar masivamente.
    protected $fillable = [
        'user_id',
        'ticket_id',     
        'amount',
        'payment_method',
        'transaction_id',    
        'status',
        'currency',      
        'notes',         
    ];

    // Casteo de atributos a tipos nativos.
    protected $casts = [
        'amount' => 'decimal:2',
    ];

    // Un pago pertenece a un usuario.
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Un pago está asociado a una entrada.
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
}