<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidate extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'photo',
        'email',
        'phone_number',
        'ktp_address',
        'current_address',
        'npwp_number',
        'ktp_number',
        'kk_number',
        'religion',
        'nationality',
        'height',
        'weight',
        'pob',
        'dob',
        'gender',
        'date_applied',
    ];

    public function familyDetails()
    {
        return $this->hasMany(FamilyDetail::class);
    }
    public function employmentHistories()
    {
        return $this->hasMany(EmploymentHistory::class);
    }
    public function educationalHistories()
    {
        return $this->hasMany(EducationalHistory::class);
    }
    public function languageProficiencies()
    {
        return $this->hasMany(LanguageProficiency::class);
    }
    public function CandidateDocuments()
    {
        return $this->hasMany(CandidateDocument::class);
    }
}
