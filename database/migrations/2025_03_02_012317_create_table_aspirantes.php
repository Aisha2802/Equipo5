<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aspirantes', function (Blueprint $table) {
            $table->id('aspirante_id');
            $table->string('nombre');
            $table->string('numero_control')->unique(); // Número de control único
            $table->enum('estado', ['egresado', 'estudiante']); // Estado del aspirante
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relación con User

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aspirantes');
    }
};
