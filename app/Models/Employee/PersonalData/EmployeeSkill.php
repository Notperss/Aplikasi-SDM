<?php

namespace App\Models\Employee\PersonalData;

use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeSkill extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'name',
        'mastery',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}