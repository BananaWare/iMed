<?php

class CustomScheduleTableSeeder extends Seeder
{

	public function run()
	{
    DB::table('custom_schedules')->delete();
    CustomSchedule::create(array(
      'idCustomSchedule' => '1',
      'day' => '2014-07-30',
      'extraHours' => '3',
      'doctorsRut' => '17560861',
      'idHospital' => '1'
    ));
  }
}