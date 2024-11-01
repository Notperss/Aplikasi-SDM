<?php

namespace App\Models\Employee;

use App\Models\Position\Position;
use App\Models\Recruitment\Candidate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

        'employee_status',////v
        'work_status',////v
        'work_relationship', ////v

        'gender', //
        'date_joining',////v
        'date_leaving',////

        'is_verified',////

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


    public function position()
    {
        return $this->belongsTo(Position::class);
    }
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
