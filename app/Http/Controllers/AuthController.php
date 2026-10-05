<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
//sirve para manejar la autenticacion de usuarios y generar tokens JWT
// para la autenticacion de usuarios en una aplicacion web.
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\Usuario;

class AuthController extends Controller
{
    private $jwt_secret;
    //
    public function __construct(Request $jwt_secret)
    {
        $this-> request = $jwt_secret;
        $this->jwt_secret = env('JWT_SECRET');
    }

    public function jwt($usuario)
    {
        $payload = [
            'iss' => "lumen-jwt", // Emisor del token
            'sub' => $usuario->id, // ID del usuario
            'iat' => time(), // Tiempo de emisión
            'exp' => time() + 60*60 // Tiempo de expiración (1 hora)
        ];

        return JWT::encode($payload, $this->jwt_secret, 'HS256');
    }

    //variable $request, que es una instancia de la clase Request de Lumen,
    // que se utiliza para manejar las solicitudes HTTP entrantes.
    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        //basicamente lo que hace es buscar un usuario en la base de datos con el
        // email proporcionado en la solicitud,
        $usuario = Usuario::where('email', $request->input('email'))->first();

        //ima condicion que verifica si el usuario existe y si la contraseña proporcionada
        // coincide con la almacenada en la base de datos.
        if (!$usuario || !password_verify($request->input('password'), $usuario->password)) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }
        // Si las credenciales son válidas, se genera un token JWT para el usuario.
        if ($usuario) {
            $token = $this->jwt($usuario);
            return response()->json(['token' => $token, 'message' => 'Credenciales válidas'], 200);
        }

        // Si el usuario no se encuentra, se devuelve un mensaje de error
        // con un código de estado 404.
        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        return response()->json(['error' => 'Error desconocido'], 500);

    }
}
