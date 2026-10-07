<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
//ruta para origen cruzado, para permitir que la aplicacion web en el
//  navegador pueda hacer solicitudes a la API desde un dominio diferente.
// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });

$router->get('/login', ['uses' => 'UsuarioController@index']);
$router->post('/auth/login', ['uses' => 'AuthController@authenticate']);

$router->group(['middleware' => 'jwt'], function () use ($router) {
    $router->get('/usuarios', ['uses' => 'UsuarioController@index']);

    $router->get('/peliculas', ['uses' => 'PeliculaController@index']);
    $router->post('/peliculas', ['uses' => 'PeliculaController@store']);
    $router->get('/peliculas/buscargenero', [
        'uses' => 'PeliculaController@buscargenero'
    ]);
    $router->get('/peliculas/todas', [
        'uses' => 'PeliculaController@allPeliculas'
    ]);
    $router->put('/peliculas/{id}', ['uses' => 'PeliculaController@update']);
    $router->delete('/peliculas/{id}', ['uses' => 'PeliculaController@destroy']);

    $router->get('/expenses', ['uses' => 'ExpenseController@index']);
    $router->post('/expenses', ['uses' => 'ExpenseController@store']);
    $router->get('/expenses/{id}', ['uses' => 'ExpenseController@show']);
    $router->put('/expenses/{id}', ['uses' => 'ExpenseController@update']);
    $router->delete('/expenses/{id}', ['uses' => 'ExpenseController@destroy']);

});

    //cuando no existe la ruta, se devuelve un error 404
$router->get('/{any:.*}', function () {
    return response()->json(['message' => 'Ruta no encontrada'], 404);
});

//notas: con resepecto a los jwt se deben hacer algunos cambios con respecyo a una forma de auth
//por lo que aqui debes tener cuidado
