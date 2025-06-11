<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Ejecuta las migraciones.
    public function up(): void
    {
        // Crea la tabla para la caché.
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary(); // Clave única de la caché.
            $table->mediumText('value'); // Valor de la caché.
            $table->integer('expiration'); // Tiempo de expiración de la caché.
        });

        // Crea la tabla para los bloqueos de caché.
        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary(); // Clave del bloqueo de caché.
            $table->string('owner'); // Propietario del bloqueo.
            $table->integer('expiration'); // Tiempo de expiración del bloqueo.
        });
    }

    // Revierte las migraciones.
    public function down(): void
    {
        // Elimina la tabla 'cache' si existe.
        Schema::dropIfExists('cache');
        // Elimina la tabla 'cache_locks' si existe.
        Schema::dropIfExists('cache_locks');
    }
};