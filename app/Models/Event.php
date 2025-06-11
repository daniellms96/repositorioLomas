<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    // Campos que se pueden asignar masivamente.
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'location',
        'city',
        'poster_path',
        'price',
        'available_tickets',
        'category_id',
        'user_id', 
        'is_published',
        'slug',
    ];

    // Casteo de atributos a tipos nativos.
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_published' => 'boolean',
        'price' => 'decimal:2',
    ];

    // Un evento pertenece a una categoría.
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Un evento pertenece a un usuario (organizador).
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un evento tiene muchas entradas.
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}