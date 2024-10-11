<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CandidateSkill extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'candidate_id',
        'name',
        'mastery',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
