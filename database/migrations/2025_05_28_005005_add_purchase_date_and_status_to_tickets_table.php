<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Ejecuta las migraciones.
    public function up(): void
    {
        // Modifica la tabla 'tickets'.
        Schema::table('tickets', function (Blueprint $table) {
            // Añade la columna 'purchase_date' si no existe.
            if (!Schema::hasColumn('tickets', 'purchase_date')) {
                $table->dateTime('purchase_date')->after('user_id');
            }
        });
    }

    // Revierte las migraciones.
    public function down(): void
    {
        // Modifica la tabla 'tickets'.
        Schema::table('tickets', function (Blueprint $table) {
            // Elimina la columna 'purchase_date' si existe.
            if (Schema::hasColumn('tickets', 'purchase_date')) {
                $table->dropColumn('purchase_date');
            }
        });
    }
};