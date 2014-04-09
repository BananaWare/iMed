<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class UsersPhoto extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users_photos';
  protected $primaryKey = 'rut';
  public $incrementing = false;
  
  public function user()
  {
    return $this->hasOne('User');
  }
}