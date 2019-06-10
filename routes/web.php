<?php

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
  $router->get('authors',  ['uses' => 'AuthorController@showAllAuthors']);
  $router->get('authors/{id}', ['uses' => 'AuthorController@showOneAuthor']);
  $router->post('authors', ['uses' => 'AuthorController@create']);
  $router->delete('authors/{id}', ['uses' => 'AuthorController@delete']);
  $router->put('authors/{id}', ['uses' => 'AuthorController@update']);
});

$router->post('login', 'LoginController@login');
$router->post('register', 'RegisterController@register');

$router->get('/', 'UsuariosController@index');

// aplicamos el middleware auth
$router->group(['middleware' => 'auth'], function() use ($router){
  
  // aqui van todas las rutas que se necesitar estar autenticado para el acceso
  $router->post('logout', 'LoginController@logout');

});
