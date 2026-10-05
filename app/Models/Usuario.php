<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'email',
        'password'
    ];

    protected $hidden = [
        'password'
    ];

    public function peliculas()
    {
        return $this->hasMany(Pelicula::class, 'usuario_id');
    }
}
