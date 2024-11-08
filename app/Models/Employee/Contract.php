<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'employee_id',
        'nik_employee',
        'start_date',
        'end_date',
        'duration',
        'contract_number',
        'description',
        'file',

    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function employeeNik()
    {
        return $this->belongsTo(Employee::class, 'nik_employee');
    }
}
