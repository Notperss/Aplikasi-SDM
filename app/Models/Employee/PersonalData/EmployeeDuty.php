<?php

namespace App\Models\Employee\PersonalData;

use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeDuty extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'nik_employee',
        'name_duty',
        'date_duty',
        'location',
        'file',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
