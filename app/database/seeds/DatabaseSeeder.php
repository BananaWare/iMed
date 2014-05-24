<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UserTableSeeder');
    $this->call('UserInfoTableSeeder');
    $this->call('SecretaryDoctorTableSeeder');
    $this->call('DoctorScheduleTableSeeder');
    $this->call('PatientHourTableSeeder');
    $this->call('HospitalTableSeeder');
    $this->call('UserRoleTableSeeder');
    $this->call('MedicalSheetTableSeeder');
    $this->call('PrescriptionTableSeeder');
    $this->call('MedicalHistoryTableSeeder');
    $this->call('DrugTableSeeder');
    $this->call('DrugPrescriptionTableSeeder');
	}

}