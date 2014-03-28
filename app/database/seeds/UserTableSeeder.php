<?php

class UserTableSeeder extends Seeder
{

	public function run()
	{
    DB::table('users')->delete();
    User::create(array(
      'rut' => '17560861',
      'dv' => '3',
      'password' => Hash::make('90960623'),
      'name'     => 'Alfredo',
      'lastname' => 'Gallardo',
      'role' => 'doctor',
      'gender' => 'male',
      'birthDate' => '1991-12-30'
    ));
    User::create(array(
      'rut' => '18218547',
      'dv' => '7',
      'password' => Hash::make('123123'),
      'name'     => 'Marco',
      'lastname' => 'Rojas',
      'role' => 'secretary',
      'gender' => 'male',
      'birthDate' => '1992-05-09'
    ));
  }

}