<?php

class BillingTableSeeder extends Seeder
{

	public function run()
	{
    DB::table('billings')->delete();
    Billing::create(array(
      'idBilling' => '1',
      'payersRut' => '17560861',
      'amountPaid' => '15000',
      'paymentDateTime' => '2014/07/03 14:35:43',
      'idHospital' => '1',
      'paymentMethod' => 'transfer',
      'type' => 'forLifeSuscription'
    ));
  }
}