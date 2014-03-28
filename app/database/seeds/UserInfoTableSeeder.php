<?php

class UserInfoTableSeeder extends Seeder
{
	public function run()
	{
    DB::table('users_info')->delete();
    UserInfo::create(array(
      'rut' => '17560861',
      'dv' => '3',
      'email' => 'alfredo.gallardo@hotmail.es',
      'phone'     => '90960623',
      'idHospital' => '1'
    ));
  }

}