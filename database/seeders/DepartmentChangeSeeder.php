<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DepartmentChange;
use App\Models\Employees;
use App\Models\Departments;


class DepartmentChangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // fetche 50 user dakaen pashan ba random departmentakan dagoreen 
        //lo test krdne  requiremente 6 
        // table zyaadkraw !!!!
         $employees = Employees::inRandomOrder()->take(Employees::count() / 2)->get();

         foreach ($employees as $employee) {
             if ($employee->department_id) {
                 $newDepartment = Departments::where('id', '!=', $employee->department_id)->inRandomOrder()->first();
                 
                 if ($newDepartment) {
                     DepartmentChange::create([
                         'employee_id' => $employee->id,
                         'old_department_id' => $employee->department_id,
                         'new_department_id' => $newDepartment->id,
                         'change_date' => now()->subDays(rand(1, 365)) 
                     ]);
                     
                     $employee->department_id = $newDepartment->id;
                     $employee->save();
                 }
             }
    }
}
}
