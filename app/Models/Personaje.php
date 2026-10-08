<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personaje extends Model
{
    protected $table = 'personajes';

    protected $fillable = [
        'nombre',
        'descripcion',
        'actor_id',
    ];

    public function actor()
    {
        return $this->belongsTo(Actor::class, 'actor_id');
    }
}
