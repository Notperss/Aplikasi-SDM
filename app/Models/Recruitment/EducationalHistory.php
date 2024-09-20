<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationalHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'candidate_id',
        'school_level',
        'school_name',
        'study',
        'year_from',
        'year_to',
        'gpa',
        'file_ijazah',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
