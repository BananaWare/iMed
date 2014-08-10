<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class CustomSchedule extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'custom_schedules';
  protected $primaryKey = 'idCustomSchedule';
  protected $appends = array('dayOfWeek');
  
  public function doctor()
  {
    return $this->belongsTo('User', 'doctorsRut', 'rut');
  }
  
  public function hospital()
  {
    return $this->belongsTo('Hospital', 'idHospital', 'idHospital');
  }
  
  public function getDayOfWeekAttribute()
  {
    $dow = date("w", strtotime($this->day));
    if ($dow == 0)
      $dow = 7;
    
    return $dow;
  }
  /*
  public function getDoctorScheduleAttribute()
  {
    $dow = date("w", strtotime($this->day));
    if ($dow == 0)
      $dow = 7;
    
    //$names = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
    return DoctorSchedule::where('idHospital', '=', $this->idHospital)->where('doctorsRut', '=', $this->doctorsRut)
      ->where('dayOfWeek', '=', $dow)->first();
    //return $names[$this->dayOfWeek - 1];
  }
  */
  /*
  public function getNameDayOfWeekAttribute()
  {
    $names = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
    return $names[$this->dayOfWeek - 1];
  }*/
}