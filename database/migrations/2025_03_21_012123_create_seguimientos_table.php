<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('seguimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aspirante_id')->constrained('aspirantes', 'aspirante_id')->onDelete('cascade'); // Clave foránea a la tabla aspirantes
            $table->foreignId('documento_id')->constrained('documentos')->onDelete('cascade'); // Clave foránea a la tabla documentos
            $table->foreignId('tipo_id')->constrained('tipos')->onDelete('cascade'); // Clave foránea a la tabla tipos
            $table->enum('estado', ['pendiente', 'aceptado', 'rechazado'])->default('pendiente'); // Campo estado con valores permitidos
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seguimientos');
    }
};
