<?php

namespace App\Models\Employee\PersonalData;

use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    // protected $table = ['attendances'];

    protected $fillable = [
        'nik',
        'check_in_time',
        'check_out_time',
        'clock_in',
        'clock_out',
        'working_type',
        'status',
        'late',
        'date',
        'working_hours',
    ];
    // protected $casts = [
    //     'check_in_time' => 'datetime',
    //     'check_out_time' => 'datetime',
    //     'late' => 'integer',
    //     'working_hours' => 'integer',
    // ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'nik', 'nik');
    }
}
