<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class SecretaryHour extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'secretaries_doctors';
  protected $primaryKey = 'idSecretaryDoctor';
  
  public function doctor()
  {
    return $this->belongsTo('User', 'doctorsRut', 'rut');
  }
  
  public function secretary()
  {
    return $this->belongsTo('User', 'secretarysRut', 'rut');
  }
}