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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('todos', 'TodoController@index');
    $router->get('todos/{id}', ['as' => 'todos.show', 'uses' => 'TodoController@show']);
    $router->post('todos', 'TodoController@store');
    $router->put('todos/{id}', ['as' => 'todos.update', 'uses' => 'TodoController@update']);
    $router->delete('todos/{id}', ['as' => 'todos.destroy', 'uses' => 'TodoController@destroy']);
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('users', 'UserController@index');
    $router->get('users/{id}', ['as' => 'users.show', 'uses' => 'UserController@show']);
    $router->post('users', 'UserController@store');
    $router->put('users/{id}', ['as' => 'users.update', 'uses' => 'UserController@update']);
    $router->delete('users/{id}', ['as' => 'users.destroy', 'uses' => 'UserController@destroy']);
    $router->get('users/{id}/todos', ['uses' => 'UserController@getUserWithTodos']);

});



$router->get('/test-middleware', function () {
    return response()->json(['id' => 1, 'title' => 'Test']);
});

