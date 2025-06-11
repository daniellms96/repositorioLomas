<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    // Muestra el formulario de perfil del usuario.
    public function edit(Request $request): View
    {
        // Retorna la vista de edición de perfil.
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    // Actualiza la información del perfil del usuario.
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Rellena el modelo de usuario con los datos validados.
        $request->user()->fill($request->validated());

        // Si el email ha cambiado, marca como no verificado.
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Guarda los cambios del usuario.
        $request->user()->save();

        // Redirige de vuelta al formulario de edición con un mensaje de estado.
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    // Elimina la cuenta del usuario.
    public function destroy(Request $request): RedirectResponse
    {
        // Valida la contraseña del usuario.
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        // Obtiene el usuario actual.
        $user = $request->user();

        // Cierra la sesión del usuario.
        Auth::logout();

        // Elimina el usuario de la base de datos.
        $user->delete();

        // Invalida la sesión y regenera el token.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirige a la página de inicio.
        return Redirect::to('/');
    }
}