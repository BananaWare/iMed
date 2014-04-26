<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
  protected $primaryKey = 'rut';
  protected $appends = array('rutFormated', 'fullName', 'age');
  public $incrementing = false;
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');
    
	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}
  
  //Secretary function
  public function getDoctorsFromHospital($idHospital)
  {
    return $this->belongsToMany('User', 'secretaries_doctors', 'secretarysRut', 'doctorsRut')
      ->where('idHospital', '=', $idHospital);    
  }
  
  //Doctor function
  public function getSecretariesFromHospital($idHospital)
  {
    return $this->belongsToMany('User', 'secretaries_doctors', 'doctorsRut', 'secretarysRut')
      ->where('idHospital', '=', $idHospital)
      ->withPivot(array('active', 'idSecretaryDoctor'));
  }
  
  //Doctor function
  public function getDoctorsScheduleFromHospital($idHospital)
  {
    return $this->hasMany('DoctorSchedule', 'doctorsRut', 'rut')->where('idHospital', '=', $idHospital);
  }
  
  /*
   * Doctor's function. Allows you to get patient's hours from an hospital in a month of a year.
   * If the month or year is null it assume current.
   * @param (idHospital) Database id from hospital to get information.
   * @param (month) Month to rescue patient's hours. If null assume current month.
   * @param (year) Year to rescue patient's hours. If null assume current year.
  */
  public function getPatientsHoursFromHospitalToMonth($idHospital, $month = null, $year = null)
  {
    $month = isset($month) ? $month : date("m");
    $year = isset($year) ? $year : date("Y");
    return $this->hasMany('PatientHour', 'doctorsRut', 'rut')->where('idHospital', '=', $idHospital)
      ->where(DB::raw('YEAR(dateTimeAssign)'), '=', $year)->where(DB::raw('MONTH(dateTimeAssign)'), '=', $month);
  }
  
  public function getPhoto()
  {
     return $this->hasOne('usersPhoto');
  }
  
  public function hospitals()
  {
     return $this->belongsToMany('Hospital', 'users_info', 'rut', 'idHospital');
  }
  
  //Obtiene los doctores de todos los hospitales para los que trabaja una secretaria
  public function doctors()
  {
    return $this->belongsToMany('User', 'secretaries_doctors', 'secretarysRut', 'doctorsRut')
      ->withPivot(array('idHospital'));
  }
  
  public function getUserInfoFromHospital($idHospital)
  {
    return $this->belongsToMany('Hospital', 'users_info', 'rut', 'idHospital')
      ->where('idHospital', '=', $idHospital);
  }
  
  public function getRutFormatedAttribute()
  {
    return number_format($this->rut, 0, ',', '.') . '-' . $this->dv;
  }
  
  public function getFullNameAttribute()
  {
    if ($this->name != null && $this->lastname != null)
      $fullName = $this->name . ' ' . $this->lastname;
    else
      $fullName = "(Sin nombre)";
    return $fullName;
  }
  
  public function getAgeAttribute()
  {
    $from = new DateTime($this->birthdate);
    $to = new DateTime('today');
    return $from->diff($to)->y;;
  }
}