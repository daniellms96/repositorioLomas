<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

// Rutas accesibles para usuarios NO autenticados (guest).
Route::middleware('guest')->group(function () {
    // Muestra el formulario de registro.
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    // Procesa el registro de un nuevo usuario.
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Muestra el formulario de inicio de sesión.
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    // Procesa el intento de inicio de sesión.
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Muestra el formulario para solicitar restablecimiento de contraseña.
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    // Envía el enlace de restablecimiento de contraseña al email.
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    // Muestra el formulario para restablecer la contraseña con un token.
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    // Procesa el restablecimiento de la nueva contraseña.
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

// Rutas accesibles solo para usuarios autenticados (auth).
Route::middleware('auth')->group(function () {
    // Muestra el aviso de verificación de email.
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    // Verifica el email del usuario usando el enlace firmado.
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    // Reenvía la notificación de verificación de email.
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // Muestra el formulario para confirmar la contraseña.
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    // Procesa la confirmación de contraseña.
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Actualiza la contraseña del usuario.
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // Cierra la sesión del usuario.
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});