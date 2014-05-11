<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Hospital extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'hospitals';
  protected $primaryKey = 'idHospital';
  /*
  public function doctor()
  {
    return $this->belongsTo('User', 'doctorsRut', 'rut');
  }
  
  public function assinger()
  {
    return $this->belongsTo('User', 'assignersRut', 'rut');
  }
  */
  public function patientsInfo()
  {
    return $this->belongsToMany('UserInfo', 'users_roles', 'idHospital', 'rut')->where('users_roles.role', '=', 'patient')
      ->where('users_info.idHospital', '=', $this->idHospital);
  }
}