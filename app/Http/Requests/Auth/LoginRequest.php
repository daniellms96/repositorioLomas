<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    // Determina si el usuario está autorizado para hacer esta petición.
    public function authorize(): bool
    {
        return true;
    }

    // Obtiene las reglas de validación para la petición.
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    // Intenta autenticar las credenciales de la petición.
    public function authenticate(): void
    {
        // Asegura que no haya un límite de intentos.
        $this->ensureIsNotRateLimited();

        // Intenta autenticar al usuario.
        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            // Incrementa el contador de intentos fallidos.
            RateLimiter::hit($this->throttleKey());

            // Lanza una excepción de validación.
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // Limpia los intentos fallidos al autenticar con éxito.
        RateLimiter::clear($this->throttleKey());
    }

    // Asegura que la petición de inicio de sesión no esté limitada por intentos.
    public function ensureIsNotRateLimited(): void
    {
        // Si no hay demasiados intentos, continúa.
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        // Dispara el evento de bloqueo.
        event(new Lockout($this));

        // Obtiene los segundos restantes para reintentar.
        $seconds = RateLimiter::availableIn($this->throttleKey());

        // Lanza una excepción de validación por límite de intentos.
        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    // Obtiene la clave para el limitador de velocidad.
    public function throttleKey(): string
    {
        // Genera una clave única basada en el email y la IP.
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}