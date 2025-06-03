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
            $table->id();                      // Clave primaria
            $table->string('titulo');          // Nombre legible del juego
            $table->text('autores');           // Lista de autores (JSON o texto)
            $table->boolean('activo')->default(true); // Soft delete lógico
            $table->timestamps();              // created_at / updated_at
            // $table->softDeletes();          // Si prefieres borrado suave
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
