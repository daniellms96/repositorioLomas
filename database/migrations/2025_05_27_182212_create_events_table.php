<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id(); // Clave primaria
            $table->string('name'); // Nombre del evento
            $table->text('description')->nullable(); // Descripción detallada, opcional
            $table->dateTime('start_date'); // Fecha y hora de inicio del evento
            $table->dateTime('end_date')->nullable(); // Fecha y hora de fin, opcional (para eventos de varios días)
            $table->string('location'); // Lugar o dirección del evento
            $table->string('city')->nullable(); // Ciudad del evento, útil para búsquedas
            $table->string('poster_path')->nullable(); // Ruta del archivo de la imagen del póster (ej: 'images/eventos/mi-evento.jpg')
            $table->decimal('price', 8, 2)->default(0.00); // Precio base de la entrada, con 8 dígitos en total y 2 decimales
            $table->integer('available_tickets')->nullable(); // Número total de entradas disponibles
            
            // Clave foránea para la relación con 'categories'
            // Si una categoría se elimina, los eventos asociados a ella también se eliminarán.
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            
            // Clave foránea para la relación con 'users' (asume que la tabla 'users' ya existe)
            // Esto vincula un evento al usuario que lo creó (el organizador).
            // Si el usuario organizador se elimina, sus eventos también se eliminarán.
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            
            $table->boolean('is_published')->default(false); // Bandera para publicar/despublicar el evento
            $table->string('slug')->unique(); // Slug único para la URL amigable del evento
            $table->timestamps(); // Columnas 'created_at' y 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events'); // Eliminar la tabla 'events'
    }
};