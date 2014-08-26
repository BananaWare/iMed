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
  protected $appends = array('nameDayOfWeek');
  
  // Necessary functions to make it compatible with SQL Server
  public function getStartHourAttribute($value)
  {
    if($value == null || $value == "" || !strpos($value, "."))
      return $value;
    list($hour, $nano) = preg_split("/\.[0-9]*/", $value);
    return (new DateTime('1990/01/01 ' . $hour))->format('H:i:s');
  }
  public function getEndHourAttribute($value)
  {
    if($value == null || $value == "" || !strpos($value, "."))
      return $value;
    list($hour, $nano) = preg_split("/\.[0-9]*/", $value);
    return (new DateTime('1990/01/01 ' . $hour))->format('H:i:s');
  }
  public function getIntervalTimeAttribute($value)
  {
    if($value == null || $value == "" || !strpos($value, ":"))
      return $value;
    return (new DateTime('1990/01/01 ' . $value))->format('H:i');
    //return round(abs(strtotime('1990-01-01 ' . $value) - strtotime('1990-01-01 00:00:00'))/60);
  }
  
  public function doctor()
  {
    return $this->belongsTo('User', 'doctorsRut', 'rut');
  }
  
  public function hospital()
  {
    return $this->belongsTo('Hospital', 'idHospital', 'idHospital');
  }
  
  public function getNameDayOfWeekAttribute()
  {
    $names = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
    return $names[$this->dayOfWeek - 1];
  }
  
  public function getConfirmedAttribute($value)
  {
    return intval($value);
  }
}