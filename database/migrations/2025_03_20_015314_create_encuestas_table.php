<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('encuestas', function (Blueprint $table) {
            $table->id('encuesta_id');
            $table->string('titulo');
            $table->text('descripcion');
            $table->enum('tipo', ['estudiante', 'empresa','egresado']); // Tipo de encuesta: estudiante, empresa o egresado
            $table->boolean('habilitada')->default(true); // Por defecto, la encuesta está habilitada
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('encuestas');
    }
};