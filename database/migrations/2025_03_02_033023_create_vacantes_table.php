<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vacantes', function (Blueprint $table) {
            $table->id('vacante_id');
            $table->foreignId('empresa_id')->constrained('empresas', 'empresa_id')->onDelete('cascade');
            $table->string('titulo');
            $table->text('descripcion');
            $table->string('ubicacion');
            $table->string('tipo'); // Residencia o empleo
            $table->enum('estado', ['abierta','pendiente' ,'cerrada'])->default('pendiente');
            $table->integer('max')->nullable();
            $table->double('pago')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vacantes');
    }
};