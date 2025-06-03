<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Juego extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'juegos';
    protected $fillable = ['titulo', 'autores', 'activo'];

    protected static function booted()
    {
        static::creating(function ($juego) {
            if (empty($juego->{$juego->getKeyName()})) {
                $juego->{$juego->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    // Relaciones
    public function partidas()
    {
        return $this->hasMany(Partida::class);
    }
}
