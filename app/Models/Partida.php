<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Juego;
use App\Models\User;

class Partida extends Model
{
     use HasFactory;

    protected $fillable = ['juego_id', 'fecha', 'tiempo', 'nivel'];

    // Relaciones
    public function juego()
    {
        return $this->belongsTo(Juego::class);
    }

    public function jugadores()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('aciertos')
                    ->withTimestamps();
    }
}
