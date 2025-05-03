<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('respuestas', function (Blueprint $table) {
            $table->id('respuesta_id');
            $table->foreignId('pregunta_id')->constrained('preguntas', 'pregunta_id')->onDelete('cascade');
            $table->foreignId('aspirante_id')->nullable()->constrained('aspirantes', 'aspirante_id')->onDelete('cascade');
            $table->foreignId('empresa_id')->nullable()->constrained('empresas', 'empresa_id')->onDelete('cascade');
            $table->text('respuesta');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('respuestas');
    }
};