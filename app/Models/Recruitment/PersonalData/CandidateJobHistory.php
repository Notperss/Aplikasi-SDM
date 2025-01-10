<?php

namespace App\Models\Recruitment\PersonalData;

use App\Models\Recruitment\Candidate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CandidateJobHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'candidate_id',
        'company_name',
        'company_type',
        'city',
        'period',
        // 'year_out',
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
