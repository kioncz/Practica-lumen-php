<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = 'expenses';

    protected $fillable = [
        'monto',
        'fecha',
        'usuario_id',
        'pelicula_id',
    ];

    public function user()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function movie()
    {
        return $this->belongsTo(Pelicula::class, 'pelicula_id');
    }
}
