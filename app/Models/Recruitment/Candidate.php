<?php

namespace App\Models\Recruitment;

use App\Models\Employee\Employee;
use App\Models\Position\Position;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidate extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    public function getActivitylogOptions() : LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'company_id',
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
                'height',
                'weight',
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

                'last_educational',
                'study',
                'reference',
                'disability',

                'tag',

                'paspor_number',

                'file_cv', //
                'file_kk', //
                'file_ktp', //
                'file_skck', //
                'file_ijazah', //
                'file_sertifikat', //
                'file_vaksin', //
                'file_surat_sehat', //

                'latitude_ktp',
                'latitude_domisili',
                'longitude_ktp',
                'longitude_domisili',

                'sim_a',
                'expired_sim_a',
                'file_sim_a',

                'sim_b',
                'expired_sim_b',
                'file_sim_b',

                'sim_c',
                'expired_sim_c',
                'file_sim_c',
            ]) // Specify the attributes you want to log
            ->logOnlyDirty() // Log only changed attributes
            ->useLogName('candidate-log'); // Specify the log name
    }

    public function getDescriptionForEvent(string $eventName) : string
    {
        return "{$this->name} has been {$eventName}";
    }
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
        'height',
        'weight',
        'glasses',
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

        'last_educational',
        'study',
        'reference',
        'disability',

        'tag',

        'paspor_number',

        'file_cv', //
        'file_kk', //
        'file_ktp', //
        'file_skck', //
        'file_ijazah', //
        'file_sertifikat', //
        'file_vaksin', //
        'file_surat_sehat', //

        'latitude_ktp',
        'latitude_domisili',
        'longitude_ktp',
        'longitude_domisili',

        'sim_a',
        'expired_sim_a',
        'file_sim_a',

        'sim_b',
        'expired_sim_b',
        'file_sim_b',

        'sim_c',
        'expired_sim_c',
        'file_sim_c',

        'is_hire',
        'is_selection',
    ];

    protected $casts = ['is_hire' => 'boolean', 'is_selection' => 'boolean'];

    public function familyDetails()
    {
        return $this->hasMany(CandidateFamilyDetail::class)->orderBy('dob_family', 'asc');
    }
    public function employmentHistories()
    {
        return $this->hasMany(CandidateEmploymentHistory::class)->orderBy('year_from', 'desc');
    }
    public function educationalHistories()
    {
        return $this->hasMany(CandidateEducationalHistory::class)->orderBy('year_from', 'desc');
    }
    public function languageProficiencies()
    {
        return $this->hasMany(CandidateLanguageProficiency::class);
    }
    public function CandidateDocuments()
    {
        return $this->hasMany(CandidateDocument::class);
    }
    public function TrainingAttendeds()
    {
        return $this->hasMany(CandidateTrainingAttended::class)->orderBy('year', 'desc');
    }
    public function Skills()
    {
        return $this->hasMany(CandidateSkill::class);
    }
    public function SocialsPlatform()
    {
        return $this->hasMany(CandidateSocialPlatform::class);
    }

    public function selectedCandidates()
    {
        return $this->hasMany(SelectedCandidate::class);
    }
    public function position()
    {
        return $this->hasOne(Position::class);
    }
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function candidatePhotos()
    {
        return $this->hasMany(CandidatePhoto::class);
    }
}
