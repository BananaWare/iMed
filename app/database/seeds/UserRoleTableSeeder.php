<?php

class UserRoleTableSeeder extends Seeder
{

	public function run()
	{
    DB::table('users_roles')->delete();
    UserRole::create(array(
      'rut' => '17560861',
      'role' => 'doctor',
      'idHospital' => '1'
    ));
    UserRole::create(array(
      'rut' => '17560861',
      'role' => 'doctor',
      'idHospital' => '2'
    ));
    UserRole::create(array(
      'rut' => '121212',
      'role' => 'doctor',
      'idHospital' => '1'
    ));
    UserRole::create(array(
      'rut' => '311331',
      'role' => 'secretary',
      'idHospital' => '1'
    ));
    UserRole::create(array(
      'rut' => '18218547',
      'role' => 'secretary',
      'idHospital' => '1'
    ));
    
    UserRole::create(array(
      'rut' => '123123123',
      'role' => 'patient',
      'idHospital' => '1'
    ));
    UserRole::create(array(
      'rut' => '321321321',
      'role' => 'patient',
      'idHospital' => '1'
    ));
    UserRole::create(array(
      'rut' => '7878787',
      'role' => 'patient',
      'idHospital' => '1'
    ));
  }
}