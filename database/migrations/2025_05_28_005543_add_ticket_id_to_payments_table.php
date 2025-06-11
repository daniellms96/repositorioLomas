<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Ejecuta las migraciones.
    public function up(): void
    {
        // Modifica la tabla 'payments'.
        Schema::table('payments', function (Blueprint $table) {
            // Añade la columna 'ticket_id' si no existe.
            if (!Schema::hasColumn('payments', 'ticket_id')) {
                $table->foreignId('ticket_id')->nullable()->constrained()->onDelete('set null')->after('user_id');
            }
        });
    }

    // Revierte las migraciones.
    public function down(): void
    {
        // Modifica la tabla 'payments'.
        Schema::table('payments', function (Blueprint $table) {
            // Elimina la columna 'ticket_id' si existe.
            if (Schema::hasColumn('payments', 'ticket_id')) {
                $table->dropConstrainedForeignId('ticket_id'); 
                $table->dropColumn('ticket_id'); 
            }
        });
    }
};