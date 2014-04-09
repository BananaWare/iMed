<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class DoctorSchedule extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'doctors_schedules';
  protected $primaryKey = 'idDoctorSchedule';
  //protected $appends = array('NumberDayOfWeek');  
  
  public function doctor()
  {
    return $this->belongsTo('User', 'doctorsRut', 'rut');
  }
  
  public function hospital()
  {
    return $this->belongsTo('User', 'idHospital', 'idHospital');
  }
}