<?php

class DoctorScheduleTableSeeder extends Seeder
{

	public function run()
	{
    DB::table('doctors_schedules')->delete();
    DoctorSchedule::create(array(
      'doctorsRut' => '17560861',
      'idHospital' => '1',
      'dayOfWeek' => '2',
      'startHour'     => '10:00:00',
      'endHour' => '14:00:00',
      'intervalTime' => '00:45:00'
    ));
    DoctorSchedule::create(array(
      'doctorsRut' => '17560861',
      'idHospital' => '1',
      'dayOfWeek' => '3',
      'startHour'     => '11:30:00',
      'endHour' => '16:00:00',
      'intervalTime' => '00:45:00'
    ));
    DoctorSchedule::create(array(
      'doctorsRut' => '17560861',
      'idHospital' => '1',
      'dayOfWeek' => '4',
      'startHour'     => '11:30:00',
      'endHour' => '16:00:00',
      'intervalTime' => '00:45:00'
    ));
    DoctorSchedule::create(array(
      'doctorsRut' => '17560861',
      'idHospital' => '1',
      'dayOfWeek' => '6',
      'startHour'     => '14:00:00',
      'endHour' => '18:00:00',
      'intervalTime' => '00:40:00'
    ));
  }

}