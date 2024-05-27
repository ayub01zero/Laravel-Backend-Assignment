<?php

namespace App\Http\Controllers\Api\V1\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Projects;
use App\Services\ProjectService;
use App\traits\apiResponse;

class ProjectController extends Controller
{
      use apiResponse;
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function searchProjects(Request $request)
    {
        $query = $request->input('search');
        $projects = $this->projectService->searchProjects($query);

        return $this->successResponse($projects);

    }

    public function averageProjectDuration()
    {
        $averageDurations = $this->projectService->averageProjectDuration();
        return $this->successResponse($averageDurations);
    }
}
