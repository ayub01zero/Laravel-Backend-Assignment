<?php

namespace App\Services;

use App\Models\Projects;
use Illuminate\Support\Facades\DB;
use App\Models\Departments;

class ProjectService
{
    public function searchProjects($query)
    {
        return Projects::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->orWhereHas('employees', function($q) use ($query) {
                $q->where('full_name', 'like', "%{$query}%");
            })
            ->get();
    }

    public function averageProjectDuration()
    {
        return Departments::join('employees', 'departments.id', '=', 'employees.department_id')
            ->join('employee_project', 'employees.id', '=', 'employee_project.employee_id')
            ->join('projects', 'employee_project.project_id', '=', 'projects.id')
            ->select('departments.id', 'departments.name', DB::raw('ROUND(AVG(DATEDIFF(projects.end_date, projects.start_date)), 0) as avg_duration'))
            ->groupBy('departments.id', 'departments.name')
            ->get();
    }
    
}
