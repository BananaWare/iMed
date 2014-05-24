<?php

class PrescriptionTableSeeder extends Seeder
{
	public function run()
	{
    DB::table('prescriptions')->delete();
    Prescription::create(array(
      'idPrescription' => '1',
      'comment' => 'Receta para el dolor de hombros para seguir durante un mes'
    ));
    Prescription::create(array(
      'comment' => 'Receta no asignada.'
    ));
    Prescription::create(array(
      'comment' => 'Receta para el dolor de cabeza.'
    ));
  }

}