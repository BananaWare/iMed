<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
  
  public function selectHospital()
  {
    Session::put('idHospitalSelected', Input::get("idHospital"));
    $roles = Auth::user()->roles->filter(function($role)
      {
          return $role->idHospital== Input::get("idHospital");
      });
    $r = "patient";
    foreach($roles as $role)
    {
      if ($role->role == "doctor")
        return $role->role;
      else if ($role->role == "secretary")
        $r = $role->role;
    }
    return $r;
  }
  /*
  public function getHospitals()
  {
     return Auth::user()->hospitals->toJson();
  }
  */
}