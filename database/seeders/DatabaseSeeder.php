<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employees;
use App\Models\Departments;
use App\Models\Projects;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        //seed bakar bhena
        User::factory()->create([
            'name' => 'HR-Admin',
            'email' => 'Hr@admin.com',
            'password' => bcrypt('password'),
        ]);
        $this->call([
            DepartmentSeeder::class,
            EmployeeSeeder::class,
            ProjectSeeder::class,
            DepartmentChangeSeeder::class,
        ]);
       
    }
}
