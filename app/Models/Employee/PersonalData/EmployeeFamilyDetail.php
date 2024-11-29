<?php

namespace App\Models\Employee\PersonalData;

use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeFamilyDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'employee_id',
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
        'emergency_contact',
    ];

    protected $casts = ['is_in_kk' => 'boolean', 'is_bpjs' => 'boolean'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
