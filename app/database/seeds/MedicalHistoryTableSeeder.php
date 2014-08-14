<?php

class MedicalHistoryTableSeeder extends Seeder
{

	public function run()
	{
    DB::table('medical_history')->delete();
    MedicalHistory::create(array(
      'idMedicalHistory' => '1',
      'adr' => 'Alérgico a la vitamina C',
      'morbid' => 'Obesidad mórbida desde hace 25 años',
      'gynecological' => 'Herpes a la edad de 55 años',
      'family' => 'Diabetes por parte materna',
      'habit' => 'Se baña una vez cada 3 semanas',
      'other' => 'Cada cuatro semanas tiene un cuadro de depresión'
    ));
  }

}