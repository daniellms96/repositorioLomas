<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    // Obtiene las reglas de validación para la petición.
    public function rules(): array
    {
        // Define las reglas para 'name' y 'email'.
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                // Asegura que el email sea único, excepto para el usuario actual.
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
    }
}