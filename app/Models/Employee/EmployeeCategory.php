<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'company_id',
        'name',
        'description',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
