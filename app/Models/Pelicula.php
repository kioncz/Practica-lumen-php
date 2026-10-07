<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelicula extends Model
{
    protected $table = 'peliculas';

    protected $fillable = [
        'titulo',
        'director',
        'anio',
        'genero',
        'usuario_id'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    // aqui puedes agregar cualquier otra relación o
    // método que necesites para tu modelo Pelicula

    // --- NUEVO MÉTODO EN EL MODELO (CORE) ---
    // Consulta a la base de datos usando el QueryBuilder de Eloquent
    public function obtenerPorGenero($genero)
    {
        return $this->where('genero', '=', $genero)->get();
    }
    //onbtiene todas las peliculas de la base de datos
    public function obtenerTodas()
    {
        return $this->all();

    }

}
