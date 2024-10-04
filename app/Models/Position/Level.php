<?php

namespace App\Models\Position;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['company_id', 'name', 'description'];

    public function allowances()
    {
        return $this->hasMany(Allowance::class);
    }
    public function positions()
    {
        return $this->hasMany(Position::class);
    }
    public function positionAllowances()
    {
        return $this->hasMany(PositionAllowance::class);
    }
}
