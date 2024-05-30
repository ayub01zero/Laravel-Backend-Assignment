<?php

namespace App\Services;

use App\Models\Employees;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\V1\TopEmployeesRequest;
use Illuminate\Http\Request;

class EmployeeService
{
    public function getManagersHierarchy($employeeId)
    {
        $employee = Employees::with('manager')->findOrFail($employeeId);
        $managers = [];

        while ($employee->manager) {
            $employee = $employee->manager;
            $managers[] = $employee->full_name; // tanha nawy employee
        }

        return $managers; 
    }
    
    public function getAverageSalaryByAgeGroup()
    {
        $averageSalaries = Employees::select(DB::raw('
            CASE 
                WHEN age BETWEEN 20 AND 29 THEN "20-29"
                WHEN age BETWEEN 30 AND 39 THEN "30-39"
                WHEN age BETWEEN 40 AND 49 THEN "40-49"
                WHEN age BETWEEN 50 AND 59 THEN "50-59"
                WHEN age BETWEEN 60 AND 69 THEN "60-69"
                ELSE "70+" 
            END as age_group'), DB::raw('AVG(salary) as average_salary'))
            ->groupBy('age_group')
            ->orderBy('age_group')
            ->get();

        return $averageSalaries; 
    }

    public function topEmployeesByCompletedProjects($departmentId)
    {
        $topEmployees = Employees::withCount(['projects' => function ($query) {
            $query->where('status', 'completed');
        }])
        ->where('department_id', $departmentId)
        ->orderBy('projects_count', 'desc')
        ->limit(10) // yan  take 10
        ->get();

        return $topEmployees;
    }

    public function employeesWithNoDepartmentChange()
    {
        $employees = Employees::doesntHave('departmentChanges')->get();

        return $employees; 
    }

    

}