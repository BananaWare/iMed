<?php

class DrugPrescriptionTableSeeder extends Seeder
{

	public function run()
	{
    DB::table('drugs_prescriptions')->delete();
    DrugPrescription::create(array(
      'idDrug' => '1',
      'idPrescription' => '1',
      'dosage' => '2 pastillas',
      'intervalTime' => 'Cada 3 horas',
      'term' => '1 semana',
      'observation' => 'No tomar en la noche'
    ));
    DrugPrescription::create(array(
      'idDrug' => '2',
      'idPrescription' => '1',
      'dosage' => '1 pastilla',
      'intervalTime' => 'Cada 6 horas',
      'term' => '3 semana',
      'observation' => 'No tomar con alcohol'
    ));
    DrugPrescription::create(array(
      'idDrug' => '3',
      'idPrescription' => '1',
      'dosage' => '5 gotitas',
      'intervalTime' => 'Cada 5 horas',
      'term' => '2 semanas',
      'observation' => 'Tomar en el almuerzo'
    ));
  }
}