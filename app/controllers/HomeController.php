<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
  protected $layout = 'layouts.default';
	public function index()
	{
    if (Auth::user() !== null)
      JavaScript::put([
        'hospitals' => Auth::user()->hospitals
      ]);
    
    /*
    if (Session::get('idHospitalSelected') == null)
    {
      Session::set('idHospitalSelected', Auth::user()->hospitals[0])->idHospital;
    }
    */
    
    
    
    $this->layout->content = View::make('home.index');
	}
}