<?php

namespace App\Models\Employee\PersonalData;

use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeJobHistory extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'employee_id',
        'company_name',
        'company_type',
        'city',
        'period',
        'year_out',
        'position',
        'salary',
        'reason',
        'job_description',
        'file',

    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
