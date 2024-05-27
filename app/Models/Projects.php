<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'start_date', 'end_date', 'status'
    ];

    public function employees()
    {
        return $this->belongsToMany(Employees::class, 'employee_project', 'project_id', 'employee_id');
    }
}
