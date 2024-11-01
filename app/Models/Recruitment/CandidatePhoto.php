<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatePhoto extends Model
{
    use HasFactory;
    protected $fillable = [
        'candidate_id',
        'company_id',
        'main_photo',
        'file_path',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
