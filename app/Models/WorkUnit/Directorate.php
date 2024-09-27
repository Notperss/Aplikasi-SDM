<?php

namespace App\Models\WorkUnit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Directorate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['company_id', 'name',];

    public function divisions()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(Division::class);
    }
}
