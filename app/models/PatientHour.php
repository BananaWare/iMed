<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class PatientHour extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'patients_hours';
  protected $primaryKey = 'idHour';
  
  public function doctor()
  {
    return $this->belongsTo('User', 'doctorsRut', 'rut');
  }
  
  public function assinger()
  {
    return $this->belongsTo('User', 'assignersRut', 'rut');
  }
  
  public function patient()
  {
    return $this->belongsTo('User', 'patientsRut', 'rut');
  }
  
  public function medicalSheet()
  {
    return $this->hasOne('MedicalSheet', 'idSheet', 'idSheet'); 
  }
}