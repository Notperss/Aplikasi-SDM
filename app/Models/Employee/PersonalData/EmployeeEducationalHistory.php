<?php

namespace App\Models\Employee\PersonalData;

use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeEducationalHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'school_level',
        'school_name',
        'study',
        'year_from',
        'year_to',
        'gpa',
        'graduate',
        'file_ijazah',
        'city',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
