<?php

namespace App\Models\WorkUnit;

use App\Models\ManagementAccess\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'department_id',
        'name',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
