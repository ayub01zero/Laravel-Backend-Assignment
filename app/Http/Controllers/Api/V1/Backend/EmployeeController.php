<?php

namespace App\Http\Controllers\Api\V1\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employees;
use Illuminate\Support\Facades\DB;
use App\Models\Projects;
use App\Services\EmployeeService;
use App\traits\apiResponse;
use App\Models\Departments;

class EmployeeController extends Controller
{
   
    use apiResponse;
    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function getManagersHierarchy($employeeId)
    {
        $managers = $this->employeeService->getManagersHierarchy($employeeId);
        return $this->successResponse($managers);
    }

    public function getAverageSalaryByAgeGroup()
    {
        $averageSalaries = $this->employeeService->getAverageSalaryByAgeGroup();
        return $this->successResponse($averageSalaries);
    }

    public function topEmployeesByCompletedProjects($departmentId)
    {
        if (!is_numeric($departmentId) || !Departments::find($departmentId)) {
            return $this->errorResponse('Invalid department ID', 400);
        }

        $topEmployees = $this->employeeService->topEmployeesByCompletedProjects($departmentId);
        return $this->successResponse($topEmployees);
    }

    public function employeesWithNoDepartmentChange()
    {
        $employees = $this->employeeService->employeesWithNoDepartmentChange();
        return $this->successResponse($employees);
       
    }
}
    

