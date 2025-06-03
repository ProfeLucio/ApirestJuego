<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PartidaUser extends Pivot
{
    protected $table = 'partida_user';
    protected $fillable = ['partida_id', 'user_id', 'aciertos'];
}
