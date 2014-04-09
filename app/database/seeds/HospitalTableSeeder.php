<?php

class HospitalTableSeeder extends Seeder
{

	public function run()
	{
    DB::table('hospitals')->delete();
    Hospital::create(array(
      'idHospital' => '1',
      'name' => 'Clínica Santa María',
      'address' => 'Av. Placeres 355',
      'city' => 'Valparaíso'
    ));
    Hospital::create(array(
      'idHospital' => '2',
      'name' => 'Hospital Los Coihues',
      'address' => 'Calle los Palmos 231',
      'city' => 'Concepción'
    ));
  }

}