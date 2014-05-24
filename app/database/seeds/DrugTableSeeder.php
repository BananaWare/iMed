<?php

class DrugTableSeeder extends Seeder
{

	public function run()
	{
    DB::table('drugs')->delete();
    Drug::create(array(
      'idDrug' => '1',
      'name' => 'Migranol'
    ));
    Drug::create(array(
      'idDrug' => '2',
      'name' => 'Tapsín'
    ));
    Drug::create(array(
      'idDrug' => '3',
      'name' => 'Sal de fruta'
    ));
  }
}