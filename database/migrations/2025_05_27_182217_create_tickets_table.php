<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Ejecuta las migraciones.
    public function up(): void
    {
        // Crea la tabla para las entradas de eventos.
        Schema::create('tickets', function (Blueprint $table) {
            $table->id(); // ID único para cada entrada.

            // Clave foránea que relaciona la entrada con un evento.
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            
            // Clave foránea que relaciona la entrada con el usuario que la compró.
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('ticket_code')->unique(); // Código único para la entrada.
            $table->decimal('price', 8, 2); // Precio de la entrada.
            $table->string('status')->default('available'); // Estado actual de la entrada.
            
            $table->timestamps(); // Registra las fechas de creación y actualización.
        });
    }

    // Revierte las migraciones.
    public function down(): void
    {
        // Elimina la tabla 'tickets' si existe.
        Schema::dropIfExists('tickets');
    }
};