<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\AuthenticationController;
use App\Http\Controllers\Api\V1\Backend\{
ProjectController,
EmployeeController
};

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Authentication Routes
Route::post('/login', [AuthenticationController::class, 'loginUser']);
Route::post('/logout/{userId}', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');


Route::middleware(['auth:sanctum'])->prefix('employees')->controller(EmployeeController::class)->group(function () {
    Route::get('/{employee}/managers', 'getManagersHierarchy');
    Route::get('/average-salary-by-age-group', 'getAverageSalaryByAgeGroup');
    Route::get('/top-employees-by-completed-projects/{departmentId}', 'topEmployeesByCompletedProjects');
    Route::get('/department', 'employeesWithNoDepartmentChange');
});


Route::middleware(['auth:sanctum'])->controller(ProjectController::class)->group(function () {
    Route::get('/employees/search-projects', 'searchProjects');
    Route::get('projects/average-duration', 'averageProjectDuration');
});

