<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Ejecuta las migraciones.
    public function up(): void
    {
        // Modifica la tabla `payments`.
        Schema::table('payments', function (Blueprint $table) {
            // Agrega la columna `ticket_id` como clave foránea, permitiendo nulos.
            $table->unsignedBigInteger('ticket_id')->after('user_id')->nullable();

            // Define la restricción de clave foránea con `onDelete('set null')`.
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('set null');
        });
    }

    // Revierte las migraciones.
    public function down(): void
    {
        // Revierte los cambios en la tabla `payments`.
        Schema::table('payments', function (Blueprint $table) {
            // Elimina la restricción de clave foránea.
            $table->dropForeign(['ticket_id']);
            // Elimina la columna `ticket_id`.
            $table->dropColumn('ticket_id');
        });
    }
};