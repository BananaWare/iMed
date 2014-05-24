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
      'gender' => 'male',
      'birthdate' => '1991-12-30'
    ));
    User::create(array(
      'rut' => '121212',
      'dv' => '1',
      'password' => Hash::make('121212'),
      'name'     => 'ElDos',
      'lastname' => 'Tor',
      'gender' => 'female',
      'birthdate' => '1982-11-10'
    ));
    User::create(array(
      'rut' => '311331',
      'dv' => '3',
      'password' => Hash::make('311331'),
      'name'     => 'Marcela',
      'lastname' => 'Serrano',
      'gender' => 'female',
      'birthdate' => '1972-03-21'
    ));
    User::create(array(
      'rut' => '18218547',
      'dv' => '7',
      'password' => Hash::make('123123'),
      'name'     => 'Jorge',
      'lastname' => 'Gonzales',
      'gender' => 'male',
      'birthdate' => '1992-05-09'
    ));
    User::create(array(
      'rut' => '123123123',
      'dv' => '1',
      'password' => Hash::make('123123'),
      'name'     => 'Elpa',
      'lastname' => 'ciente',
      'gender' => 'male',
      'birthdate' => '1991-03-09'
    ));
    User::create(array(
      'rut' => '321321321',
      'dv' => '3',
      'password' => Hash::make('123123'),
      'name'     => 'doña',
      'lastname' => 'pepa',
      'gender' => 'female',
      'birthdate' => '1951-02-21'
    ));
    User::create(array(
      'rut' => '7878787',
      'dv' => '7',
      'password' => Hash::make('123123'),
      'name'     => 'don',
      'lastname' => 'ramon',
      'gender' => 'male',
      'birthdate' => '1947-12-25'
    ));
    User::create(array(
      'rut' => '6616616',
      'dv' => '6',
      'password' => Hash::make('123123'),
      'name'     => 'UsuarioSin',
      'lastname' => 'UserInfo',
      'gender' => 'male',
      'birthdate' => '1992-02-23'
    ));
  }

}