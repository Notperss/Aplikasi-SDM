<?php

namespace App\Models\WorkUnit;

use Illuminate\Database\Eloquent\Model;
use App\Models\ManagementAccess\Company;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Directorate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['company_id', 'code', 'name',];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function divisions()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(Division::class);
    }
}
