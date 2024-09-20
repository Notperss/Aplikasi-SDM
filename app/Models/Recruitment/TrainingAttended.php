<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingAttended extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'candidate_id',
        'training_name',
        'organizer_name',
        'year',
        'city',
        'file_sertifikat',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
