<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class MedicalSheet extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'medical_sheets';
  protected $primaryKey = 'idSheet';
  
  public function prescription()
  {
    return $this->hasOne('Prescription', 'idPrescription');
  }
  
  public function patientHour()
  {
    return $this->belongsTo('PatientHour', 'idHour', 'idHour'); 
  }
}