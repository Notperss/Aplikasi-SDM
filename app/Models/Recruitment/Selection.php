<?php

namespace App\Models\Recruitment;

use App\Models\ManagementAccess\Company;
use App\Models\Position\Position;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Selection extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'position_id',
        'name',
        'pic_selection',
        'date_selection',
        'start_selection',
        'end_selection',
        'interviewer',
        'description',
        'file_selection',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function SelectedCandidates()
    {
        return $this->hasMany(SelectedCandidate::class);
    }
}
