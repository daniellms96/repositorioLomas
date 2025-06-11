<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Ejecuta las migraciones.
    public function up(): void
    {
        // Crea la tabla 'categories'.
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // ID de la categoría.
            $table->string('name')->unique(); // Nombre único de la categoría.
            $table->string('slug')->unique(); // Slug único para URLs.
            $table->text('description')->nullable(); // Descripción opcional.
            $table->timestamps(); // Timestamps de creación y actualización.
        });
    }

    // Revierte las migraciones.
    public function down(): void
    {
        // Elimina la tabla 'categories' si existe.
        Schema::dropIfExists('categories'); 
    }
};