<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    //
    //sirve para obtener todos los usuarios de la base de datos y devolverlos en formato JSON
    //index ex como metodo de controlador que se utiliza para obtener una lista de recursos,
    //  en este caso, todos los usuarios de la base de datos.
    public function index()
    {
        $usuarios = Usuario::all();
        return response()->json($usuarios);
        //formato json es un formato de intercambio de datos ligero
        // y fácil de leer y escribir, que se utiliza para enviar y
        // recibir datos entre un cliente y un servidor en aplicaciones web.
    }
}
