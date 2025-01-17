<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Login;
use App\Models\Employee;

class LoginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        foreach (range(1, 200) as $index) {
            Login::create([
                'employee_id' => Employee::inRandomOrder()->first()->id,
                'created_at' => $faker->dateTimeThisYear,
            ]);
        }
    }
}
