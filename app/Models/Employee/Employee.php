<?php

namespace App\Models\Employee;

use App\Models\Position\Position;
use App\Models\Recruitment\Candidate;
use Illuminate\Database\Eloquent\Model;
use App\Models\ManagementAccess\Company;
use App\Models\Employee\EmployeeCategory;
use App\Models\Employee\PersonalData\Attendance;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Employee\PersonalData\EmployeeKpi;
use App\Models\Employee\PersonalData\EmployeeDuty;
use App\Models\Employee\PersonalData\EmployeeAward;
use App\Models\Employee\PersonalData\EmployeePhoto;
use App\Models\Employee\PersonalData\EmployeeSkill;
use App\Models\Employee\PersonalData\EmployeeCareer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Employee\PersonalData\EmployeeJobHistory;
use App\Models\Employee\PersonalData\EmployeeFamilyDetail;
use App\Models\Employee\PersonalData\EmployeeSocialPlatform;
use App\Models\Employee\PersonalData\EmployeeTrainingAttended;
use App\Models\Employee\PersonalData\EmployeeEducationalHistory;
use App\Models\Employee\PersonalData\EmployeeLanguageProficiency;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [

        'company_id',
        'candidate_id',
        'position_id',
        'employee_category_id',

        'name', //
        'nik', ////v
        'dob', //
        'pob', //
        'email', //
        'phone_number1', //
        'phone_number2', ////v
        'photo', //
        'ktp_address', //
        'zipcode_ktp', ////v
        'current_address', //
        'npwp_number', ////v
        'ktp_number',//
        'kk_number',//
        'bpjs_kesehatan_number',////v
        'bpjs_naker_number',////v
        'religion',//
        'nationality',//

        'last_educational',
        'study',

        'employee_status',////v
        'work_status',////v
        'work_relationship', ////v

        'gender', //
        'date_joining',////v
        'date_leaving',////

        'is_verified',////
        'is_approve',////

        'ethnic', //
        'blood_type',//
        'candidate_from', //

        'marital_status', //

        'paspor_number', //

        'file_cv', //
        'file_kk', //
        'file_ijazah', //
        'file_ktp', //
        'file_skck', //
        'file_sertifikat', //
        'file_vaksin', //
        'file_surat_sehat', //

        'longitude_ktp', //
        'longitude_domisili',//
        'latitude_ktp',//
        'latitude_domisili',//

        'sim_a',//
        'expired_sim_a',//
        'file_sim_a',//

        'sim_b',//
        'expired_sim_b',//
        'file_sim_b',//

        'sim_c',//
        'expired_sim_c',//
        'file_sim_c',//

        'temporary', ////
        'contract',////

        'add1', ////
        'add2',////
        'add3',////
        'add4',////
        'add5',////

    ];


    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
    public function employeeCategory()
    {
        return $this->belongsTo(EmployeeCategory::class);
    }
    public function familyDetails()
    {
        return $this->hasMany(EmployeeFamilyDetail::class)->orderBy('dob_family', 'asc');
    }
    public function jobHistories()
    {
        return $this->hasMany(EmployeeJobHistory::class)->orderBy('year_to', 'desc');
    }
    public function educationalHistories()
    {
        return $this->hasMany(EmployeeEducationalHistory::class)->orderBy('year_to', 'asc');
    }
    public function languageProficiencies()
    {
        return $this->hasMany(EmployeeLanguageProficiency::class);
    }
    public function EmployeeDocuments()
    {
        return $this->hasMany(EmployeeDocument::class);
    }
    public function TrainingAttendeds()
    {
        return $this->hasMany(EmployeeTrainingAttended::class)->orderBy('year', 'desc');
    }
    public function Skills()
    {
        return $this->hasMany(EmployeeSkill::class)->latest();
    }
    public function SocialsPlatform()
    {
        return $this->hasMany(EmployeeSocialPlatform::class);
    }

    public function employeePhotos()
    {
        return $this->hasMany(EmployeePhoto::class);
    }
    public function contracts()
    {
        return $this->hasMany(Contract::class)->orderBy('end_date', 'desc');
    }
    public function kpis()
    {
        return $this->hasMany(EmployeeKpi::class)->latest();
    }
    public function employeeDuties()
    {
        return $this->hasMany(EmployeeDuty::class)->latest();
    }
    public function employeeCareers()
    {
        return $this->hasMany(EmployeeCareer::class)->orderBy('is_approve', 'desc')->latest();
    }
    public function employeeAwards()
    {
        return $this->hasMany(EmployeeAward::class)->latest();
    }
    public function employeeAttendances()
    {
        return $this->hasMany(Attendance::class, 'nik', 'nik');
    }

    public function getPhotoUrlAttribute()
    {
        $mainPhoto = $this->employeePhotos->where('main_photo', true)->first();
        return $mainPhoto ? asset('storage/' . $mainPhoto->file_path) : asset('images/default-avatar.png');
    }
}
