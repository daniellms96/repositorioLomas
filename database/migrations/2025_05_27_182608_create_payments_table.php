<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Ejecuta las migraciones.
    public function up(): void
    {
        // Crea la tabla para los pagos.
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // ID único para cada pago.
            // Clave foránea que relaciona el pago con un usuario.
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict'); 
            
            $table->string('transaction_id')->unique()->nullable(); // ID de la transacción.
            $table->decimal('amount', 10, 2); // Monto del pago.
            $table->string('currency', 3); // Moneda del pago.
            $table->string('status'); // Estado del pago.
            $table->string('payment_method')->nullable(); // Método de pago.
            $table->text('notes')->nullable(); // Notas adicionales.
            $table->timestamps(); // Timestamps de creación y actualización.
        });
    }

    // Revierte las migraciones.
    public function down(): void
    {
        // Elimina la tabla 'payments' si existe.
        Schema::dropIfExists('payments');
    }
};