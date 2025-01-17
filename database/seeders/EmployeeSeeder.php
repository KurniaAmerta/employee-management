<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Jabatan;
use App\Models\JabatanEmployee;
use App\Models\Unit;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1, 10) as $index) {
            Jabatan::create([
                'name' => "Jabatan".$index,
            ]);
        }

        foreach (range(1, 10) as $index) {
            Unit::create([
                'name' => "Unit".$index,
            ]);
        }

        foreach (range(1, 10) as $index) {
            $unit = Unit::inRandomOrder()->first();

            Employee::create([
                'name' => $faker->name,
                'username' => $faker->userName,
                'dateJoined' => $faker->dateTimeThisDecade,
                'unit_id' => $unit ? $unit->id : null,
                'username_verified_at' => $faker->optional()->dateTimeThisYear, 
                'password' => bcrypt('password'), 
            ]);
        }

        foreach (range(1, 10) as $index) {
            $jabatan = Jabatan::inRandomOrder()->first();

            JabatanEmployee::create([
                'jabatan_id' => $jabatan ? $jabatan->id : null,
                'employee_id' => $index,
            ]);
        }
    }
}
