<?php

namespace App\Models\Position;

use App\Models\ManagementAccess\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Allowance extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'company_id',
        'level_id',
        // 'position_id',
        'name',
        'type',
        'natura',
        'amount',
        'efective_date',
        'description',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    // public function position()
    // {
    //     return $this->belongsTo(Position::class);
    // }
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function positionAllowances()
    {
        return $this->hasMany(PositionAllowance::class);
    }
    public function positions()
    {
        return $this->belongsToMany(Position::class, 'position_allowances');
    }

}
