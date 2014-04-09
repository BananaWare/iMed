<?php

class SecretaryDoctorTableSeeder extends Seeder
{
	public function run()
	{
    DB::table('secretaries_doctors')->delete();
    SecretaryDoctor::create(array(
      'doctorsRut' => '17560861',
      'secretarysRut' => '18218547',
      'active' => '1',
      'idHospital' => '1'
    ));
    SecretaryDoctor::create(array(
      'doctorsRut' => '121212',
      'secretarysRut' => '18218547',
      'active' => '1',
      'idHospital' => '1'
    ));
    SecretaryDoctor::create(array(
      'doctorsRut' => '17560861',
      'secretarysRut' => '311331',
      'active' => '1',
      'idHospital' => '1'
    ));
  }

}