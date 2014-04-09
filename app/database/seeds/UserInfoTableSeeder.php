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
    UserInfo::create(array(
      'rut' => '17560861',
      'dv' => '3',
      'email' => 'agallard@loscoihues.cl',
      'phone'     => '032223243',
      'idHospital' => '2'
    ));
    UserInfo::create(array(
      'rut' => '121212',
      'dv' => '1',
      'email' => 'donUno.Dos@yahoo.com',
      'phone'     => '11221122',
      'idHospital' => '1'
    ));
    UserInfo::create(array(
      'rut' => '311331',
      'dv' => '3',
      'email' => 'marcela.s@yahoo.es',
      'phone'     => '131313',
      'idHospital' => '1'
    ));
    UserInfo::create(array(
      'rut' => '18218547',
      'dv' => '7',
      'email' => 'asdf@asdf.cl',
      'phone'     => '9898989',
      'idHospital' => '1'
    ));
    UserInfo::create(array(
      'rut' => '123123123',
      'dv' => '1',
      'email' => 'qwer@qwer.com',
      'phone'     => '3131313',
      'idHospital' => '1'
    ));
    UserInfo::create(array(
      'rut' => '321321321',
      'dv' => '3',
      'email' => 'gatitu_bunitux3@gmail.com',
      'phone'     => '93456528',
      'idHospital' => '1'
    ));
    UserInfo::create(array(
      'rut' => '7878787',
      'dv' => '7',
      'phone'     => '112112',
      'idHospital' => '1'
    ));
  }

}