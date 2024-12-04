<?php

namespace App\Models\Approval;

use App\Models\Employee\PersonalData\EmployeeCareer;
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
    ];

    public function selectedCandidate()
    {
        return $this->belongsTo(SelectedCandidate::class);
    }

    public function employeeCareer()
    {
        return $this->belongsTo(EmployeeCareer::class);
    }
}
