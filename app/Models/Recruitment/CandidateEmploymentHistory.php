<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CandidateEmploymentHistory extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'candidate_id',
        'company_name',
        'company_type',
        'direct_supervisor',
        'year_from',
        'year_to',
        'position',
        'salary',
        'reason',
        'job_description',
        'file',

    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
