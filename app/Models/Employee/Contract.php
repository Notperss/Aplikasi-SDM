<?php

namespace App\Models\Employee;

use App\Models\Employee\PersonalData\EmployeeKpi;
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
        'contract_sequence_number',
        'description',
        'file',
        'is_lock',
    ];

    protected $casts = ['is_lock' => 'boolean'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function employeeNik()
    {
        return $this->belongsTo(Employee::class, 'nik_employee', 'nik');
    }
    public function contractKpi()
    {
        return $this->hasOne(EmployeeKpi::class);
    }
}
