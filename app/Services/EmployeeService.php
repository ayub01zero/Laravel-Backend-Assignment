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
        $topEmployees = Employees::select('employees.id', 'employees.full_name', DB::raw('COUNT(projects.id) as completed_projects'))
            ->join('employee_project', 'employees.id', '=', 'employee_project.employee_id')
            ->join('projects', 'employee_project.project_id', '=', 'projects.id')
            ->where('projects.status', 'completed')
            ->where('employees.department_id', $departmentId)
            ->groupBy('employees.id', 'employees.full_name')
            ->orderByDesc('completed_projects')
            ->limit(10)
            ->get();

        return $topEmployees;
    }

    public function employeesWithNoDepartmentChange()
    {
        $employees = Employees::leftJoin('department_changes', 'employees.id', '=', 'department_changes.employee_id')
            ->whereNull('department_changes.id')
            ->select('employees.id', 'employees.full_name', 'employees.age', 'employees.salary', 'employees.date_of_employment', 'employees.manager_id', 'employees.department_id')
            ->get();

        return $employees; 
    }

    

}