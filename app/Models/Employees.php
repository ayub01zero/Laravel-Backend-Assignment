<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Filters\V1\QueryFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Employees extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name', 'age', 'salary', 'date_of_employment', 'manager_id', 'department_id'
    ];

    public function department()
    {
        return $this->belongsTo(Departments::class);
    }

    public function manager()
    {
        return $this->belongsTo(Employees::class, 'manager_id');
    }


    public function projects()
    {
        return $this->belongsToMany(Projects::class, 'employee_project', 'employee_id', 'project_id');
    }

    public function departmentChanges()
    {
        return $this->hasMany(DepartmentChange::class);
    }
}
