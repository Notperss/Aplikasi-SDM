<?php

namespace App\Models\WorkUnit;

use App\Models\WorkUnit\Division;
use Illuminate\Database\Eloquent\Model;
use App\Models\ManagementAccess\Company;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'company_id',
        'division_id',
        'name',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
