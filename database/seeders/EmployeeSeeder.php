<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
    
        $founderId = DB::table('employees')->insertGetId([
            'full_name' => 'Bill Gates',
            'age' => 65,
            'salary' => 1000000,
            'date_of_employment' => '1988-05-05',
            'manager_id' => null, //founder managere neya 
            'department_id' => 1, 
            'created_at' => now(),
        ]);

        $departmentManagers = [];

        // drustkrdne manager bo departmentakan
        foreach (DB::table('departments')->get() as $department) {
            $managerId = DB::table('employees')->insertGetId([
                'full_name' => $faker->name,
                'age' => $faker->numberBetween(30, 50),
                'salary' => $faker->numberBetween(60000, 120000),
                'date_of_employment' => $faker->date,
                'manager_id' => $founderId,
                'department_id' => $department->id,
                'created_at' => now(),
            ]);

            $departmentManagers[$department->id] = $managerId;
        }

        //more 
        for ($i = 1; $i <= 5; $i++) {
            $departmentId = $faker->numberBetween(1, 3);
            $additionalManagerId = DB::table('employees')->insertGetId([
                'full_name' => $faker->name,
                'age' => $faker->numberBetween(30, 50),
                'salary' => $faker->numberBetween(60000, 120000),
                'date_of_employment' => $faker->date,
                'manager_id' => $departmentManagers[$departmentId],
                'department_id' => $departmentId,
                'created_at' => now(),
            ]);

            $departmentManagers[$departmentId] = $additionalManagerId; 
        }

        // drustkrdne employeeakan with Dep u manager
        for ($i = 1; $i <= 50; $i++) {
            $departmentId = $faker->numberBetween(1, 3);
            DB::table('employees')->insert([
                'full_name' => $faker->name,
                'age' => $faker->numberBetween(20, 60),
                'salary' => $faker->numberBetween(30000, 150000),
                'date_of_employment' => $faker->date,
                'manager_id' => $departmentManagers[$departmentId],
                'department_id' => $departmentId,
                'created_at' => now(),
            ]);
        }
    }
}

