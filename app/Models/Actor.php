<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    protected $table = 'actores';

    protected $fillable = [
        'nombre',
        'pelicula_id',
    ];

    public function pelicula()
    {
        return $this->belongsTo(Pelicula::class, 'pelicula_id');
    }

    public function personajes()
    {
        return $this->hasMany(Personaje::class, 'actor_id');
    }
}
