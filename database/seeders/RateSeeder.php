<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 6; $i++) {
            DB::table('rates')->insert([
                'hourly' => $faker->randomFloat(2),
                'user_id' => $i,
                'currency_id' => $faker->numberBetween(1,3),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
