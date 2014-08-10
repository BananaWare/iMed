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
Route::get('/', ['uses' => 'HomeController@index']);

Route::get('/signin', ['uses' => 'AuthController@showLogin', 'before' => 'guest']);

Route::post('/signin', ['uses' => 'AuthController@doLogin', 'before' => 'guest']);

Route::get('/logout', ['uses' => 'AuthController@doLogOut', 'before' => 'auth']);

Route::get('/dashboard', ['uses' => function() {
  if (Session::get('idHospitalSelected') !== null)
    $idHospitalSelected = Session::get('idHospitalSelected');
  else
    $idHospitalSelected = Auth::user()->hospitals[0]->idHospital;
  
    if(Auth::user()->isDoctorOn($idHospitalSelected))
    {
      return Redirect::to('/dashboard/doctor'); 
    }
    else if(Auth::user()->isSecretaryOn($idHospitalSelected))
    {
      return Redirect::to('/dashboard/secretary'); 
    }
    else if(Auth::user()->isPatientOn($idHospitalSelected))
    {
      return Redirect::to('/dashboard/patient'); 
    }
  }]);

Route::get('/dashboard/getHospitals', ['uses' => 'BaseController@getHospitals']);

Route::get('/dashboard/secretary', ['uses' => 'SecretaryController@index', 'before' => 'secretary']);

Route::get('/dashboard/secretary/firstLogin', ['uses' => 'SecretaryController@firstLogin', 'before' => 'pre-secretary']);

Route::get('/dashboard/doctor', ['uses' => 'DoctorController@index', 'before' => 'doctor']);

Route::get('/dashboard/doctor/assignHour', ['uses' => 'DoctorController@showAssignHourFromHospitalSelected', 'before' => 'doctor|billing']);

Route::get('/dashboard/doctor/billings', ['uses' => 'DoctorController@billings', 'before' => 'doctor']);

Route::post('/dashboard/doctor/assignHour', ['uses' => 'DoctorController@doAssignHour', 'before' => 'doctor']);

Route::get('/dashboard/secretary/assignHour', ['uses' => 'SecretaryController@showAssignHourFromHospitalSelected', 'before' => 'secretary']);

Route::post('/dashboard/secretary/assignHour', ['uses' => 'SecretaryController@doAssignHour', 'before' => 'secretary']);

Route::post('/dashboard/secretary/modifySecretary', ['uses' => 'SecretaryController@doModifySecretary', 'before' => 'pre-secretary']);

Route::get('/dashboard/doctor/secretaries', ['uses' => 'DoctorController@showSecretaries', 'before' => 'doctor']);

Route::get('/dashboard/doctor/patients', ['uses' => 'DoctorController@showPatients', 'before' => 'doctor|billing']);

Route::get('/dashboard/secretary/patients', ['uses' => 'SecretaryController@showPatients', 'before' => 'secretary']);

Route::post('/dashboard/doctor/refreshHoursForCalendar', ['uses' => 'DoctorController@doRefreshHoursForCalendar', 'before' => 'doctor']);

Route::post('/dashboard/doctor/changeSchedules', ['uses' => 'DoctorController@doChangeSchedules', 'before' => 'doctor']);

Route::post('/dashboard/secretary/refreshHoursForCalendar', ['uses' =>  'SecretaryController@doRefreshHoursForCalendar', 'before' => 'secretary']);


Route::post('/dashboard/secretary/hospitalsWithPatients', ['uses' => 'SecretaryController@doGetHospitalsWithPatients', 'before' => 'secretary']);

Route::post('/dashboard/secretary/addExtraHour', ['uses' => 'SecretaryController@doAddExtraHour', 'before' => 'secretary']);

Route::post('/dashboard/doctor/addExtraHour', ['uses' => 'DoctorController@doAddExtraHour', 'before' => 'doctor']);
/*Route::get('/patients', ['uses' => function() {
    if(Auth::user()->role == 'doctor')
    {
      return Redirect::to('/dashboard/doctor/patients'); 
    }
    else if(Auth::user()->role == 'secretary')
    {
      return Redirect::to('/dashboard/secretary/patients'); 
    }
  }, 'before' => 'doctor|secretary']);
*/

/*
Route::post('/dashboard/createPatient', ['before' => 'doctor|secretary', function() {
  if (Session::get('idHospitalSelected') !== null)
    $idHospitalSelected = Session::get('idHospitalSelected');
  else
    $idHospitalSelected = Auth::user()->hospitals[0]->idHospital;
    
    if(Auth::user()->isDoctorOn($idHospitalSelected))
    {
      return Redirect::action('DoctorController@doCreatePatient'); 
    }
    else if(Auth::user()->isSecretaryOn($idHospitalSelected))
    {
      return Redirect::action('SecretaryController@doCreatePatient'); 
    }
  } ]);
*/
Route::post('/dashboard/doctor/confirmHour', ['uses' => 'DoctorController@doConfirmHour', 'before' => 'doctor']);

Route::post('/dashboard/secretary/confirmHour', ['uses' => 'SecretaryController@doConfirmHour', 'before' => 'secretary']);

Route::post('/dashboard/doctor/revokeHour', ['uses' => 'DoctorController@doRevokeHour', 'before' => 'doctor']);

Route::post('/dashboard/secretary/revokeHour', ['uses' => 'SecretaryController@doRevokeHour', 'before' => 'secretary']);

Route::post('/dashboard/doctor/createPatient', ['uses' => 'DoctorController@doCreatePatient', 'before' => 'doctor']);

Route::post('/dashboard/secretary/createPatient', ['uses' => 'SecretaryController@doCreatePatient', 'before' => 'secretary']);

Route::post('/dashboard/doctor/modifyPatient', ['uses' => 'DoctorController@doModifyPatient', 'before' => 'doctor']);

Route::post('/dashboard/secretary/modifyPatient', ['uses' => 'SecretaryController@doModifyPatient', 'before' => 'secretary']);

Route::post('/dashboard/doctor/assignSecretary', ['uses' => 'DoctorController@doAssignSecretary', 'before' => 'doctor']);

Route::post('/dashboard/doctor/lockSecretary', ['uses' => 'DoctorController@doLockSecretary', 'before' => 'doctor']);

Route::post('/dashboard/doctor/unlockSecretary', ['uses' => 'DoctorController@doUnlockSecretary', 'before' => 'doctor']);

Route::post('/dashboard/doctor/unassignSecretary', ['uses' => 'DoctorController@doUnassignSecretary', 'before' => 'doctor']);

Route::get('/dashboard/doctor/prescriptions', ['uses' => 'DoctorController@showPrescriptions', 'before' => 'doctor|billing']);

Route::get('/dashboard/doctor/schedules', ['uses' => 'DoctorController@schedules', 'before' => 'doctor']);

Route::get('/dashboard/doctor/noSuscription', ['uses' => 'DoctorController@noSuscription', 'before' => 'doctor|no-billing']);
Route::get('/dashboard/secretary/noSuscription', ['uses' => 'SecretaryController@noSuscription', 'before' => 'secretary|no-billing']);

Route::post('/dashboard/doctor/savePrescriptionAndMedicalSheet', ['uses' => 'DoctorController@doSavePrescriptionAndMedicalSheet', 'before' => 'doctor']);

Route::post('/dashboard/selectHospital', ['uses' => 'BaseController@selectHospital', 'before' => 'auth']);