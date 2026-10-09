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
            'peliculas' => collect(),
            'genero' => '',
        ]);
    }

    public function buscarPorGenero(Request $request)
    {
        $genero = $request->input('genero');
        $this->pelicula = new Pelicula();

        $peliculas = Pelicula::where('genero', 'like', '%' . $genero . '%')
            ->with([
                'actores:id,pelicula_id,nombre',
                'actores.personajes:id,actor_id,nombre,descripcion',
            ])
            ->get();

        return response()->json($peliculas);
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


























//     public function store(Request $request)
//     {
//         $pelicula = new Pelicula();
//         $pelicula->titulo = $request->input('titulo');
//         $pelicula->director = $request->input('director');
//         $pelicula->genero = $request->input('genero');
//         $pelicula->anio = $request->input('anio');
//         $pelicula->usuario_id = $request->input('usuario_id');
//         //guarda los datos
//         $pelicula->save();
//         return response()->json(['message' => 'Película creada exitosamente', 'pelicula' => $pelicula], 201);
//     }

//     public function show($id)
//     {
//         $pelicula = Pelicula::find($id);
//         if (!$pelicula) {
//             return response()->json(['message' => 'Película no encontrada'], 404);
//         }
//         return response()->json($pelicula);
//     }

//     public function update(Request $request, $id)
//     {
//         $pelicula = Pelicula::find($id);
//         if (!$pelicula) {
//             return response()->json(['message' => 'Película no encontrada'], 404);
//         }

//         //enviar datos opcioneales para actualizar
//         $pelicula->titulo = $request->input('titulo', $pelicula->titulo);
//         $pelicula->director = $request->input('director', $pelicula->director);
//         $pelicula->genero = $request->input('genero', $pelicula->genero);
//         $pelicula->anio = $request->input('anio', $pelicula->anio);
//         $pelicula->usuario_id = $request->input('usuario_id', $pelicula->usuario_id);
//         $pelicula->save();

//         return response()->json(['message' => 'Película actualizada exitosamente', 'pelicula' => $pelicula]);
//     }

//     public function destroy(Request $request, $id)
//     {
//         $pelicula = Pelicula::find($id);
//         if (!$pelicula) {
//             return response()->json(['message' => 'Película no encontrada'], 404);
//         }
//         $pelicula->delete();
//         return response()->json(['message' => 'Película eliminada exitosamente']);
//     }
}
