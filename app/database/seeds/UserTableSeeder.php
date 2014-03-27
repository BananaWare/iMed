<?php

class UserTableSeeder extends Seeder
{

	public function run()
	{
    DB::table('users')->delete();
    User::create(array(
      'rut' => '17560861',
      'password' => Hash::make('90960623')
      'name'     => 'Alfredo',
      'lastname' => 'Gallardo',
      'role' => 'doctor',
      'gender' => 'male'
    ));
  }

}