<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Prescription extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'prescriptions';
  protected $primaryKey = 'idPrescription';
  
  public function drugs()
  {
    return $this->belongsToMany('Drug', 'drugs_prescriptions', 'idPrescription', 'idDrug')
      ->withPivot(array('dosage', 'term', 'intervalTime', 'observation'));
  }
  
  public function medicalSheet()
  {
    
    return $this->belongsTo('MedicalSheet', 'idSheet', 'idSheet');
  }
  
  public function drugsPrescriptions()
  {
    return $this->hasMany('DrugPrescription', 'idPrescription', 'idPrescription');
  }
}