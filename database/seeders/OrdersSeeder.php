<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i=0; $i < 15; $i++) { 
            DB::table('orders')->insert([
                'customer_name' => $faker->name(),
                'customer_email' => $faker->safeEmail,
                'customer_mobile' => $faker->phoneNumber,
                'status' => $faker->randomElement(['CREATED', 'PAYED', 'REJECTED']),
                'created_at' => $faker->dateTime(),
                'updated_at' => $faker->dateTime()
            ]);
        }
        
    }
}
