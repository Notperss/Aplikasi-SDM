<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'candidate_id',
        'relationship',
        'gender',
        'name',
        'education',
        'job',
        'phone_number',
        'address',
        'dob',
    ];
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
