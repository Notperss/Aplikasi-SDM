<?php

namespace App\Models\Recruitment;

use App\Models\ManagementAccess\Company;
use App\Models\Position\Position;
use App\Models\WorkUnit\Division;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Selection extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        // 'position_id',
        'division_id',
        'name',
        'fptk_number',
        'date_selection',
        'start_selection',
        'end_selection',
        'interviewer',
        'description',
        'file_selection',
        'is_finished',
        'status',
    ];

    protected $casts = ['is_finished' => 'boolean',];


    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // public function position()
    // {
    //     return $this->belongsTo(Position::class);
    // }
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function selectedCandidates()
    {
        return $this->hasMany(SelectedCandidate::class);
    }

    public function selectedPositions()
    {
        return $this->belongsToMany(Position::class, 'position_selection');
    }
}
