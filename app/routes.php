<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
//Pagina principal donde está el formulario de identificación
Route::get('/', ['uses' => 'HomeController@index', 'before' => 'guest']);

Route::get('/signin', ['uses' => 'AuthController@showLogin', 'before' => 'guest']);

Route::post('/signin', ['uses' => 'AuthController@doLogin', 'before' => 'guest']);

Route::get('/logout', ['uses' => 'AuthController@doLogOut', 'before' => 'auth']);
