<?php

class PatientHourTableSeeder extends Seeder
{

	public function run()
	{
    DB::table('patients_hours')->delete();
    PatientHour::create(array(
      'doctorsRut' => '17560861',
      'assignersRut' => '18218547',
      'patientsRut' => '123123123',
      'dateTimeAssign' => '2014-02-02 10:00:00',
      'dateTimeEnd' => '2014-02-02 10:30:00',
      'reason' => 'dolor de cabeza y de estomago',
      'confirmed' => '0',
      'idHospital' => '1'
    ));
    PatientHour::create(array(
      'doctorsRut' => '17560861',
      'assignersRut' => '18218547',
      'patientsRut' => '123123123',
      'dateTimeAssign'     => '2014-02-05 15:30:00',
      'dateTimeEnd'     => '2014-02-05 16:00:00',
      'reason' => 'no puede caminar',
      'confirmed' => '0',
      'idHospital' => '1'
    ));
    PatientHour::create(array(
      'doctorsRut' => '17560861',
      'assignersRut' => '18218547',
      'patientsRut' => '123123123',
      'dateTimeAssign'     => '2014-04-04 16:30:00',
      'dateTimeEnd'     => '2014-04-04 17:00:00',
      'reason' => 'tiene el brazo morado',
      'confirmed' => '1',
      'idHospital' => '1'
    ));
  }

}