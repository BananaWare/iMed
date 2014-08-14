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
  protected $appends = array('rutFormated', 'fullName', 'age', 'isSecretary', 'isDoctor', 'isPatient', 'birthdateFormatted', 'fullNameRut');
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
  
  public function setNameAttribute($value)
  {
    $this->attributes['name'] = ucwords(strtolower($value));
  }
  
  public function setLastnameAttribute($value)
  {
    $this->attributes['lastname'] = ucwords(strtolower($value));
  }
  
	public function getBirthdateFormattedAttribute()
	{
    try{
      list($year, $month, $day) = preg_split('/-/', $this->birthdate);
      return $day . "/" . $month . "/" . $year;
    }
    catch(Exception $e)
      {
      return $this->birthdate;
    }
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
  
  //Doctor's function
  public function getCustomScheduleFromHospitalToMonth($idHospital, $month, $year)
  {
    return $this->hasMany('CustomSchedule', 'doctorsRut', 'rut')->where('idHospital', '=', $idHospital)
      ->where(DB::raw('YEAR(day)'), '=', $year)->where(DB::raw('MONTH(day)'), '=', $month);;
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
  
  // Atributo solamente necesario para buscar en el magicSuggest por nombre y rut debido a que el plugin no acepta otra forma.
  public function getFullNameRutAttribute()
  {
    $nameWithoutAccents = preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|uml|caron);~i', '$1', htmlentities($this->fullName, ENT_COMPAT, 'UTF-8'));
    $nameWithoutAccents = preg_replace('/&ntilde;/', 'ñ', $nameWithoutAccents);
    $nameWithoutAccents = preg_replace('/&Ntilde;/', 'Ñ', $nameWithoutAccents);
    return $nameWithoutAccents . ' ' . $this->rut . '-' . $this->dv . ' ' . $this->rutFormated;
  }
  
  public function getAgeAttribute()
  {
    try
    {
    $from = new DateTime($this->birthdate);
    $to = new DateTime('today');
    return $from->diff($to)->y;
    }
    catch(Exception $e)
    {
      return 0;
    }
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
  
  //Doctor's function
  public function getBillingsFromHospital($idHospital)
  {
    return Billing::where('payersRut', '=', $this->rut)->where('idHospital', '=', $idHospital);
  }
}