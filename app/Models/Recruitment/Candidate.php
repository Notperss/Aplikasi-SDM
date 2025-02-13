<?php

namespace App\Models\Recruitment;

use App\Models\Employee\Employee;
use App\Models\Position\Position;
use App\Models\Recruitment\PersonalData\CandidateJobHistory;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidate extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    public function getActivitylogOptions(): LogOptions
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
                'note',
            ]) // Specify the attributes you want to log
            ->logOnlyDirty() // Log only changed attributes
            ->useLogName('candidate-log'); // Specify the log name
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "{$this->name} has been {$eventName}";
    }
    protected $fillable = [
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

        'zipcode_ktp',
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
        'note',
    ];

    protected $casts = ['is_hire' => 'boolean', 'is_selection' => 'boolean'];


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
    public function jobHistories()
    {
        return $this->hasMany(CandidateJobHistory::class)->latest();
    }

}
