<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('solicitud_vacantes', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('vacante_id')->constrained('vacantes', 'vacante_id')->onDelete('cascade'); // Relación con vacantes
            $table->foreignId('aspirante_id')->constrained('aspirantes', 'aspirante_id')->onDelete('cascade'); // Relación con aspirantes
            $table->foreignId('periodo_id')->constrained('periodos')->onDelete('cascade'); // Relación con periodos
            $table->enum('estado', ['pendiente', 'aceptado', 'rechazado','cancelada','seguimiento'])->default('pendiente'); // Estado de la solicitud
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_vacantes');
    }
};