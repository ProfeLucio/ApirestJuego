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
        Schema::create('partidas', function (Blueprint $table) {
            $table->id();
            $table->uuid('juego_id');
            $table->foreign('juego_id')->references('id')->on('juegos')->onDelete('cascade');
            $table->timestamp('fecha');        // Fecha y hora de la partida
            $table->integer('tiempo')->nullable(); // Tiempo en segundos (opcional)
            $table->string('nivel')->nullable();   // Nivel jugado (opcional)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('partidas');
    }
};
