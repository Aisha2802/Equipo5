<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perfiles', function (Blueprint $table) {
            $table->id('perfil_id');
            $table->foreignId('carrera_id')->constrained('carreras', 'carrera_id')->onDelete('cascade');
            $table->foreignId('especialidad_id')->nullable()->constrained('especialidades', 'especialidad_id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perfiles');
    }
};