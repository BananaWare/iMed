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
//Pagina solo para testeo.
Route::get('/test', [function() { return View::make('test'); } ]);

//Pagina principal donde está el formulario de identificación
Route::get('/', ['uses' => 'HomeController@index']);

Route::get('/signin', ['uses' => 'AuthController@showLogin', 'before' => 'guest']);

Route::post('/signin', ['uses' => 'AuthController@doLogin', 'before' => 'guest']);

Route::get('/logout', ['uses' => 'AuthController@doLogOut', 'before' => 'auth']);

Route::get('/secretary', ['uses' => 'SecretaryController@index', 'before' => 'auth']);

Route::get('/secretary/assignhour', ['uses' => 'SecretaryController@showAssignHour', 'before' => 'secretary']);

Route::post('/secretary/assignhour', ['uses' => 'SecretaryController@doAssignHour', 'before' => 'secretary']);

Route::get('/createPatient', ['uses' => 'SecretaryController@createPatient', 'before' => 'secretary']);

Route::get('/createSecretary', ['uses' => 'DoctorController@createDoctor', 'before' => 'doctor']);
