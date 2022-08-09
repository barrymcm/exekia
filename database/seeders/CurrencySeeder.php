<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $currencies = ['GBP', 'EUR', 'USD'];

        foreach ($currencies as $currency) {
            DB::table('currencies')->insert([
                'currency' => $currency,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
