<?php

class UserTableSeeder extends Seeder
{

	public function run()
	{
		DB::table('users')->delete();
		User::create(array(
			'names'     => 'Alfredo Ignacio',
            'lastnames' => 'Gallardo León',
			'rut' => '17560861',
            'dv' => '3',
			'email'    => 'alfredo.gallardo@hotmail.es',
			'password' => Hash::make('90960623'),
            'phone' => '62043249',
            'role' => 'doctor',
            'birthday' => '1991-12-30',
            'updated_at' => '1991-12-30',
		));
	}

}