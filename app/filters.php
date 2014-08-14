<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});
/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
  if (Auth::guest()) return Redirect::guest('/signin')->with('msg', 'Debes iniciar sesión primero');;
});

Route::filter('secretary', function()
{
  if (Auth::guest() || !Auth::user()->isSecretaryOn(Session::get('idHospitalSelected')) )
    return Redirect::guest('/signin')->with('msg', 'No tienes permiso para estar aquí');
  else if (Auth::user()->isSecretaryOn(Session::get('idHospitalSelected')) && 
      Auth::user()->name == NULL )
    return Redirect::guest('/dashboard/secretary/firstLogin')->with('msg', 'No tienes permiso para estar aquí');
  
});

Route::filter('pre-secretary', function()
{
  if (Auth::guest() || !Auth::user()->isSecretaryOn(Session::get('idHospitalSelected')) 
      || (isset(Auth::user()->name) && Auth::user()->name != ""))
    return Redirect::guest('/dashboard')->with('msg', 'No tienes permiso para estar aquí');
});

Route::filter('doctor', function()
{
  if (Auth::guest() || !Auth::user()->isDoctorOn(Session::get('idHospitalSelected'))) return Redirect::guest('/signin')->with('msg', 'No tienes permiso para estar aquí');;
});

Route::filter('billing', function()
{
   $billings = Auth::user()->getBillingsFromHospital(Session::get('idHospitalSelected'))
      ->orderBy('startDateTime', 'desc') ->get();
    $activeBillings = $billings->filter(function($b){
      if ($b->status == "active")
        return true;
    });
    if ($activeBillings->count()==0){
      if(Auth::user()->isDoctorOn(Session::get('idHospitalSelected')))
        return Redirect::guest('/dashboard/doctor/noSuscription')->with('msg', 'No tienes permiso para estar aquí');
      else if (Auth::user()->isSecretaryOn(Session::get('idHospitalSelected')))
        return Redirect::guest('/dashboard/secretary/noSuscription')->with('msg', 'No tienes permiso para estar aquí');
      else 
        return Redirect::guest('/dashboard')->with('msg', 'No tienes permiso para estar aquí');
    }
});

Route::filter('no-billing', function(){
  $billings = Auth::user()->getBillingsFromHospital(Session::get('idHospitalSelected'))
    ->orderBy('startDateTime', 'desc') ->get();
  $activeBillings = $billings->filter(function($b){
    if ($b->status == "active")
      return true;
  });
  if ($activeBillings->count()>=1){
    if(Auth::user()->isDoctorOn(Session::get('idHospitalSelected')))
      return Redirect::guest('/dashboard/doctor/');
    else if (Auth::user()->isSecretaryOn(Session::get('idHospitalSelected')))
      return Redirect::guest('/dashboard/secretary/');
    else 
      return Redirect::guest('/dashboard');
  }
});

Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});