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
  protected $appends = array('rutFormated', 'fullName', 'age', 'isSecretary', 'isDoctor', 'isPatient');
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
  
  //Secretary's function
  public function getDoctorsFromHospital($idHospital)
  {
    return $this->belongsToMany('User', 'secretaries_doctors', 'secretarysRut', 'doctorsRut')
      ->where('idHospital', '=', $idHospital);    
  }
  
  //Doctor's function
  public function getSecretariesFromHospital($idHospital)
  {
    return $this->belongsToMany('User', 'secretaries_doctors', 'doctorsRut', 'secretarysRut')
      ->where('idHospital', '=', $idHospital)
      ->withPivot(array('active', 'idSecretaryDoctor'));
  }
  
  //Doctor's function
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
  public function getPatientsHoursFromHospitalToMonth($idHospital, $month, $year)
  {

    return $this->hasMany('PatientHour', 'doctorsRut', 'rut')->where('idHospital', '=', $idHospital)
      ->where(DB::raw('YEAR(dateTimeAssign)'), '=', $year)->where(DB::raw('MONTH(dateTimeAssign)'), '=', $month);
  }
  
  // Patient's function
  public function getPatientsHoursFromHospitalToDoctor($idHospital, $doctorsRut)
  {
    return $this->hasMany('PatientHour', 'patientsRut', 'rut')->where('idHospital', '=', $idHospital)
      ->where('doctorsRut', '=', $doctorsRut);
  }
  
  public function getPhoto()
  {
     return $this->hasOne('usersPhoto');
  }
  
  public function patientHours()
  {
     return $this->hasMany('PatientHour', 'patientsRut');
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
    return $this->hasMany('UserInfo', 'rut', 'rut')
      ->where('idHospital', '=', $idHospital)->first();
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
    return $from->diff($to)->y;
  }
  
  public function getIsSecretaryAttribute()
  {
    foreach($this->roles as $rol)
    {
      if ($rol->role == "secretary")
        return true;
    }
    return false;
  }
  
  public function getIsDoctorAttribute()
  {
    foreach($this->roles as $rol)
    {
      if ($rol->role == "doctor")
        return true;
    }
    return false;
  }
  
  public function getIsPatientAttribute()
  {
    foreach($this->roles as $rol)
    {
      if ($rol->role == "doctor" || $rol->role == "secretary")
        return true;
    }
    return false;
  }
  
  public function isDoctorOn($idHospital)
  {
    foreach($this->roles as $rol)
    {
      if ($rol->idHospital == $idHospital && $rol->role == "doctor")
        return true;
    }
    return false;
  }
  
  public function isSecretaryOn($idHospital)
  {
    foreach($this->roles as $rol)
    {
      if ($rol->idHospital == $idHospital && $rol->role == "secretary")
        return true;
    }
    return false;
  }
  
  public function isPatientOn($idHospital)
  {
    foreach($this->roles as $rol)
    {
      if ($rol->idHospital == $idHospital && $rol->role == "patient")
        return true;
    }
    return false;
  }
  
  public function roles()
  {
    return $this->hasMany('UserRole', 'rut');  
  }
  
  //Patient's function
  public function getPatientHoursFromHospitalToDoctor($idHospital, $doctorsRut)
  {
    return $this->patientHours->filter(function($patientHour) use($idHospital, $doctorsRut){
      if ($patientHour->idHospital == $idHospital && $patientHour->doctorsRut == $doctorsRut) {
        return true;
      }
    });
  }
}