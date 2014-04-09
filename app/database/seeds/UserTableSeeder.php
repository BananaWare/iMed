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
      'rut' => '121212',
      'dv' => '1',
      'password' => Hash::make('121212'),
      'name'     => 'UnoDos',
      'lastname' => 'DosUno',
      'role' => 'doctor',
      'gender' => 'female',
      'birthDate' => '1982-11-10'
    ));
    User::create(array(
      'rut' => '311331',
      'dv' => '3',
      'password' => Hash::make('311331'),
      'name'     => 'Marcela',
      'lastname' => 'Serrano',
      'role' => 'secretary',
      'gender' => 'female',
      'birthDate' => '1972-03-21'
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
    User::create(array(
      'rut' => '123123123',
      'dv' => '1',
      'password' => Hash::make('123123'),
      'name'     => 'Elpa',
      'lastname' => 'ciente',
      'role' => 'patient',
      'gender' => 'male',
      'birthDate' => '1991-03-09'
    ));
    User::create(array(
      'rut' => '321321321',
      'dv' => '3',
      'password' => Hash::make('123123'),
      'name'     => 'doña',
      'lastname' => 'pepa',
      'role' => 'patient',
      'gender' => 'female',
      'birthDate' => '1951-02-21'
    ));
    User::create(array(
      'rut' => '7878787',
      'dv' => '7',
      'password' => Hash::make('123123'),
      'name'     => 'don',
      'lastname' => 'ramon',
      'role' => 'patient',
      'gender' => 'male',
      'birthDate' => '1947-12-25'
    ));
  }

}