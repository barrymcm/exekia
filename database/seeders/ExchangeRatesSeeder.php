<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExchangeRatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $xchangeRates = [
                'GBP–USD' => 1.3,
                'GBP–EUR' => 1.1,
                'EUR–GBP' => 0.9,
                'EUR–USD' => 1.2,
                'USD–GBP' => 0.7,
                'USD–EUR' => 0.8,
            ];

        foreach ($xchangeRates as $xchangeRate => $rate) {
            DB::table('exchange_rates')->insert([
                'currency_exchange' => $xchangeRate,
                'rate' => $rate,
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', now()),
            ]);
        }
    }
}
