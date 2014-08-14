<?php

class MedicalSheetTableSeeder extends Seeder
{

	public function run()
	{
    DB::table('medical_sheets')->delete();
    MedicalSheet::create(array(
      'idSheet' => '1',
      'observation' => 'el paciente tiene un severo cuadro dolor de hombros',
      'generalExamination' => 'Examen físico general',
      'bloodPressure' => '120/80 mmHg',
      'temperature' => '38°C',
      'sat' => 'SAT?',
      'segmentary' => 'Segmentario?',
      'complementary' => 'Exámenes complementarios',
      'diagnostic' => 'Gastritis esdrújula'
      
    ));
    MedicalSheet::create(array(
      'idSheet' => '2',
      'observation' => 'el paciente viene con tres ojos',
      'idHour' => '2'
    ));
    MedicalSheet::create(array(
      'idSheet' => '3',
      'observation' => 'al paciente le nació una cabeza extra',
      'idHour' => '3'
    ));
  }

}