<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Ejecuta las migraciones.
    public function up(): void
    {
        // Crea la tabla 'jobs' para las colas de trabajo.
        Schema::create('jobs', function (Blueprint $table) {
            $table->id(); // ID de la tarea.
            $table->string('queue')->index(); // Cola a la que pertenece la tarea.
            $table->longText('payload'); // Contenido serializado de la tarea.
            $table->unsignedTinyInteger('attempts'); // Número de intentos.
            $table->unsignedInteger('reserved_at')->nullable(); // Marca de tiempo de reserva.
            $table->unsignedInteger('available_at'); // Marca de tiempo de disponibilidad.
            $table->unsignedInteger('created_at'); // Marca de tiempo de creación.
        });

        // Crea la tabla 'job_batches' para lotes de trabajos.
        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary(); // ID del lote, clave primaria.
            $table->string('name'); // Nombre del lote.
            $table->integer('total_jobs'); // Total de tareas en el lote.
            $table->integer('pending_jobs'); // Tareas pendientes en el lote.
            $table->integer('failed_jobs'); // Tareas fallidas en el lote.
            $table->longText('failed_job_ids'); // IDs de las tareas fallidas.
            $table->mediumText('options')->nullable(); // Opciones del lote.
            $table->integer('cancelled_at')->nullable(); // Marca de tiempo de cancelación.
            $table->integer('created_at'); // Marca de tiempo de creación del lote.
            $table->integer('finished_at')->nullable(); // Marca de tiempo de finalización.
        });

        // Crea la tabla 'failed_jobs' para tareas que fallaron.
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id(); // ID de la tarea fallida.
            $table->string('uuid')->unique(); // UUID único para la tarea fallida.
            $table->text('connection'); // Conexión de la cola.
            $table->text('queue'); // Cola de la tarea.
            $table->longText('payload'); // Contenido serializado de la tarea.
            $table->longText('exception'); // Excepción que causó el fallo.
            $table->timestamp('failed_at')->useCurrent(); // Fecha y hora del fallo.
        });
    }

    // Revierte las migraciones.
    public function down(): void
    {
        // Elimina la tabla 'jobs' si existe.
        Schema::dropIfExists('jobs');
        // Elimina la tabla 'job_batches' si existe.
        Schema::dropIfExists('job_batches');
        // Elimina la tabla 'failed_jobs' si existe.
        Schema::dropIfExists('failed_jobs');
    }
};