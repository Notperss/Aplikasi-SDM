<?php

namespace App\Models\Employee\PersonalData;

use App\Models\Employee\Contract;
use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeKpi extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'contract_id',
        'nik_employee',
        'grade',
        'year',
        'kpi_date',
        'contract_recommendation',
        'file',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
