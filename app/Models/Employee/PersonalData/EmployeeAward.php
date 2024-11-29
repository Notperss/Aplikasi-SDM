<?php

namespace App\Models\Employee\PersonalData;

use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeAward extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'name_award',
        'date_award',
        'file_award',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
