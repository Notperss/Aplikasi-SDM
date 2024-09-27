<?php

namespace App\Models\Position;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Allowance extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'company_id',
        'name',
        'type',
        'amount',
        'efective_date',
    ];
}
