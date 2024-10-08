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
        // 'npwp_number',
        'ktp_number',
        'kk_number',
        'religion',
        'nationality',
        // 'height',
        // 'weight',
        'pob',
        'dob',
        'gender',
        'date_applied',

        'is_qualify',
        'is_hire',
        'ethnic', //
        'blood_type',
        'candidate_from', //
        'applied_position', //
        'recommended_position', //
        'marital_status', //

        'paspor_number',

        'file_cv', //
        'file_kk', //
        'file_ktp', //
        'file_skck', //
        'file_vaksin', //
        'file_surat_sehat', //

        'latitude_ktp',
        'latitude_domisili',
        'longitude_ktp',
        'longitude_domisili',
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
    public function TrainingAttendeds()
    {
        return $this->hasMany(TrainingAttended::class);
    }
    public function Skills()
    {
        return $this->hasMany(Skill::class);
    }
}
