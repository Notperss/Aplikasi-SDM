<?php

namespace App\Models\Approval;

use App\Models\Employee\Employee;
use App\Models\Employee\PersonalData\EmployeeCareer;
use App\Models\Position\Position;
use App\Models\Recruitment\SelectedCandidate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $fillable = [
        'selected_candidate_id',
        'employee_career_id',
        'is_approve',
        'description',
        'position_id',
        'employee_id',
        'company_id',
    ];

    public function selectedCandidate()
    {
        return $this->belongsTo(SelectedCandidate::class);
    }

    public function employeeCareer()
    {
        return $this->belongsTo(EmployeeCareer::class);
    }
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
