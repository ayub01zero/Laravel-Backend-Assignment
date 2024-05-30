<?php

namespace App\Services;

use App\Models\Projects;
use Illuminate\Support\Facades\DB;
use App\Models\Departments;
use Carbon\Carbon;

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
        $departments = Departments::with('projects')->get();

        $result = $departments->map(function ($department) {
            $avgDuration = $department->projects->filter(function ($project) {
                return $project->end_date !== null;
            })->avg(function ($project) {
                $startDate = Carbon::parse($project->start_date);
                $endDate = Carbon::parse($project->end_date);
                return $startDate->diffInDays($endDate);
            });

            return [
                'department_id' => $department->id,
                'department_name' => $department->name,
                'avg_duration' => round($avgDuration, 0)
            ];
        });

        return $result;
    }
    
}
