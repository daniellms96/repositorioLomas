<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    // Habilita factories y notificaciones.
    use HasFactory, Notifiable;

    // Atributos que se pueden asignar masivamente.
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Atributos ocultos para serialización.
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casteo de atributos.
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Un usuario puede organizar muchos eventos.
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    // Un usuario puede comprar muchas entradas.
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    // Un usuario puede tener muchos pagos.
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}