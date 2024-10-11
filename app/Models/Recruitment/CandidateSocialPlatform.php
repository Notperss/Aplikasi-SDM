<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CandidateSocialPlatform extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'candidate_id',
        'platform',
        'account_name',
        'account_link',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
