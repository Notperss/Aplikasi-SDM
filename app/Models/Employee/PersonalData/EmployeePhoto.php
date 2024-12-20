<?php

namespace App\Models\Employee\PersonalData;

use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeePhoto extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'employee_id',
        'company_id',
        'main_photo',
        'file_path',
    ];

    protected $casts = [
        'main_photo' => 'boolean',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
