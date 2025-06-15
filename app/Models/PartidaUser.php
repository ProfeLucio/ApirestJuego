<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PartidaUser extends Pivot
{
    protected $table = 'partida_user';
    protected $fillable = ['partida_id', 'user_id', 'aciertos', 'tiempo'];
    public function user() { return $this->belongsTo(User::class); }
    public function partida() { return $this->belongsTo(Partida::class); }
}
