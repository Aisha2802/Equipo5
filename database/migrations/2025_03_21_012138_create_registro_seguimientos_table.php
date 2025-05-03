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
        Schema::create('registro_seguimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aspirante_id')->constrained('aspirantes', 'aspirante_id')->onDelete('cascade'); // Clave foránea a la tabla aspirantes
            $table->foreignId('vacante_id')->constrained('vacantes', 'vacante_id')->onDelete('cascade'); // Clave foránea a la tabla vacantes
            $table->foreignId('periodo_id')->constrained('periodos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_seguimientos');
    }
};
