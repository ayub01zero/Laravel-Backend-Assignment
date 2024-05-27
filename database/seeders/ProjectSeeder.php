<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

      
        for ($i = 1; $i <= 20; $i++) {
            $projectId = DB::table('projects')->insertGetId([
                'name' => $faker->word,
                'description' => $faker->sentence,
                'start_date' => $faker->date,
                'end_date' => $faker->optional()->date,
                'status' => $faker->randomElement(['planned', 'in_progress', 'completed']),
                'created_at' => now(),
            ]);

            ///daxlekrden employee bo har projectak
            //table zyadkraw bo bastnawa employee u project !!!
            $employeeIds = DB::table('employees')->pluck('id')->toArray();
            for ($j = 0; $j < rand(1, 10); $j++) {
                DB::table('employee_project')->insert([
                    'employee_id' => $faker->randomElement($employeeIds),
                    'project_id' => $projectId,
                ]);
            }
        
        
    }
}

}
