<?php

namespace App\Models\Employee\PersonalData;

use App\Models\Approval\Approval;
use App\Models\Employee\Employee;
use App\Models\Position\Position;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeCareer extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'position_id',
        'nik_employee',
        'start_date',
        'end_date',
        'placement',
        'type',
        'description',
        'is_approve',
        'file_career',
        'cmnp_career',
        'position_name',
    ];

    protected $casts = [
        'is_approve' => 'boolean',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
    public function approval()
    {
        return $this->hasOne(Approval::class);
    }
}
