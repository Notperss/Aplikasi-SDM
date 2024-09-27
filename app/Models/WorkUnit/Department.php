<?php

namespace App\Models\WorkUnit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'company_id',
        'division_id',
        'name',
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
