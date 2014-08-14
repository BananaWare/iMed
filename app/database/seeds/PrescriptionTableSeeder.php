<?php

class PrescriptionTableSeeder extends Seeder
{
	public function run()
	{
    DB::table('prescriptions')->delete();
    Prescription::create(array(
      'idPrescription' => '1',
      'idSheet' => '1',
      'comment' => 'Receta para el dolor de hombros para seguir durante un mes'
    ));
    Prescription::create(array(
      'idPrescription' => '2',
      'idSheet' => '2',
      'comment' => 'Receta asignada.'
    ));
    Prescription::create(array(
      'idPrescription' => '3',
      'idSheet' => '3',
      'comment' => 'Receta para el dolor de cabeza.'
    ));
  }

}