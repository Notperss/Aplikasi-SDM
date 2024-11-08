<?php

namespace App\Models\Position;

use App\Models\Employee\Employee;
use App\Models\WorkUnit\Section;
use App\Models\WorkUnit\Division;
use App\Models\WorkUnit\Department;
use App\Models\WorkUnit\Directorate;
use Illuminate\Database\Eloquent\Model;
use App\Models\ManagementAccess\Company;
use App\Models\Recruitment\Candidate;
use App\Models\Recruitment\SelectedCandidate;
use App\Models\Recruitment\Selection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'directorate_id',
        'division_id',
        'department_id',
        'section_id',
        'level_id',
        'name',
        'description',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function directorate()
    {
        return $this->belongsTo(Directorate::class);
    }
    public function division()
    {
        return $this->belongsTo(Division::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function level()
    {
        return $this->belongsTo(Level::class);
    }
    // public function candidate()
    // {
    //     return $this->belongsTo(Candidate::class);
    // }
    // public function allowances()
    // {
    //     return $this->hasMany(Allowance::class);
    // }
    // public function positions()
    // {
    //     return $this->hasMany(Employee::class);
    // }

    public function allowances()
    {
        return $this->belongsToMany(Allowance::class, 'position_allowances');
    }
    public function selectedCandidates()
    {
        return $this->hasMany(SelectedCandidate::class);
    }
    public function selectedPositions()
    {
        return $this->belongsToMany(Selection::class, 'position_selection');
    }
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }
}
