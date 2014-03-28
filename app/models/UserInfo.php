<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class UserInfo extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users_info';
  protected $primaryKey = 'rut';
  
  public function user()
  {
    return $this->belongsTo('User');
  }
}