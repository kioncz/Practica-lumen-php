<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use App\Models\Usuario;


class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Pre-Middleware Action
        // acciones antes de que la solicitud llegue al controlador
        $authorization = $request->header('Authorization');

        if ($authorization) {
            $array = explode(' ', $authorization);
            $token = $array[1] ?? null;
        } elseif ($request->hasCookie('token')) {
            $token = $request->cookie('token');
        } else {
            return response()->json(['error' => 'Token no proporcionado'], 401);
        }

        try {
            $credentials = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
        } catch (ExpiredException $e) {
            return response()->json(['error' => 'Token expirado'], 401);
        } catch (Exception $e) {
            return response()->json(['error' => 'Token inválido'], 401);
        }

        $usuario = Usuario::find($credentials->sub);
        $request->auth = $usuario;

        $response = $next($request);

        // Post-Middleware Action
        // acciones despues de que la solicitud llegue al controlador
        return $response;
    }
}
