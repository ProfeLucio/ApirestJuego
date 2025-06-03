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
        Schema::create('juegos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('titulo');          // Nombre legible del juego
            $table->text('autores');           // Lista de autores (JSON o texto)
            $table->boolean('activo')->default(true); // Soft delete lógico
            $table->timestamps();              // created_at / updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('juegos');
    }
};
