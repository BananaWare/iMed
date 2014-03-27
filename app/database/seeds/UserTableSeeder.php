<?php

class UserTableSeeder extends Seeder
{

	public function run()
	{
		DB::table('users')->delete();
		User::create(array(
			'name'     => 'Alfredo',
      'lastname' => 'Gallardo',
			'rut' => '17560861',
      'dv' => '3',
			'password' => Hash::make('90960623'),
      'role' => 'doctor'
		));
	}

}