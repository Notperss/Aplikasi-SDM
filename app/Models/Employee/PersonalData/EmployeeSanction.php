<?php

namespace App\Models\Employee\PersonalData;

use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSanction extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'sanction_name',
        'sanction_category',
        'start_date',
        'end_date',
        'file_sanction',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
