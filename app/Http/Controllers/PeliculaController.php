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
        return view('pelicula.pelicula', [
            'peliculas' => collect(),
            'genero' => ''
        ]);
    }

    public function buscargenero(Request $request)
    {
        $this->pelicula = new Pelicula();
        $genero = $request->input('genero');
        $peliculas = $this->pelicula->obtenerPorGenero($genero);

        $data = [
            'peliculas' => $peliculas,
            'genero' => $genero
        ];
        return view('pelicula.pelicula', $data);
    }

    public function allPeliculas()
    {
        $this->pelicula = new Pelicula();
        $peliculas = $this->pelicula->obtenerTodas();

        $data = [
            'peliculas' => $peliculas,
            'genero' => ''
        ];

        return view('pelicula.pelicula', $data);
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
