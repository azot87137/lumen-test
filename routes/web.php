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
    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->post('/sign-in', 'AuthController@signIn');
        $router->post('/register', 'AuthController@register');
        $router->post('/recover-password', 'AuthController@recoverPasswordRequest');
        $router->patch('/recover-password', 'AuthController@recoverPassword');

        $router->get('/companies', 'CompanyController@index');
        $router->post('/companies', 'CompanyController@create');

        $router->get('/me', 'UserController@profile');
    });
});
