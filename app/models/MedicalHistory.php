<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class MedicalHistory extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'medical_history';
  protected $primaryKey = 'idMedicalHistory';
  
  public function userInfo()
  {
    return $this->hasMany('UserInfo', 'Rut')->where('idHospital', '=', $this->idHospital);
  }
}