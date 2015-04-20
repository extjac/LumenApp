<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

$app->get('/', function() use ($app) {
    return 'api test';
});

/* Auth */
$app->post('/auth/login', 	'App\Http\Controllers\AuthController@logIn') ;
$app->post('/auth/logout', 	'App\Http\Controllers\AuthController@logOut') ;
$app->post('/auth/register', 'App\Http\Controllers\AuthController@register') ;
$app->get('/auth/{token}/activation', 'App\Http\Controllers\AuthController@activation') ;

$app->get('/user', 			'App\Http\Controllers\UserController@index') ;
$app->get('/user/{id}', 	'App\Http\Controllers\UserController@show') ;
$app->post('/user/create', 	'App\Http\Controllers\UserController@store') ;
$app->put('/user/{id}',		'App\Http\Controllers\UserController@update') ;
$app->delete('/user/{id}',	'App\Http\Controllers\UserController@destroy') ;

