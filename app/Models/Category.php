<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Campos que se pueden asignar masivamente.
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    // Una categoría tiene muchos eventos.
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}