<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    use HasFactory;


    protected $fillable = [
        'name', 'description'
    ];

    public function employees()
    {
        return $this->hasMany(Employees::class);
    }
    public function projects()
    {
        return $this->hasManyThrough(Projects::class, Employees::class, 'department_id', 'id', 'id', 'id');
    }
    // public function manager()
    // {
    //     return $this->hasOne(Employees::class);
    // }
}