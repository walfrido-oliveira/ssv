<?php

use Illuminate\Database\Seeder;

class BillingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('billings')->insert([
            'budget_id' => 17,
            'client_id' => 2,
            'payment_method_id' => 2,
            'due_date' => '2020-08-11 11:08:00',
            'amount' => 10.02,
        ]);
        DB::table('billings')->insert([
            'budget_id' => 18,
            'client_id' => 2,
            'payment_method_id' => 2,
            'due_date' => '2020-08-11 11:08:00',
            'amount' => 11.02,
        ]);
        DB::table('billings')->insert([
            'budget_id' => 21,
            'client_id' => 2,
            'payment_method_id' => 2,
            'due_date' => '2020-08-11 11:08:00',
            'amount' => 20.02,
        ]);
    }
}
