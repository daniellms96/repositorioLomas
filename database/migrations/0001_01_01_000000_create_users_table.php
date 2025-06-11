<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Ejecuta las migraciones.
    public function up(): void
    {
        // Crea la tabla 'users'.
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Columna de ID autoincremental.
            $table->string('name'); // Columna para el nombre.
            $table->string('email')->unique(); // Columna para el email, debe ser único.
            $table->timestamp('email_verified_at')->nullable(); // Fecha de verificación de email.
            $table->string('password'); // Contraseña.
            $table->rememberToken(); // Token para recordar sesión.
            $table->timestamps(); // Columnas 'created_at' y 'updated_at'.
        });

        // Crea la tabla 'password_reset_tokens'.
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Email como clave primaria.
            $table->string('token'); // Token de reseteo.
            $table->timestamp('created_at')->nullable(); // Fecha de creación.
        });

        // Crea la tabla 'sessions'.
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // ID de sesión como clave primaria.
            $table->foreignId('user_id')->nullable()->index(); // Clave foránea al ID de usuario.
            $table->string('ip_address', 45)->nullable(); // Dirección IP.
            $table->text('user_agent')->nullable(); // Agente de usuario del navegador.
            $table->longText('payload'); // Datos de sesión serializados.
            $table->integer('last_activity')->index(); // Marca de tiempo de última actividad.
        });
    }

    // Revierte las migraciones.
    public function down(): void
    {
        // Elimina la tabla 'users' si existe.
        Schema::dropIfExists('users');
        // Elimina la tabla 'password_reset_tokens' si existe.
        Schema::dropIfExists('password_reset_tokens');
        // Elimina la tabla 'sessions' si existe.
        Schema::dropIfExists('sessions');
    }
};