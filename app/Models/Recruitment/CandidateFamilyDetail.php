<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CandidateFamilyDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'candidate_id',
        'relation',
        'gender',
        'name',
        'education',
        'job',
        'phone_number',
        'address',
        'dob_family',
        'is_in_kk',
        'is_bpjs',
    ];

    protected $casts = ['is_in_kk' => 'boolean', 'is_bpjs' => 'boolean'];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
