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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('juego_id')
                  ->after('id')               // Colocar tras el id
                  ->constrained('juegos')     // Llave foránea a juegos.id
                  ->onDelete('cascade');      // Borra usuarios si se borra el juego
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('juego_id');
        });
    }
};
