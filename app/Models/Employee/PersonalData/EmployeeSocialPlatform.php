<?php

namespace App\Models\Employee\PersonalData;

use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeSocialPlatform extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'platform',
        'account_name',
        'account_link',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
