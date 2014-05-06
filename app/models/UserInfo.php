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
  public $incrementing = false;
  
  public function user()
  {
    return $this->belongsTo('user', 'rut');
  }
  
  public function roles()
  {
    return $this->hasMany('UserRole', 'rut');
  }
}