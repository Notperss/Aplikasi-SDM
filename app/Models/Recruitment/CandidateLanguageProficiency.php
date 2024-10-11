<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CandidateLanguageProficiency extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'candidate_id',
        'language',
        'speaking',
        'listening',
        'writing',
        'reading',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
