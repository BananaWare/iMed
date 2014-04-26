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

Route::get('/dashboard', ['uses' => function() {
    if(Auth::user()->role == 'doctor')
    {
      return Redirect::to('/doctor'); 
    }
    else if(Auth::user()->role == 'secretary')
    {
      return Redirect::to('/secretary'); 
    }
    else if(Auth::user()->role == 'patient')
    {
      return Redirect::to('/patient'); 
    }
  }, 'before' => 'auth']);

Route::get('/secretary', ['uses' => 'SecretaryController@index', 'before' => 'secretary']);

Route::get('/doctor', ['uses' => 'DoctorController@index', 'before' => 'doctor']);

Route::get('/secretary/assignhour', ['uses' => 'SecretaryController@showAssignHour', 'before' => 'secretary']);

Route::post('/secretary/assignhour', ['uses' => 'SecretaryController@doAssignHour', 'before' => 'secretary']);

Route::get('/doctor/secretaries', ['uses' => 'DoctorController@showSecretaries', 'before' => 'doctor']);

Route::get('/doctor/patients', ['uses' => 'DoctorController@showPatients', 'before' => 'doctor']);

Route::get('/patients', ['uses' => function() {
    if(Auth::user()->role == 'doctor')
    {
      return Redirect::to('/doctor/patients'); 
    }
    else if(Auth::user()->role == 'secretary')
    {
      return Redirect::to('/secretary/patients'); 
    }
  }, 'before' => 'auth']);

Route::post('/doctor/createPatient', ['uses' => 'DoctorController@doCreatePatient', 'before' => 'doctor']);

Route::post('/secretary/createPatient', ['uses' => 'SecretaryController@doCreatePatient', 'before' => 'secretary']);

Route::post('/doctor/modifyPatient', ['uses' => 'DoctorController@doModifyPatient', 'before' => 'doctor']);

Route::post('/secretary/modifyPatient', ['uses' => 'SecretaryController@doModifyPatient', 'before' => 'secretary']);

Route::post('/assignSecretary', ['uses' => 'DoctorController@doAssignSecretary', 'before' => 'doctor']);

Route::post('/lockSecretary', ['uses' => 'DoctorController@doLockSecretary', 'before' => 'doctor']);

Route::post('/unlockSecretary', ['uses' => 'DoctorController@doUnlockSecretary', 'before' => 'doctor']);

Route::post('/unassignSecretary', ['uses' => 'DoctorController@doUnassignSecretary', 'before' => 'doctor']);