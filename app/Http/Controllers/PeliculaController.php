<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelicula;

class PeliculaController extends Controller
{
    private $pelicula;
    //
    public function index()
    {
        $this->pelicula = new Pelicula();

        return view('pelicula.pelicula', [
            'peliculas' => $this->pelicula->all(),
            'generos' => $this->pelicula->newQuery()
                ->whereNotNull('genero')
                ->select('genero')
                ->distinct()
                ->orderBy('genero')
                ->pluck('genero'),
            //se usa collect() para crear una colección vacía de películas
            // 'peliculas' => collect(),
            'genero' => '',
        ]);
    }

    /**
     * Busca películas por nombre.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function peliculasPorNombre (Request $request){

        $nombre = $request->input('nombre');
        $this->pelicula = new Pelicula();

        $peliculas = Pelicula::where('titulo', 'like', '%' . $nombre . '%')
            ->with([
                'actores:id,pelicula_id,nombre',
                'actores.personajes:id,actor_id,nombre,descripcion',
            ])
            ->get();

        return response()->json($peliculas);
    }

    public function buscarPorGenero(Request $request)
    {
        $genero = $request->input('genero');
        $this->pelicula = new Pelicula();

        if ($genero === null || $genero === '') {
            return response()->json([
                'message' => 'Debe seleccionar un género.',
            ], 422);
        }

        $opciones = $this->pelicula->getListaPeliculasPorGenero($genero);

        // El frontend espera directamente la lista de películas.
        return response()->json($opciones['peliculas']);
    }
    /**
     * Define la relación entre películas y actores.
     *
     * @return array
     */
    public function relacionpeliculas()
    {
        return Pelicula::select([
            'id',
            'titulo',
            'genero',
            'anio',
        ])
            ->with([
                'actores:id,pelicula_id,nombre',
                'actores.personajes:id,actor_id,nombre,descripcion',
            ])
            ->get();
    }
    /**
     * Obtiene la información completa de una película.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPeliculaFullInfo($id)
    {
        $this->pelicula = new Pelicula();
        $pelicula = $this->pelicula->with('actores.personajes')->find($id);

        if (!$pelicula) {
            return response()->json([
                'message' => 'Película no encontrada'
            ], 404);
        }

        return response()->json($pelicula);
    }

}
