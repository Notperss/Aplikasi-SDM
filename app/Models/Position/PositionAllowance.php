<?php

namespace App\Models\Position;

use App\Models\ManagementAccess\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionAllowance extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'level_id',
        'allowance_id',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function level()
    {
        return $this->belongsTo(Level::class);
    }
    public function allowance()
    {
        return $this->belongsTo(Allowance::class);
    }
}
