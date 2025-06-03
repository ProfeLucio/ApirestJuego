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
        Schema::create('partida_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partida_id')
                  ->constrained('partidas')
                  ->onDelete('cascade');
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->integer('aciertos');       // Aciertos por jugador (obligatorio)
            // $table->integer('errores')->default(0); // Opcional: contar fallos
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('partida_user');
    }
};
