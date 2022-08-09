<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    final public function run(): void
    {
        $faker = Faker::create();

        $professions = ['IT', 'Sales', 'Marketing', 'Finance', 'HR', 'Project Manager'];

        for ($i = 0; $i <= 5; $i++) {
            DB::table('users')->insert([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'dob' => $faker->date('Y_m_d'),
                'contact_number' => $faker->phoneNumber,
                'profession' => $professions[$i],
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
