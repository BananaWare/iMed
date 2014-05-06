<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class UserRole extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users_roles';
  protected $primaryKey = 'idRole';
  
  public function user()
  {
    return $this->belongsTo('User', 'rut');  
  }
  
  public function userInfo()
  {
    return $this->belongsToMany('UserInfo', 'rut');  
  }
}