<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vacante_perfil', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vacante_id');
            $table->unsignedBigInteger('perfil_id');
            $table->timestamps();

            // Claves foráneas
            $table->foreign('vacante_id')->references('vacante_id')->on('vacantes')->onDelete('cascade');
            $table->foreign('perfil_id')->references('perfil_id')->on('perfiles')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vacante_perfil');
    }
};