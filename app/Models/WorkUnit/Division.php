<?php

namespace App\Models\WorkUnit;

use Illuminate\Database\Eloquent\Model;
use App\Models\ManagementAccess\Company;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Division extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'directorate_id',
        'code',
        'name',
    ];

    public function company()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(Company::class);
    }
    public function directorate()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(Directorate::class);
    }
    public function departments()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(Department::class);
    }

}
