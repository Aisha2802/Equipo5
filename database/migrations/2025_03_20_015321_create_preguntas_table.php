<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('preguntas', function (Blueprint $table) {
            $table->id('pregunta_id');
            $table->foreignId('encuesta_id')->constrained('encuestas', 'encuesta_id')->onDelete('cascade');
            $table->text('texto');
            $table->enum('tipo', ['rango', 'opcion_multiple', 'texto']);
            $table->json('opciones')->nullable(); // Para almacenar opciones o rangos
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('preguntas');
    }
};